<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// Flex Slider 불러오기
apms_script('flexslider'); 

// 기본값 정리
$wset['effect'] = (isset($wset['effect']) && $wset['effect']) ? $wset['effect'] : 'slide';

// 랜덤아이디
$widget_id = apms_id();

?>
<?php if(!G5_IS_MOBILE) {?>
<style>
	.brex-post-ticker ul li { font-size:12px; }
</style>
<?php } ?>
<div class="img-wrap brex-post-ticker" style="padding-bottom:20px; line-height:20px;">
	<div class="img-item">
		<div id="<?php echo $widget_id;?>" class="flexslider">
			<ul class="slides">
			<?php 
				if($wset['cache'] > 0) { // 캐시적용시
					echo apms_widget_cache($widget_path.'/widget.rows.php', $wname, $wid, $wset);
				} else {
					include($widget_path.'/widget.rows.php');
				}
			?>
			</ul>
		</div>
	</div>
</div>
<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>
<script>
$(document).ready(function() {
	$('#<?php echo $widget_id;?>').flexslider({
		controlNav: false,
		directionNav: false,
		<?php if(isset($wset['rdm']) && $wset['rdm']) { ?>
		randomize: true,
		<?php } ?>
		<?php if(isset($wset['speed']) && $wset['speed'] > 0) { ?>
	    slideshowSpeed: <?php echo $wset['speed'];?>,
		<?php } ?>
		<?php if(isset($wset['ani']) && $wset['ani'] > 0) { ?>
	    animationSpeed: <?php echo $wset['ani'];?>,
		<?php } ?>
		<?php if($wset['effect'] == 'vertical') { ?>
	    direction: "vertical",
		<?php } ?>
		animation: "<?php echo ($wset['effect'] == 'fade') ? 'fade' : 'slide';?>"
	});
});
</script>
