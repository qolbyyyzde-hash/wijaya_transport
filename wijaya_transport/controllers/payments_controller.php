<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_admin();
require_once __DIR__ . '/../middleware/csrf.php';
require_once __DIR__ . '/../helpers/email.php';

// Handle admin POST actions (update status) with CSRF and email notification
if($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update_status'){
	$payment_id = $_POST['payment_id'] ?? null;
	$new_status = $_POST['status'] ?? null;
	$token = $_POST['csrf_token'] ?? null;
	if(!verify_csrf_token($token)){
		header('Location: /wijaya_transport/admin.php?module=payments&err=csrf');
		exit;
	}
	if($payment_id && $new_status){
		// update payment
		$upd = $pdo->prepare('UPDATE payments SET status = :st WHERE id = :id');
		$upd->execute(['st'=>$new_status,'id'=>$payment_id]);
		// update related booking status if exists
		$stmt = $pdo->prepare('SELECT booking_id FROM payments WHERE id = :id LIMIT 1');
		$stmt->execute(['id'=>$payment_id]);
		$row = $stmt->fetch();
		if($row && $row['booking_id']){
			$bstatus = 'pending';
			if(in_array($new_status, ['settlement','capture','paid','success','settled'])) $bstatus = 'paid';
			if(in_array($new_status, ['cancel','deny','expire','cancelled'])) $bstatus = 'cancelled';
			$bupd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
			$bupd->execute(['st'=>$bstatus,'id'=>$row['booking_id']]);

			// notify admin via email log (and attempt mail)
			$subject = "Payment #$payment_id status updated to $new_status";
			$body = "Payment ID: $payment_id\nBooking ID: " . $row['booking_id'] . "\nNew status: $new_status";
			// send to admin email from env or default
			$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
			send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));
		}
	}
	header('Location: /wijaya_transport/admin.php?module=payments');
	exit;
}

$stmt = $pdo->query("SELECT p.*, b.car_id, b.user_id, b.start_date, b.end_date, c.brand, c.model FROM payments p LEFT JOIN bookings b ON p.booking_id = b.id LEFT JOIN cars c ON b.car_id = c.id ORDER BY p.id DESC");
$payments = $stmt->fetchAll();

// ensure CSRF token available for forms
$csrf = generate_csrf_token();
include __DIR__ . '/../views/admin/payments.php';
