<?php
require_once __DIR__ . '/../models/Car.php';

$carModel = new Car($pdo);

// Simple router via 'action' param
$action = $_GET['action'] ?? 'index';
if($action === 'index'){
    $cars = $carModel->all();
    include __DIR__ . '/../views/admin/cars/index.php';
    exit;
}

if($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    // handle upload if exists
    $imagePath = null;
    if(!empty($_FILES['image']['name'])){
        $targetDir = __DIR__ . '/../uploads/cars/';
        if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
        $imagePath = 'uploads/cars/' . $filename;
    }
    $data = [
        'brand'=>$_POST['brand'],'model'=>$_POST['model'],'year'=>$_POST['year'],'plate_number'=>$_POST['plate_number'],'price_per_day'=>$_POST['price_per_day'],'image'=>$imagePath,'status'=>$_POST['status'] ?? 'available'
    ];
    $carModel->create($data);
    header('Location: /wijaya_transport/admin.php?module=cars');
    exit;
}

if($action === 'new'){
    include __DIR__ . '/../views/admin/cars/create.php';
    exit;
}

if($action === 'edit'){
    $id = $_GET['id'] ?? null;
    $car = $carModel->find($id);
    include __DIR__ . '/../views/admin/cars/edit.php';
    exit;
}

if($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $data = ['brand'=>$_POST['brand'],'model'=>$_POST['model'],'year'=>$_POST['year'],'plate_number'=>$_POST['plate_number'],'price_per_day'=>$_POST['price_per_day'],'status'=>$_POST['status']];
    if(!empty($_FILES['image']['name'])){
        $targetDir = __DIR__ . '/../uploads/cars/';
        if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
        $data['image'] = 'uploads/cars/' . $filename;
    }
    $carModel->update($id,$data);
    header('Location: /wijaya_transport/admin.php?module=cars');
    exit;
}

if($action === 'delete'){
    $id = $_GET['id'] ?? null;
    $carModel->delete($id);
    header('Location: /wijaya_transport/admin.php?module=cars');
    exit;
}

http_response_code(404);
echo 'Action not found';
