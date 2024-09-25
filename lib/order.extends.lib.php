<?php
if (!defined('_GNUBOARD_')) exit;

function mapOrderExtends(){
    return array(
        'hardInsert',
        'order_uuid',
        'order_parent',
        'order_id',
        'order_option_1',
        'order_option_etc',
        'order_detail_id',
        'order_item_id',
        'order_use_days',
        'order_download_days',
        'order_extends_memo',
        'order_extends_status',
        'user_id'
    );
}
// UTF8 Encode ------------------------------------------------------------------------
function confirmOrderExtend($order_id, $order_status, $status = 'C'){
    if($order_status == '입금'){
        $status = "S";
       echo  $sqlUpdate =  "
            UPDATE shop_order_extend
            SET 
                order_extends_status = '".$status."'
            WHERE
                order_id = '".$order_id."'
        ";
        return sql_query($sqlUpdate);
    }else{
       echo $sqlUpdate =  "
            UPDATE shop_order_extend
            SET
                order_extends_status = '".$status."'
            WHERE
                order_id = '".$order_id."'
        ";
        return sql_query($sqlUpdate);
    }
}
function checkRootIsAlive($params){
    global $config, $g5, $default,$member,$db;
    $userId =  $params['userId']??null;
    $itemId = $params['itemId']??null;
    $optionEtc = $params['optionEtc']??null;
    
    $existRoot = $db->select(['*']) // 살아있는데 옵션 root 가  존재하는지 체크 
    ->from('shop_order_extend')
    ->where([
        'order_item_id' => $itemId,
        'order_order_etc' => $optionEtc,
        'order_extends_memo' => 'ROOT',
        'order_extends_status' => 'A',
        'user_id' => $userId
    ])
    ->getOne();
    
    if(empty($existRoot)){  // 살아있는 root 가 없으면 
        return false;
    }else{ // 있으면 남은 일자 체크 
        $useStatus  = getItemUseStatus($params);
        
        return  $useStatus['remainDays'] && $useStatus['remainDays'] > 0 ;
        
    }
    
}


