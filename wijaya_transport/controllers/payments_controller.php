<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_admin();
require_once __DIR__ . '/../middleware/csrf.php';
require_once __DIR__ . '/../helpers/email.php';

// Handle admin GET actions from payments action buttons
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && isset($_GET['payment_id'])){
	$action = $_GET['action'];
	$payment_id = intval($_GET['payment_id']);
	$bookingId = 0;

	if($payment_id){
		$stmt = $pdo->prepare('SELECT booking_id FROM payments WHERE id = :id LIMIT 1');
		$stmt->execute(['id'=>$payment_id]);
		$row = $stmt->fetch();
		$bookingId = intval($row['booking_id'] ?? 0);
	}

	if($action === 'paid' && $payment_id && $bookingId){
		$pdo->prepare('UPDATE payments SET status = :st WHERE id = :id')->execute(['st'=>'paid','id'=>$payment_id]);
		$pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'Paid','id'=>$bookingId]);
		$pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'unavailable','bid'=>$bookingId]);
	}

    if($action === 'complete' && $payment_id && $bookingId){
        $pdo->prepare('UPDATE payments SET status = :st WHERE id = :id')->execute(['st'=>'completed','id'=>$payment_id]);
        $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'Completed','id'=>$bookingId]);
        $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'available','bid'=>$bookingId]);
    }

	if($action === 'pending' && $payment_id && $bookingId){
		$pdo->prepare('UPDATE payments SET status = :st WHERE id = :id')->execute(['st'=>'pending','id'=>$payment_id]);
		$pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'Pending','id'=>$bookingId]);
	}

	header('Location: /wijaya_transport/admin.php?module=payments');
	exit;
}

// Handle admin POST actions with CSRF and email notification
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$action = $_POST['action'] ?? '';
	$payment_id = $_POST['payment_id'] ?? null;
	$bookingId = intval($_POST['booking_id'] ?? 0);
	$token = $_POST['csrf_token'] ?? null;
	if(!verify_csrf_token($token)){
		header('Location: /wijaya_transport/admin.php?module=payments&err=csrf');
		exit;
	}

	if(!$bookingId && $payment_id){
		$stmt = $pdo->prepare('SELECT booking_id FROM payments WHERE id = :id LIMIT 1');
		$stmt->execute(['id'=>$payment_id]);
		$row = $stmt->fetch();
		$bookingId = intval($row['booking_id'] ?? 0);
	}

	if($action === 'confirm_payment' && $payment_id && $bookingId){
		$upd = $pdo->prepare('UPDATE payments SET status = :st WHERE id = :id');
		$upd->execute(['st'=>'paid','id'=>$payment_id]);
		$bupd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
		$bupd->execute(['st'=>'paid','id'=>$bookingId]);
		$cstmt = $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)');
		$cstmt->execute(['st'=>'unavailable','bid'=>$bookingId]);
		$subject = "Pembayaran #$payment_id dikonfirmasi";
		$body = "Pembayaran ID: $payment_id\nBooking ID: $bookingId\nStatus: paid";
		$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
		send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));
	}

	if($action === 'update_status' && ($payment_id || $bookingId)){
		$newStatus = ($_POST['status'] ?? 'cancelled');
		$allowedStatus = in_array($newStatus, ['paid','cancelled','pending'], true) ? $newStatus : 'pending';

		if($payment_id){
			$upd = $pdo->prepare('UPDATE payments SET status = :st WHERE id = :id');
			$upd->execute(['st'=>$allowedStatus,'id'=>$payment_id]);
		}

		if($bookingId){
			$updByBooking = $pdo->prepare('UPDATE payments SET status = :st WHERE booking_id = :bid');
			$updByBooking->execute(['st'=>$allowedStatus,'bid'=>$bookingId]);

			$bookingStatus = $allowedStatus === 'paid' ? 'Paid' : ($allowedStatus === 'cancelled' ? 'Cancelled' : 'Pending');
			$bupd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
			$bupd->execute(['st'=>$bookingStatus,'id'=>$bookingId]);
		}

		if($allowedStatus === 'cancelled' && $bookingId){
			$cstmt = $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)');
			$cstmt->execute(['st'=>'available','bid'=>$bookingId]);
		}
	}

	if($action === 'complete_rental' && $payment_id && $bookingId){
		$cstmt = $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)');
		$cstmt->execute(['st'=>'available','bid'=>$bookingId]);
		$bupd = $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id');
		$bupd->execute(['st'=>'completed','id'=>$bookingId]);
		$subject = "Rental selesai untuk booking #$bookingId";
		$body = "Booking ID: $bookingId\nRental telah selesai dan mobil dikembalikan ke status tersedia.";
		$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@example.test';
		send_email($adminEmail, $subject, nl2br(htmlspecialchars($body)));
	}

	header('Location: /wijaya_transport/admin.php?module=payments');
	exit;
}

$stmt = $pdo->query("SELECT b.id AS booking_id, b.total_price AS amount, b.status AS booking_status, b.start_date, b.end_date, COALESCE(NULLIF(u.name, ''), NULLIF(b.customer_name, ''), '') AS customer_name, COALESCE(NULLIF(b.whatsapp, ''), NULLIF(u.phone, ''), '') AS customer_phone, p.id AS payment_id, p.transaction_id, COALESCE(NULLIF(p.payment_method, ''), 'Transfer') AS payment_method, p.amount AS payment_amount, COALESCE(NULLIF(p.status, ''), b.status) AS payment_status, p.payment_date, p.proof_image, COALESCE(NULLIF(c.brand, ''), '-') AS brand, COALESCE(NULLIF(c.model, ''), '-') AS model FROM bookings b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN cars c ON b.car_id = c.id LEFT JOIN payments p ON p.booking_id = b.id ORDER BY b.id DESC");
$payments = $stmt->fetchAll();

// ensure CSRF token available for forms
$csrf = generate_csrf_token();
include __DIR__ . '/../views/admin/payments.php';
