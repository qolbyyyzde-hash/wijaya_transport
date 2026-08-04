<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Car.php';

$carModel = new Car($pdo);
$action = $_GET['action'] ?? 'list';

if($action === 'list'){
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    if($search !== ''){
        // search all cars (show results even if not available) so UI can show unavailable state
        $cars = $carModel->search($search);
    } else {
        // list all cars and let the view decide availability badge/state
        $cars = $carModel->all();
    }
    include __DIR__ . '/../views/cars/list.php';
    exit;
}

if($action === 'detail'){
    $id = $_GET['id'] ?? null;
    $car = $carModel->find($id);
    if(!$car){ http_response_code(404); echo 'Car not found'; exit; }
    include __DIR__ . '/../views/cars/detail.php';
    exit;
}

http_response_code(404);
echo 'Not found';
