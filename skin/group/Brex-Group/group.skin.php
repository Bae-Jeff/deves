<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 헤더 출력
if(isset($wset['hskin']) && $wset['hskin']) {
	$header_skin = $wset['hskin'];
	$header_color = $wset['hcolor'];
	include_once('./header.php');
}
?>

<!-- 2단 그룹메인 -->
<style>
.group-box { background:#fff; border:1px solid #ddd; padding:15px; }
.group-bg { background:#f7fafc; }
.widget-wrap { margin-bottom:10px; padding:15px; background:#fff; border:1px solid #ddd; }
.widget-head { overflow:hidden; padding:15px; border:1px solid #ddd; border-bottom:0px; background:#fff; }
.widget-list { height:248px; }
</style>

<div class="group-bg">
	<div class="at-container">
		<div class="group-box">
			<?php
				echo apms_widget('brex-post-webzine', $gr_id.'b', 'rows=4 item=2 bold=1 thumb_w=400 thumb_h=300 image=1 gr_id='.$gr_id, 'rows=4', $group_skin_path);
			?>
		</div>
	</div>
</div>

<div class="at-container">
<div class="">
<div class="row">
<div class="col-md-12">

<?php if(!isset($wset['best']) || (isset($wset['best']) && !$wset['best'])) { // 베스트 ?>
	<div class="row">
		<div class="col-sm-8" style="<?php if(!G5_IS_MOBILE) echo 'padding-right:0px;'; ?>">
			<?php if(!G5_IS_MOBILE) {?>
			<div style="width:100%; padding:15px; text-align:center; background:#fff; border:1px solid #ddd;">
				반응형 애드센스
			</div>
			<div class="h10"></div>
			<?php } else {?>
			<div class="h10"></div>
			<?php } ?>

			<div class="row">
			<?php 
			// 보드추출
			$bo_device = (G5_IS_MOBILE) ? 'pc' : 'mobile';
			$sql = " select bo_table, bo_subject from {$g5[board_table]} where gr_id = '{$gr_id}' and bo_list_level <= '{$member[mb_level]}' and bo_device <> '{$bo_device}' and as_show = '1' ";
			if(!$is_admin) $sql .= " and bo_use_cert = '' ";
			$sql .= " order by as_order, bo_order ";
			$result = sql_query($sql);
			for ($i=0; $row=sql_fetch_array($result); $i++) { ?>
				<?php if($i > 0 && $i%2 == 0) { ?>
						</div>
					<div class="row">
				<?php } ?>
				</style>
				<div class="col-sm-6" style="<?php if(!G5_IS_MOBILE) echo ($i >= 0 && $i%2 == 1) ? 'padding-left:0px;' : 'padding-right:10px;'; ?>">
					<div class="widget-head">
						<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $row['bo_table']; ?>">
							<b><?php echo get_text($row['bo_subject']); ?></b>
						</a>
					</div>
					
					<div class="widget-wrap"<?php echo (G5_IS_MOBILE) ? ' style="padding:0px;"' : '';?>>
					<?php //보드별 추출 
						echo apms_widget('brex-post-list', 'bgroup-list-'.$row['bo_table'], 'rows=10 bo_list='.$row['bo_table'].' date=m.d', 'rows=7', $group_skin_path);
					?>
					</div>
				</div>
			<?php } ?>
			</div>

			<div class="widget-head">
				<b>갤러리</b>
			</div>
			<div class="widget-wrap">
				<?php echo apms_widget('brex-post-gallery', $wid.'-wb9', 'rows=8 item=4 center=1', '', $group_skin_path); ?>
			</div>
			
			<div class="widget-head">
				<b>스토리 포토</b>
			</div>
			<div class="widget-wrap">
			<?php echo apms_widget('brex-post-sero', $wid.'-wb3', 'date=1 center=1 strong=1,2 thumb_w=400 thumb_h=240 irows=1 size=170 rows=5', '', $group_skin_path); ?>
			<div class="h10"></div>
			<div style="margin-left:190px; border-top:1px solid #eee;"></div>
			<div class="h10"></div>
			<?php echo apms_widget('brex-post-sero', $wid.'-wb4', 'date=1 center=1 strong=1,2 thumb_w=400 thumb_h=240 irows=1 size=170 rows=5', '', $group_skin_path); ?>
			</div>

		</div>
		<div class="col-sm-4" style="<?php if(!G5_IS_MOBILE) echo 'padding-left:10px;'; ?>">
			<div class="widget-head">
				<b>베스트글</b>
			</div>

			<div class="widget-wrap"<?php echo (G5_IS_MOBILE) ? ' style="padding:0px;"' : '';?>>
				<?php echo apms_widget('brex-post-list', $wid.'-wb8', 'strong=1,2,3 rows=10 sort=hit rank=green date=1', '', $group_skin_path); ?>
			</div>
			
			<div class="widget-box" id="brex-post-add" style="border:1px solid #ddd; margin-bottom:10px;">
				<?php echo apms_widget('brex-post-add', $wid.'-wbadd', 'rows=1 item=1 lg=1 md=1 sm=1 xs=1 center=1 thumb_w=400 thumb_h=190 sort=rdm', '', $group_skin_path); ?>
			</div>

			<div class="widget-head">
				<b>뉴스</b>
			</div>
			<div class="widget-wrap">
				<?php echo apms_widget('brex-post-garo', $wid.'-wb5', 'date=1 center=1 irows=2 thumb_w=400 thumb_h=220 rows=5  strong=1,2', '', $group_skin_path); ?>
			</div>

		</div>
	</div>
<?php } //베스트 끝 ?>

</div>

</div>
</div>
</div>
