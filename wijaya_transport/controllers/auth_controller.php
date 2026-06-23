<?php
session_start();
require_once __DIR__ . '/../models/User.php';

$userModel = new User($pdo);
$action = $_GET['action'] ?? 'login';

if($action === 'login'){
    include __DIR__ . '/../views/auth/login.php';
    exit;
}

if($action === 'authenticate' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = $userModel->findByEmail($email);
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'role'=>$user['role']];
        header('Location: /wijaya_transport/admin.php');
        exit;
    }
    header('Location: /wijaya_transport/admin.php?module=auth&action=login&err=1');
    exit;
}

if($action === 'logout'){
    session_destroy();
    header('Location: /wijaya_transport/admin.php?module=auth&action=login');
    exit;
}

http_response_code(404);
echo 'Not found';
