<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Car.php';
require_once __DIR__ . '/../middleware/csrf.php';

$carModel = new Car($pdo);

// Simple router via 'action' param
$action = $_GET['action'] ?? 'index';
// ensure csrf token for views
$csrf = generate_csrf_token();
if($action === 'index'){
    $cars = $carModel->all();
    include __DIR__ . '/../views/admin/cars/index.php';
    exit;
}

if($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ header('Location: /wijaya_transport/admin.php?module=cars&action=new&err=csrf'); exit; }
    // handle upload if exists
    $imagePath = null;
    // basic sanitation
    $brand = trim((string)($_POST['brand'] ?? ''));
    $modelName = trim((string)($_POST['model'] ?? ''));
    $year = isset($_POST['year']) ? (int)$_POST['year'] : null;
    $plate = trim((string)($_POST['plate_number'] ?? ''));
    $price = isset($_POST['price_per_day']) ? (float)$_POST['price_per_day'] : 0.0;
    $status = in_array($_POST['status'] ?? 'available',['available','unavailable']) ? $_POST['status'] : 'available';

    if($brand === '' || $modelName === '' || !$year || $price <= 0){
        header('Location: /wijaya_transport/admin.php?module=cars&action=new&err=validation'); exit;
    }

    if(!empty($_FILES['image']['name'])){
        $targetDir = __DIR__ . '/../uploads/cars/';
        if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
        $tmp = $_FILES['image']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmp);
        finfo_close($finfo);
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if(!isset($allowed[$mime])){ header('Location: /wijaya_transport/admin.php?module=cars&action=new&err=badimage'); exit; }
        $ext = $allowed[$mime];
        $filename = time() . '_' . preg_replace('/[^a-z0-9\._-]/i','',basename($_FILES['image']['name']));
        $targetFile = $targetDir . $filename;
        if(move_uploaded_file($tmp,$targetFile)){
            $imagePath = 'uploads/cars/' . $filename;
        }
    }

    $data = [
        'brand'=>$brand,'model'=>$modelName,'year'=>$year,'plate_number'=>$plate,'price_per_day'=>$price,'image'=>$imagePath,'status'=>$status
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
    if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ header('Location: /wijaya_transport/admin.php?module=cars&action=edit&id=' . ($_POST['id'] ?? '') . '&err=csrf'); exit; }
    $id = $_POST['id'];
    // sanitize
    $brand = trim((string)($_POST['brand'] ?? ''));
    $modelName = trim((string)($_POST['model'] ?? ''));
    $year = isset($_POST['year']) ? (int)$_POST['year'] : null;
    $plate = trim((string)($_POST['plate_number'] ?? ''));
    $price = isset($_POST['price_per_day']) ? (float)$_POST['price_per_day'] : 0.0;
    $status = in_array($_POST['status'] ?? 'available',['available','unavailable']) ? $_POST['status'] : 'available';

    $data = ['brand'=>$brand,'model'=>$modelName,'year'=>$year,'plate_number'=>$plate,'price_per_day'=>$price,'status'=>$status];
    if(!empty($_FILES['image']['name'])){
        $targetDir = __DIR__ . '/../uploads/cars/';
        if(!is_dir($targetDir)) mkdir($targetDir,0755,true);
        $tmp = $_FILES['image']['tmp_name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmp);
        finfo_close($finfo);
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if(!isset($allowed[$mime])){ header('Location: /wijaya_transport/admin.php?module=cars&action=edit&id=' . $id . '&err=badimage'); exit; }
        $filename = time() . '_' . preg_replace('/[^a-z0-9\._-]/i','',basename($_FILES['image']['name']));
        $targetFile = $targetDir . $filename;
        if(move_uploaded_file($tmp,$targetFile)){
            $data['image'] = 'uploads/cars/' . $filename;
        }
    }
    $carModel->update($id,$data);
    header('Location: /wijaya_transport/admin.php?module=cars');
    exit;
}

if($action === 'delete'){
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        http_response_code(405); echo 'Method not allowed'; exit;
    }
    $id = $_POST['id'] ?? null;
    $token = $_POST['csrf_token'] ?? '';
    if(!verify_csrf_token($token)){ header('Location: /wijaya_transport/admin.php?module=cars&err=csrf'); exit; }
    $carModel->delete($id);
    header('Location: /wijaya_transport/admin.php?module=cars');
    exit;
}

http_response_code(404);
echo 'Action not found';
