<?php
class DB
{
    private $connection;
    private $query;
    private $lastQuery; // 마지막 쿼리를 저장할 변수 추가
    private $lastBindings = []; // 마지막 실행된 쿼리의 바인딩 값 저장
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

    public function whereNot($conditions = [])
    {
        foreach ($conditions as $field => $value) {
            $this->where[] = "$field != ?";
            $this->bindings[] = $value;
        }
        return $this;
    }

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
        $sql = "SELECT $this->select FROM $this->from";
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($this->where)) {
            $sql .= " WHERE " . implode(' AND ', $this->where);
        }

        // 기본적으로 ORDER BY id DESC 추가
        // $sql .= " ORDER BY id DESC";

        // LIMIT 1 설정
        $sql .= " LIMIT 1";

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

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

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

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

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

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

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

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

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

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

        // 마지막 쿼리 저장
        $this->lastQuery = $sql;

        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total'];
    }

    private function prepare($sql)
    {
        // 쿼리와 바인딩을 저장
        $this->lastQuery = $sql;
        $this->lastBindings = $this->bindings; // 쿼리가 실행될 때의 바인딩 값을 따로 저장

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

    // 마지막으로 실행된 쿼리를 반환하는 메서드
    public function getLastQuery()
    {
        // 쿼리에 바인딩된 값을 순차적으로 삽입
        $query = $this->lastQuery;
        foreach ($this->lastBindings as $binding) {
            // 문자열일 경우 따옴표를 추가
            $value = is_numeric($binding) ? $binding : "'$binding'";
            $query = preg_replace('/\?/', $value, $query, 1);
        }

        return $query;
    }

    public function close()
    {
        $this->connection->close();
    }
    public function renderPagination($pagination) {

        // 현재 URL에서 쿼리스트링을 제거한 베이스 URL 구하기
        $urlWithoutPage = preg_replace('/([&?])page=[^&]+/', '', $_SERVER['REQUEST_URI']);

        // URL에 이미 다른 파라미터가 있는지 확인
        $querySeparator = strpos($urlWithoutPage, '?') === false ? '?' : '&';

        $html = '<ul class="pagination pagination-sm en" style="margin-top:0; padding-top:0;">';

        // 왼쪽 화살표 (처음, 이전 페이지)
        if ($pagination['current_page'] > 1) {
            $html .= '<li><a href="' . $urlWithoutPage . $querySeparator . 'page=1" data-page="1"><i class="fa fa-angle-double-left"></i></a></li>';
            $html .= '<li><a href="' . $urlWithoutPage . $querySeparator . 'page=' . ($pagination['current_page'] - 1) . '" data-page="' . ($pagination['current_page'] - 1) . '"><i class="fa fa-angle-left"></i></a></li>';
        } else {
            $html .= '<li class="disabled"><a><i class="fa fa-angle-double-left"></i></a></li>';
            $html .= '<li class="disabled"><a><i class="fa fa-angle-left"></i></a></li>';
        }

        // 페이지 번호
        for ($i = 1; $i <= $pagination['last_page']; $i++) {
            if ($i == (int)$pagination['current_page']) { // 현재 페이지가 active
                $html .= '<li class="active"><a href="#">' . $i . '</a></li>';
            } else {
                $html .= '<li><a href="' . $urlWithoutPage . $querySeparator . 'page=' . $i . '" data-page="' . $i . '">' . $i . '</a></li>';
            }
        }

        // 오른쪽 화살표 (다음, 마지막 페이지)
        if ($pagination['current_page'] < $pagination['last_page']) {
            $html .= '<li><a href="' . $urlWithoutPage . $querySeparator . 'page=' . ($pagination['current_page'] + 1) . '" data-page="' . ($pagination['current_page'] + 1) . '"><i class="fa fa-angle-right"></i></a></li>';
            $html .= '<li><a href="' . $urlWithoutPage . $querySeparator . 'page=' . $pagination['last_page'] . '" data-page="' . $pagination['last_page'] . '"><i class="fa fa-angle-double-right"></i></a></li>';
        } else {
            $html .= '<li class="disabled"><a><i class="fa fa-angle-right"></i></a></li>';
            $html .= '<li class="disabled"><a><i class="fa fa-angle-double-right"></i></a></li>';
        }

        $html .= '</ul>';
        return $html;
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

