<?php
// Run this script once (via browser or CLI) to create an initial admin user.
require_once __DIR__ . '/config/database.php';

$name = $argv[1] ?? 'Admin';
$email = $argv[2] ?? 'admin@example.test';
$password = $argv[3] ?? 'admin123';

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
$stmt->execute(['email'=>$email]);
if($stmt->fetch()){
    echo "User with email $email already exists\n";
    exit;
}

$ins = $pdo->prepare("INSERT INTO users (name,email,password,phone,address,role,created_at) VALUES (:name,:email,:password,:phone,:address,:role,NOW())");
$ins->execute(['name'=>$name,'email'=>$email,'password'=>$hash,'phone'=>null,'address'=>null,'role'=>'admin']);

echo "Created admin user: $email with password: $password\n";
