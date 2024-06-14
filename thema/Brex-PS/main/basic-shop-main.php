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
	.widget-index .div-title-underbar { margin-bottom:15px; }
	.widget-index .div-title-underbar span { padding-bottom:4px; }
	.widget-index .div-title-underbar span b { font-weight:500; }
	.widget-index .widget-img img { display:block; max-width:100%; /* 배너 이미지 */ }

	.widget-box { margin-bottom:15px; }
	.widget-wrap { margin-bottom:15px; padding:15px; background:#fff; border:1px solid #ddd; }
	.widget-head { overflow:hidden; font-size:14px; padding:15px; border:1px solid #ddd; border-bottom:0px; background:#fff; }
	.main-sp { border-bottom:1px solid #ddd; }

	.box-left { float:left; width:824px; }
	.sbox-left { width:288px; }
	.sbox-right { width:536px; }
	.box-right { position:relative; float:left; width:376px; height:320px; line-height:320px; text-align:center; background:#f6f6f6; }
	.box-right .ad-over { position:absolute; background:rgba(0, 0, 0, 0.8); width:100%; height:100%; top:0; left:0; text-align:center; line-height:320px; }
	.box-right .ad-over .ad-text { border:1px solid #fff; border-radius:3px; padding:5px 8px; color:#fff; }
</style>

<div class="shop-main">
	<div class="shop-main-bg at-container">
		<div class="box-left">
			<div class="sbox-left pull-left">
				
			</div>
			<div class="sbox-right pull-right">
				<?php echo apms_widget('basic-title', $wid.'-main-bg', 'height=320px arrow=1', 'auto=0'); //타이틀 ?>
			</div>
		</div>

		<div class="box-right">
			<!--코드를 삽입할 때 주석으로 묶인 부분을 지워주세요.-->
			<img src="<?php echo THEMA_URL;?>/assets/img/ad.jpg" style="width:336px; height:280px;">
			<div class="ad-over">
				<a href="#" class="ad-text">336x280 구글 애드센스</a>
			</div>
			<!--코드를 삽입할 때 주석으로 묶인 부분을 지워주세요.-->
		</div>
	</div>
</div>

<div class="at-container widget-index">

	<div class="row at-row">
		<!-- 메인 영역 -->
		<div class="col-md-9<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main" style="<?php echo ($side == "left") ? 'padding-left:15px;' : 'padding-right:15px;';?> padding-top:5px;">

			<!-- 쇼핑몰 시작 -->
			<?php echo apms_widget('brex-shop-item-slider', $wid.'-wm1', 'auto=1 thumb_w=300 thumb_h=300 nav=1 rdm=1 item=4 md=3 sm=2 xs=2', 'auto=0'); ?>
			<!-- 쇼핑몰 끝 -->

		</div>

		<!-- 사이드 영역 -->
		<div class="col-md-3<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side" style="<?php echo ($side == "left") ? 'padding-right:0px;' : 'padding-left:0px;';?> padding-top:5px;">

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

		
		</div>
	</div>

<!-- 쇼핑몰 시작 -->
<?php echo apms_widget('brex-shop-item', $wid.'-wm4', 'more=1 rows=12 thumb_w=300 thumb_h=400 item=5 md=3 sm=2 xs=2', 'auto=0'); ?>
<!-- 쇼핑몰 끝 -->

</div>
