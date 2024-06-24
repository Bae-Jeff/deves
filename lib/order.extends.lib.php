<?php
if (!defined('_GNUBOARD_')) exit;

function mapOrderExtends(){
    return array(
        'hardInsert',
        'order_parent',
        'order_id',
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

function addOrderExtends($params){
    global $config, $g5, $default,$member;
    
    foreach (mapOrderExtends() as $pKey => $culumn){
        $$culumn = $params[$culumn] ?? null;
    };
    $order_extends_memo = $order_extends_memo ?? '';
    $existSql = "SELECT * FROM shop_order_extend 
                WHERE order_id = '".$order_id."' 
                AND order_item_id = '".$order_item_id."'";
    $rsExist = sql_query($existSql);
    $order_detail_id = null;
   
    if ($rsExist && mysqli_num_rows($rsExist) > 0 && empty($hardInsert)) { // 결과값이 있는 경우
        $arrExist = mysqli_fetch_assoc($rsExist);
       echo  $updateSql = "
            UPDATE shop_order_extend
            SET
                order_id = '".$order_id."',
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
       echo  $insertSql = "
            INSERT INTO shop_order_extend (
                order_id,
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