<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<div class="m-wrap">
	<div class="at-container">
		<div class="m-table en">
			<div class="m-list">
				<div class="m-nav" id="mobile_nav">
					<ul class="clearfix">
					<li>
						<a href="?srows=<?php echo $srows;?>&sfl=<?php echo $sfl;?>&stx=<?php echo $stx;?>&sop=<?php echo $sop;?>">통합검색</a>
					</li>
					<?php 
						$j = 1; //현재위치 표시
						for ($i=1; $i < $menu_cnt; $i++) {

							if(!$menu[$i]['gr_id']) continue;

							if($menu[$i]['on'] == 'on') {
								$m_sat = $j;

								//서브메뉴
								if($menu[$i]['is_sub']) {
									$m_sub = $i;
								}
							}
					?>
						<li>
							<a href="?srows=<?php echo $srows;?>&gr_id=<?php echo $menu[$i]['gr_id'];?>&sfl=<?php echo $sfl;?>&stx=<?php echo $stx;?>&sop=<?php echo $sop;?>"<?php echo $menu[$i]['target'];?>>
								<?php echo $menu[$i]['menu'];?>
								<?php if($menu[$i]['new'] == "new") { ?>
									<i class="fa fa-bolt new"></i>
								<?php } ?>
							</a>
						</li>
					<?php $j++; } //for ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
