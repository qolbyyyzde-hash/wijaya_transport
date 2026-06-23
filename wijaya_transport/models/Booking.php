<?php
class Booking {
    protected $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function create($data){
        $stmt = $this->pdo->prepare("INSERT INTO bookings (user_id,car_id,start_date,end_date,total_price,status,created_at) VALUES (:user_id,:car_id,:start,:end,:total,:status,NOW())");
        $ok = $stmt->execute([
            'user_id'=>$data['user_id'],'car_id'=>$data['car_id'],'start'=>$data['start_date'],'end'=>$data['end_date'],'total'=>$data['total_price'],'status'=>$data['status'] ?? 'pending'
        ]);
        if($ok) return $this->pdo->lastInsertId();
        return false;
    }

    public function findByUser($user_id){
        $stmt = $this->pdo->prepare("SELECT b.*, c.brand, c.model FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = :uid ORDER BY b.created_at DESC");
        $stmt->execute(['uid'=>$user_id]);
        return $stmt->fetchAll();
    }
}
