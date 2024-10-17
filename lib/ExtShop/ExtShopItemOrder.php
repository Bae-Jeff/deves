<?php

class ExtShopItemOrder {
    protected $db;
    protected $params;
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
        header('Content-Type: application/json');
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'result' => $data
        ],JSON_PRETTY_PRINT);
        exit;
    }
    public function response($responseData = [],$code = 200,$message = 'success'){
        if($this->isApi){
            $this->returnJson($responseData,$code,$message);
            exit;
        }else{
            return $responseData;
        }
    }

    public function getLogOrders($params){
        $page = !empty($params['page']) && is_numeric($params['page'])?$params['page']:1;
        $perPage = !empty($params['per_page']) && is_numeric($params['page'])?$params['per_page']:10;
        $this->params =  $params;
        $this->checkValidParams([
            'parent_uuid',
        ]);
        $orders = $this->db->select(['*'])
            ->from('ext_shop_item_orders')
            ->where([
                'ex_order_parent' => $params['parent_uuid']
            ])
            ->join('g5_shop_order', 'g5_shop_order.od_id = ext_shop_item_orders.order_id')
            ->paginate($page,$perPage);
       return $this->response($orders);
    }
    public function updateExtOrderStatus($params){
        $this->params =  $params;
        $this->checkValidParams([
            'order_id',
            'order_status'
        ]);
        $curOrder = $this->db->select(['*'])
            ->from('ext_shop_item_orders')
            ->where([
                'order_id' => $params['order_id']
            ])
            ->orderBy([
                'id' => 'desc'
            ])
            ->getOne();
        $stateText =  $params['order_status'] .'('.$params['update_state_text'].')';
        $newChageLog = $curOrder['change_log'].date('Y-m-d H:i:s').' => ['.$_SESSION['ss_mb_id'].'] '.$stateText.' 주문 상태수정 <br>';
        $this->db->update('ext_shop_item_orders',[
                'ex_order_status' => $params['order_status'],
                'change_log' => $newChageLog,
                'updated_date' => date('Y-m-d H:i:s')
            ],
            [
                'id' => $curOrder['id'],
    //            'item_id' => $params['item_id'],
    //            'item_option' => $params['item_option_full']
            ]
        );
        makeLog('Order '.'['.$_SESSION['ss_mb_id'].'] '.$stateText.' 로 업데이트 <br>');
//        makeLog($this->db->getLastQuery());
    }
    public function insertExtOrder($params){
        global $extItemLog;
        $this->params =  $params;
        $this->checkValidParams([
            'member_id',
            'item_id',
            'item_option',
            'order_id',
            'item_use_days',
            'item_download_days',
            'order_status'
        ]);
        $activeLog = $extItemLog->getKeyLog([
            'member_id' => $params['member_id'],
            'item_id' => $params['item_id'],
            'item_option' => $params['item_option'],
        ]);
        $params['ex_order_parent'] = $activeLog['uuid'];
        $newChageLog = date('Y-m-d H:i:s').' => ['.$_SESSION['ss_mb_id'].']  주문 생성 <br>';

        $rsInsert = $this->db->insert('ext_shop_item_orders',[
            'uuid' => mekeUuid(),
            'ex_order_parent' => $activeLog['uuid'],
            'order_id' => $params['order_id'],
            'item_id' => $params['item_id'],
            'item_option_full' => $params['item_option'],
            'item_use_days' => $params['item_use_days'],
            'item_download_days' => $params['item_download_days'],
            'member_id' => $params['member_id'],
            'change_log' => $newChageLog,
            'ex_order_status' => $params['order_status']??'R',
            'creater' => $_SESSION['ss_mb_id'],
            'created_date' => date('Y-m-d H:i:s')
        ]);
        if($rsInsert){
            makeLog('Order 생성 완료');
            return $rsInsert;
        }else{
            makeLog('Order 생성 실패');
            makeLog('Params : '.json_encode($params));
        };
    }
}

/*
-- deves.ext_shop_item_orders definition


CREATE TABLE `ext_shop_item_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '순번',
  `uuid` varchar(36) NOT NULL COMMENT '고유 식별자',
  `ex_order_parent` varchar(36) NOT NULL COMMENT 'ext_shop_item_log의 ID',
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
  `ex_order_status` varchar(10) DEFAULT NULL COMMENT '주문 상태 (Registered, Cancel, Paid, Failed, Deleted)',
  `change_log` text DEFAULT NULL COMMENT '수정일지',
  `creater` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 * */