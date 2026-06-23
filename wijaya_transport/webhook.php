<?php
// Midtrans webhook: verify signature and update payments/bookings
require_once __DIR__ . '/config/database.php';
$config = require __DIR__ . '/config/midtrans.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if(!$data){ http_response_code(400); echo 'invalid payload'; exit; }

file_put_contents(__DIR__ . '/storage/webhook.log', date('c') . " " . $raw . "\n", FILE_APPEND);

// verify signature_key per Midtrans docs: sha512(order_id + status_code + gross_amount + server_key)
$signature = $data['signature_key'] ?? '';
$order_id = $data['order_id'] ?? '';
$status_code = $data['status_code'] ?? '';
$gross_amount = $data['gross_amount'] ?? '';

$computed = hash('sha512', $order_id . $status_code . $gross_amount . ($config['server_key'] ?? ''));
if(empty($signature) || $signature !== $computed){
	// invalid signature
	http_response_code(403);
	echo 'invalid signature';
	exit;
}

// extract booking id from order_id if format ORDER-<booking_id>-<ts>
$booking_id = null;
if(preg_match('/ORDER-(\d+)-/', $order_id, $m)){
	$booking_id = (int)$m[1];
}

$transaction_id = $data['transaction_id'] ?? null;
$transaction_status = $data['transaction_status'] ?? null;
$payment_type = $data['payment_type'] ?? null;

if($booking_id){
	// update payments row for booking
	$stmt = $pdo->prepare('SELECT id FROM payments WHERE booking_id = :bid LIMIT 1');
	$stmt->execute(['bid'=>$booking_id]);
	$p = $stmt->fetch();
	if($p){
		$upd = $pdo->prepare('UPDATE payments SET transaction_id = :tx, payment_method = :pm, status = :st, payment_date = NOW() WHERE id = :id');
		$upd->execute(['tx'=>$transaction_id,'pm'=>$payment_type,'st'=>$transaction_status,'id'=>$p['id']]);
	}

	// update booking status
	$bookingStatus = 'pending';
	if(in_array($transaction_status, ['capture','settlement'])) $bookingStatus = 'paid';
	if(in_array($transaction_status, ['deny','cancel','expire'])) $bookingStatus = 'cancelled';
	$bUpd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
	$bUpd->execute(['st'=>$bookingStatus,'id'=>$booking_id]);
}

http_response_code(200);
echo 'ok';
