<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/csrf.php';
require_once __DIR__ . '/../helpers/email.php';

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo 'Method not allowed';
    exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
    header('Location: /wijaya_transport/?err=csrf');
    exit;
}

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
if($booking_id <= 0){
    header('Location: /wijaya_transport/?err=missing');
    exit;
}

$proofFile = $_FILES['bukti_transfer'] ?? $_FILES['payment_proof'] ?? null;
if(empty($proofFile) || $proofFile['error'] !== UPLOAD_ERR_OK){
    header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $booking_id . '&err=file');
    exit;
}

$allowed = ['image/jpeg','image/png','image/webp'];
$fileType = mime_content_type($proofFile['tmp_name']);
if(!in_array($fileType, $allowed, true)){
    header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $booking_id . '&err=type');
    exit;
}

$uploadDir = __DIR__ . '/../uploads/bukti_transfer/';
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}
$filename = sprintf('%s_%s.%s', $booking_id, time(), pathinfo($proofFile['name'], PATHINFO_EXTENSION));
$targetPath = $uploadDir . $filename;
if(!move_uploaded_file($proofFile['tmp_name'], $targetPath)){
    header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $booking_id . '&err=upload');
    exit;
}

$proofPath = 'uploads/bukti_transfer/' . $filename;
$stmt = $pdo->prepare('UPDATE payments SET proof_image = :proof, status = :status, payment_date = NOW() WHERE booking_id = :bid');
$stmt->execute(['proof' => $proofPath, 'status' => 'pending', 'bid' => $booking_id]);

$hasBookingProofColumn = false;
try {
    $columnCheck = $pdo->prepare("SHOW COLUMNS FROM bookings LIKE 'bukti_transfer'");
    $columnCheck->execute();
    $hasBookingProofColumn = (bool)$columnCheck->fetch();
} catch (Exception $e) {
    $hasBookingProofColumn = false;
}

if ($hasBookingProofColumn) {
    $stmt2 = $pdo->prepare('UPDATE bookings SET bukti_transfer = :proof WHERE id = :id');
    $stmt2->execute(['proof' => $proofPath, 'id' => $booking_id]);
}

// notify admin about uploaded proof
$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
$subject = "Bukti pembayaran diterima untuk Booking #{$booking_id}";
$body = "Bukti pembayaran telah diunggah untuk booking ID {$booking_id}. Silakan verifikasi dan update status pembayaran di panel admin.";
send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));

header('Location: /wijaya_transport/index.php?page=booking&action=confirmation&booking_id=' . $booking_id . '&msg=proof_uploaded');
exit;
