<?php
// Minimal Midtrans skeleton — create transaction and webhook verification
require_once __DIR__ . '/../config/database.php';
$config = require __DIR__ . '/../config/midtrans.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/Car.php';

$action = $_GET['action'] ?? null;
if($action === 'snapToken'){
    // return JSON {token}
    $booking_id = $_GET['booking_id'] ?? null;
    if(!$booking_id){ http_response_code(400); echo json_encode(['error'=>'missing booking_id']); exit; }
    $bookingModel = new Booking($pdo);
    $carModel = new Car($pdo);
    $booking = $pdo->prepare("SELECT b.*, c.brand, c.model, u.name as user_name FROM bookings b JOIN cars c ON b.car_id = c.id LEFT JOIN users u ON b.user_id = u.id WHERE b.id = :id LIMIT 1");
    $booking->execute(['id'=>$booking_id]);
    $b = $booking->fetch();
    if(!$b){ http_response_code(404); echo json_encode(['error'=>'booking not found']); exit; }

    // choose a customer name: explicit customer_name (if project adds it) -> user name -> fallback
    $customerName = $b['customer_name'] ?? $b['user_name'] ?? 'Customer';

    $payload = [
        'transaction_details' => [
            'order_id' => 'ORDER-' . $b['id'] . '-' . time(),
            'gross_amount' => (int)$b['total_price']
        ],
        'customer_details' => [
            'first_name' => $customerName
        ]
    ];

    $url = rtrim($config['api_base'], '/') . '/snap/v1/transactions';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ]);
    curl_setopt($ch, CURLOPT_USERPWD, $config['server_key'] . ':');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($code >= 200 && $code < 300){
        header('Content-Type: application/json');
        echo $res;
        exit;
    }
    http_response_code(500);
    echo json_encode(['error'=>'midtrans error','response'=>$res]);
    exit;
}

// fallback webhook skeleton remains
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Webhook handling
    $raw = file_get_contents('php://input');
    file_put_contents(__DIR__ . '/../storage/webhook.log', date('c') . " " . $raw . "\n", FILE_APPEND);
    http_response_code(200);
    echo 'ok';
    exit;
}

http_response_code(404);
echo 'Not found';
