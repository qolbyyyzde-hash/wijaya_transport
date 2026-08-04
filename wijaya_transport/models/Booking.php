<?php
class Booking {
    protected $pdo;
    public function __construct($pdo){ $this->pdo = $pdo; }

    public function create($data){
        // Build insert dynamically to allow optional customer fields (name, phone, email)
        $allowed = [
            'user_id'=>'user_id', 'car_id'=>'car_id', 'start_date'=>'start_date', 'end_date'=>'end_date',
            'total_price'=>'total_price', 'status'=>'status', 'customer_name'=>'customer_name',
            'customer_phone'=>'customer_phone', 'customer_email'=>'customer_email',
            'name'=>'name', 'phone'=>'phone', 'whatsapp'=>'whatsapp',
            'driver_option'=>'driver_option', 'pickup_option'=>'pickup_option',
            'foto_ktp'=>'foto_ktp', 'foto_sim'=>'foto_sim'
        ];

        // get existing columns from bookings table
        $colsInfo = $this->pdo->query("DESCRIBE bookings")->fetchAll(PDO::FETCH_ASSOC);
        $existing = array_map(function($r){ return $r['Field']; }, $colsInfo);

        $insertCols = [];
        $placeholders = [];
        $params = [];
        foreach($allowed as $key => $col){
            if(array_key_exists($key, $data) && in_array($col, $existing, true)){
                $insertCols[] = $col;
                $placeholders[] = ':' . $col;
                $params[$col] = $data[$key];
            }
        }

        // always include created_at if column exists
        if(in_array('created_at', $existing, true)){
            $insertCols[] = 'created_at';
            $placeholders[] = 'NOW()';
        }

        if(empty($insertCols)) return false;

        $sql = 'INSERT INTO bookings (' . implode(',', $insertCols) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute($params);
        if($ok) return $this->pdo->lastInsertId();
        return false;
    }

    public function findByUser($user_id){
        $stmt = $this->pdo->prepare("SELECT b.*, c.brand, c.model FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = :uid ORDER BY b.created_at DESC");
        $stmt->execute(['uid'=>$user_id]);
        return $stmt->fetchAll();
    }
}
