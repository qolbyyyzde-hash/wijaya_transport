<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Car.php';
require_once __DIR__ . '/../middleware/csrf.php';

$bookingModel = new Booking($pdo);
$carModel = new Car($pdo);

$action = $_GET['action'] ?? 'confirmation';

if($action === 'new'){
    // show a generic booking form where user can choose a car
    $cars = $carModel->all();
    $csrf = generate_csrf_token();
    $selected = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;
    include __DIR__ . '/../views/booking/new.php';
    exit;
}

if($action === 'confirmation'){
    $booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
    if(!$booking_id){ http_response_code(400); echo 'Missing booking id'; exit; }
    $stmt = $pdo->prepare('SELECT b.*, c.brand, c.model, c.price_per_day FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.id = :id LIMIT 1');
    $stmt->execute(['id'=>$booking_id]);
    $booking = $stmt->fetch();
    if(!$booking){ http_response_code(404); echo 'Booking not found'; exit; }
    include __DIR__ . '/../views/booking/confirmation.php';
    exit;
}

http_response_code(404);
echo 'Not found';
