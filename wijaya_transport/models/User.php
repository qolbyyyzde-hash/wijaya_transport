<?php
class User {
    protected $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email'=>$email]);
        return $stmt->fetch();
    }

    public function find($id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }

    public function create($data){
        $stmt = $this->pdo->prepare("INSERT INTO users (name,email,password,phone,address,role,created_at) VALUES (:name,:email,:password,:phone,:address,:role,NOW())");
        return $stmt->execute([
            'name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],'phone'=>$data['phone'] ?? null,'address'=>$data['address'] ?? null,'role'=>$data['role'] ?? 'user'
        ]);
    }
}
