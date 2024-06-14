<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
#scroll-layer { background:transparent !important; margin-top:-1px; }
#scroll-layer:hover { background:#fff !important; }
.box-small { height:40px !important; }
</style>

	<!-- PC Header -->
	<header class="s-header">
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
						<input type="text" name="stx" class="form-control input-sm" placeholder="APMS에 최적화" value="<?php echo $stx;?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm"><i class="fa fa-search fa-lg"></i></button>
						</span>
					</div>
				</form>
			</div>

			<div class="pull-right header-right">
				<a href="<?php echo (!$is_member) ? $at_href['login'] : $at_href['logout'];?>" class="btn btn-sm"><?php echo (!$is_member) ? '로그인' : '로그아웃';?></a>
				<a href="#" onclick="sidebar_open('sidebar-user'); return false;"><img src="<?php echo THEMA_URL;?>/assets/img/th.png" width="16px"></a>
			</div>

			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Mobile Header -->
	<header class="s-m-header">
		<div class="at-container">
			<div class="header-logo">
				<a href="<?php echo $at_href['home'];?>">B</a>
			</div>
			<div class="header-search">
				<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo (IS_SHOP) ? $at_href['isearch'] : $at_href['search'];?>">
					<div class="input-group input-group-sm">
						<input type="text" name="stx" class="form-control input-sm" value="<?php echo $stx;?>" placeholder="검색어를 입력하세요">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm btn-brex"><i class="fa fa-search fa-lg"></i></button>
						</span>
					</div>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Menu -->
	<nav class="at-menu">
		<!-- SUB Menu -->
		<div class="s-menu">
			<!-- Menu Button & Right Icon Menu -->
			<div class="at-container">
				<div class="nav-right nav-rw nav-height">
					<?php if(!G5_IS_MOBILE) {?>
						<?php include_once(G5_LIB_PATH.'/popular.lib.php'); ?> 
						<?php echo popular('Brex-PGP', '10', '1'); ?>
					<?php } ?>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php include_once(THEMA_PATH.'/s-menu.php');	// 메뉴 불러오기 ?>
			<div class="clearfix"></div>
			<div class="nav-back"></div>
		</div><!-- .pc-menu -->

		<!-- Mobile Menu -->
		<div class="s-m-menu">
			<?php include_once(THEMA_PATH.'/s-menu-m.php');	// 메뉴 불러오기 ?>
		</div><!-- .m-menu -->
	</nav><!-- .at-menu -->