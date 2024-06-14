<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 내글반응 및 쪽지 자동알림 시간설정(초) - 0 설정시 자동알림 작동하지 않음
$response_check_time = 60; 

// 소셜로그인 플러그인이 설치되어 있어야 작동 - http://amina.co.kr/bbs/board.php?bo_table=skin_amina&wr_id=150
// 소셜로그인 사용 - 0 : 사용안함, 1 : 사용
$use_sns_login = 1;

// 상단라인 컬러 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line_top = 'color';-
// 출석부 보드아이디
$bo_chulsuk = 'chulsuk';

//----------------------------------------------------------------------------

global $member, $is_guest, $is_member, $is_admin, $at_href, $at_set, $menu, $stats, $is_main, $gid, $stx, $urlencode;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

// 소셜로그인
$sns_login_icon = '';
if ($is_guest && $use_sns_login && function_exists('get_login_oauth')) {
	$sns_login_icon .= get_login_oauth('naver');
	$sns_login_icon .= get_login_oauth('facebook');
	$sns_login_icon .= get_login_oauth('twitter');
	$sns_login_icon .= get_login_oauth('google');
	$sns_login_icon .= get_login_oauth('kakao');
}

// 영카트
if (IS_YC && !isset($member['cart'])) {
	thema_member('cart');
}

// 카테고리
$menu_id = 'sidebar_menu';
$menu_cnt = count($menu);

?>
<script>
var sidebar_url = "<?php echo $widget_url;?>";
var sidebar_time = "<?php echo $response_check_time;?>";
</script>
<script src="<?php echo $widget_url; ?>/sidebar.js"></script>

<!-- sidebar Box -->
<aside id="sidebar-box" class="<?php echo (isset($at_set['font']) && $at_set['font']) ? $at_set['font'] : 'ko';?>">
	
	<div class="sidebar-head">
		<div class="profile pull-left" style="width:220px;">
			<?php if($is_member) {?>
			<a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo" title="사진등록">
				<div class="photo pull-left">
					<?php echo ($member['photo']) ? '<img src="'.$member['photo'].'" alt="">' : '<i class="fa fa-user"></i>'; //사진 ?>
				</div>
			</a>
			<?php } else {?>
			<div class="photo pull-left">
				<i class="fa fa-user"></i>
			</div>
			<?php } ?>
			<h3><?php echo ($is_member) ? "<strong>".$member['mb_nick']."</strong> 님" : '<a href="'.$at_href["login"].'">로그인이 필요합니다.</a>';?>
			<?php if($is_member) {?><a href="<?php echo ($is_admin) ? G5_ADMIN_URL : $at_href['edit'];?>"><span class="for-edit"> <i class="fa fa-cog"></i></span></a><?php } ?></h3>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<?php if($is_member) {?>
	<div class="sidebar-head-menu">
		<div class="sidebar-head-menu-list" style="border-left:0px;"  onclick="sidebar_open('sidebar-user'); return false;">
			<div class="font-18 text-center"><i class="fa fa-user"></i></div>
			<div class="text-center">마이메뉴</div>
		</div>
		<div class="sidebar-head-menu-list" onclick="sidebar_open('sidebar-menu'); return false;">
			<div class="font-18 text-center"><i class="fa fa-th"></i></div>
			<div class="text-center">게시판</div>
		</div>
		<div class="sidebar-head-menu-list" onclick="sidebar_open('sidebar-response'); return false;">
			<div class="font-18 text-center"><i class="fa fa-bell"></i></div>
			<div class="text-center">알림</div>
		</div>
		<a href="<?php echo $at_href['logout'];?>">
			<div class="sidebar-head-menu-list">
				<div class="font-18 text-center"><i class="fa fa-power-off"></i></div>
				<div class="text-center">로그아웃</div>
			</div>
		</a>
	</div>
	<?php } else {?>
	<div class="sidebar-head-menu">
		<a href="<?php echo $at_href['reg'];?>">
			<div class="sidebar-head-menu-list" style="border-left:0px;">
				<div class="font-18 text-center"><i class="fa fa-sign-in"></i></div>
				<div class="text-center">회원가입</div>
			</div>
		</a>
		<a href="<?php echo $at_href['lost'];?>" target="_blank" class="win_memo">
			<div class="sidebar-head-menu-list">
				<div class="font-18 text-center"><i class="fa fa-lock"></i></div>
				<div class="text-center">정보찾기</div>
			</div>
		</a>
		<div class="sidebar-head-menu-list" onclick="sidebar_open('sidebar-response'); return false;">
			<div class="font-18 text-center"><i class="fa fa-bell"></i></div>
			<div class="text-center">알림</div>
		</div>
		<a href="<?php echo $at_href['home'];?>">
			<div class="sidebar-head-menu-list">
				<div class="font-18 text-center"><i class="fa fa-home"></i></div>
				<div class="text-center">홈으로</div>
			</div>
		</a>
	</div>
	<?php } ?>

	<!-- sidebar Content -->
	<div id="sidebar-content" class="sidebar-content">

		<!-- Common -->
		<div class="sidebar-common">

			<!-- Login -->
			<!--<div class="btn-group btn-group-justified" role="group">
				<?php if($is_member) { ?>
					<a href="#" onclick="sidebar_open('sidebar-user'); return false;" class="btn btn-color btn-sm">내정보</a>
					<?php if($member['admin']) { ?>
						<a href="<?php echo G5_ADMIN_URL;?>" class="btn btn-color btn-sm">관리자</a>
					<?php } ?>
					<?php if($member['partner']) { ?>
						<a href="<?php echo $at_href['myshop'];?>" class="btn btn-color btn-sm">마이샵</a>
					<?php } ?>
					<a href="<?php echo $at_href['logout'];?>" class="btn btn-color btn-sm">로그아웃</a>
				<?php } else { ?>
					<a href="#" onclick="sidebar_open('sidebar-user'); return false;" class="btn btn-color btn-sm">로그인</a>
					<a href="<?php echo $at_href['reg'];?>" class="btn btn-color btn-sm">회원가입</a>
					<a href="<?php echo $at_href['lost'];?>" class="win_password_lost btn btn-color btn-sm">정보찾기</a>
				<?php } ?>
			</div>-->

		</div>

		<!-- Menu -->
		<div id="sidebar-menu" class="sidebar-item">
			<?php @include_once($widget_path.'/menu.php'); ?>
		</div>

		<!-- User -->
		<div id="sidebar-user" class="sidebar-item">
			<?php @include_once($widget_path.'/user.php'); ?>
		</div>

		<!-- Response -->
		<div id="sidebar-response" class="sidebar-item">
			<div id="sidebar-response-list"></div>
		</div>

		<?php if(IS_YC) { //영카트 ?>
		<!-- Cart -->
		<div id="sidebar-cart" class="sidebar-item">
			<div id="sidebar-cart-list"></div>
		</div>
		<?php } ?>

		<!--<div class="h30"></div>-->
	</div>

</aside>

<div id="sidebar-box-mask" class="sidebar-close"></div>
