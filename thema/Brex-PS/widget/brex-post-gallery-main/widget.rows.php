<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
if(!$wset['rows']) {
	$wset['rows'] = 12;	
}

//$wset['rows']  = 10;

// 추출하기
$wset['image'] = 1; //이미지글만 추출
$list = apms_board_rows($wset);
$list_cnt = count($list); // 글수

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 날짜
$is_date = (isset($wset['date']) && $wset['date']) ? true : false;
$is_dtype = (isset($wset['dtype']) && $wset['dtype']) ? $wset['dtype'] : 'm.d';
$is_dtxt = (isset($wset['dtxt']) && $wset['dtxt']) ? true : false;

// 새글
$is_new = (isset($wset['new']) && $wset['new']) ? $wset['new'] : 'red'; 

// 분류
$is_cate = (isset($wset['cate']) && $wset['cate']) ? true : false;

// 글내용 - 줄이 1줄보다 크고
$is_cont = ($wset['line'] > 1) ? true : false; 
$is_details = ($is_cont) ? '' : ' no-margin'; 

// 동영상아이콘
$is_vicon = (isset($wset['vicon']) && $wset['vicon']) ? '' : '<i class="fa fa-play-circle-o post-vicon"></i>'; 

// 스타일
$is_center = (isset($wset['center']) && $wset['center']) ? ' text-center' : ''; 
$is_bold = (isset($wset['bold']) && $wset['bold']) ? true : false; 

// 그림자
$shadow_in = '';
$shadow_out = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';
if($shadow_out && isset($wset['inshadow']) && $wset['inshadow']) {
	$shadow_in = '<div class="in-shadow">'.$shadow_out.'</div>';
	$shadow_out = '';	
}

// 강조글
$bold = array();
$strong = explode(",", $wset['strong']);
$is_strong = count($strong);
for($i=0; $i < $is_strong; $i++) {

	list($n, $bc) = explode("|", $strong[$i]);

	if(!$n) continue;

	$n = $n - 1;
	$bold[$n]['num'] = true;
	$bold[$n]['color'] = ($bc) ? ' class="'.$bc.'"' : '';
}

$wset['wide'] = "";
$wide = explode(",", $wset['wide']);
$is_wide = count($wide);
for($i=0; $i < $is_wide; $i++) {
	echo '
	<style>
		.post-row-'.$wide[$i].' { width:50% !important; }
		.img-wrap-'.$wide[$i].' { padding-bottom:66.5% !important; }
	</style>
	';
}

$over = explode(",", $wset['over']);
$is_over = count($over);
for($i=0; $i < $is_over; $i++) {
	echo '
	<style>
		.post-list-'.$over[$i].' .post-content { display:none; }
		.post-list-'.$over[$i].' .over-blur { display:block; }
		.post-list-'.$over[$i].' .post-content-over { display:block; }
	</style>
	';
}
?>

<?php
// 리스트
for ($i=0; $i < $list_cnt; $i++) {

	//아이콘 체크
	$wr_icon = '';
	$is_lock = false;
	if ($list[$i]['secret'] || $list[$i]['is_lock']) {
		$is_lock = true;
		$wr_icon = '<span class="rank-icon en bg-orange en">Lock</span>';	
	} else if ($wset['rank']) {
		$wr_icon = '<span class="rank-icon en bg-'.$wset['rank'].'">'.$rank.'</span>';	
		$rank++;
	} else if($list[$i]['new']) {
		$wr_icon = '<span class="rank-icon txt-normal en bg-'.$is_new.'">New</span>';	
	}

	// 링크이동
	$target = '';
	if($is_link_target && $list[$i]['wr_link1']) {
		$target = $is_link_target;
		$list[$i]['href'] = $list[$i]['link_href'][1];
	}

	//강조글
	if($is_strong) {
		if($bold[$i]['num']) {
			$list[$i]['subject'] = '<b'.$bold[$i]['color'].'>'.apms_cut_text($list[$i]['subject'], 80).'</b>';
		}
	}
?>
	<div class="post-row post-row-<?php echo $i;?>">
		<div class="post-list post-list-<?php echo $i;?>">
			<div class="post-image">
				<a href="<?php echo $list[$i]['href'];?>" class="ellipsis"<?php echo $is_modal_js;?><?php echo $target;?>>
					<div class="img-wrap img-wrap-<?php echo $i;?>">
						<?php echo $shadow_in;?>
						<?php if($list[$i]['as_list'] == "2" || $list[$i]['as_list'] == "3") echo $is_vicon; ?>
						<div class="img-item">
							<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>">
						</div>
					</div>
				</a>
				<?php echo $shadow_out;?>
			</div>
			<div class="over-blur">
			</div>
			<div class="post-content-over<?php echo $is_center;?>">
				<div class="post-subject">
					<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
						<?php //echo $wr_icon;?>
						<span class="white"><?php echo $list[$i]['subject'];?></span>
						<?php if($is_cont) { ?>
							<div class="post-text">
								<?php echo apms_cut_text($list[$i]['content'], 80);?>
							</div>
						<?php } ?>
					</a>
				</div>
				<div class="post-text post-ko txt-short ellipsis<?php echo $is_center;?><?php echo $is_details;?>">
					<span class="white"><?php echo $list[$i]['name'];?></span>
					<?php if($is_cate && $list[$i]['ca_name']) { ?>
						<span class="post-sp">|</span>
						<?php echo $list[$i]['ca_name'];?>
					<?php } ?>
					<?php if($is_date) { ?>
						<span class="post-sp">|</span>
						<span class="txt-normal">
							<?php echo ($is_dtxt) ? apms_datetime($list[$i]['date'], $is_dtype) : date($is_dtype, $list[$i]['date']); ?>
						</span>
					<?php } ?>
					<?php if ($list[$i]['comment']) { ?>
						<span class="count white">[<?php echo $list[$i]['comment']; ?>]</span>
					<?php } ?>
				</div>
			</div>
			<div class="post-content<?php echo $is_center;?>">
				<div class="post-subject">
					<a href="<?php echo $list[$i]['href'];?>"<?php echo $is_modal_js;?><?php echo $target;?>>
						<?php //echo $wr_icon;?>
						<?php echo $list[$i]['subject'];?>
						<?php if($is_cont) { ?>
							<div class="post-text">
								<?php echo apms_cut_text($list[$i]['content'], 80);?>
							</div>
						<?php } ?>
					</a>
				</div>
				<div class="post-text post-ko txt-short ellipsis<?php echo $is_center;?><?php echo $is_details;?>">
					<span class="orangered"><?php echo $list[$i]['name'];?></span>
					<?php if($is_cate && $list[$i]['ca_name']) { ?>
						<span class="post-sp">|</span>
						<?php echo $list[$i]['ca_name'];?>
					<?php } ?>
					<?php if($is_date) { ?>
						<span class="post-sp">|</span>
						<span class="txt-normal">
							<?php echo ($is_dtxt) ? apms_datetime($list[$i]['date'], $is_dtype) : date($is_dtype, $list[$i]['date']); ?>
						</span>
					<?php } ?>
					<?php if ($list[$i]['comment']) { ?>
						<span class="count red">[<?php echo $list[$i]['comment']; ?>]</span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } // end for ?>
<?php if(!$list_cnt) { ?>
	<div class="post-none">등록된 글이 없습니다.</div>
<?php } ?>
