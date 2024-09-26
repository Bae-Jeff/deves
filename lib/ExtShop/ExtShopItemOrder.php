<?php

class ExtShopItemOrder {
    protected $db;
    protected $itemLog;
    public function __construct($db) {
        $this->db = $db;
        $this->itemLog = new ExtShopItemLog($db);
    }

    public function insertOrUpdate($orderData) {
        // 주문 데이터에서 필요한 필드 추출
        $memberId = $orderData['member_id'];
        $itemId = $orderData['item_id'];
        $itemUseDays = $orderData['item_use_days'];

        // Active 로그 확인
        $activeLog = $this->db->select(['*'])
            ->from('ext_shop_item_log')
            ->where([
                'member_id' => $memberId,
                'log_status' => 'A',
                'item_options' => $itemOption
            ])
            ->get();

        if (empty($activeLog)) {
            // Active 로그가 없는 경우, 새로운 로그를 삽입
            $newLogData = [
                'uuid' => uniqid(),
                'item_id' => $itemId,
                'item_options' => $orderData['item_option_full'], // 필요한 옵션
                'member_id' => $memberId,
                'start_date' => date('Ymd'), // 오늘 날짜로 설정
                'log_status' => 'A',
                'remain_download_days' => null, // 필요에 따라 설정
                'remain_use_days' => $itemUseDays, // 초기 남은 사용 일수 설정
                'creater' => 'admin' // 예시: 생성자
            ];
            $this->db->insert('ext_shop_item_log', $newLogData);
        } else {
            // Active 로그가 있는 경우, Pause 로그 확인
            $pauseLog = $this->db->select(['*'])
                ->from('ext_shop_item_log')
                ->where([
                    'member_id' => $memberId,
                    'log_status' => 'P'
                ])
                ->get();

            if (!empty($pauseLog)) {
                // Pause 로그가 있는 경우, remain_use_days 업데이트
                $logId = $pauseLog[0]['id']; // 첫 번째 Pause 로그를 선택
                $newRemainUseDays = $pauseLog[0]['remain_use_days'] + $itemUseDays;

                $this->db->update('ext_shop_item_log', ['remain_use_days' => $newRemainUseDays], ['id' => $logId]);
            }
        }

        // 주문 데이터 삽입 또는 업데이트
        // 예: 주문이 존재하는지 확인하고 업데이트, 없으면 삽입
        $existingOrder = $this->db->select(['*'])
            ->from('ext_shop_item_orders')
            ->where(['order_id' => $orderData['order_id']])
            ->get();

        if (empty($existingOrder)) {
            // 주문이 없는 경우, 삽입
            $this->db->insert('ext_shop_item_orders', $orderData);
        } else {
            // 주문이 있는 경우, 업데이트
            $this->db->update('ext_shop_item_orders', $orderData, ['order_id' => $orderData['order_id']]);
        }
    }

    public function create($data) {
        return $this->db->insert('ext_shop_item_orders', $data);
    }

    public function read($conditions = [], $limit = 10) {
        return $this->db->select(['*'])
            ->from('ext_shop_item_orders')
            ->where($conditions)
            ->limit($limit)
            ->get();
    }

    public function update($data, $conditions) {
        return $this->db->update('ext_shop_item_orders', $data, $conditions);
    }

    public function delete($conditions) {
        return $this->db->delete('ext_shop_item_orders', $conditions);
    }
}