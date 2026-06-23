<?php
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Car.php';

$bookingModel = new Booking($pdo);
$carModel = new Car($pdo);

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405); echo 'Method not allowed'; exit;
}

// minimal validation
$car_id = $_POST['car_id'] ?? null;
$start = $_POST['start_date'] ?? null;
$end = $_POST['end_date'] ?? null;
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;

if(!$car_id || !$start || !$end || !$name){
    header('Location: /wijaya_transport/index.php?page=car&action=detail&id='.$car_id.'&err=missing');
    exit;
}

$car = $carModel->find($car_id);
if(!$car){ header('Location: /wijaya_transport/'); exit; }

// compute total price (days * price_per_day)
try{
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);
    $diff = $d1->diff($d2);
    $days = (int)$diff->days;
    if($days < 1) $days = 1;
} catch(Exception $e){ $days = 1; }
$total = $days * (float)$car['price_per_day'];

$data = [
    'user_id' => 0,
    'car_id' => $car_id,
    'start_date' => $start,
    'end_date' => $end,
    'total_price' => $total,
    'status' => 'pending'
];

$bookingId = $bookingModel->create($data);
if($bookingId){
    // create pending payment record
    require_once __DIR__ . '/../models/Payment.php';
    $paymentModel = new Payment($pdo);
    $paymentModel->create([
        'booking_id'=>$bookingId,
        'transaction_id'=>null,
        'payment_method'=>null,
        'amount'=>$total,
        'status'=>'pending',
        'payment_date'=>null
    ]);
    // redirect to checkout page to get snap token
    header('Location: /wijaya_transport/views/payment/checkout.php?booking_id=' . $bookingId);
    exit;
}

header('Location: /wijaya_transport/index.php?msg=error');
exit;
