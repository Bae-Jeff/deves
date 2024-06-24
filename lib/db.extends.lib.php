<?php

class DB {
    private $connection;
    private $query;
    private $select = '*';
    private $from;
    private $where = [];
    private $bindings = [];
    private $limit;
    private $offset;
    
    public function __construct($host, $user, $password, $database) {
        $this->connection = new mysqli($host, $user, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    
    public function select($fields = ['*']) {
        $this->select = implode(', ', $fields);
        return $this;
    }
    
    public function from($table) {
        $this->from = $table;
        return $this;
    }
    
    public function where($conditions = []) {
        foreach ($conditions as $field => $value) {
            $this->where[] = "$field = ?";
            $this->bindings[] = $value;
        }
        return $this;
    }
    
    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }
    
    public function offset($offset) {
        $this->offset = $offset;
        return $this;
    }
    
    public function get() {
        $sql = "SELECT $this->select FROM $this->from";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        if ($this->limit) {
            $sql .= " LIMIT ?";
            $this->bindings[] = $this->limit;
        }
        if ($this->offset) {
            $sql .= " OFFSET ?";
            $this->bindings[] = $this->offset;
        }
        
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        
        $stmt = $this->prepare($sql);
        foreach ($data as $value) {
            $this->bindings[] = $value;
        }
        return $stmt->execute();
    }
    
    public function update($table, $data, $conditions = []) {
        $fields = [];
        foreach ($data as $field => $value) {
            $fields[] = "$field = ?";
            $this->bindings[] = $value;
        }
        $sql = "UPDATE $table SET " . implode(', ', $fields);
        
        if (!empty($conditions)) {
            $this->where($conditions);
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->prepare($sql);
        return $stmt->execute();
    }
    
    public function delete($table, $conditions = []) {
        $sql = "DELETE FROM $table";
        
        if (!empty($conditions)) {
            $this->where($conditions);
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->prepare($sql);
        return $stmt->execute();
    }
    
    public function paginate($page = 1, $perPage = 10) {
        $this->limit = $perPage;
        $this->offset = ($page - 1) * $perPage;
        
        $total = $this->getTotal();
        $data = $this->get();
        
        return [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'data' => $data
        ];
    }
    
    private function getTotal() {
        $sql = "SELECT COUNT(*) as total FROM $this->from";
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return $result['total'];
    }
    
    private function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Failed to prepare statement: " . $this->connection->error);
        }
        
        if (!empty($this->bindings)) {
            $types = str_repeat('s', count($this->bindings)); // assuming all values are strings for simplicity
            $stmt->bind_param($types, ...$this->bindings);
        }
        return $stmt;
    }
    
    public function close() {
        $this->connection->close();
    }
}
 

// SELECT with pagination
// $results = $db->select(['id', 'name'])
// ->from('users')
// ->where(['status' => 'active'])
// ->paginate(2, 10);
// print_r($results);

// // INSERT
// $insert = $db->insert('users', ['name' => 'John', 'email' => 'john@example.com']);
// echo $insert ? "Insert successful" : "Insert failed";

// // UPDATE
// $update = $db->update('users', ['name' => 'John Doe'], ['id' => 1]);
// echo $update ? "Update successful" : "Update failed";

// // DELETE
// $delete = $db->delete('users', ['id' => 1]);
// echo $delete ? "Delete successful" : "Delete failed";

// $db->close();
?>
