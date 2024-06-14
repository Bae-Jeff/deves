<?php
include_once('./_common.php');

// Page ID
$pid = ($pid) ? $pid : '';
$at = apms_page_thema($pid);
include_once(G5_LIB_PATH.'/apms.thema.lib.php');

// 위젯 대표아이디 설정
$wid = 'BREX';

echo apms_widget('brex-post-add', $wid.'-add-1', 'rows=1 item=1 lg=1 md=1 sm=1 xs=1 thumb_w=400 thumb_h=190 center=1 sort=rdm');
?>