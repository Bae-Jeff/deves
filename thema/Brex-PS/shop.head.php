<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
include_once(THEMA_PATH.'/assets/thema.php');
//include_once(THEMA_PATH.'/add/style.php');

add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/assets/css/swiper.min.css" type="text/css">',0);

$add_url = THEMA_URL.'/add';
$add_time = 60;
?>

<style>
	<?php if($bo_table && !G5_IS_MOBILE) {?>
		.at-body .at-container { padding-top:15px; }
	<?php } else if($is_index) {?>
		.at-body .at-container { padding-top:15px; }
	<?php } else {?>
		.at-body .at-container { background:#fff; }
		.at-body .at-main { padding:15px !important; }
	<?php } ?>

	<?php if($is_search) {?>
		.at-body .at-container { padding:0px; }
	<?php } ?>

	<?php if($gid || $is_index) {?>
		.at-content { padding:0px !important; }
	<?php } else {?>
		.at-content { padding:20px 10px !important; }
	<?php } ?>

	<?php if($is_index) {?>
		.is-pc .at-body { background:#f2f4f7; }
	<?php } ?>
</style>
<script>
var add_url = "<?php echo $add_url;?>"
var add_time = "<?php echo $add_time;?>";
</script>
<script src="<?php echo $add_url;?>/add.js"></script>

<div id="thema_wrapper" class="wrapper <?php echo $is_thema_layout;?> <?php echo $is_thema_font;?>">

<?php //if($gid || $bo_table) {?>
	<?php //include_once(THEMA_PATH.'/sub-head.php');?>
<?php //} else if($is_search) {?>
	<?php //include_once(THEMA_PATH.'/s-head.php');?>
<?php //} else {?>
	<!-- LNB -->
	<aside class="at-lnb">
		<div class="at-container">

			<div class="pull-left">
				<ul>
					<li><a href="javascript:;" onclick="">시작페이지</a></li>
					<li><a href="javascript:;" onclick="">즐겨찾기</a></li>
				</ul>
			</div>
			
			<!-- LNB Right -->
			<div class="pull-right" style="position:relative;">
				<ul>
					<?php if($is_member) { // 로그인 상태 ?>
						<li><a href="javascript:;" onclick="sidebar_open('sidebar-user');"><b><?php echo $member['mb_nick'];?></b></a></li>
						<?php if($member['admin']) {?>
							<li><a href="<?php echo G5_ADMIN_URL;?>">관리</a></li>
						<?php } ?>
						<?php if($member['partner']) { ?>
							<li><a href="<?php echo $at_href['myshop'];?>">마이샵</a></li>
						<?php } ?>
						<?php if(!$is_main) {?>
						<li class="sidebarLabel"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
							<a href="javascript:;" onclick="<?php echo ($at_set['sadd'] == "b1") ? "response_open()" : "sidebar_open('sidebar-response')";?>"> 
								알림 <b class="orangered sidebarCount"><?php echo $member['response'] + $member['memo'];?></b>
							</a>
						</li>
						<?php } ?>
					<?php } else { // 로그아웃 상태 ?>
						<li><a href="<?php echo $at_href['login'];?>" onclick="sidebar_open('sidebar-user'); return false;">로그인</a></li>
						<li><a href="<?php echo $at_href['reg'];?>">회원가입</a></li>
						<li><a href="<?php echo $at_href['lost'];?>" class="win_password_lost">정보찾기</a></li>
					<?php } ?>
					<?php if(IS_YC) { // 영카트 사용하면 ?>
						<?php if($member['cart'] || $member['today']) { ?>
							<li>
								<a href="<?php echo $at_href['cart'];?>" onclick="sidebar_open('sidebar-cart'); return false;"> 
									쇼핑 <b class="blue"><?php echo number_format($member['cart'] + $member['today']);?></b>
								</a>
							</li>
						<?php } ?>
						<li><a href="<?php echo $at_href['change'];?>"><?php echo (IS_SHOP) ? '커뮤니티' : '쇼핑몰';?></a></li>
					<?php } ?>
					<li><a href="<?php echo $at_href['connect'];?>">접속 <?php echo number_format($stats['now_total']); ?><?php echo ($stats['now_mb']) ? ' (<b class="orangered">'.number_format($stats['now_mb']).'</b>)' : ''; ?></a></li>
					<?php if($is_member) { ?>
						<li><a href="<?php echo $at_href['logout'];?>">로그아웃	</a></li>
					<?php } ?>
				</ul>
				<?php if($is_member && $at_set['sadd'] == "b1" && !$is_main) {?>
				<div id="lnb-alarm" class="hide">
					<div class="over-user1" style="top:40px;">
						<div class="in-add">
							<div id="add1-response-list">
								<?php include(THEMA_PATH.'/add/response.php');?>
							</div>
						</div>
					</div>
					<div class="close-over-user">
						<div class="close-over-user1" onclick="javascript:response_open();">
							닫기
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</aside>

	<!-- PC Header -->
	<header class="shop-header">
		<div class="at-container">
			<!-- PC Logo -->
			<div class="header-logo">
				<a href="<?php echo $at_href['home'];?>">
					BREX	
				</a>
			</div>
			<!-- PC Search -->
			<div class="header-search">
				<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo (IS_SHOP) ? $at_href['isearch'] : $at_href['search'];?>">
					<div class="input-group input-group-sm">
						<input type="text" name="stx" class="form-control input-sm" value="<?php echo $stx;?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
						</span>
					</div>
				</form>
			</div>

			<div class="header-keyword">
				<?php echo apms_widget('brex-keyword', 'brex-keyword', 'search=item q=카메라,파리스,에펠타워,맥북'); // 키워드 ?>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Mobile Header -->
	<header class="m-header">
		<div class="at-container">
			<div class="header-wrap">
				<div class="header-icon" style="position:relative;">
					<a href="javascript:;" onclick="sidebar_open('sidebar-<?php echo ($member["response"]) ? "response" : "menu";?>');">
						<i class="fa fa-bars"></i>
					
					<div class="head-alarm-icon"<?php echo ($member['response']) ? '' : ' style="display:none;"';?>>
						<span class="addLabel">
							<b class="addCount"><?php echo $member['response'];?></b>
						</span>
					</div>
					</a>
				</div>
				<div class="header-logo en">
					<!-- Mobile Logo -->
					<a href="<?php echo $at_href['home'];?>">
						<b>BREX</b>
					</a>
				</div>
				<div class="header-icon" style="position:relative;">
					<a href="<?php echo $at_href['change']?>">
						<i class="fa fa-comment-o"></i>
					</a>
				</div>
				<div class="header-icon" style="position:relative;">
					<a href="<?php echo $at_href['cart']?>" target="_blank" class="win_memo">
						<i class="fa fa-shopping-cart"></i>
					
					<div class="head-cart-icon"<?php echo $member['cart'] ? '' : ' style="display:none;"';?>>
						<span><b><?php echo $member['cart'];?></b></span>
					</div>
					</a>
				</div>
			</div>
			<div class="header-search">
				<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo (IS_SHOP) ? $at_href['isearch'] : $at_href['search'];?>">
					<div class="input-group input-group-sm">
						<input type="text" name="stx" class="form-control input-sm" placeholder="Search..." value="<?php echo $stx;?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
						</span>
					</div>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Menu -->
	<nav class="at-menu">
		<!-- PC Menu -->
		<div class="pc-menu">
			<!-- Menu Button & Right Icon Menu -->
			<div class="at-container">
				<div class="nav-right nav-rw nav-height">
					<?php if(!G5_IS_MOBILE) {?>
						<?php include_once(G5_LIB_PATH.'/popular.lib.php'); ?> 
						<?php echo popular('Brex-Popular', '10', '1'); ?>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php include_once(THEMA_PATH.'/menu.php');	// 메뉴 불러오기 ?>
			<div class="clearfix"></div>
			<div class="nav-back"></div>
		</div><!-- .pc-menu -->

		<!-- Mobile Menu -->
		<div class="m-menu">
			<?php //include_once(THEMA_PATH.'/menu-m.php');	// 메뉴 불러오기 ?>
		</div><!-- .m-menu -->
	</nav><!-- .at-menu -->
<?php //} ?>

	<div class="clearfix"></div>

	<div class="at-body ts_up0" id="body_text">
		<?php if($col_name) { ?>
			<div class="<?php echo ($gid) ? 'at-containered' : 'at-container';?>">
			<?php if($col_name == "two") { ?>
				<div class="row at-row">
					<div class="col-md-<?php echo $col_content;?><?php echo ($at_set['side']) ? ' pull-right' : '';?> at-col at-main">		
			<?php } else { ?>
				<div class="at-content">
			<?php } ?>
		<?php } ?>
