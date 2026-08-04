<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Car.php';
require_once __DIR__ . '/../middleware/csrf.php';

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

$bookingModel = new Booking($pdo);
$carModel = new Car($pdo);

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405); echo 'Method not allowed'; exit;
}

// verify csrf
if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id=' . ($_POST['car_id'] ?? '') . '&err=csrf');
    exit;
}

// sanitize and validate inputs
$car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
$start = trim((string)($_POST['start_date'] ?? ''));
$end = trim((string)($_POST['end_date'] ?? ''));
$name = trim(strip_tags((string)($_POST['name'] ?? '')));
$phone = trim((string)($_POST['phone'] ?? ''));
$driverOption = trim(strip_tags((string)($_POST['driver_option'] ?? 'Lepas Kunci')));
$pickupOption = trim(strip_tags((string)($_POST['pickup_option'] ?? 'Ambil di Garasi')));

if($car_id <= 0 || $start === '' || $end === '' || $name === ''){
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=missing');
    exit;
}

// find car
$car = $carModel->find($car_id);
if(!$car){ header('Location: /wijaya_transport/'); exit; }

// validate dates
try{
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);
    if($d2 < $d1){
        header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=dates');
        exit;
    }
    $diff = $d1->diff($d2);
    $days = max(1, (int)$diff->days);
    $max_days = 90;
    if($days > $max_days){
        header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=toomanydays');
        exit;
    }
} catch(Exception $e){
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=dates');
    exit;
}

// sanitize phone (allow + and digits)
$phone = preg_replace('/[^0-9+]/', '', $phone);
// optional customer email (not persisted)
$email = trim((string)($_POST['email'] ?? ''));
$fotoKtpFile = $_FILES['ktp_file'] ?? $_FILES['foto_ktp'] ?? null;
$paymentProofFile = $_FILES['payment_proof'] ?? $_FILES['bukti_transfer'] ?? null;

