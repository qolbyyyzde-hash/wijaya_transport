<?php
require_once __DIR__ . '/config/database.php';

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $new_status = ($_GET['type'] === 'confirm') ? 'Paid' : 'Pending';

    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status_pembayaran = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
    } catch (Exception $e) {
    }

    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
    } catch (Exception $e) {
    }

    $redirect_url = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: " . $redirect_url);
    exit();
}
?>
