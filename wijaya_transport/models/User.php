<?php
class User {
    protected $pdo;
    protected $schema = null;

    public function __construct($pdo){ $this->pdo = $pdo; }

    protected function hasColumn(string $column): bool {
        if($this->schema === null){
            $colsInfo = $this->pdo->query("DESCRIBE users")->fetchAll(PDO::FETCH_ASSOC);
            $this->schema = array_column($colsInfo, 'Field');
        }
        return in_array($column, $this->schema, true);
    }

    public function findByIdentifier(string $identifier){
        if($this->hasColumn('username')){
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :id OR email = :id LIMIT 1");
            $stmt->execute(['id'=>$identifier]);
            return $stmt->fetch();
        }
        if($identifier === 'admin'){
            return $this->findByEmail('admin@example.test');
        }
        return $this->findByEmail($identifier);
    }

    public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email'=>$email]);
        return $stmt->fetch();
    }

    public function findAdmin(){
        if($this->hasColumn('role')){
            $stmt = $this->pdo->query("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
            return $stmt->fetch();
        }
        return $this->findByEmail('admin@example.test');
    }

    public function find($id){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch();
    }

    public function create($data){
        $columns = ['name','email','password','phone','address','role'];
        $params = [
            'name'=>$data['name'],'email'=>$data['email'],'password'=>$data['password'],
            'phone'=>$data['phone'] ?? null,'address'=>$data['address'] ?? null,
            'role'=>$data['role'] ?? 'user'
        ];
        if($this->hasColumn('username')){
            array_splice($columns, 1, 0, 'username');
            $params['username'] = $data['username'] ?? null;
        }
        if($this->hasColumn('created_at')){
            $columns[] = 'created_at';
            $params['created_at'] = date('Y-m-d H:i:s');
        }

        $placeholders = array_map(function($col){ return ':' . $col; }, $columns);
        $sql = 'INSERT INTO users (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
