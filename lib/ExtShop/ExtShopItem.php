<?php
class ExtShopItem {
    protected $db;
    protected $isApi = false;
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
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ],JSON_PRETTY_PRINT);
        exit;
    }
    public function getItemVersion($params){
        return $this->db->select(['*'])
            ->from('ext_shop_item')
            ->where([
                'item_target' => $params['item_target'],
                'item_id' => $params['item_id'],
                'extend_type'=> 'I'
            ])
            ->getOne();
    }
    public function setItemVersion($params){
        $itemVersion =$this->db->select(['*'])
            ->from('ext_shop_item')
            ->where([
                'item_target' => $params['item_target'],
                'item_id' => $params['item_id'],
                'extend_type'=> 'I'
            ])
            ->getOne();
        if(!empty($itemVersion)){
            $params['updated_date'] = date('Y-m-d H:i:s');
            $rsSet = $this->db->update('ext_shop_item', $params, [
                'id' => $itemVersion['id']
            ]);
        }else{
            $rsSet = $this->db->insert('ext_shop_item', [
                'extend_type' => 'I', //Info ,Link
                'item_target' => $params['item_target'],
                'item_id' => $params['item_id'],
                'item_version' => $params['item_version']??'1.0.0',
                'item_buy_count' => $params['item_buy_count']??0,
                'item_download_days' => $params['item_download_days']??30,
                'item_use_days' => $params['item_use_days']??30,
                'item_ext_status' => 'Y',
                'creater' => $params['creater'],
                'created_date' => date('Y-m-d H:i:s')
            ]);
        }
        if($this->isApi){
            $itemVersion = $this->db->select(['*'])
                ->from('ext_shop_item')
                ->where([
                    'item_target' => $params['item_target'],
                    'item_id' => $params['item_id'],
                    'extend_type'=> 'I'
                ])
                ->getOne();
            $this->returnJson($itemVersion);
        }else{
            return $rsSet;
        }
    }
    public function getItemLinkByKey($itemLinkKey){
        $linkInfo = $this->db->select(['*'])
            ->from('ext_shop_item')
            ->where([
                'item_link_key' => $itemLinkKey,
                'item_ext_status' => 'Y'
            ])
            ->getOne();
        if($this->isApi){
            $this->returnJson($linkInfo);
        }else{
            return $linkInfo;
        }
    }
    public function deleteItemLink($params){
        $rsDelete = $this->db->update('ext_shop_item', $params,[
            'item_ext_status' => 'D',
            'deleted_date' => date('Y-m-d H:i:s')
        ]);
        if($this->isApi){
            $this->returnJson($rsDelete);
        }else{
            return $rsDelete;
        }
    }
    public function getItemLinks($params){
        $itemLinks = $this->db->select(['*'])
            ->from('ext_shop_item')
            ->where([
                'item_target' => $params['item_target'],
                'item_id' => $params['item_id'],
                'extend_type' => 'L',
                'item_ext_status' => 'U'
            ])
            ->get();
        if($this->isApi){
            $this->returnJson($itemLinks);
        }else{
            return $itemLinks;
        }
    }
    public function setItemLink($params)
    {
        $itemLink = $this->db->select(['*'])
            ->from('ext_shop_item')
            ->where([
                'item_target' => $params['item_target'],
                'item_id' => $params['item_id'],
                'extend_type' => 'L',
                'item_ext_link_key' => $params['item_ext_link_key'],
                'item_ext_status' => 'U'
            ])
            ->getOne();
        if (!empty($itemLink)) {
            $itemLink['updated_date'] = date('Y-m-d H:i:s');
            $rsSet = $this->db->update('ext_shop_item', $itemLink, [
                'id' => $itemLink['id']
            ]);
        } else {
            $params['created_date'] = date('Y-m-d H:i:s');
            $rsSet = $this->db->insert('ext_shop_item',$params);
        }
        if ($this->isApi) {
            $itemLinks = $this->db->select(['*'])
                ->from('ext_shop_item')
                ->where([
                    'item_target' => $params['item_target'],
                    'item_id' => $params['item_id'],
                    'extend_type' => 'L',
                    'item_ext_status' => 'U'
                ])
                ->get();
            $this->returnJson($itemLinks);
        } else {
            return $rsSet;
        }
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



CREATE TABLE `ext_shop_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '순번',
  `extend_type` varchar(1) DEFAULT NULL COMMENT '확장 구분',
  `item_target` varchar(1) DEFAULT NULL COMMENT '아이템 소속',
  `item_id` int(11) DEFAULT NULL COMMENT '상품순번',
  `item_option_id_1` int(11) DEFAULT NULL COMMENT '상품옵션순번1',
  `item_option_id_2` int(11) DEFAULT NULL COMMENT '상품옵션순번2',
  `item_option_id_3` int(11) DEFAULT NULL COMMENT '상품옵션순번3',
  `item_ext_link_key` varchar(36) DEFAULT NULL COMMENT '릴크 키',
  `item_ext_link_name` varchar(255) DEFAULT NULL COMMENT '링크 명',
  `item_ext_link` varchar(255) DEFAULT NULL COMMENT '링크 주소',
  `item_ext_link_download_code` varchar(255) DEFAULT NULL COMMENT '링크 다운로드 코드',
  `item_ext_link_is_buy` varchar(1) DEFAULT NULL COMMENT '링크 구매여부(타입)',
  `item_ext_link_is_download` varchar(1) DEFAULT NULL COMMENT '링크 다운상품 여부',
  `item_ext_link_read` varchar(1) DEFAULT NULL COMMENT '링크 읽기 가능여부',
  `item_ext_link_guest` varchar(1) DEFAULT NULL COMMENT '링크 비회원 가능여부',
  `item_version` varchar(12) DEFAULT NULL COMMENT '버전',
  `item_buy_count` int(11) DEFAULT NULL COMMENT '다운로드 제한 횟수',
  `item_download_days` int(11) DEFAULT NULL COMMENT '구매후 추가되는 일수',
  `item_use_days` int(11) DEFAULT NULL COMMENT '구매후 사용가능한 일수',
  `item_ext_status` varchar(1) DEFAULT NULL COMMENT '상태',
  `creater` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_ext_link_key` (`item_ext_link_key`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



 * */