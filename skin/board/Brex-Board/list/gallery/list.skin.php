<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// Load Script
if($boset['masonry']) {
	apms_script('masonry');
	apms_script('imagesloaded');
}
if($boset['lightbox']) apms_script('lightbox');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$list_skin_url.'/list.css" media="screen">', 0);

// 간격
$gap_right = ($boset['gap_r'] == "") ? 15 : $boset['gap_r'];
$gap_bottom = ($boset['gap_b'] == "") ? 15 : $boset['gap_b'];

// 이미지 비율
$thumb_w = $board['bo_'.MOBILE_.'gallery_width'];
$thumb_h = $board['bo_'.MOBILE_.'gallery_height'];
$img_h = apms_img_height($thumb_w, $thumb_h); // 이미지 높이

// 너비
$item_w = apms_img_width($board['bo_gallery_cols']);

$boset['right'] = 1;

// 제목
$ellipsis = ($boset['sone'] && !G5_IS_MOBILE) ? ' class="ellipsis"' : '';

// 날짜
$is_date = '';
if($boset['date']) {
	$is_date = ($boset['trans']) ? 'trans-bg-'.$boset['date'] : 'bg-'.$boset['date'];
	$is_date = ($boset['right']) ? $is_date.' right' : $is_date.' left';
}

?>
<style>
	.list-wrap .list-container { overflow:hidden; margin-right:<?php echo ($gap_right > 0) ? '-'.$gap_right : 0;?>px; margin-bottom:<?php echo ($gap_bottom > 15) ? 0 : 15;?>px; padding:0px 15px; }
	.list-wrap .list-row { float:left; width:<?php echo $item_w;?>%; }
	.list-wrap .list-item { margin-right:<?php echo $gap_right;?>px; margin-bottom:<?php echo $gap_bottom;?>px; }
