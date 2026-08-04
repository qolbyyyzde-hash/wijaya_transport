<?php
class Payment {
    protected $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function create($data){
        $stmt = $this->pdo->prepare("INSERT INTO payments (booking_id,transaction_id,payment_method,amount,status,payment_date,proof_image) VALUES (:booking_id,:transaction_id,:payment_method,:amount,:status,:payment_date,:proof_image)");
        return $stmt->execute([
            'booking_id'=>$data['booking_id'],'transaction_id'=>$data['transaction_id'] ?? null,'payment_method'=>$data['payment_method'] ?? null,'amount'=>$data['amount'],'status'=>$data['status'] ?? 'pending','payment_date'=>$data['payment_date'] ?? null,'proof_image'=>$data['proof_image'] ?? null
        ]);
    }

    public function updateStatusByTransaction($transaction_id,$status){
        $stmt = $this->pdo->prepare("UPDATE payments SET status = :status WHERE transaction_id = :tx");
        return $stmt->execute(['status'=>$status,'tx'=>$transaction_id]);
    }
}
