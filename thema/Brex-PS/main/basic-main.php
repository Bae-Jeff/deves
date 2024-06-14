<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'BREX-G';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

// 사이드 위치 설정 - left, right
$side = ($at_set['side']) ? 'left' : 'right';

?>
<style>
	.widget-index .at-main,
	.widget-index .at-side { padding-bottom:0px; }
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }

	.widget-box { margin-bottom:10px; }
	.widget-wrap { margin-bottom:10px; padding:15px; background:#fff; border:1px solid #ddd; }
	.widget-head { overflow:hidden; font-size:14px; padding:15px; border:1px solid #ddd; border-bottom:0px; background:#fff; }
	.main-sp { border-bottom:1px solid #ddd; }

	.tab10 .w-tab { border:1px solid #ddd; border-bottom:0px; background:#fff; }
	.tab10 .w-tab .nav { border:0 !important; padding:0px; margin-top:0px !important; }
	.tab10 .w-tab .nav li a { color:#888 !important; padding:15px; font-size:14px; font-weight:bold; }
	.tab10 .w-tab .nav li.active a { border:0 !important; border-bottom:3px solid #333333 !important; color:#333333 !important; font-weight:bold; }
	.tab10 .tabs { margin-bottom:0px !important; }
	.tab10 .tab-content { border:1px solid #ddd !important; padding:15px !important; }

	.tab20 .w-tab { border:1px solid #ddd; border-bottom:0px; background:#fff; }
	.tab20 .w-tab .nav { border:0 !important; padding:0px; margin-top:0px !important; }
	.tab20 .w-tab .nav li a { color:#888 !important; padding:15px; font-size:14px; font-weight:bold; }
	.tab20 .w-tab .nav li.active a { border:0 !important; border-bottom:3px solid #333333 !important; color:#333333 !important; font-weight:bold; }
	.tab20 .tabs { margin-bottom:0px !important; }
	.tab20 .tab-content { border:1px solid #ddd !important; padding:15px !important; }

	.tab30 .w-tab { border:1px solid #ddd; border-bottom:0px; background:#fff; }
	.tab30 .w-tab .nav { border:0 !important; padding:0px; margin-top:0px !important; }
	.tab30 .w-tab .nav li a { color:#888 !important; padding:15px; font-size:14px; font-weight:bold; }
	.tab30 .w-tab .nav li.active a { border:0 !important; border-bottom:3px solid #333333 !important; color:#333333 !important; font-weight:bold; }
	.tab30 .tabs { margin-bottom:0px !important; }
	.tab30 .tab-content { border:1px solid #ddd !important; padding:15px !important; }
</style>

<div class="at-container widget-index">
<div class="row at-row">
		<!-- 메인 영역 -->
		<div class="col-md-8<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main" style="<?php echo ($side == "left") ? 'padding-left:10px;' : 'padding-right:10px;';?> padding-top:5px;">
			
			<div style="border:1px solid #ddd;">
				<?php echo apms_widget('brex-banner', $wid.'-wt1', ''); //타이틀 ?>
			</div>

			<div class="h10"></div>

			<div class="widget-wrap">
				<?php echo apms_widget('brex-post-ticker', 'popular-main', 'icon={아이콘:bell} effect=vertical'); ?>
			</div>

			<!-- 가로형 위젯 Start //-->
			<div class="tab10">
			<?php
			$tnum0 = rand(0, 2);
			?>
			<div id="tab_10" class="div-tab tabs swipe-tab tabs-color-top">
				<div class="w-tab">
					<ul class="nav nav-tabs" data-toggle="tab-click">
						<li<?php if($tnum0 == "0") echo ' class="active"';?>><a href="#tab_11" data-toggle="tab">뉴스</a></li>
						<li<?php if($tnum0 == "1") echo ' class="active"';?>><a href="#tab_12" data-toggle="tab">스포츠</a></li>
						<li<?php if($tnum0 == "2") echo ' class="active"';?>><a href="#tab_13" data-toggle="tab">연예</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane<?php if($tnum0 == "0") echo ' active';?>" id="tab_11">
						<div class="row">
							<div class="col-md-6" style="padding-right:7.5px;">
								<?php echo apms_widget('brex-post-list', $wid.'-wb1', 'date=1 center=1 rows=10 strong=1,2'); ?>
							</div>
							<div class="col-md-6" style="padding-left:7.5px;">
								<?php echo apms_widget('brex-post-list', $wid.'-wb2', 'date=1 center=1 rows=10 strong=1,2'); ?>
							</div>
						</div>
					</div>
					<div class="tab-pane<?php if($tnum0 == "1") echo ' active';?>" id="tab_12">
						<?php echo apms_widget('brex-post-sero', $wid.'-wb3', 'date=1 center=1 strong=1,2 thumb_w=400 thumb_h=240 irows=1 size=170 rows=5'); ?>
						<div class="h10"></div>
						<?php echo apms_widget('brex-post-sero', $wid.'-wb4', 'date=1 center=1 strong=1,2 thumb_w=400 thumb_h=240 irows=1 size=170 rows=5'); ?>
					</div>
					<div class="tab-pane<?php if($tnum0 == "2") echo ' active';?>" id="tab_13">
						<div class="row">
							<div class="col-md-6" style="padding-right:7.5px;">
								<?php echo apms_widget('brex-post-garo', $wid.'-wb5', 'date=1 center=1 irows=2 thumb_w=400 thumb_h=220 rows=5 strong=1,2'); ?>
							</div>
							<div class="col-md-6" style="padding-left:7.5px;">
								<?php echo apms_widget('brex-post-garo', $wid.'-wb6', 'date=1 center=1 irows=2 thumb_w=400 thumb_h=220 rows=5 strong=1,2'); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<!-- //End -->
					
			<div class="h10"></div>

			<div class="tab30">
			<?php
			$tnum2 = rand(0, 9);
			?>
			<div id="tab_30" class="div-tab tabs swipe-tab tabs-color-top">
				<div class="w-tab">
					<ul class="nav nav-tabs" data-toggle="tab-click">
						<li<?php if($tnum2 == "0") echo ' class="active"';?>><a href="#tab_31" data-toggle="tab">전체</a></li>
						<li<?php if($tnum2 == "1") echo ' class="active"';?>><a href="#tab_32" data-toggle="tab">커뮤니티</a></li>
						<li<?php if($tnum2 == "2") echo ' class="active"';?>><a href="#tab_33" data-toggle="tab">뉴스</a></li>
						<li<?php if($tnum2 == "3") echo ' class="active"';?>><a href="#tab_34" data-toggle="tab">IT/트렌드</a></li>
						<li<?php if($tnum2 == "4") echo ' class="active"';?>><a href="#tab_35" data-toggle="tab">스포츠</a></li>
						<li<?php if($tnum2 == "5") echo ' class="active"';?>><a href="#tab_36" data-toggle="tab">쇼핑</a></li>
						<li<?php if($tnum2 == "6") echo ' class="active"';?>><a href="#tab_37" data-toggle="tab">포토</a></li>
						<li<?php if($tnum2 == "7") echo ' class="active"';?>><a href="#tab_38" data-toggle="tab">게임</a></li>
						<li<?php if($tnum2 == "8") echo ' class="active"';?>><a href="#tab_39" data-toggle="tab">역사</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane<?php if($tnum2 == "0") echo ' active';?>" id="tab_31">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg1', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "1") echo ' active';?>" id="tab_32">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg2', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "2") echo ' active';?>" id="tab_33">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg3', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "3") echo ' active';?>" id="tab_34">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg4', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "4") echo ' active';?>" id="tab_35">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg5', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "5") echo ' active';?>" id="tab_36">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg6', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "6") echo ' active';?>" id="tab_37">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg7', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "7") echo ' active';?>" id="tab_38">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg8', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
					<div class="tab-pane<?php if($tnum2 == "8") echo ' active';?>" id="tab_39">
						<?php echo apms_widget('brex-post-gallery-main', $wid.'-wbg9', 'thumb_w=285 thumb_h=400 rows=12 item=4 xs=2 strong=2,3 over=2,4,11');?>	
					</div>
				</div>
			</div>
			</div>

			<div class="h10"></div>

			<div class="widget-wrap">
				<?php echo apms_widget('brex-post-banner', $wid.'-wm-banner', 'thumb_w=400 thumb_h=200 nav=1 rows=2 item=2', 'auto=0'); ?>
			</div>

		</div>

		<!-- 사이드 영역 -->
		<div class="col-md-4<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side" style="<?php echo ($side == "left") ? 'padding-right:0px;' : 'padding-left:0px;';?> padding-top:5px;">

			<?php if(!G5_IS_MOBILE) { //PC일 때만 출력 ?>
				<div class="hidden-sm hidden-xs">
					<div class="widget-box" style="position:relative;">
						<?php echo apms_widget('brex-outlogin'); //외부로그인 ?>
						<?php if($is_member) {?>
						<div class="over-user hide">
							<div class="in-add">
								<div id="add-response-list">
									<?php include(THEMA_PATH.'/add/response.php');?>
								</div>

								<div id="add-memo-list" class="hide">
									
								</div>

								<div id="add-scrap-list" class="hide">
									
								</div>

								<div id="add-user-list" class="hide">
									
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>

		<div class="widget-head">
			<?php
				$tweek = array("일", "월", "화", "수", "목", "금", "토");
			?>	
			<div class="pull-right bold"><?php echo date('m월 d일');?>(<?php echo $tweek[date("w")];?>)</div>
			<div class="pull-left">공지사항</div>
		</div>
		<div class="widget-wrap">
			<?php echo apms_widget('brex-post-list', $wid.'-wbg11', 'date=1 center=1 rows=5'); ?>
		</div>

		<div class="widget-box" id="brex-post-add" style="border:1px solid #ddd;">
			<?php echo apms_widget('brex-post-add', $wid.'-wbadd', 'thumb_w=400 thumb_h=190 rows=1 item=1 lg=1 md=1 sm=1 xs=1 center=1 thumb_w=400 thumb_h=190 sort=rdm'); ?>
		</div>

		<div class="tab20">
					<?php
					$tnum1 = rand(0, 2);
					?>
					<div id="tab_20" class="div-tab tabs swipe-tab tabs-color-top">
						<div class="w-tab">
							<ul class="nav nav-tabs" data-toggle="tab-click">
								<li<?php if($tnum1 == "0") echo ' class="active"';?>><a href="#tab_21" data-toggle="tab">뉴스</a></li>
								<li<?php if($tnum1 == "1") echo ' class="active"';?>><a href="#tab_22" data-toggle="tab">스포츠</a></li>
								<li<?php if($tnum1 == "2") echo ' class="active"';?>><a href="#tab_23" data-toggle="tab">연예</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane<?php if($tnum1 == "0") echo ' active';?>" id="tab_21">
								<?php echo apms_widget('brex-post-photo', $wid.'-wbs1', 'thumb_w=300 thumb_h=360 rows=9 item=3 center=1'); ?>
								<div class="h15"></div>
								<div class="main-sp"></div>
								<div class="h15"></div>
								<?php echo apms_widget('brex-post-gallery-side', $wid.'-wbs2', 'thumb_w=400 thumb_h=285 rows=2 item=2 center=1'); ?>
							</div>
							<div class="tab-pane<?php if($tnum1 == "1") echo ' active';?>" id="tab_22">
								<?php echo apms_widget('brex-post-photo', $wid.'-wbs3', 'thumb_w=300 thumb_h=360 rows=9 item=3 center=1'); ?>
								<div class="h15"></div>
								<div class="main-sp"></div>
								<div class="h15"></div>
								<?php echo apms_widget('brex-post-gallery-side', $wid.'-wbs4', 'thumb_w=400 thumb_h=285 rows=2 item=2 center=1'); ?>
							</div>
							<div class="tab-pane<?php if($tnum1 == "2") echo ' active';?>" id="tab_23">
								<?php echo apms_widget('brex-post-photo', $wid.'-wbs5', 'thumb_w=300 thumb_h=360 rows=9 item=3 center=1'); ?>
								<div class="h15"></div>
								<div class="main-sp"></div>
								<div class="h15"></div>
								<?php echo apms_widget('brex-post-gallery-side', $wid.'-wbs6', 'thumb_w=400 thumb_h=285 rows=2 item=2 center=1'); ?>
							</div>
						</div>
					</div>
					</div>

		<div class="h10"></div>
		
		<div style="border:1px solid #ddd;">
			<?php echo apms_widget('brex-banner', $wid.'-wt2', ''); //타이틀 ?>
		</div>

		</div>
	</div>
</div>
