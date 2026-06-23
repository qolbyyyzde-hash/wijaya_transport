<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Payment.php';

// Accept POST form or JSON payload with { booking_id, result }
$booking_id = $_POST['booking_id'] ?? null;
$result = $_POST['result'] ?? null;

if((empty($booking_id) || empty($result)) && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false){
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if(isset($json['booking_id'])) $booking_id = $json['booking_id'];
    if(isset($json['result'])) $result = $json['result'];
}

if(empty($booking_id) || empty($result)){
    http_response_code(400);
    echo 'missing';
    exit;
}

// result may be a JSON string if sent via form
if(!is_array($result)){
    $result = json_decode($result, true);
}

$transaction_id = $result['transaction_id'] ?? null;
$transaction_status = $result['transaction_status'] ?? ($result['status'] ?? null);
$payment_type = $result['payment_type'] ?? null;
$gross_amount = $result['gross_amount'] ?? ($result['gross_amount'] ?? 0);

try{
    $pdo->beginTransaction();
    // find existing payment for booking
    $stmt = $pdo->prepare('SELECT id FROM payments WHERE booking_id = :bid LIMIT 1');
    $stmt->execute(['bid'=>$booking_id]);
    $p = $stmt->fetch();
    if($p){
        $upd = $pdo->prepare('UPDATE payments SET transaction_id = :tx, payment_method = :pm, status = :st, payment_date = NOW() WHERE id = :id');
        $upd->execute(['tx'=>$transaction_id,'pm'=>$payment_type,'st'=>$transaction_status,'id'=>$p['id']]);
    } else {
        $ins = $pdo->prepare('INSERT INTO payments (booking_id,transaction_id,payment_method,amount,status,payment_date) VALUES (:bid,:tx,:pm,:amount,:st,NOW())');
        $ins->execute(['bid'=>$booking_id,'tx'=>$transaction_id,'pm'=>$payment_type,'amount'=>$gross_amount,'st'=>$transaction_status]);
    }

    $bookingStatus = 'pending';
    if(in_array($transaction_status, ['capture','settlement'])) $bookingStatus = 'paid';
    if(in_array($transaction_status, ['deny','cancel','expire'])) $bookingStatus = 'cancelled';
    $bUpd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
    $bUpd->execute(['st'=>$bookingStatus,'id'=>$booking_id]);

    $pdo->commit();
    echo 'ok';
} catch(Exception $e){
    $pdo->rollBack();
    http_response_code(500);
    error_log('payment_callback error: '. $e->getMessage());
    // For development: return the exception message to aid debugging
    echo 'error: ' . $e->getMessage();
}
