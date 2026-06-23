<?php
require_once __DIR__ . '/config/database.php';

$module = $_GET['module'] ?? 'dashboard';

// allow auth module without protecting
if($module === 'auth'){
    include __DIR__ . '/controllers/auth_controller.php';
    exit;
}

// protect admin routes
require_once __DIR__ . '/middleware/auth.php';
require_admin();

if($module === 'cars'){
    include __DIR__ . '/controllers/car_controller.php';
    exit;
}

if($module === 'payments'){
    include __DIR__ . '/controllers/payments_controller.php';
    exit;
}

// Simple admin dashboard placeholder
include __DIR__ . '/views/admin/dashboard.php';
