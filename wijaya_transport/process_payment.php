<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/middleware/auth.php';
require_admin();

$action = $_GET['action'] ?? '';
$bookingId = intval($_GET['id'] ?? 0);
$carId = intval($_GET['car_id'] ?? 0);

if ($bookingId > 0) {
    if ($action === 'paid') {
        $pdo->prepare('UPDATE payments SET status = :status WHERE booking_id = :booking_id')
            ->execute(['status' => 'paid', 'booking_id' => $bookingId]);
        $pdo->prepare('UPDATE bookings SET status = :status WHERE id = :id')
            ->execute(['status' => 'Paid', 'id' => $bookingId]);
        $pdo->prepare('UPDATE cars SET status = :status WHERE id = (SELECT car_id FROM bookings WHERE id = :booking_id)')
            ->execute(['status' => 'unavailable', 'booking_id' => $bookingId]);

        header('Location: /wijaya_transport/admin.php?module=dashboard&msg=payment_confirmed');
        exit;
    }

    if ($action === 'return') {
        if ($carId > 0) {
            $pdo->prepare('UPDATE cars SET status = :status WHERE id = :id')
                ->execute(['status' => 'available', 'id' => $carId]);
        } else {
            $pdo->prepare('UPDATE cars SET status = :status WHERE id = (SELECT car_id FROM bookings WHERE id = :booking_id)')
                ->execute(['status' => 'available', 'booking_id' => $bookingId]);
        }

        $pdo->prepare('UPDATE bookings SET status = :status WHERE id = :id')
            ->execute(['status' => 'completed', 'id' => $bookingId]);
        $pdo->prepare('UPDATE payments SET status = :status WHERE booking_id = :booking_id')
            ->execute(['status' => 'completed', 'booking_id' => $bookingId]);

        header('Location: /wijaya_transport/admin.php?module=dashboard&msg=returned');
        exit;
    }
}

header('Location: /wijaya_transport/admin.php?module=dashboard');
exit;
