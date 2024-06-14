<?php
include_once('./_common.php');

add_stylesheet('<link rel="stylesheet" href="'.THEMA_URL.'/add/style.css">', 0);

// 카운트
if(isset($count) && $count) {

	if($is_guest) exit;

	$count = $member['as_response'] + $member['as_memo'];
	$count = ($count > 0) ? $count : 0;
	echo '{ "count": "' . $count . '" }';
	exit;

}

// 읽음처리
if(isset($read) && $read) {
	apms_response_act($id);
}

?>

<?php if($is_guest) { // 비회원 ?>
	<p class="text-muted">
		로그인 후 이용할 있습니다.
	</p>
<?php exit; } ?>

<?php
	// 내글반응 - 시간순이면 1, 역순이면 0
	$list = apms_response_rows(0);
	$response_cnt = count($list);
?>

<?php if($response_cnt) {
	for($i=0; $i < $response_cnt; $i++) {
?>		
		<div class="response-media media">
		<a href="#" onclick="<?php echo $list[$i]['href'];?>">
			<div class="media-photo pull-left">
				<i class="fa fa-circle"></i>
			</div>
			<div class="media-body">
				<b class="ellipsis"><?php echo $list[$i]['subject'];?></b>

				<div class="media-info ellipsis">
					<b><?php echo $list[$i]['name'];?></b>

					<?php if($list[$i]['reply_cnt']>1) { ?>
						외 <?php echo $list[$i]['reply_cnt']-1;?>
					<?php } ?>
					<?php if($list[$i]['comment_cnt']>1) { ?>
						외 <?php echo $list[$i]['comment_cnt']-1;?>명
					<?php } ?>
					<?php if($list[$i]['comment_reply_cnt']>1) { ?>
						외 <?php echo $list[$i]['comment_reply_cnt']-1;?>
					<?php } ?>
					<?php if($list[$i]['good_cnt']>1) { ?>
						외 <?php echo $list[$i]['good_cnt']-1;?>
					<?php } ?>
					<?php if($list[$i]['nogood_cnt']>1) { ?>
						외 <?php echo $list[$i]['nogood_cnt']-1;?>
					<?php } ?>
					<?php if($list[$i]['use_cnt']>1) { ?>
						외 <?php echo $list[$i]['use_cnt']-1;?>
					<?php } ?>
					<?php if($list[$i]['qa_cnt']>1) { ?>
						외 <?php echo $list[$i]['qa_cnt']-1;?>
					<?php } ?>
					<?php echo apms_datetime($list[$i]['date']);?>
				</div>
			</div>
		<div class="del-list">
			<a href="#" onclick="add_read('<?php echo $list[$i]['id'];?>'); return false;">
				<i class="fa fa-times"></i>
			</a>
		</div>

		</a>
		</div>
	<?php }	?>
<?php } else { ?>
	<p class="text-muted">
		새로운 내글반응이 없습니다.
	</p>
<?php } ?>

<!--
<div class="h20"></div>

<?php
	// 쪽지
	$list = apms_memo_rows();
	$memo_cnt = count($list);
?>

<div class="div-title-underline-thin en">
	<b>MESSAGE</b>
	<?php if($memo_cnt) { ?>
		<span class="count orangered">+<?php echo number_format($memo_cnt);?></span>
	<?php } ?>
</div>

<?php if($memo_cnt) {
	for($i=0; $i < $memo_cnt; $i++) {
?>
		<div class="sidebar-media media">
			<div class="media-photo pull-left">
				<?php echo ($list[$i]['photo']) ? '<img src="'.$list[$i]['photo'].'" alt="">' : '<i class="fa fa-envelope"></i>'; ?>
			</div>
			<div class="media-body">
				<a href="#" onclick="win_memo('<?php echo $list[$i]['href'];?>');">
					<b><?php echo ($list[$i]['mb_nick']) ? $list[$i]['mb_nick'] : '정보없음';?></b>
					<span class="text-muted"><?php echo apms_datetime($list[$i]['date']);?></span>
					<div class="media-info ellipsis">
						<?php echo apms_cut_text($list[$i]['me_memo'], 30);?>
					</div>
				</a>
			</div>
		</div>
	<?php } ?>
<?php } else { ?>
	<p class="text-muted">
		새로온 쪽지가 없습니다.
	</p>
<?php } ?>
-->