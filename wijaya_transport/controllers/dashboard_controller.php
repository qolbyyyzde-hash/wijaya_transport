<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_admin();
require_once __DIR__ . '/../middleware/csrf.php';

// Auto-update expired bookings and return cars on admin dashboard load
try {
    $pdo->prepare(
        "UPDATE bookings b
         JOIN cars c ON c.id = b.car_id
         SET b.status = 'completed', c.status = 'available'
         WHERE b.end_date < CURRENT_DATE()
           AND b.status NOT IN ('completed', 'Selesai')
           AND c.status <> 'available'"
    )->execute();
} catch (Exception $e) {
    // do not block admin loading if cleanup fails
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking_id'])) {
    $bookingId = intval($_POST['confirm_booking_id'] ?? 0);

    if ($bookingId) {
        $pdo->prepare("UPDATE payments SET status = 'paid' WHERE booking_id = ?")->execute([$bookingId]);
        $pdo->prepare("UPDATE bookings SET status = 'Paid' WHERE id = ?")->execute([$bookingId]);
        $pdo->prepare("UPDATE cars SET status = 'unavailable' WHERE id = (SELECT car_id FROM bookings WHERE id = ?)")->execute([$bookingId]);
    }

    header('Location: /wijaya_transport/admin.php?module=dashboard');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])){
    $action = $_GET['action'] ?? '';
    $payment_id = $_GET['payment_id'] ?? null;
    $bookingId = $_GET['booking_id'] ?? null;

    if(!$bookingId && $payment_id){
        $stmt = $pdo->prepare('SELECT booking_id FROM payments WHERE id = :id LIMIT 1');
        $stmt->execute(['id'=>$payment_id]);
        $row = $stmt->fetch();
        $bookingId = $row['booking_id'] ?? null;
    }

    if($action === 'confirm_payment' && ($payment_id || $bookingId)){
        if($payment_id){
            $pdo->prepare('UPDATE payments SET status = :st WHERE id = :id')->execute(['st'=>'paid','id'=>$payment_id]);
        }
        if($bookingId){
            $pdo->prepare('UPDATE payments SET status = :st WHERE booking_id = :bid')->execute(['st'=>'paid','bid'=>$bookingId]);
            $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'paid','id'=>$bookingId]);
            $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'unavailable','bid'=>$bookingId]);
        }
    }

    if($action === 'complete_rental' && ($payment_id || $bookingId)){
        if($bookingId){
            $pdo->prepare('UPDATE payments SET status = :st WHERE booking_id = :bid')->execute(['st'=>'completed','bid'=>$bookingId]);
            $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'available','bid'=>$bookingId]);
            $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'completed','id'=>$bookingId]);
        }

        header('Location: /wijaya_transport/admin.php?module=dashboard&msg=returned');
        exit;
    }

    header('Location: /wijaya_transport/admin.php?module=dashboard');
    exit;
} 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_POST['action'] ?? '';
    $payment_id = $_POST['payment_id'] ?? null;
    $bookingId = intval($_POST['booking_id'] ?? 0);
    $token = $_POST['csrf_token'] ?? null;

    if($action !== 'confirm_payment' && !verify_csrf_token($token)){
        header('Location: /wijaya_transport/admin.php?module=dashboard&err=csrf');
        exit;
    }

    if(!$bookingId && $payment_id){
        $stmt = $pdo->prepare('SELECT booking_id FROM payments WHERE id = :id LIMIT 1');
        $stmt->execute(['id'=>$payment_id]);
        $row = $stmt->fetch();
        $bookingId = intval($row['booking_id'] ?? 0);
    }

    if($action === 'confirm_payment' && $bookingId){
        try {
            $pdo->prepare('UPDATE payments SET status = :st WHERE booking_id = :bid')->execute(['st'=>'paid','bid'=>$bookingId]);
        } catch (Exception $e) {}

        try {
            $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'Paid','id'=>$bookingId]);
        } catch (Exception $e) {
            try {
                $pdo->prepare('UPDATE bookings SET status_pembayaran = :st WHERE id = :id')->execute(['st'=>'Paid','id'=>$bookingId]);
            } catch (Exception $e2) {
                $pdo->prepare('UPDATE bookings SET payment_status = :st WHERE id = :id')->execute(['st'=>'Paid','id'=>$bookingId]);
            }
        }

        $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'unavailable','bid'=>$bookingId]);
    }

    if($action === 'complete_rental' && $bookingId){
        try {
            $pdo->prepare('UPDATE payments SET status = :st WHERE booking_id = :bid')->execute(['st'=>'completed','bid'=>$bookingId]);
        } catch (Exception $e) {}
        $pdo->prepare('UPDATE cars SET status = :st WHERE id = (SELECT car_id FROM bookings WHERE id = :bid)')->execute(['st'=>'available','bid'=>$bookingId]);
        $pdo->prepare('UPDATE bookings SET status = :st WHERE id = :id')->execute(['st'=>'completed','id'=>$bookingId]);
    }

    header('Location: /wijaya_transport/admin.php?module=dashboard&msg=returned');
    exit;
} 

// detect booking columns safely before building the SELECT statement
$columnsInfo = $pdo->query('DESCRIBE bookings')->fetchAll(PDO::FETCH_COLUMN, 0);
$hasCustomerName = in_array('customer_name', $columnsInfo, true);
$hasName = in_array('name', $columnsInfo, true);
$hasCustomerPhone = in_array('customer_phone', $columnsInfo, true);
$hasPhone = in_array('phone', $columnsInfo, true);
$hasWhatsapp = in_array('whatsapp', $columnsInfo, true);

$nameColumn = $hasCustomerName ? 'b.customer_name' : ($hasName ? 'b.name' : "''");
$phoneColumn = $hasWhatsapp ? 'b.whatsapp' : ($hasCustomerPhone ? 'b.customer_phone' : ($hasPhone ? 'b.phone' : "''"));
$emailColumn = in_array('customer_email', $columnsInfo, true) ? 'b.customer_email' : "''";

$nameExpr = "COALESCE(NULLIF(u.name, ''), COALESCE($nameColumn, ''), '')";
$phoneExpr = "COALESCE(NULLIF(u.phone, ''), COALESCE($phoneColumn, ''), '')";
$emailExpr = "COALESCE(NULLIF(u.email, ''), COALESCE($emailColumn, ''), '')";

$sql = "SELECT b.*, {$nameExpr} AS customer_name, {$phoneExpr} AS customer_phone, {$emailExpr} AS customer_email, b.driver_option AS driver_option, b.pickup_option AS pickup_option, b.foto_ktp AS foto_ktp, b.foto_sim AS foto_sim, c.brand AS car_brand, c.model AS car_model, c.status AS car_status, p.id AS payment_id, COALESCE(NULLIF(p.status, ''), b.status) AS payment_status, p.proof_image, p.payment_date FROM bookings b LEFT JOIN users u ON u.id = b.user_id LEFT JOIN cars c ON b.car_id = c.id LEFT JOIN payments p ON p.booking_id = b.id ORDER BY b.id DESC";
$stmt = $pdo->query($sql);
$bookings = $stmt->fetchAll();
$transactions = $bookings;
$csrf = generate_csrf_token();
include __DIR__ . '/../views/admin/dashboard.php';
