<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';
require_admin();

$type = $_GET['type'] ?? null;
if(!$type || !in_array($type,['bookings','payments'])){ http_response_code(400); echo 'invalid export type'; exit; }

if($type === 'bookings'){
    $stmt = $pdo->query("SELECT b.id,b.user_id,b.car_id,b.start_date,b.end_date,b.total_price,b.status,b.created_at,c.brand,c.model FROM bookings b LEFT JOIN cars c ON b.car_id = c.id ORDER BY b.id DESC");
    $rows = $stmt->fetchAll();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="bookings_export_'.date('Ymd_His').'.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['id','user_id','car_id','brand','model','start_date','end_date','total_price','status','created_at']);
    foreach($rows as $r) fputcsv($out, [$r['id'],$r['user_id'],$r['car_id'],$r['brand'],$r['model'],$r['start_date'],$r['end_date'],$r['total_price'],$r['status'],$r['created_at']]);
    fclose($out);
    exit;
}

if($type === 'payments'){
    $stmt = $pdo->query("SELECT p.id,p.booking_id,p.transaction_id,p.payment_method,p.amount,p.status,p.payment_date,b.user_id,c.brand,c.model FROM payments p LEFT JOIN bookings b ON p.booking_id = b.id LEFT JOIN cars c ON b.car_id = c.id ORDER BY p.id DESC");
    $rows = $stmt->fetchAll();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="payments_export_'.date('Ymd_His').'.csv"');
    $out = fopen('php://output','w');
    fputcsv($out, ['id','booking_id','user_id','brand','model','transaction_id','payment_method','amount','status','payment_date']);
    foreach($rows as $r) fputcsv($out, [$r['id'],$r['booking_id'],$r['user_id'],$r['brand'],$r['model'],$r['transaction_id'],$r['payment_method'],$r['amount'],$r['status'],$r['payment_date']]);
    fclose($out);
    exit;
}
