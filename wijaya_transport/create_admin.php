<?php
// Run this script once (via browser or CLI) to create an initial admin user.
require_once __DIR__ . '/config/database.php';

$name = $argv[1] ?? 'Administrator';
$username = $argv[2] ?? 'admin';
$email = $argv[3] ?? 'admin@example.test';
$password = $argv[4] ?? 'admin123';

$hash = password_hash($password, PASSWORD_DEFAULT);
$schema = $pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_COLUMN, 0);
$hasUsername = in_array('username', $schema, true);

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email" . ($hasUsername ? " OR username = :username" : "") . " LIMIT 1");
$params = ['email'=>$email];
if($hasUsername){ $params['username'] = $username; }
$stmt->execute($params);
if($stmt->fetch()){
    echo "User with email $email or username $username already exists\n";
    exit;
}

$columns = ['name','email','password','phone','address','role','created_at'];
$params = ['name'=>$name,'email'=>$email,'password'=>$hash,'phone'=>null,'address'=>null,'role'=>'admin'];
if($hasUsername){
    array_splice($columns, 1, 0, 'username');
    $params['username'] = $username;
}
$placeholders = array_map(fn($col) => ':' . $col, $columns);
$sql = 'INSERT INTO users (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')';
$ins = $pdo->prepare($sql);
$ins->execute($params);

echo "Created admin user: $username with email $email and password $password\n";
