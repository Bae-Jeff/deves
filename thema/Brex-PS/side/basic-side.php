<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 위젯 대표아이디 설정
$wid = 'BREX-G';

// 게시판 제목 폰트 설정
$font = 'font-16 en';

// 게시판 제목 하단라인컬러 설정 - red, blue, green, orangered, black, orange, yellow, navy, violet, deepblue, crimson..
$line = 'navy';

?>
<style>
	.widget-side .div-title-underbar { margin-bottom:15px; }
	.widget-side .div-title-underbar span { padding-bottom:4px; }
	.widget-side .div-title-underbar span b { font-weight:500; }
	.widget-box { margin-bottom:5px; }
	.widget-wrap { margin-bottom:10px; padding:15px; background:#fff; border:1px solid #ddd; }
	.widget-head { overflow:hidden; padding:15px; border:1px solid #ddd; border-bottom:0px; background:#fff; }
</style>

<div class="widget-side">

		<!--
		//1.2 버전 추가
		<?php 
		// 카테고리 체크
		$side_category = apms_widget('basic-category');
		if($side_category) { 
		?>
			<div class="div-title-underbar">
				<span class="div-title-underbar-bold border-<?php echo $line;?> <?php echo $font;?>">
					<b>Category</b>
				</span>
			</div>

			<div class="widget-box">
				<?php echo $side_category;?>
			</div>
		<?php } ?>-->
		
		<?php if(!G5_IS_MOBILE) {?>
		<div style="border:1px solid #ddd; margin-bottom:10px;">
			<?php echo apms_widget('brex-banner', $wid.'-wt3', ''); //타이틀 ?>
		</div>
		<?php } ?>
		
		<?php if(!G5_IS_MOBILE) {?>
		<div class="widget-head">
			<b>베스트글</b>
		</div>
		<?php } ?>
		<div class="widget-wrap"<?php echo (G5_IS_MOBILE) ? ' style="padding:0px;"' : '';?>>
			<?php echo apms_widget('brex-post-list', $wid.'-wb8', 'strong=1,2,3 rows=10 sort=hit rank=green date=1'); ?>
		</div>
		
		<div class="widget-box" id="brex-post-add" style="border:1px solid #ddd; margin-bottom:10px;">
			<?php echo apms_widget('brex-post-add', $wid.'-wbadd-s', 'rows=1 item=1 lg=1 md=1 sm=1 xs=1 center=1 thumb_w=400 thumb_h=190 sort=rdm'); ?>
		</div>
		
		<?php if(!G5_IS_MOBILE) {?>
		<div class="widget-head">
			<b>뉴스</b>
		</div>
		<?php } ?>
		<div class="widget-wrap">
			<?php echo apms_widget('brex-post-garo', $wid.'-wb5', 'date=1 center=1 irows=2 thumb_w=400 thumb_h=220 rows=5  strong=1,2'); ?>
		</div>

</div>