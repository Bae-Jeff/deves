<?php

class ExtShopItemLog {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        return $this->db->insert('ext_shop_item_log', $data);
    }

    public function read($conditions = [], $limit = 10) {
        return $this->db->select(['*'])
            ->from('ext_shop_item_log')
            ->where($conditions)
            ->limit($limit)
            ->get();
    }

    public function update($data, $conditions) {
        return $this->db->update('ext_shop_item_log', $data, $conditions);
    }

    public function delete($conditions) {
        return $this->db->delete('ext_shop_item_log', $conditions);
    }
}
