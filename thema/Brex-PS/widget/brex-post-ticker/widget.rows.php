<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 추출하기
$list = apms_board_rows($wset);
$list_cnt = count($list);

// 아이콘
$icon = (isset($wset['icon']) && $wset['icon']) ? apms_fa($wset['icon']) : '';

// 랭킹
$rank = apms_rank_offset($wset['rows'], $wset['page']);

// 링크
$is_link = (isset($wset['link']) && $wset['link']) ? true : false;

for ($i=0; $i < $list_cnt; $i++) { 
	// 링크#1
	$target = '';
	if($is_link && $list[$i]['wr_link1']) {
		$list[$i]['href'] = $list[$i]['link_href'][1];
		$target = ' target="_blank"';
	}	
?>
	<li style="height:20px;">
		<a href="<?php echo $list[$i]['href'];?>" class="ellipsis"<?php echo $target;?>>
			<span class="black">
				<span class="pull-right text-muted">
					<?php if($list[$i]['comment'] && !$wset['use_cmt']) { ?>
						<b class="red en">[<?php echo number_format($list[$i]['comment']);?>]</b> &nbsp;
					<?php } ?>
					<?php echo date("m.d", $list[$i]['date']);?>
				</span>
				<?php if($wset['rank']) { ?>
					<span class="rank-icon en bg-<?php echo $wset['rank'];?>"><?php echo $rank; $rank++; ?></span>
				<?php } else if($icon) { ?>
					<?php if($list[$i]['new']) { ?>
						<span class="<?php echo $wset['new'];?>"><?php echo $icon;?></span>
					<?php } else { ?>
						<?php echo $icon;?>
					<?php } ?>
				<?php } ?>
				<?php echo $list[$i]['subject'];?>
			</span>
		</a> 
	</li>
<?php } ?>
<?php if(!$list_cnt) { ?>
	<li style="height:20px;">
		<a class="ellipsis">
			<span class="black"><?php echo $icon;?> 글이 없습니다.</span>
		</a>
	</li>
<?php } ?>
