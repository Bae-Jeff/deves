<?php
if (!defined('_GNUBOARD_')) exit;

// UTF8 Encode ------------------------------------------------------------------------
function dump($params){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
}
function err(){
    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );
}
function mapItemInfoExtends(){
    return array(
        'extend_type',
        'item_target',
        'item_id',
        'item_version',
        'item_buy_count',
        'item_download_days',
        'item_use_days',
        'item_extend_status',
        'create_user'
    );
}
function mapItemAttrExtends(){
    return array(
        'extend_type',
        'item_target',
        'item_id',
        'item_ext_link_key',
        'item_ext_link_name',
        'item_ext_link',
        'item_ext_link_download_code',
        'item_ext_link_is_buy',
        'item_ext_link_is_download',
        'item_ext_link_read',
        'item_ext_link_guest',
        'create_user'
    );
}
//Callback
function getItemLinkExtends($item_id) {
 
    $linkList =  array();
    echo $sqlItemLinks =  "SELECT * FROM shop_item_extend WHERE item_id =".$item_id." and extend_type = 'L'";
    $rsLinks = sql_query($sqlItemLinks);
    for ($i=0; $link = sql_fetch_array($rsLinks); $i++) {
        $linkList[] = $link;
    }
    
    return $linkList;
}
function getItemLinkKey(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return  strtoupper(time().substr(str_shuffle($characters), 0, 6));
}
function setItemLinkExtends($params) {
    global $config, $g5, $default,$member;
   
    foreach (mapItemAttrExtends() as $pKey => $culumn){
        $$culumn = $params[$culumn] ?? null;
    };
    echo '----------set getItemLinkKey start-------------<br>';
    var_dump($params);
    echo '----------set getItemLinkKey  params-------------<br>';
    
    $existSql = "SELECT * FROM shop_item_extend WHERE extend_type = 'L' AND item_ext_link_key = '".$item_ext_link_key."'";
    $rsExist = sql_query($existSql);
    echo '-------결과값 갯수 ---'.mysqli_num_rows($rsExist);
    if (mysqli_num_rows($rsExist) > 0) { // 결과값이 있는 경우
        $updateSql = "
            UPDATE shop_item_extend
            SET
                extend_type = '".$extend_type."',
                item_id = '".$item_id."',
                item_ext_link_name = '".$item_ext_link_name."',
                item_ext_link = '".$item_ext_link."',
                item_ext_link_download_code = '".$item_ext_link_download_code."',
                item_ext_link_is_buy = '".$item_ext_link_is_buy."',
                item_ext_link_is_download = '".$item_ext_link_is_download."',
                item_ext_link_read = '".$item_ext_link_read."',
                item_ext_link_guest = '".$item_ext_link_guest."',
                updated_date = '".date('Y-m-d H:i:s')."',
                create_user = '".$member['mb_id']."'
            WHERE
                item_ext_link_key = '".$item_ext_link_key."'
        ";
        echo $updateSql;
        return sql_query($updateSql);
    }else{ // insert
        $insertSql = "
            INSERT INTO shop_item_extend (
                extend_type,
                item_target,
                item_id,
                item_ext_link_key,
                item_ext_link_name,
                item_ext_link,
                item_ext_link_download_code,
                item_ext_link_is_buy,
                item_ext_link_is_download,
                item_ext_link_read,
                item_ext_link_guest,
                created_date,
                create_user
            )
            VALUES (
                '".$extend_type."',
                '".$item_target."',
                '".$item_id."',
                '".$item_ext_link_key."',
                '".$item_ext_link_name."',
                '".$item_ext_link."',
                '".$item_ext_link_download_code."',
                '".$item_ext_link_is_buy."',
                '".$item_ext_link_is_download."',
                '".$item_ext_link_read."',
                '".$item_ext_link_guest."',
                '".date('Y-m-d H:i:s')."',
                '".$member['mb_id']."'
            )
        ";
        $rsSetItemLinks =  sql_query($insertSql);
        echo 'insert == '.$insertSql;
        echo '----------set getItemLinkKey  end  ['.$rsSetItemLinks.']-------------<br>';
        return $rsSetItemLinks;
    }
    
    
}
function deleteItemLinkExteds($params) {
    $sqlItemLinkDelete =  "DELETE FROM shop_item_extend WHERE item_id = ".$params['item_id']." and item_ext_link_key = '".$params['item_ext_link_key']."'";
    return sql_query($sqlItemLinkDelete);
}
function getItemVersionConfig($item_id) {
    $sqlItemConfig =  "SELECT id,item_target,item_id,item_version,item_buy_count,item_download_days,item_use_days,item_extend_status FROM shop_item_extend  WHERE item_id =".$item_id." and extend_type = 'I'";
    $result = sql_query($sqlItemConfig);
    return  mysqli_fetch_assoc($result);
   
}
function setItemVersionConfig($params) {
    global $config, $g5, $default,$member;
    
    foreach (mapItemInfoExtends() as $pKey => $culumn){
        $$culumn = $params[$culumn] ?? null;
    };
    
    
    $existSql = "select * from shop_item_extend where extend_type = 'I' and item_id =  '".$item_id."'";
    $rsExist = sql_query($existSql);

    if ($rsExist && mysqli_num_rows($rsExist) > 0) {
        
        $updateSql = "
            UPDATE shop_item_extend
            SET
                extend_type = '".$extend_type."',
                item_id = '".$item_id."',
                item_version = '".$item_version."',
                item_buy_count = '".$item_buy_count."',
                item_download_days = '".$item_download_days."',
                item_use_days = '".$item_use_days."',
                item_extend_status = '".$item_extend_status."',
                updated_date = '".date('Y-m-d H:i:s')."',
                create_user = '".$member['mb_id']."'
            WHERE
                item_id = '".$item_id."'
            AND
                extend_type = 'I'
        ";
        echo $updateSql;
        return sql_query($updateSql);
    }else{ // insert
        $insertSql = "
                INSERT INTO shop_item_extend (
                    extend_type,
                    item_target,
                    item_id,
                    item_version,
                    item_buy_count,
                    item_download_days,
                    item_use_days,
                    item_extend_status,
                    created_date,
                    create_user
                )
                VALUES (
                    '".$extend_type."',
                    '".$item_target."',
                    '".$item_id."',
                    '".$item_version."',
                    '".$item_buy_count."',
                    '".$item_download_days."',
                    '".$item_use_days."',
                    '".$item_extend_status."',
                    '".date('Y-m-d H:i:s')."',
                    '".$member['mb_id']."'
                )
            ";
        echo $insertSql;
        $rsSetItemVersion =  sql_query($insertSql);
        echo '----------set itemversion  end ['.$rsSetItemVersion.']-------------<br>';
    
        
    }
}
function deleteItemVersionConfig($m) {
}


/*
-- deves.shop_item_extend definition

CREATE TABLE `shop_item_extend` (
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
  `item_extend_status` varchar(1) DEFAULT NULL COMMENT '상태',
  `create_user` varchar(50) DEFAULT NULL COMMENT '생성인',
  `created_date` datetime DEFAULT NULL COMMENT '생성일',
  `updated_date` datetime DEFAULT NULL COMMENT '수정일',
  `deleted_date` datetime DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_ext_link_key` (`item_ext_link_key`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
 * */