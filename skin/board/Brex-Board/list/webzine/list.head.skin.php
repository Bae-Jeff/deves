<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<?php if($notice_count > 0) { //공지사항 ?>
	<div class="panel panel-default list-notice">
		<div class="panel-heading">
			<h4 class="panel-title">Notice</h4>
		</div>
		<div class="list-group">
			<?php for ($i=0; $i < $notice_count; $i++) { 
					if(!$list[$i]['is_notice']) break; //공지가 아니면 끝냄 
			?>
				 <a href="<?php echo $list[$i]['href'];?>" class="list-group-item ellipsis"<?php echo $is_modal_js;?>>
					<span class="hidden-xs pull-right font-12 black">
						<i class="fa fa-clock-o"></i> <?php echo apms_datetime($list[$i]['date'], "Y.m.d");?>
					</span>
					<span class="wr-notice"></span>
					<strong class="black"><?php echo $list[$i]['subject'];?></strong>
					<?php if($list[$i]['wr_comment']) { ?>
						<span class="count red"><?php echo $list[$i]['wr_comment'];?></span>
					<?php } ?>
				</a>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<?php 
if($is_category) 
	include_once($board_skin_path.'/category.skin.php'); // 카테고리	
?>
	
	<div class="h15"></div>
		<div class="list-head">
			<div class="list-btn">
				<div class="form-group pull-right">
					<div class="btn-group dropdown" role="group">
						<ul class="dropdown-menu sort-drop" role="menu" aria-labelledby="sortLabel">
							<li>
								<a href="./board.php?bo_table=<?php echo $bo_table;?>&amp;sca=<?php echo urlencode($sca);?>">
									<i class="fa fa-power-off"></i> 초기화
								</a>
							</li>
							<li<?php echo ($sst == 'wr_datetime') ? ' class="sort"' : '';?>>
								<?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>
									<i class="fa fa-clock-o"></i> 날짜순
								</a>
							</li>
							<li<?php echo ($sst == 'wr_hit') ? ' class="sort"' : '';?>>
								<?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>
									<i class="fa fa-eye"></i> 조회순
								</a>
							</li>
							<?php if ($is_good) { ?>
								<li<?php echo ($sst == 'wr_good') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_good', $qstr2, 1) ?>
										<i class="fa fa-thumbs-up"></i> 추천순
									</a>
								</li>
							<?php } ?>
							<?php if ($is_nogood) { ?>
								<li<?php echo ($sst == 'wr_nogood') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>
										<i class="fa fa-thumbs-down"></i> 비추순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['scmt']) { ?>
								<li<?php echo ($sst == 'wr_comment') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_comment', $qstr2, 1) ?>
										<i class="fa fa-comment"></i> 댓글순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['sdload']) { ?>
								<li<?php echo ($sst == 'as_download') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_download', $qstr2, 1) ?>
										<i class="fa fa-download"></i> 다운순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['spoll']) { ?>
								<li<?php echo ($sst == 'as_poll') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_poll', $qstr2, 1) ?>
										<i class="fa fa-user"></i> 참여순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['svisit']) { ?>
								<li<?php echo ($sst == 'wr_link1_hit') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('wr_link1_hit', $qstr2, 1) ?>
										<i class="fa fa-share"></i> 방문순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['supdate']) { ?>
								<li<?php echo ($sst == 'as_update') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_update', $qstr2, 1) ?>
										<i class="fa fa-history"></i> 업데이트순
									</a>
								</li>
							<?php } ?>
							<?php if ($boset['sdown']) { ?>
								<li<?php echo ($sst == 'as_down') ? ' class="sort"' : '';?>>
									<?php echo subject_sort_link('as_down', $qstr2, 1) ?>
										<i class="fa fa-gift"></i> 다운점수순
									</a>
								</li>
							<?php } ?>
						</ul>
						<a id="sortLabel" role="button" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-<?php echo $btn1;?> btn-sm">
							<?php 
								switch($sst) {
									case 'wr_datetime'	: echo '<i class="fa fa-clock-o"></i> 날짜순'; break;
									case 'wr_hit'		: echo '<i class="fa fa-eye"></i> 조회순'; break;
									case 'wr_good'		: echo '<i class="fa fa-thumbs-up"></i> 추천순'; break;
									case 'wr_nogood'	: echo '<i class="fa fa-thumbs-down"></i> 비추순'; break;
									case 'wr_comment'	: echo '<i class="fa fa-comment"></i> 댓글순'; break;
									case 'as_download'	: echo '<i class="fa fa-download"></i> 다운순'; break;
									case 'as_poll'		: echo '<i class="fa fa-user"></i> 참여순'; break;
									case 'wr_link1_hit'	: echo '<i class="fa fa-share"></i> 방문순'; break;
									case 'as_update'	: echo '<i class="fa fa-history"></i> 업데이트순'; break;
									case 'as_down'		: echo '<i class="fa fa-gift"></i> 다운점수순'; break;
									default				: echo '<i class="fa fa-sort"></i> 정렬'; break;
								}
							?>
						</a>
						<span class="list-sp"></span>
						<?php if ($list_href) { ?><a role="button" href="<?php echo $list_href ?>" class="btn btn-<?php echo $btn1;?> btn-sm">목록</a>
						<span class="list-sp"></span><?php } ?>
						<?php if ($write_href) { ?><a role="button" href="<?php echo $write_href ?>" class="btn btn-<?php echo $btn2;?> btn-sm">글쓰기</a><?php } ?>
					</div>
				</div>
				<div class="form-group pull-left">
					<div class="btn-group" role="group">
						<?php if ($rss_href) { ?>
							<a role="button" href="<?php echo $rss_href; ?>" class="btn btn-<?php echo $btn2;?> btn-sm"><i class="fa fa-rss"></i></a>
							<span class="list-sp"></span>
						<?php } ?>
						<a role="button" href="#" class="btn btn-<?php echo $btn1;?> btn-sm" data-toggle="modal" data-target="#searchModal" onclick="return false;">검색</a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
