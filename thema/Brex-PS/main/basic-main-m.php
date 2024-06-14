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

add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/assets/css/swiper.min.css" type="text/css">',0);
?>
<style>
	.widget-index .at-main,
	.widget-index .at-side { padding-bottom:0px; }
	.widget-box { background:#fff; }
	.widget-box-2nd { background:#fff; padding:15px; margin-bottom:10px; }
	.widget-box-head { overflow:hidden; background:#fff; padding:15px; border-bottom:1px solid #ddd; }
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

	.m-b-text { padding:10px; }
	.m-b-text .col-xs-4 { text-align:center; background:#a1d1ee; }
	.m-b-text .col-xs-4:first-child {  }
</style>

<div class="swipe10">

  <!-- 탭 메뉴 -->
  <div class="swiper-container swiper-tab">
        <div class="swiper-wrapper">
            <div class="swiper-slide active">메인</div>
            <div class="swiper-slide">커뮤니티</div>
            <div class="swiper-slide">뉴스</div>
            <div class="swiper-slide">스포츠</div>
            <div class="swiper-slide">연예인</div>
            <div class="swiper-slide">포토</div>
        </div>
  </div>
  
  <!-- 탭 컨텐트 -->
  <div class="swiper-container swiper-body">
      <div class="swiper-wrapper">
          <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab1.php');?>
		  </div>

          <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab2.php');?>
		  </div>

		  <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab3.php');?>
		  </div>
		  
		  <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab4.php');?>
		  </div>

		  <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab5.php');?>
		  </div>

		  <div class="swiper-slide">
			<?php include(THEMA_PATH.'/swipe/tab6.php');?>
		  </div>
      </div>
  </div>
  
</div>
