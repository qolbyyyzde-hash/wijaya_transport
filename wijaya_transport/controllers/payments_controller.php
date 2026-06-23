<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_admin();

$stmt = $pdo->query("SELECT p.*, b.car_id, b.user_id, b.start_date, b.end_date, c.brand, c.model FROM payments p LEFT JOIN bookings b ON p.booking_id = b.id LEFT JOIN cars c ON b.car_id = c.id ORDER BY p.id DESC");
$payments = $stmt->fetchAll();
include __DIR__ . '/../views/admin/payments.php';
