<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$view_skin_url.'/view.css" media="screen">', 0);

$attach_list = '';
if ($view['link']) {
	// 링크
	for ($i=1; $i<=count($view['link']); $i++) {
		if ($view['link'][$i]) {
			$attach_list .= '<a class="list-group-item break-word" href="'.$view['link_href'][$i].'" target="_blank">';
			$attach_list .= '<i class="fa fa-link"></i> '.cut_str($view['link'][$i], 70).' &nbsp;<span class="blue">+ '.$view['link_hit'][$i].'</span></a>'.PHP_EOL;
		}
	}
}

// 가변 파일
$j = 0;
if ($view['file']['count']) {
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
			if ($board['bo_download_point'] < 0 && $j == 0) {
				$attach_list .= '<a class="list-group-item"><i class="fa fa-bell red"></i> 다운로드시 <b>'.number_format(abs($board['bo_download_point'])).'</b>'.AS_MP.' 차감 (최초 1회 / 재다운로드시 차감없음)</a>'.PHP_EOL;
			}
			$file_tooltip = '';
			if($view['file'][$i]['content']) {
				$file_tooltip = ' data-original-title="'.strip_tags($view['file'][$i]['content']).'" data-toggle="tooltip"';
			}
			$attach_list .= '<a class="list-group-item break-word view_file_download at-tip" href="'.$view['file'][$i]['href'].'"'.$file_tooltip.'>';
			$attach_list .= '<span class="pull-right hidden-xs text-muted"><i class="fa fa-clock-o"></i> '.date("Y.m.d H:i", strtotime($view['file'][$i]['datetime'])).'</span>';
			$attach_list .= '<i class="fa fa-download"></i> '.$view['file'][$i]['source'].' ('.$view['file'][$i]['size'].') &nbsp;<span class="orangered">+ '.$view['file'][$i]['download'].'</span></a>'.PHP_EOL;
			$j++;
		}
	}
}

$view_font = (G5_IS_MOBILE) ? '' : ' font-12';
$view_subject = get_text($view['wr_subject']);

