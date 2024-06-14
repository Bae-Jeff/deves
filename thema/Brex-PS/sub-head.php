<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

	<!-- PC Header -->
	<header class="sub-header">
		<div class="at-container">
		<div class="pull-left header-control">
			<!-- PC Logo -->
			<div class="header-logo">
				<a href="<?php echo $at_href['home'];?>">
					BREX
				</a>
			</div>
			<!--div class="pull-left" style="padding:3px 0 0 15px;">
				<?php echo apms_widget('basic-category');?>
			</div-->
			<!-- PC Search -->
			<div class="header-search">
				<form name="tsearch" method="get" onsubmit="return tsearch_submit(this);" role="form" class="form">
				<input type="hidden" name="url"	value="<?php echo (IS_SHOP) ? $at_href['isearch'] : $at_href['search'];?>">
					<div class="input-group input-group-sm">
						<input type="text" name="stx" class="form-control input-sm" placeholder="APMS 1.7에 최적화" value="<?php echo $stx;?>">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-sm"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>
		</div>

			<div class="pull-right header-right" style="position:relative;">
				<ul>
					<li><a href="<?php echo ($is_member) ? $at_href['logout'] : $at_href['login']; ?>"><i class="fa fa-power-off fa-lg"></i></a></li>
					<li class="sidebarLabel"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
						<a href="javascript:;" onclick="<?php echo ($at_set['add'] == "a1") ? "response_open()" : "sidebar_open('sidebar-response')";?>"> 
							<i class="fa fa-bell fa-lg"></i>
						</a>
					</li>
					<li><a href="#" onclick="sidebar_open('sidebar-user'); return false;"><i class="fa fa-th fa-lg"></i></a></li>
				</ul>
				<?php if($is_member && $at_set['add'] == "a1") {?>
				<div id="lnb-alarm" class="hide">
					<div class="over-user1">
						<div class="in-add">
							<div id="add-response-list">
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
					<a href="<?php echo $at_href['memo']?>" target="_blank" class="win_memo">
						<i class="fa fa-envelope-o"></i>
					
					<div class="head-memo-icon"<?php echo ($member['memo']) ? '' : ' style="display:none;"';?>>
						<span><b>N</b></span>
					</div>
					</a>
				</div>
			</div>
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
			<div class="clearfix"></div>
		</div>
	</header>

	<!-- Menu -->
	<nav class="at-menu">
		<!-- SUB Menu -->
		<div class="sub-menu">
			<!-- Menu Button & Right Icon Menu -->
			<div class="at-container">
				<div class="nav-right nav-rw nav-height">
					<?php echo apms_widget('brex-post-ticker', 'sub', 'effect=vertical use_cmt=1'); ?>
					<div class="clearfix"></div>
				</div>
			</div>
			<?php include_once(THEMA_PATH.'/sub-menu.php');	// 메뉴 불러오기 ?>
			<div class="clearfix"></div>
			<div class="nav-back"></div>
		</div><!-- .pc-menu -->

		<!-- Mobile Menu -->
		<div class="m-menu">
			<?php include_once(THEMA_PATH.'/menu-m.php');	// 메뉴 불러오기 ?>
		</div><!-- .m-menu -->
	</nav><!-- .at-menu -->