<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 위젯 대표아이디 설정
$wid = 'BREX';

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
	.widget-box { background:#fff; }
	.widget-box-2nd { background:#fff; padding:15px; margin-bottom:10px; }
	.widget-box-head { overflow:hidden; background:#fff; padding:15px; border-bottom:1px solid #ddd; }
	.widget-box-head-2nd { text-align:center; overflow:hidden; background:#fff; padding:10px 15px; border-bottom:1px solid #ddd; }
	.widget-m-table { background:#fff; margin:0; }
	.widget-m-table td { width:33.33333%; text-align:center; }

	.tab10 .w-tab { border:0; }
	.tab10 .w-tab .nav { border:0 !important; margin-top:-1px !important; }
	.tab10 .w-tab .nav li a { padding:0 10px; color:#727272 !important; font-weight:bold; }
	.tab10 .w-tab .nav li a:first-child { padding-left:0px; }
	.tab10 .w-tab .nav li.active a { border:0 !important; color:#000 !important; font-weight:bold; }
	.tab10 .tabs { margin-bottom:20px !important; }
	.tab10 .tab-content { border:0 !important; padding:0px !important; padding-top:15px !important; }

	.tab20 .w-tab { border:0; }
	.tab20 .w-tab .nav { border:0px solid #eee !important; margin-top:-1px !important; }
	.tab20 .w-tab .nav li { width:33.33333%; border-left:1px solid #ccc !important; border-bottom:1px solid #ccc !important; background:#f1f1f1; text-align:center; }
	.tab20 .w-tab .nav li:last-child { border-right:1px solid #ccc !important; }
	.tab20 .w-tab .nav li a { padding:15px 0px; color:#333 !important; font-weight:normal; }
	.tab20 .w-tab .nav li.active, .tab20 .w-tab .nav li:hover { border-color:#fff !important; border-top:1px solid #ccc !important; border-left:1px solid #ccc !important; background:#fff !important; }
	.tab20 .w-tab .nav li.active a, .tab20 .w-tab .nav li a:hover { border-top:0 !important; font-weight:normal; }
	.tab20 .tab-ad { padding:10px 18px; padding-bottom:25px !important; background:#fafafa; text-align:center; }
	.tab20 .tab-ad ul li { list-style:none; float:left; padding-left:15px; }
	.tab20 .tab-ad ul li.red-ad a { color:orangered; font-weight:bold; }
	.tab20 .tab-ad ul li a { color:#727272; text-decoration:underline; font-size:11px; }
	.tab20 .tab-ad ul li a:after {  }
	.tab20 .tabs { margin-bottom:20px !important; }
	.tab20 .tab-content { border:0 !important; padding:15px !important; padding-top:10px !important; }
</style>

<div class="at-container widget-index">
<div class="row at-row">
	<!-- 메인 영역 -->
	<div class="col-md-6<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main">
		
		<?php //echo apms_widget('brex-banner', $wid.'-m-b3', ''); //타이틀 ?>

		<!--div class="h10"></div-->
		
		<?php echo apms_widget('brex-banner-2nd', $wid.'-m-b4', 'arrow=2 height=180px nav=1', 'auto=0'); //타이틀 ?>

		<div class="h10"></div>

		<div class="widget-box">
			<?php echo apms_widget('brex-tags', 'brex-tags', 'q=랩탑,펜슬,파리스,스마트폰,카메라'); // 키워드 ?>
		</div>

	</div>
	<!-- 사이드 영역 -->
	<div class="col-md-6<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side">
		
		<div class="widget-box-head-2nd">
			<b>HOT ITEMS+</b>
		</div>
		<div class="widget-box-2nd">
			<?php echo apms_widget('brex-shop-item', $wid.'-wmm4', 'more=1 rows=6 thumb_w=300 thumb_h=400 item=3 md=3 sm=2 xs=2', 'auto=0'); ?>
		</div>

		<div class="widget-box">
			<?php echo apms_widget('brex-post-list', $wid.'-m-5', 'rows=5 date=1'); ?>
			<div style="border-top:1px solid #ddd; padding:10px 15px;">
				<?php echo apms_widget('brex-post-ticker', 'pop-2', 'sort=hit rank=green effect=vertical'); ?>
			</div>
		</div>
		
		<div class="h10"></div>

		<?php echo apms_widget('brex-banner', $wid.'-m-b3', ''); //타이틀 ?>

		<div class="h10"></div>

		<div class="widget-box-head-2nd">
			<b>NEW ARRIVALS+</b>
		</div>
		<div class="widget-box-2nd">
			<?php echo apms_widget('brex-shop-item', $wid.'-wmm5', 'more=1 rows=6 thumb_w=300 thumb_h=400 item=3 md=3 sm=2 xs=2', 'auto=0'); ?>
		</div>
		
		</div>
	</div>
</div>