?>
<style>
.view-under { border-bottom:2px solid #<?php echo $brex_color;?>; }
.view-control .control-box { background:#<?php echo $brex_color;?>; }
.view-control .control-box .count { background:#<?php echo $brex_color;?>; }
</style>

<section itemscope itemtype="http://schema.org/NewsArticle">
	<article itemprop="articleBody">
		<h1 itemprop="headline" content="<?php echo $view_subject;?>">
			<?php if($view['photo']) { ?><span class="talker-photo hidden-xs"><?php echo $view['photo'];?></span><?php } ?>
			<?php echo cut_str(get_text($view['wr_subject']), 70); ?>
		</h1>
		<div class="view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
			<div class="">
				<div class="ellipsis text-muted<?php echo $view_font;?>">
					<div class="pull-left">
					<span itemprop="publisher" content="<?php echo get_text($view['wr_name']);?>">
						<?php echo $view['name']; //등록자 ?>
					</span>
					<?php echo ($is_ip_view) ? '<span class="print-hide hidden-xs">('.$ip.')</span>' : ''; ?>
					<?php if($view['ca_name']) { ?>
						<span class="hidden-xs">
							<span class="sp">|</span>
							<i class="fa fa-tag"></i>
							<?php echo $view['ca_name']; //분류 ?>
						</span>
					<?php } ?>
					<span class="sp">|</span>
					댓글
					<?php echo ($view['wr_comment']) ? '<b class="red">'.$view['wr_comment'].'</b>' : 0; //댓글수 ?>
					<span class="sp">|</span>
					조회수
					<?php echo $view['wr_hit']; //조회수 ?>
					</div>
					<div class="pull-right">
						작성일
						<span itemprop="datePublished" content="<?php echo date('Y-m-dTH:i:s', $view['date']);?>">
							<?php echo apms_date($view['date'], 'orangered', 'before'); //시간 ?>
						</span>
					</div>
				</div>
			</div>
		   <?php
				if($attach_list) {
					echo '<div class="list-group'.$view_font.'">'.$attach_list.'</div>'.PHP_EOL;
				}
			?>
		</div>

		<div class="view-padding">

			<?php if ($is_torrent) echo apms_addon('torrent-basic'); // 토렌트 파일정보 ?>

			<?php
				// 이미지 상단 출력
				$v_img_count = count($view['file']);
				if($v_img_count && $is_img_head) {
					echo '<div class="view-img">'.PHP_EOL;
					for ($i=0; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							echo get_view_thumbnail($view['file'][$i]['view']);
						}
					}
					echo '</div>'.PHP_EOL;
				}
			 ?>

			<div itemprop="description" class="view-content">
				<?php echo get_view_thumbnail($view['content']); ?>
			</div>

			<?php
				// 이미지 하단 출력
				if($v_img_count && $is_img_tail) {
					echo '<div class="view-img">'.PHP_EOL;
					for ($i=0; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							echo get_view_thumbnail($view['file'][$i]['view']);
						}
					}
					echo '</div>'.PHP_EOL;
				}
			?>

		</div>
		
		<?php if($view['wr_10'] == 'm') {?>
			<div class="text-muted font-11 m-written"><i class="fa fa-tablet"></i> 모바일에서 작성된 글입니다.</div>
		<?php } ?>

		<?php if ($is_tag) { // 태그 ?>
			<p class="view-tag view-padding<?php echo $view_font;?>"><i class="fa fa-tags"></i> <?php echo $tag_list;?></p>
		<?php } ?>

		<?php if($is_signature) { // 서명 ?>
			<div class="print-hide">
				<?php echo apms_addon('sign-basic'); // 회원서명 ?>
			</div>
		<?php } ?>

	</article>
</section>

<div class="h15"></div>
<div class="view-under">
	<div class="view-control print-hide">
		<!--div class="pull-left">
		댓글 <b class="red"><?php echo number_format($write['wr_comment']);?></b>개
		</div-->
		<div class="control-box-wrap pull-right">
			<?php if ($good_href) { ?>
				<div class="control-box">
					<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'good', 'wr_good'); return false;">
					<i class="fa fa-thumbs-up"></i>
					<?php if($view['wr_good']) {?><div class="count en" id="wr_good"><?php echo $view['wr_good']; ?></div><?php } ?>
					</a>
				</div>
			<?php } ?>
			<?php if ($nogood_href) { ?>
				<div class="control-box">
					<a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'nogood', 'wr_nogood'); return false;"><i class="fa fa-thumbs-down"></i>
					<?php if($view['wr_nogood']) {?><div class="count en" id="wr_nogood"><?php echo $view['wr_nogood']; ?></div><?php } ?>
					</a>
				</div>
			<?php } ?>
			<?php if($board['bo_use_sns']) {?>
			<div class="control-box">
				<a href="#" onclick="view_control('sns'); return false;"><i class="fa fa-share-alt"></i></a>

				<div id="sns" class="view-manager">
					<?php 
						// SNS 보내기
						echo apms_sns_share_icon('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $view['subject'], $seometa['img']['src']);
					?>
				</div>
			</div>
			<?php } ?>
			<div class="control-box">
				<a href="#" onclick="view_control('manager'); return false;"><i class="fa fa-ellipsis-v"></i></a>

				<div id="manager" class="view-manager">
					<img src="<?php echo G5_IMG_URL;?>/sns/print.png" alt="프린트" class="cursor at-tip" onclick="apms_print();">
					<?php if ($scrap_href) { ?>
						<img src="<?php echo G5_IMG_URL;?>/sns/scrap.png" alt="스크랩" class="cursor at-tip" onclick="win_scrap('<?php echo $scrap_href;  ?>');">
					<?php } ?>
					<?php if ($is_shingo) { ?>
						<img src="<?php echo G5_IMG_URL;?>/sns/shingo.png" alt="신고" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>');">
					<?php } ?>
					<?php if ($is_admin) { ?>
						<?php if ($view['is_lock']) { // 글이 잠긴상태이면 ?>
							<img src="<?php echo G5_IMG_URL;?>/sns/unlock.png" alt="해제" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'unlock');">
						<?php } else { ?>
							<img src="<?php echo G5_IMG_URL;?>/sns/lock.png" alt="잠금" class="cursor at-tip" onclick="apms_shingo('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'lock');">
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="h20"></div>

<script>
var is_show;

function view_control(id) {
	$("#"+id).toggle();

	return false;
}
</script>

<?php include_once('./view_comment.php'); ?>
