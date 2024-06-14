<?php
if (!defined('_GNUBOARD_')) {
	include_once('../../../../common.php');
	include_once(G5_LIB_PATH.'/apms.more.lib.php');
	$is_ajax = true;

	//썸네일
	$wset['thumb_w'] = (isset($wset['thumb_w']) && $wset['thumb_w'] > 0) ? $wset['thumb_w'] : 400;
	$wset['thumb_h'] = (isset($wset['thumb_h']) && ($wset['thumb_h'] > 0 || $wset['thumb_h'] == "0")) ? $wset['thumb_h'] : 500;
}

// 추출하기
if(!isset($wset['rows']) || !$wset['rows']) {
	$wset['rows'] = 8;
}

$list = apms_item_rows($wset);
$list_cnt = count($list);

// 랭킹
$is_rank = (isset($wset['rank']) && $wset['rank']) ? $wset['rank'] : '';
$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 새상품
$new_item = (isset($wset['newtime']) && $wset['newtime']) ? $wset['newtime'] : 24;

// 별점
$wset['star'] = (isset($wset['star']) && $wset['star']) ? $wset['star'] : '1';
$is_star = ($wset['star'] != "1") ? true : false;

// 포인트
$wset['pbg'] = (isset($wset['pbg']) && $wset['pbg']) ? $wset['pbg'] : 'navy';

// 숨김항목
$is_buy = (isset($wset['buy']) && $wset['buy']) ? false : true;
$is_cmt = (isset($wset['cmt']) && $wset['cmt']) ? false : true;
$is_good = (isset($wset['good']) && $wset['good']) ? false : true;

// 보임항목
$is_use = (isset($wset['use']) && $wset['use']) ? true : false;
$is_qa = (isset($wset['qa']) && $wset['qa']) ? true : false;
$is_hit = (isset($wset['hit']) && $wset['hit']) ? true : false;

$is_info = ($is_star || $is_use || $is_qa || $is_buy || $is_cmt || $is_good || $is_hit) ? true : false;

// 그림자
$is_shadow = (isset($wset['shadow']) && $wset['shadow']) ? apms_shadow($wset['shadow']) : '';

for ($i=0; $i < $list_cnt; $i++) { 

	$item_label = $dc = '';
	if($list[$i]['it_cust_price'] > 0 && $list[$i]['it_price'] > 0) {
		$dc = round((($list[$i]['it_cust_price'] - $list[$i]['it_price']) / $list[$i]['it_cust_price']) * 100);
	}

	if($dc || $list[$i]['it_type5']) {
		$item_label = '<div class="label-cap bg-red">DC</div>';	
	} else if($list[$i]['pt_num'] >= (G5_SERVER_TIME - ($new_item * 3600))) {
		$item_label = '<div class="label-cap bg-'.$wset['new'].'">New</div>';
	}

	// 아이콘
	$item_icon = item_icon($list[$i]);
?>
	<div class="item-row">
		<div class="item-list item-col is-round-item">
			<div class="bg-white">
				<div class="item-image">
					<?php if($wset['thumb_h'] > 0) { // 이미지 높이값이 있을 경우?>
						<div class="imgframe">
							<div class="img-wrap">
								<a href="<?php echo $list[$i]['href'];?>">
									<?php //echo $item_label;?>
									<?php if($item_icon) { ?>
										<div class="item-icon"><?php echo $item_icon;?></div>
									<?php } ?>
									<?php if($list[$i]['it_point']) { ?>
										<div class="item-point rank-icon trans-bg-<?php echo $wset['pbg'];?>">
											<span><?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i])).' '.AS_MP;?></span> 적립
										</div>
									<?php } ?>
									<div class="img-item" style="overflow:hidden;">
										<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>" class="wr-img">
									</div>
								</a>
							</div>
							<div class="info-line">
								<div style="position:relative;">
									<b class="white">
										<?php if($list[$i]['it_tel_inq']) { ?>
											전화문의
										<?php } else { ?>
											<span class="font-16 en white"><?php echo number_format($list[$i]['it_price']);?></span>원
										<?php } ?>
									</b>

									<div class="badge-dc"><b><span class="font-14 en black"><?php echo $dc;?>%</span></b></div>
								</div>
							</div>
						</div>
					<?php } else { ?>
						<div class="item-img">
							<a href="<?php echo $list[$i]['href'];?>">
								<?php echo $item_label;?>
								<?php if($item_icon) { ?>
									<div class="item-icon"><?php echo $item_icon;?></div>
								<?php } ?>
								<?php if($list[$i]['it_point']) { ?>
									<div class="item-point rank-icon trans-bg-<?php echo $wset['pbg'];?>">
										<span><?php echo ($list[$i]['it_point_type'] == 2) ? $list[$i]['it_point'].'%' : number_format(get_item_point($list[$i])).' '.AS_MP;?></span> 적립
									</div>
								<?php } ?>
								<img src="<?php echo $list[$i]['img']['src'];?>" alt="<?php echo $list[$i]['img']['alt'];?>" class="wr-img">
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="is-item-content">
					<?php echo $is_shadow; //그림자 ?>
					<div class="item-content">
						<a href="<?php echo $list[$i]['href'];?>">
							<?php if ($is_rank) { ?>
								<span class="rank-icon en bg-<?php echo $is_rank;?>"><?php echo $rank;?></span>	
							<?php } ?>
							<strong>
								<?php echo $list[$i]['it_name'];?>
							</strong>
							<div class="item-desc text-muted">
								<?php echo $list[$i]['it_basic']; ?>
							</div>
						</a>
					</div>
					<?php if($is_info) { ?>
						<div class="item-info en">
							<?php if($is_star) { ?>
								<span class="item-star">
									<?php echo apms_get_star($list[$i]['it_use_avg'], $wset['star']); //평균별점 ?>
								</span>
							<?php } ?>
							<?php if($is_use) { ?>
								<span>
									<i class="fa fa-pencil-square-o violet"></i>
									<?php echo number_format($list[$i]['it_use_cnt']);?>
								</span>
							<?php } ?>
							<?php if($is_qa) { ?>
								<span>
									<i class="fa fa-question-circle orange"></i>
									<?php echo number_format($list[$i]['pt_qa']);?>
								</span>
							<?php } ?>
							<?php if($is_buy) { ?>
								<span>
									<i class="fa fa-shopping-cart green"></i>
									<?php echo number_format($list[$i]['it_sum_qty']);?>
								</span>
							<?php } ?>
							<?php if($is_cmt) { ?>
								<span>
									<i class="fa fa-commenting blue"></i> 
									<?php echo number_format($list[$i]['pt_comment']);?>
								</span>
							<?php } ?>
							<?php if($is_good) { ?>
								<span>
									<i class="fa fa-heart orangered"></i> 
									<?php echo number_format($list[$i]['pt_good']);?>
								</span>
							<?php } ?>
							<?php if($is_hit) { ?>
								<span>
									<i class="fa fa-eye navy"></i> 
									<?php echo number_format($list[$i]['it_hit']);?>
								</span>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php $rank++; } ?>
<?php if(!$is_ajax && !$list_cnt) { ?>
	<div class="item-none text-center text-muted">
		등록된 상품이 없습니다.
	</div>
<?php } ?>