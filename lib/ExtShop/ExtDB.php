<?php
class DB
{
    private $connection;
    private $query;
    private $select = '*';
    private $from;
    private $where = [];
    private $bindings = [];
    private $limit;
    private $offset;
    private $joins = [];
    private $orderBy = [];

    public function __construct($host, $user, $password, $database)
    {
        $this->connection = new mysqli($host, $user, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function reset()
    {
        $this->select = '*';
        $this->from = null;
        $this->where = [];
        $this->bindings = [];
        $this->limit = null;
        $this->offset = null;
        $this->joins = [];
        $this->orderBy = [];
        return $this;
    }

    public function select($fields = ['*'])
    {
        $this->select = implode(', ', $fields);
        return $this;
    }

    public function from($table)
    {
        $this->from = $table;
        return $this;
    }

    public function join($table, $condition, $type = 'INNER')
    {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    public function where($conditions = [])
    {
        foreach ($conditions as $field => $value) {
            $this->where[] = "$field = ?";
            $this->bindings[] = $value;
        }
        return $this;
    }

    // whereNot 추가
    public function whereNot($conditions = [])
    {
        foreach ($conditions as $field => $value) {
            $this->where[] = "$field != ?";
            $this->bindings[] = $value;
        }
        return $this;
    }

    // whereIn 추가
    public function whereIn($field, $values = [])
    {
        if (!empty($values)) {
            $placeholders = implode(', ', array_fill(0, count($values), '?'));
            $this->where[] = "$field IN ($placeholders)";
            foreach ($values as $value) {
                $this->bindings[] = $value;
            }
        }
        return $this;
    }

    // whereNotIn 추가
    public function whereNotIn($field, $values = [])
    {
        if (!empty($values)) {
            $placeholders = implode(', ', array_fill(0, count($values), '?'));
            $this->where[] = "$field NOT IN ($placeholders)";
            foreach ($values as $value) {
                $this->bindings[] = $value;
            }
        }
        return $this;
    }

    public function orderBy($fields = [])
    {
        foreach ($fields as $field => $direction) {
            $this->orderBy[] = "$field $direction";
        }
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function getOne()
    {
        // SQL 작성
        $sql = "SELECT $this->select FROM $this->from";

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
        }
        $sql .= " LIMIT 1";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        // 상태 초기화
        $this->reset();

        return $result;
    }

    public function get()
    {
        $sql = "SELECT $this->select FROM $this->from";
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }
        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(', ', $this->orderBy);
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
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // 상태 초기화
        $this->reset();

        return $result;
    }

    public function insert($table, $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        foreach ($data as $value) {
            $this->bindings[] = $value;
        }
        $stmt = $this->prepare($sql);
        $result = $stmt->execute();
        $this->reset();
        return $result;
    }

    public function update($table, $data, $conditions = [])
    {
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
        $result = $stmt->execute();
        $this->reset();
        return $result;
    }

    public function delete($table, $conditions = [])
    {
        $sql = "DELETE FROM $table";

        if (!empty($conditions)) {
            $this->where($conditions);
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $stmt = $this->prepare($sql);
        $result = $stmt->execute();
        $this->reset();
        return $result;
    }

    public function paginate($page = 1, $perPage = 10)
    {
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

    private function getTotal()
    {
        $sql = "SELECT COUNT(*) as total FROM $this->from";
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total'];
    }

    private function prepare($sql)
    {
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

    public function query($sql)
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            die("Failed to prepare statement: " . $this->connection->error);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $this->reset();
        return $result;
    }

    public function close()
    {
        $this->connection->close();
    }
}




/*
 *  $db = new DB('localhost', 'username', 'password', 'database');
 * $results = $db->select(['id', 'name'])
              ->from('users')
              ->whereNot(['status' => 'inactive'])
              ->limit(10)
              ->get();




 // 기본 SELECT 예시
 $results = $db->select(['id', 'name'])
 ->from('users')
 ->where(['status' => 'active'])
 ->limit(10)
 ->get();

 print_r($results);



 // JOIN을 포함한 SELECT 예시
 $results = $db->select(['users.id', 'users.name', 'profiles.bio'])
 ->from('users')
 ->join('profiles', 'users.id = profiles.user_id')
 ->where(['users.status' => 'active'])
 ->limit(10)
 ->get();

 print_r($results);



 // INSERT 예시
 $data = [
 'name' => 'John Doe',
 'email' => 'john.doe@example.com',
 'status' => 'active'
 ];
 $inserted = $db->insert('users', $data);

 echo $inserted ? 'Insert successful' : 'Insert failed';




 // UPDATE 예시
 $data = ['status' => 'inactive'];
 $updated = $db->update('users', $data, ['email' => 'john.doe@example.com']);

 echo $updated ? 'Update successful' : 'Update failed';



 // DELETE 예시
 $deleted = $db->delete('users', ['email' => 'john.doe@example.com']);

 echo $deleted ? 'Delete successful' : 'Delete failed';





 // 직접 SQL 쿼리 실행 예시
 $sql = "SELECT id, name FROM users WHERE status = 'active' LIMIT 10";
 $results = $db->query($sql);

 print_r($results);




 // Pagination 예시
 $page = 1;
 $perPage = 10;
 $pagination = $db->select(['id', 'name'])
 ->from('users')
 ->where(['status' => 'active'])
 ->paginate($page, $perPage);

 print_r($pagination);



 * */

