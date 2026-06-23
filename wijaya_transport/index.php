<?php
// Simple front controller with basic routing
require_once __DIR__ . '/config/database.php';

$page = $_GET['page'] ?? 'home';
if($page === 'cars'){
	include __DIR__ . '/controllers/public_controller.php';
	exit;
}

if($page === 'car'){
	include __DIR__ . '/controllers/public_controller.php';
	exit;
}

if($page === 'booking'){
    include __DIR__ . '/controllers/public_booking_controller.php';
    exit;
}

// default
include __DIR__ . '/views/home.php';
