<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/csrf.php';

$userModel = new User($pdo);
$action = $_GET['action'] ?? 'login';

if($action === 'login'){
    // Create a fallback default admin account if no admin exists yet.
    if(!$userModel->findAdmin()){
        $userModel->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@example.test',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin'
        ]);
    }
    $csrf = generate_csrf_token();
    include __DIR__ . '/../views/auth/login.php';
    exit;
}

if($action === 'authenticate' && $_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ header('Location: /wijaya_transport/admin.php?module=auth&action=login&err=csrf'); exit; }
    $identifier = trim((string)($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';
    $user = $userModel->findByIdentifier($identifier);
    if($user && password_verify($password, $user['password'])){
        $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'role'=>$user['role']];
        header('Location: /wijaya_transport/admin.php');
        exit;
    }
    header('Location: /wijaya_transport/admin.php?module=auth&action=login&err=1');
    exit;
}

if($action === 'logout'){
    // Require POST + CSRF for logout to avoid CSRF logout attacks
    if($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? '')){
        header('Location: /wijaya_transport/admin.php?module=auth&action=login');
        exit;
    }
    session_destroy();
    header('Location: /wijaya_transport/admin.php?module=auth&action=login');
    exit;
}

http_response_code(404);
echo 'Not found';
