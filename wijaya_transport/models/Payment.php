<?php
class Payment {
    protected $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function create($data){
        $stmt = $this->pdo->prepare("INSERT INTO payments (booking_id,transaction_id,payment_method,amount,status,payment_date) VALUES (:booking_id,:transaction_id,:payment_method,:amount,:status,:payment_date)");
        return $stmt->execute([
            'booking_id'=>$data['booking_id'],'transaction_id'=>$data['transaction_id'] ?? null,'payment_method'=>$data['payment_method'] ?? null,'amount'=>$data['amount'],'status'=>$data['status'] ?? 'pending','payment_date'=>$data['payment_date'] ?? null
        ]);
    }

    public function updateStatusByTransaction($transaction_id,$status){
        $stmt = $this->pdo->prepare("UPDATE payments SET status = :status WHERE transaction_id = :tx");
        return $stmt->execute(['status'=>$status,'tx'=>$transaction_id]);
    }
}
