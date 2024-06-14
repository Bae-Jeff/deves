<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$is_search = true;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$skin_url.'/style.css" media="screen">', 0);

// 헤더 출력
if($header_skin)
	include_once('./header.php');

?>
<style>
<?php if(G5_IS_MOBILE) {?>
.at-content { padding:20px 15px; margin:10px 0px; background:#fff; }
<?php } else {?>
.at-content { padding:0px; margin:0px; }
<?php } ?>
.p-title { font-size:15px; }
</style>

<div class="row">
<div class="col-md-7" style="<?php echo (!G5_IS_MOBILE) ? 'padding-top:15px; padding-right:20px; min-height:600px; border-right:1px solid #ddd;' : '' ;?>">
<?php
if ($stx) {
	if ($board_count) {
 ?>

<?php } else { ?>
	<p class="search-none text-center text-muted<?php echo (G5_IS_MOBILE) ? '' : ' search-none';?>">검색된 자료가 하나도 없습니다.</p>
<?php } } else { ?>
	<p class="search-none text-center text-muted<?php echo (G5_IS_MOBILE) ? '' : ' search-none';?>">검색어는 두글자 이상, 공백은 1개만 입력할 수 있습니다.</p>
<?php } ?>

<div class="clearfix"></div>

<?php
$k=0;
for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
?>
	<div class="div-title-wrap search-title-wrap">
		<div class="div-title"><strong><?php echo $bo_subject[$idx] ?></strong></div>
	</div>
	<div class="search-media">
	<?php
	for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {

		$img = apms_wr_thumbnail($list[$idx][$i]['bo_table'], $list[$idx][$i], 80, 100, false, true); // 썸네일
		$img['src'] = ($img['src']) ? $img['src'] : apms_photo_url($list[$idx][$i]['mb_id']); // 회원사진

		if ($list[$idx][$i]['wr_is_comment']) {
			$comment_def = '<span class="tack-icon bg-orange">댓글</span> ';
			$comment_href = '#c_'.$list[$idx][$i]['wr_id'];
			$fa_icon = 'comment';
			$txt = '[댓글] ';
		} else {
			$comment_def = '';
			$comment_href = '';
			$fa_icon = 'file-text-o';
			$txt = '';
		}
	 ?>
		<div class="media">
			<div class="photo pull-left">
				<?php echo ($img['src']) ? '<img src="'.$img['src'].'" alt="'.$img['src'].'">' : '<i class="fa fa-'.$fa_icon.'"></i>'; ?>
			</div>
			<div class="media-body">
				<div class="media-heading">
					<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>">
						<?php echo $comment_def ?><?php echo $icon;?><?php echo $list[$idx][$i]['subject'] ?>
					</a>
					<span class="space"></span>
					<time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', $list[$idx][$i]['date']) ?>"><?php echo apms_datetime($list[$idx][$i]['date'], 'Y.m.d H:i');?></time>
					<?php if($list[$idx][$i]['ca_name']) { ?>
						<span class="sp lightgray">|</span>
						<?php echo $list[$idx][$i]['ca_name']; ?>
					<?php } ?>
				</div>

				<div class="media-content">
					<span><?php echo apms_cut_text($list[$idx][$i]['content'], 100, '...'); ?></span>
				</div>
				<div class="media-link">
					<a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>">
						<?php
							$media_link = str_replace('./', G5_BBS_URL.'/', $list[$idx][$i]['href'].$comment_href);
							echo str_replace('http://', '', $media_link);
						?>	
					</a>
					<span class="space"></span>
					<?php echo $list[$idx][$i]['wr_name']; ?>
				</div>
			</div>
		</div>
	<?php }  ?>
	</div>
	<div class="text-right">
		<a style="color:#0000cc;" href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><?php echo $bo_subject[$idx] ?> 더보기 <i class="fa fa-angle-right gray"></i></a>
	</div>
	<div class="clearfix h20"></div>
<?php }  ?>

<?php if($total_count > 0) { ?>
	<div class="text-center">
		<ul class="pagination pagination-sm en">
			<?php echo apms_paging($write_page_rows, $page, $total_page, $list_page); ?>
		</ul>
	</div>
<?php } ?>
</div>
<div class="col-md-4" style="<?php echo (!G5_IS_MOBILE) ? 'padding-top:30px; padding-left:35px;' : '' ;?>">

<p class="p-title">
	<a href="<?php echo G5_BBS_URL;?>/board.php?bo_table=basic">
		<b>인기 베스트10</b>
	</a>
</p>
<div class="">
	<?php echo apms_widget('brex-post-list', $wid.'-bs1', 'rank=green sort=hit term=day dayterm=365 date=m.d rows=10', 'rows=10'); ?>
</div>

</div>
</div>