</style>
<div class="list-container">
	<?php
	// 목록출력
	$k = 0;
	for ($i=0; $i < $list_cnt; $i++) { 

		if($list[$i]['is_notice']) continue;		

		// 아이콘 체크
		$is_lock = false;
		$wr_icon = $wr_label = '';
		if ($list[$i]['icon_secret'] || $list[$i]['is_lock']) {
			$wr_icon = '<span class="wr-icon wr-secret"></span>';
			$wr_label = '<div class="label-cap bg-red">Lock</div>';
			$is_lock = true;
		} else if ($list[$i]['icon_hot']) {
			$wr_icon = '<span class="wr-icon wr-hot"></span>';
			$wr_label = '<div class="label-cap bg-orange">Hot</div>';
		} else if ($list[$i]['icon_new']) {
			$wr_icon = '<span class="wr-icon wr-new"></span>';
			$wr_label = '<div class="label-cap bg-green">New</div>';
		}

		if($wr_id && $list[$i]['wr_id'] == $wr_id) {
			$wr_label = '<div class="label-cap bg-blue">Now</div>';
		}

		// 링크
		if($is_link_target && $list[$i]['wr_link1']) {
			$list[$i]['href'] = $list[$i]['link_href'][1];
		}

		$list[$i]['no_img'] = $board_skin_url.'/img/no-img.jpg'; // No-Image
		if($boset['lightbox']) { //라이트박스
			$img = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], 0, 0, false, true) : apms_wr_thumbnail($bo_table, $list[$i], 0, 0, false, true);
			$thumb = apms_thumbnail($img['src'], $thumb_w, $thumb_h, false, true); // 썸네일
			$caption = "<a href='".$list[$i]['href']."'>".str_replace('"', '\'', $wr_icon).apms_get_html($list[$i]['subject'], 1);
			$caption .= " &nbsp;<i class='fa fa-comment'></i> ";
			if($list[$i]['wr_comment']) $caption .= "<span class='en orangered'>".$list[$i]['wr_comment']."</span>&nbsp; ";
			$caption .= "<span class='font-normal font-11'>댓글달기</span></a>";
		} else {
			$thumb = ($is_lock) ? apms_thumbnail($list[$i]['no_img'], $thumb_w, $thumb_h, false, true) : apms_wr_thumbnail($bo_table, $list[$i], $thumb_w, $thumb_h, false, true);
		}
	?>
		<?php if(!$boset['masonry'] && $k > 0 && $k%$board['bo_gallery_cols'] == 0) { ?>
			<div class="list-row clearfix"></div>
		<?php } ?>
		<div class="list-row">
			<div class="list-item">
				<?php if($thumb_h > 0) { ?>
					<div class="imgframe">
						<div class="img-wrap" style="padding-bottom:<?php echo $img_h;?>%;">
							<div class="img-item">
								<?php echo $wr_label;?>
								<?php if ($is_checkbox) { ?>
									<div class="tack-check<?php echo ($boset['right']) ? '-left' : '';?>">
										<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
									</div>	
								<?php } ?>
								<?php if($boset['lightbox']) { //라이트박스 ?>
									<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
								<?php } else { ?>
									<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js.$is_link_target;?>>
								<?php } ?>
									<img src="<?php echo $thumb['src'];?>" alt="<?php echo $thumb['alt'];?>">
								</a>
							</div>
						</div>
						<?php if($is_date) { ?>
							<div class="list-date <?php echo $is_date;?> en">
								<?php echo date("Y.m.d", $list[$i]['date']); ?>
							</div>
						<?php } ?>
						<?php if($list[$i]['wr_comment']) {?>
							<div class="list-ballon">
								<b><?php echo number_format($list[$i]['wr_comment']); ?></b>
							</div>
						<?php } ?>
					</div>
				<?php } else { ?>
					<div class="list-img">
						<?php echo $wr_label;?>
						<?php if ($is_checkbox) { ?>
							<div class="tack-check<?php echo ($boset['right']) ? '-left' : '';?>">
								<input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
							</div>	
						<?php } ?>
						<?php if($boset['lightbox']) { //라이트박스 ?>
							<a href="<?php echo $img['src'];?>" data-lightbox="<?php echo $bo_table;?>-lightbox" data-title="<?php echo $caption;?>">
						<?php } else { ?>
							<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js.$is_link_target;?>>
						<?php } ?>
							<img src="<?php echo $thumb['src'];?>" alt="<?php echo $thumb['alt'];?>">
						</a>
						<?php if($is_date) { ?>
							<div class="list-date <?php echo $is_date;?> en">
								<?php echo date("Y.m.d", $list[$i]['date']); ?>
							</div>
						<?php } ?>
						<?php if($list[$i]['wr_comment']) {?>
							<div class="list-ballon">
								<b><?php echo number_format($list[$i]['wr_comment']); ?></b>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<?php if($boset['shadow']) echo apms_shadow($boset['shadow']); //그림자 ?>
				<h2>
					<a href="<?php echo $list[$i]['href'];?>"<?php echo $ellipsis.$is_modal_js.$is_link_target;?>>
						<?php if($wr_id && $list[$i]['wr_id'] == $wr_id) {?>
							<span class="crimson"><?php echo $list[$i]['subject'];?></span>
						<?php } else { ?>
							<?php echo $list[$i]['subject'];?>
						<?php } ?>
					</a>
				</h2>
				<div class="list-details text-muted">
					<span class="pull-left">
						작성자 <?php echo $list[$i]['name'];?>
					</span>
					<span class="pull-right">
						조회
						<?php echo number_format($list[$i]['wr_hit']);?>
						<?php if ($boset['udp'] && $list[$i]['as_down']) { ?>
							&nbsp;&nbsp;
							<i class="fa fa-download"></i>
							<?php echo number_format($list[$i]['as_down']); ?>P
						<?php } ?>
					</span>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	<?php $k++; } ?>
</div>
<div class="clearfix"></div>

<?php if (!$list_cnt) { ?>
	<div class="text-center text-muted list-none">게시물이 없습니다.</div>
<?php } ?>

<?php if($boset['masonry']) { // 메이선리 ?>
	<script>
		$(function(){
			var $container = $('.list-container');
			$container.imagesLoaded(function(){
				$container.masonry({
					columnWidth : '.list-row',
					itemSelector : '.list-row',
					isAnimated: true
				});
			});
		});
	</script>
<?php } ?>