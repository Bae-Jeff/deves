<?php
if (!defined('_GNUBOARD_')) exit;

// mysql password length 41, old_password 의 경우에는 16
if(!defined('G5_MYSQL_PASSWORD_LENGTH')) {
	define('G5_MYSQL_PASSWORD_LENGTH', 41);
}

// jwplayer 대신 video 태그 사용하고 싶으면 1(수동실행) 또는 2(자동실행) 설정
if(!defined('APMS_USE_VIDEO_TAG')) {
	define('APMS_USE_VIDEO_TAG', '');
}

?>