function addOrderExtends($params){
    global $config, $g5, $default,$member;
    
    foreach (mapOrderExtends() as $pKey => $culumn){
        $$culumn = $params[$culumn] ?? null;
    };
    
    if(!checkRootIsAlive([
        'itemId' => $order_item_id,
        'optionEtc' => $order_option_etc,
        'userId' => $user_id
    ])){
        $rsInsert = $db->insert('shop_order_extend',[
            'order_id' => $order_id,
            'order_option_etc' => $order_option_etc,
            'order_parent' => $order_parent,
            'order_item_id' => $order_item_id,
            'order_use_days' => $order_use_days,
            'order_download_days' => $order_download_days,
            'order_extends_memo' => 'ROOT',
            'order_extends_status' => 'A',
            'user_id' => $user_id,
            'create_date' => date('Y-m-d H:i:s'),
            'create_user' => $member['mb_id']
        ]);
    }
    
    $order_extends_memo = $order_extends_memo ?? '';
    $existSql = "SELECT * FROM shop_order_extend 
                WHERE order_id = '".$order_id."' 
                AND order_item_id = '".$order_item_id."'";
    $rsExist = sql_query($existSql);
    $order_detail_id = null;
   
    if ($rsExist && mysqli_num_rows($rsExist) > 0 && empty($hardInsert)) { // 결과값이 있는 경우
        $arrExist = mysqli_fetch_assoc($rsExist);
        $updateSql = "
            UPDATE shop_order_extend
            SET
                order_id = '".$order_id."',
                order_option_etc = '".$order_option_etc."',
                order_parent = '".$order_parent."',
                order_item_id = '".$order_item_id."',
                order_use_days = ".$order_use_days.",
                order_download_days = ".$order_download_days.",
                order_extends_status = '".$order_extends_status."',
                order_extends_memo = '".$order_extends_memo."',
                updated_date = '".date('Y-m-d H:i:s')."',
                create_user = '".$member['mb_id']."'
            WHERE
                id = '".$arrExist['id']."'
        ";
        return sql_query($updateSql);
    }else{
        $order_id = $order_id ?? null;
        $order_parent = $order_parent ?? null;
       $insertSql = "
            INSERT INTO shop_order_extend (
                order_id,
                order_option_etc,
                order_parent,
                order_item_id,
                order_use_days,
                order_download_days,
                order_extends_status,
                order_extends_memo,
                created_date,
                create_user
            )
            VALUES (
                '".$order_id."',
                '".$order_option_etc."',
                '".$order_parent."',
                '".$order_item_id."',
                ".$order_use_days.",
                ".$order_download_days.",
                '".$order_extends_status."',
                '".$order_extends_memo."',
                '".date('Y-m-d H:i:s')."',
                '".$member['mb_id']."'
            )
            
        ";
        return sql_query($insertSql);
    }
}
function getUuid(){
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
}
function getItemUseStatus($params) {
    global $db;
    
    $userId =  $params['userId']??null;
    $itemId = $params['itemId']??null;
    $optionEtc = $params['optionEtc']??null;
    $return = array(
        "remainDays" => 0,
        "endDate" => '0000-00-00',
        "orderHistory" => [],
    );
    if(
        empty($userId) ||
        empty($itemId) ||
        empty($optionEtc)
    ){
        return $return ;
    }else{
        $activeRoot =  $db->select(['*'])
        ->from('shop_order_extend')
        ->where([
            'order_extends_memo' => 'ROOT',
            'order_exteds_status' => 'A', //Active
            'order_item_id' => $itemId,
            'order_optoin_etc' => $optionEtc,
            'user_id' => $userId
        ])
        ->getOne();
        
        if(empty($activeRoot)){
            return $return;
        }else{
            $optionOrders =  $db->select(['*'])
            ->from('shop_order_extend')
            ->where([
                'order_parent' => $activeRoot,
                'order_item_id' => $itemId,
                'order_optoin_etc' => $optionEtc,
                'user_id' => $userId
            ])
            ->whereNot([
                'order_extends_memo' => 'ROOT',
                'order_extends_status' => 'D'
            ])
            ->orderBy([
                'id' => 'asc'
            ])
            ->get();
            if(count($optionOrders) > 0){
                $totalDays = 0;
                $startDate =  '';
                foreach ($optionOrders as $oKey => $oRow){
                    if($oKey == 0){
                        $startDate = $oRow['created_date'];
                    }
                    $totalDays += $oRow['order_use_days'];
                }
                //         dump([$startDate,$totalDays]);
                //         $return['data'] = $orders;
                $return['endDate'] =  getUseEndDate($startDate,$totalDays);
                $return['remainDays'] = getGapDays(date('Y-m-d'),$return['endDate']);
                $return['orderHistory'] =  $orders;
            }
            
            return $return;
        }
    }
    
}
function getUseEndDate($startDate, $days) {
    $dateTime = new DateTime($startDate);
    $interval = new DateInterval('P' . $days . 'D'); // P stands for Period, D stands for Day
    $dateTime->add($interval);
    return $dateTime->format('Y-m-d');
}
function getGapDays($date1, $date2) {
    
    $dateTime1 = new DateTime($date1);
    $dateTime2 = new DateTime($date2);
    
    $interval = $dateTime1->diff($dateTime2);
    return $date2 < date('Y-m-d')? -1 *  $interval->days : $interval->days;
}

/*
 * 
CREATE TABLE `shop_order_extend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '순번',
  `order_parent` bigint(20) DEFAULT NULL COMMENT '소속',
  `order_id` bigint(20) unsigned NOT NULL COMMENT '주문번호',
  `order_detail_id` int(11) DEFAULT NULL COMMENT '주문상세번호',
  `order_item_id` int(11) DEFAULT NULL COMMENT '주문상품번호',
  `order_download_days` int(11) DEFAULT NULL COMMENT '주문발생 다운로드 일수',
  `order_use_days` int(11) DEFAULT NULL COMMENT '주문발생 사용 일수',
  `order_extends_status` varchar(1) DEFAULT NULL COMMENT '주문추가정보 상태',
  `order_extends_memo` varchar(255) DEFAULT NULL COMMENT '주문추가정보 메모',
  `create_user` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

 * */