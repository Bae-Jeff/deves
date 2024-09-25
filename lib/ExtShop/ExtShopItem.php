<?php
class ExtShopItem {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        return $this->db->insert('ext_shop_item', $data);
    }

    public function read($conditions = [], $limit = 10) {
        return $this->db->select(['*'])
            ->from('ext_shop_item')
            ->where($conditions)
            ->limit($limit)
            ->get();
    }

    public function update($data, $conditions) {
        return $this->db->update('ext_shop_item', $data, $conditions);
    }

    public function delete($conditions) {
        return $this->db->delete('ext_shop_item', $conditions);
    }
}
/*
 // 데이터베이스 연결 객체 생성
$db = new DatabaseConnection(); // 예시: 실제 데이터베이스 연결 클래스

// ExtShopItemLog 사용 예시
$log = new ExtShopItemLog($db);
$log->create([
    'uuid' => 'some-unique-id',
    'item_id' => 1,
    'item_options' => 'option1, option2',
    'member_id' => 'member123',
    'start_date' => '230101',
    'end_date' => '230202',
    'log_status' => 'Active',
    'remain_download_days' => 5,
    'remain_use_days' => 10,
    'creater' => 'admin'
]);

// ExtShopItem 사용 예시
$item = new ExtShopItem($db);
$items = $item->read(['status' => 'active']);
print_r($items);

// ExtShopItemOrders 사용 예시
$order = new ExtShopItemOrders($db);
$order->create([
    'uuid' => 'order-unique-id',
    'ex_order_parent' => 1,
    'order_id' => 'order-001',
    'order_detail_id' => 'detail-001',
    'item_id' => 1,
    'item_option_1' => 1,
    'item_option_2' => 2,
    'item_option_3' => 3,
    'item_use_days' => 30,
    'item_download_days' => 5,
    'member_id' => 'member123',
    'ex_order_status' => 'Registered',
    'creater' => 'admin'
]);
 * */