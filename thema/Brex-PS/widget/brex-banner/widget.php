<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

$wset['href'] = (!$wset['href']) ? G5_URL : $wset['href'];
?>
<style>

</style>
<?php if($wset['img']) {?>
	<a href="<?php echo $wset['href']?>"><img src="<?php echo $wset['img']?>" width="100%"></a>
<?php } else {?>
	위젯설정을 통해 이미지를 설정해주세요.
<?php } ?>

<?php if($setup_href) { ?>
	<div class="btn-wset text-center p10">
		<a href="<?php echo $setup_href;?>" class="win_memo">
			<span class="text-muted font-12"><i class="fa fa-cog"></i> 위젯설정</span>
		</a>
	</div>
<?php } ?>