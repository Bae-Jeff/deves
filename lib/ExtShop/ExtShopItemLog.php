<?php

class ExtShopItemLog {
    protected $db;
    protected $isApi = false;
    protected $params = [];
    protected $table = [
        'uuid',
        'item_id',
        'item_option',
        'start_date',
        'end_date',
        'log_status',
        'remain_download_days',
        'remain_use_days',
        'change_log',
        'creater',
        'created_date',
        'updated_date'
    ];
    public function __construct($db,$isApi = false) {
        $this->db = $db;
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
        return [
            'code' => $code,
            'message' => $message,
            'result' => $data
        ];
    }
    public function response($responseData = [],$code = 200,$message = 'success'){
        if($this->isApi){
            return $this->returnJson($responseData,$code,$message);
            exit;
        }else{
            return $responseData;
        }
    }

    public function getLogDetail($params){
        global $extItemOrder;
        $this->params = $params;
        $this->checkValidParams([
            'uuid',
        ]);

        $keyLog = $this->db->select(['*'])
            ->from('ext_shop_item_log')
            ->where([
               'uuid'=> $params['uuid']
            ])
            ->getOne();
        $logOrders = $extItemOrder->getLogOrders(['parent_uuid' => $keyLog['uuid']]);

        if($this->isApi){
            return $this->returnJson($logOrders);
        }else{
            return $logOrders;
        }
    }
    public function getKeyLogs($params){
        $this->params = $params;
        $this->checkValidParams([
            'member_id',
        ]);
        $page = !empty($params['page']) && is_numeric($params['page'])?$params['page']:1;
        $perPage = !empty($params['per_page']) && is_numeric($params['page'])?$params['per_page']:10;
        $rsActiveLogs = $this->db->select([
            'ext_shop_item_log.*',
            'g5_shop_item.it_name',
            'g5_shop_item.it_img1',
            'g5_shop_item.it_price',
            ])
            ->from('ext_shop_item_log')
            ->where([
                'member_id' => $params['member_id'],
                'log_status' => 'A'
            ])
            ->join('g5_shop_item', 'g5_shop_item.it_id = ext_shop_item_log.item_id')
            ->paginate($page,$perPage);
//        dump($this->db->getLastQuery());
        if($this->isApi){
            return $this->returnJson($rsActiveLogs);
        }else{
            return $rsActiveLogs;
        }
    }
    public function getKeyLog($params){
        $this->params = $params;
        $this->checkValidParams([
            'member_id',
            'item_id',
            'item_option'
        ]);
        $memberId = $params['member_id'];
        $itemId = $params['item_id'];
        $itemOption = $params['item_option'];
        $activeLog = $this->db->select(['*'])
            ->where([
                    'member_id' => $memberId,
                    'item_id' => $itemId,
                    'item_option' => $itemOption,
                    'log_status' => 'A'
                ])
            ->from('ext_shop_item_log')
            ->getOne();
        if(empty($activeLog)) { // Active Log 없으면
            $pausedLog = $this->db->select(['*'])
                ->where([
                    'member_id' => $memberId,
                    'item_id' => $itemId,
                    'item_option' => $itemOption,
                    'log_status' => 'P'
                ])
                ->from('ext_shop_item_log')
                ->getOne();
            if(!empty($pausedLog)) { // Paused Log 있으면
                $activeLog  =  $pausedLog;
            }else{ // Active , Paused 두 Log 모두 없으면
                $newLog = [
                    'uuid' => mekeUuid(),
                    'member_id' => $memberId,
                    'item_id' => $itemId,
                    'item_option' => $itemOption,
                    'log_status' => 'A',
                    'start_date' => date('Y-m-d'),
                    'creater' => $_SESSION['ss_mb_id'],
                    'created_date' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('ext_shop_item_log', $newLog);
                $activeLog = $this->db->select(['*'])->where(['uuid' => $newLog['uuid']])->from('ext_shop_item_log')->getOne();
            }
        }
        if($this->isApi){
            return $this->returnJson($activeLog);
        }else{
            return $activeLog;
        }
    }

    public function getLogItemStatus($params){
        global $extItemOrder;
        $this->params = $params;
        $this->checkValidParams([
            'uuid',
        ]);
        $activeLog = $this->db->select(['*'])
            ->where([
                'uuid' => $params['uuid']
            ])
            ->from('ext_shop_item_log')
            ->getOne();
        $logOrders = $this->db->select(['*'])
            ->from('ext_shop_item_orders')
            ->where([
                'ex_order_parent' => $params['uuid']
            ])
            ->get();
        $totalUseDays = 0;
        $totalDownDays = 0;
        $today = date('Ymd');
        foreach ($logOrders as $order) {
            if($order['ex_order_status'] == 'S'){
                $totalUseDays += $order['item_use_days'];
                $totalDownDays += $order['item_download_days'];
            }
        }

        // start_date와 totalUseDays를 비교하여 만료 체크
        $startDate = $activeLog['start_date'];
        $expirationDownDate = date('Ymd', strtotime($startDate . " + $totalDownDays days"));
        $expirationUseDate = date('Ymd', strtotime($startDate . " + $totalUseDays days"));

        // 오늘 날짜와 만료 날짜를 비교하여 남은 일수를 계산합니다.
        $today = new DateTime($today);
        //        -------------------
        $expirationDateUse = new DateTime($expirationUseDate);
        $intervalUse = $today->diff($expirationDateUse);
        $remainUseDays = $intervalUse->days;
        if($expirationDateUse < $today){
            $remainUseDays = -1 *  $remainUseDays;
        }
        //        -------------------
        $expirationDateDown = new DateTime($expirationDownDate);
        $intervalDown = $today->diff($expirationDateDown);
        $remainDownDays = $intervalDown->days; // 남은 일수
        if($expirationDateDown < $today){
            $remainDownDays = -1 *  $remainDownDays;
        }

        return $this->response([
            'useStatus' => [
                'days' => $remainUseDays <= 1 ? 0: $remainUseDays,
                'date' => $expirationUseDate
            ],
            'downloadStatus' => [
                'days' => $remainDownDays <= 1 ? 0: $remainDownDays,
                'date' => $expirationDownDate
            ]
        ]);
    }
    public function update($data, $conditions) {
        return $this->db->update('ext_shop_item_log', $data, $conditions);
    }

    public function delete($conditions) {
        return $this->db->update('ext_shop_item_log', [
            'log_status' => 'D',
            'deleted_date' => date('Y-m-d H:i:s')
        ],$conditions);
    }
}


/*
 CREATE TABLE `ext_shop_item_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '순번',
  `uuid` varchar(36) NOT NULL COMMENT '고유 식별자',
  `item_id` int(11) DEFAULT NULL COMMENT '상품순번',
  `item_option` varchar(255) DEFAULT NULL COMMENT '상품옵션',
  `member_id` varchar(50) DEFAULT NULL COMMENT '회원 ID',
  `start_date` datetime DEFAULT NULL COMMENT '시작일 (yymmdd)',
  `end_date` datetime DEFAULT NULL COMMENT '종료일 (yymmdd)',
  `log_status` varchar(1) DEFAULT NULL COMMENT '로그 상태 (Active, End, Paused)',
  `remain_download_days` int(11) DEFAULT NULL COMMENT '남은 다운로드 일수',
  `remain_use_days` int(11) DEFAULT NULL COMMENT '남은 사용 일수',
  `change_log` text DEFAULT NULL COMMENT '수정일지',
  `creater` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 * */