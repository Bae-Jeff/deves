<?php
$sub_menu = '400650';
include_once('./_common.php');

check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

$posts = array();
$check_keys = array('is_subject', 'is_content', 'is_confirm', 'is_reply_subject', 'is_reply_content', 'is_id');

foreach($check_keys as $key){

    if( in_array($key, array('is_content', 'is_reply_content')) ){
        $posts[$key] = isset($_POST[$key]) ? $_POST[$key] : '';
    } else {
        $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
    }
}

$is_id = $posts['is_id'];

if ($w == "u")
{
    $sql = "update {$g5['g5_shop_item_use_table']}
               set is_subject = '".$posts['is_subject']."',
                   is_content = '".$posts['is_content']."',
                   is_confirm = '".$posts['is_confirm']."',
                   is_reply_subject = '".$posts['is_reply_subject']."',
                   is_reply_content = '".$posts['is_reply_content']."',
                   is_reply_name = '".$member['mb_nick']."'
             where is_id = '".$is_id."'";
    sql_query($sql);

    if( isset($_POST['it_id']) ) {
		update_use_cnt($_POST['it_id']);
		update_use_avg($_POST['it_id']);
	}

	//���۹���
	if($posts['is_reply_content']) {
		$is_reply_subject = ($posts['is_reply_subject']) ? $posts['is_reply_subject'] : apms_cut_text($posts['is_reply_content'], 80);
		$row = sql_fetch(" select it_id, mb_id from {$g5['g5_shop_item_use_table']} where is_id = '".$is_id."' ", false);
		apms_response('it', 'use', $row['it_id'], '', $is_id, $is_reply_subject, $row['mb_id'], $member['mb_id'], $member['mb_nick']);
	}

    goto_url("./itemuseform.php?w=$w&amp;is_id=$is_id&amp;sca=$sca&amp;$qstr");
}
else
{
    alert();
}
?>
