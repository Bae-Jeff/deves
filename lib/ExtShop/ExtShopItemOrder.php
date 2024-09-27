<?php

class ExtShopItemOrder {
    protected $db;
    protected $itemLog;
    protected $isApi = false;
    public function __construct($db,$isApi = false) {
        $this->db = $db;
        $this->itemLog = new ExtShopItemLog($db);
        $this->isApi = $isApi;
    }
    public function checkValidParams($requiredParams) {
        foreach($requiredParams as $param) {
            if(!isset($this->params[$param])) {
                throw new Exception('Invalid params : '.$param);
            }
        }
    }
    public function returnJson($data = [],$code = 200,$message = 'success'){
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ],JSON_PRETTY_PRINT);
        exit;
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
        return $this->db->delete('ext_shop_item_orders', $conditions,[
            'ex_order_status' => 'D',
            'deleted_date' => date('Y-m-d H:i:s')
        ]);
    }
}

/*

CREATE TABLE `ext_shop_item_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '순번',
  `uuid` varchar(36) NOT NULL COMMENT '고유 식별자',
  `ex_order_parent` int(11) DEFAULT NULL COMMENT 'ext_shop_item_log의 ID',
  `order_id` varchar(50) DEFAULT NULL COMMENT '주문 ID',
  `order_detail_id` varchar(50) DEFAULT NULL COMMENT '주문 상세 ID',
  `item_id` int(11) DEFAULT NULL COMMENT '상품순번',
  `item_option_1` int(11) DEFAULT NULL COMMENT '상품옵션 1',
  `item_option_2` int(11) DEFAULT NULL COMMENT '상품옵션 2',
  `item_option_3` int(11) DEFAULT NULL COMMENT '상품옵션 3',
  `item_option_full` varchar(255) DEFAULT NULL COMMENT '전체 상품 옵션',
  `item_use_days` int(11) DEFAULT NULL COMMENT '사용 가능한 일수',
  `item_download_days` int(11) DEFAULT NULL COMMENT '다운로드 일수',
  `member_id` varchar(50) DEFAULT NULL COMMENT '회원 ID',
  `ex_order_status` varchar(10) DEFAULT NULL COMMENT '주문 상태 (Registered, Paid, Failed, Deleted)',
  `creater` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 * */