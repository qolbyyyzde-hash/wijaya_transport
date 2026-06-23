<?php
// Usage: php scripts/webhook_simulate.php [booking_id] [status_code] [transaction_status] [gross_amount] [endpoint]
// Example: php scripts/webhook_simulate.php 12 200 settlement 150000 http://localhost/wijaya_transport/webhook.php

$booking_id = $argv[1] ?? '1';
$status_code = $argv[2] ?? '200';
$transaction_status = $argv[3] ?? 'settlement';
$gross_amount = $argv[4] ?? '100000';
$endpoint = $argv[5] ?? 'http://localhost/wijaya_transport/webhook.php';

$order_id = "ORDER-{$booking_id}-" . time();

$payload = [
    'order_id' => $order_id,
    'status_code' => (string)$status_code,
    'gross_amount' => (string)$gross_amount,
    'transaction_id' => 'TX-' . bin2hex(random_bytes(4)),
    'transaction_status' => $transaction_status,
    'payment_type' => 'bank_transfer'
];

// try to load server_key from config
$server_key = null;
if(file_exists(__DIR__ . '/../config/midtrans.php')){
    $cfg = require __DIR__ . '/../config/midtrans.php';
    $server_key = $cfg['server_key'] ?? null;
}
$server_key = getenv('MIDTRANS_SERVER_KEY') ?: $server_key;

if(!$server_key){
    echo "MIDTRANS server key not found. Set MIDTRANS_SERVER_KEY env var or config/midtrans.php\n";
    exit(1);
}

$signature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $server_key);
$payload['signature_key'] = $signature;

echo "Posting to $endpoint\n";
echo json_encode($payload, JSON_PRETTY_PRINT) . "\n";

$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$res = curl_exec($ch);
$err = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($err){
    echo "Curl error: $err\n";
    exit(1);
}

echo "Response ($code):\n" . $res . "\n";
