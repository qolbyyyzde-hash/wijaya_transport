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

// compute total price (days * price_per_day)
$total = $days * (float)$car['price_per_day'];

// associate with logged-in user if available
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

$data = [
    'user_id' => $user_id,
    'car_id' => $car_id,
    'start_date' => $d1->format('Y-m-d'),
    'end_date' => $d2->format('Y-m-d'),
    'total_price' => $total,
    'status' => 'pending',
    'customer_name' => $name,
    'customer_phone' => $phone,
    'customer_email' => filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null
];

$bookingId = $bookingModel->create($data);
if($bookingId){
    // create pending payment record
    require_once __DIR__ . '/../models/Payment.php';
    $paymentModel = new Payment($pdo);
    $paymentModel->create([
        'booking_id'=>$bookingId,
        'transaction_id'=>null,
        'payment_method'=>null,
        'amount'=>$total,
        'status'=>'pending',
        'payment_date'=>null
    ]);
    // send notification email to admin and optionally to customer
    require_once __DIR__ . '/../helpers/email.php';
    $adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
    $subject = "New booking #{$bookingId} for {$car['brand']} {$car['model']}";
    $body = "Booking ID: {$bookingId}\nCar: {$car['brand']} {$car['model']}\nStart: {$d1->format('Y-m-d')}\nEnd: {$d2->format('Y-m-d')}\nDays: {$days}\nTotal: Rp " . number_format($total,0,',','.') . "\nCustomer: " . htmlspecialchars($name) . "\nPhone: " . htmlspecialchars($phone) . "\n";
    // send to admin (HTML)
    send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));
    // send to customer if email provided
    if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        $custBody = "Terima kasih. Booking Anda berhasil.\n" . $body . "\nSilakan lanjutkan ke pembayaran jika diperlukan.";
        send_email($email, "Konfirmasi Booking #{$bookingId}", nl2br(htmlspecialchars($custBody)));
    }
    // redirect to confirmation page
    header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $bookingId);
    exit;
}

header('Location: /wijaya_transport/index.php?msg=error');
exit;
