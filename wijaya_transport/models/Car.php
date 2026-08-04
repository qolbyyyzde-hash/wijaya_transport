<?php
class Car {
    protected $pdo;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function all(){
        $stmt = $this->pdo->query("SELECT * FROM cars ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function available(){
        $stmt = $this->pdo->query("SELECT * FROM cars WHERE status = 'available' ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function search($term){
        $term = '%' . $term . '%';
        $stmt = $this->pdo->prepare("SELECT DISTINCT * FROM cars WHERE brand LIKE :t OR model LIKE :t ORDER BY created_at DESC");
        $stmt->execute(['t' => $term]);
        return $stmt->fetchAll();
    }

    public function searchAvailable($term){
        $term = '%' . $term . '%';
        $stmt = $this->pdo->prepare("SELECT DISTINCT * FROM cars WHERE status = 'available' AND (brand LIKE :t OR model LIKE :t) ORDER BY created_at DESC");
        $stmt->execute(['t' => $term]);
        return $stmt->fetchAll();
    }

    public function find($id){
        $stmt = $this->pdo->prepare("SELECT * FROM cars WHERE id = :id LIMIT 1");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }

    public function create($data){
        $stmt = $this->pdo->prepare("INSERT INTO cars (brand,model,year,plate_number,price_per_day,image,status,created_at) VALUES (:brand,:model,:year,:plate,:price,:image,:status,NOW())");
        return $stmt->execute([
            'brand'=>$data['brand'],'model'=>$data['model'],'year'=>$data['year'],'plate'=>$data['plate_number'],'price'=>$data['price_per_day'],'image'=>$data['image'] ?? null,'status'=>$data['status'] ?? 'available'
        ]);
    }

    public function update($id,$data){
        $fields = [];
        $params = ['id'=>$id];
        foreach(['brand','model','year','plate_number','price_per_day','image','status'] as $f){
            if(isset($data[$f])){ $fields[] = "$f = :$f"; $params[$f] = $data[$f]; }
        }
        if(empty($fields)) return false;
        $sql = "UPDATE cars SET " . implode(',', $fields) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id){
        $stmt = $this->pdo->prepare("DELETE FROM cars WHERE id = :id");
        return $stmt->execute(['id'=>$id]);
    }
}