function isValidUploadImage(array $file): bool {
    if(!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $imageData = @getimagesize($file['tmp_name']);
    if($imageData === false) {
        return false;
    }
    $allowed = ['image/jpeg','image/png','image/webp'];
    return in_array($imageData['mime'], $allowed, true);
}

function safeUploadDocument(array $file, string $uploadDir, string $prefix): string {
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $ext = preg_replace('/[^a-z0-9]/', '', $ext);
    $baseName = sprintf('%s_%s.%s', $prefix, time(), $ext ?: 'jpg');
    $destination = rtrim($uploadDir, '/') . '/' . $baseName;
    if(!move_uploaded_file($file['tmp_name'], $destination)) {
        return '';
    }
    return $baseName;
}

if (!$fotoKtpFile || $fotoKtpFile['error'] !== UPLOAD_ERR_OK) {
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=missing_ktp');
    exit;
}
if (!isValidUploadImage($fotoKtpFile)) {
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=type_ktp');
    exit;
}
if ($paymentProofFile && $paymentProofFile['error'] !== UPLOAD_ERR_OK && $paymentProofFile['error'] !== UPLOAD_ERR_NO_FILE) {
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=file_proof');
    exit;
}
if ($paymentProofFile && $paymentProofFile['error'] === UPLOAD_ERR_OK && !isValidUploadImage($paymentProofFile)) {
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=type_proof');
    exit;
}

// compute total price (days * price_per_day)
$total = $days * (float)$car['price_per_day'];

// associate with logged-in user if available
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

$paymentMethod = trim((string)($_POST['payment_method'] ?? 'Transfer BCA'));
$data = [
    'user_id' => $user_id,
    'car_id' => $car_id,
    'start_date' => $d1->format('Y-m-d'),
    'end_date' => $d2->format('Y-m-d'),
    'total_price' => $total,
    'status' => 'pending',
    'customer_name' => $name,
    'customer_phone' => $phone,
    'name' => $name,
    'phone' => $phone,
    'whatsapp' => $phone,
    'customer_email' => filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null,
    'driver_option' => $driverOption,
    'pickup_option' => $pickupOption
];

$statusKey = strtolower(trim($car['status'] ?? 'available'));
if(!$car || $statusKey !== 'available'){
    header('Location: /wijaya_transport/index.php?page=cars&err=unavailable');
    exit;
}

try {
    $pdo->beginTransaction();

    $data['foto_ktp'] = null;
    $bookingId = $bookingModel->create($data);
    if(!$bookingId){
        throw new Exception('failed_booking_create');
    }

    $uploadDirKtp = __DIR__ . '/../uploads/documents';
    if(!is_dir($uploadDirKtp)){
        mkdir($uploadDirKtp, 0755, true);
    }

    $fotoKtpName = safeUploadDocument($fotoKtpFile, $uploadDirKtp, 'booking_' . $bookingId . '_ktp');
    if($fotoKtpName === ''){
        throw new Exception('failed_upload_ktp');
    }

    $stmtUpdateFiles = $pdo->prepare('UPDATE bookings SET foto_ktp = :foto_ktp WHERE id = :id');
    $stmtUpdateFiles->execute(['foto_ktp' => 'uploads/documents/' . $fotoKtpName, 'id' => $bookingId]);

    $proofPath = null;
    $paymentProofName = '';
    $uploadDirProof = null;
    if ($paymentProofFile && $paymentProofFile['error'] === UPLOAD_ERR_OK) {
        $uploadDirProof = __DIR__ . '/../uploads/payment_proofs';
        if(!is_dir($uploadDirProof)){
            mkdir($uploadDirProof, 0755, true);
        }
        $paymentProofName = safeUploadDocument($paymentProofFile, $uploadDirProof, 'booking_' . $bookingId . '_proof');
        if($paymentProofName === ''){
            throw new Exception('failed_upload_proof');
        }
        $proofPath = 'uploads/payment_proofs/' . $paymentProofName;
    }

    $updateCar = $pdo->prepare('UPDATE cars SET status = :status WHERE id = :id');
    $updateCar->execute(['status' => 'unavailable', 'id' => $car_id]);

    require_once __DIR__ . '/../models/Payment.php';
    $paymentModel = new Payment($pdo);
    $paymentModel->create([
        'booking_id' => $bookingId,
        'transaction_id' => null,
        'payment_method' => $paymentMethod,
        'amount' => $total,
        'status' => 'pending',
        'payment_date' => null,
        'proof_image' => $proofPath
    ]);

    $pdo->commit();

    require_once __DIR__ . '/../helpers/email.php';
    $adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
    $subject = "New booking #{$bookingId} for {$car['brand']} {$car['model']}";
    $body = "Booking ID: {$bookingId}\nCar: {$car['brand']} {$car['model']}\nStart: {$d1->format('Y-m-d')}\nEnd: {$d2->format('Y-m-d')}\nDays: {$days}\nTotal: Rp " . number_format($total,0,',','.') . "\nLayanan Sewa: {$driverOption}\nMetode Pengambilan: {$pickupOption}\nCustomer: " . htmlspecialchars($name) . "\nPhone: " . htmlspecialchars($phone) . "\n";
    send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $custBody = "Terima kasih. Booking Anda berhasil.\n" . $body . "\nSilakan lanjutkan ke pembayaran jika diperlukan.";
        send_email($email, "Konfirmasi Booking #{$bookingId}", nl2br(htmlspecialchars($custBody)));
    }

    header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $bookingId);
    exit;
} catch (Exception $e) {
    if($pdo->inTransaction()){
        $pdo->rollBack();
    }
    if(!empty($uploadDirKtp) && !empty($fotoKtpName)){
        @unlink($uploadDirKtp . '/' . $fotoKtpName);
    }
    if(!empty($uploadDirProof) && !empty($paymentProofName)){
        @unlink($uploadDirProof . '/' . $paymentProofName);
    }
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=upload');
    exit;
}

header('Location: /wijaya_transport/index.php?msg=error');
exit;
