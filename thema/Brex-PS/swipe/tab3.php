<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
?>

<div class="at-container widget-index">
<div class="row at-row">
	<!-- 메인 영역 -->
	<div class="col-md-6<?php echo ($side == "left") ? ' pull-right' : '';?> at-col at-main">

		<div class="widget-box">
			<?php echo apms_widget('brex-post-list', $wid.'-m-6', 'date=1'); ?>
			<div style="padding:10px;"><?php echo apms_widget('brex-post-gallery', $wid.'-m-7', 'center=1 item=3 lg=3 md=3 sm=3 xs=3 rows=3'); ?></div>
			<div style="border-top:1px solid #ddd; padding:10px 15px;">
				<?php echo apms_widget('brex-post-ticker', 'pop-3', 'sort=hit rank=green effect=vertical'); ?>
			</div>
		</div>

		<div class="h10"></div>

		<div class="table-responsive widget-m-table">
		<table class="table table-bordered">
			<tr>
				<td><a href="#">연예</a></td>
				<td><a href="#">IT</a></td>
				<td><a href="#">트렌드</a></td>
			</tr>
			<tr>
				<td><a href="#">게임</a></td>
				<td><a href="#">스포츠</a></td>
				<td><a href="#">테마</a></td>
			</tr>
		</table>
		</div>
		
		<div>
		<div class="h10"></div>

		<div class="widget-box">
			<?php echo apms_widget('brex-post-list', $wid.'-m-8', 'date=1'); ?>
			<div style="padding:10px;"><?php echo apms_widget('brex-post-gallery', $wid.'-m-9', 'center=1 item=3 lg=3 md=3 sm=3 xs=3 rows=3'); ?></div>
		</div>

		</div><!--padding-->

	</div>
	<!-- 사이드 영역 -->
	<div class="col-md-6<?php echo ($side == "left") ? ' pull-left' : '';?> at-col at-side">

		<div class="widget-box-head">
			<span class="pull-left">APMS 1.7에 최적화 되어있습니다.</span>
			<span class="pull-right"><a href="#">더보기 <i class="fa fa-angle-right"></i></a></span>
		</div>
		<div class="widget-box-2nd">
			<?php echo apms_widget('brex-post-photo', $wid.'-m-g1', 'center=1 rows=4 item=2 lg=2 md=2 sm=2 xs=2'); ?>
		</div>

		<div class="widget-box">
			<?php echo apms_widget('brex-post-list', $wid.'-m-10', 'date=1'); ?>
			<div style="border-top:1px solid #ddd; padding:10px 15px;">
				<?php echo apms_widget('brex-post-ticker', 'pop-4', 'sort=hit rank=green effect=vertical'); ?>
			</div>
		</div>
		
		<div class="h10"></div>

		<?php echo apms_widget('brex-banner', $wid.'-m-b3', ''); //타이틀 ?>
		
		<div class="h10"></div>

		<div class="tab20">
			<div id="tab_20" class="div-tab tabs swipe-tab tabs-color-top">
				<div class="w-tab">
					<ul class="nav nav-tabs" data-toggle="tab-click">
						<li class="active"><a href="#tab_21" data-toggle="tab">뉴스</a></li>
						<li><a href="#tab_22" data-toggle="tab">스포츠</a></li>
						<li><a href="#tab_23" data-toggle="tab">연예</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_21">
						<?php echo apms_widget('brex-post-photo', $wid.'-mt4', 'center=1 thumb_w=300 thumb_h=300 rows=9 item=3 lg=3 md=3 sm=3 xs=3'); ?>	
					</div>
					<div class="tab-pane" id="tab_22">
						<?php echo apms_widget('brex-post-photo', $wid.'-mt5', 'center=1 thumb_w=300 thumb_h=300 rows=9 item=3 lg=3 md=3 sm=3 xs=3'); ?>	
					</div>
					<div class="tab-pane" id="tab_23">
						<?php echo apms_widget('brex-post-photo', $wid.'-mt6', 'center=1 thumb_w=300 thumb_h=300 rows=9 item=3 lg=3 md=3 sm=3 xs=3'); ?>	
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
