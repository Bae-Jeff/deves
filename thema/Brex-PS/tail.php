<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

?>

<style>
.widget-box { background:#fff; }
/* 텍스트 크기 조절 */
#text_size a {margin:0;padding:0px;border:1px solid #c3c6ca; width:34px; height:34px; padding:5px; background:#f6f6f9; border-right:0px; color:#ccc;}
#text_size a:last-child { border-right:1px solid #c3c6ca; }
.ts_up {font-size:1.167em !important}
.ts_up2 {font-size:1.3em !important}
.ts_up0 #text_size a.active1 { background:#e6e7e9 !important; color:#000; }
.ts_up #text_size a.active2 { background:#e6e7e9 !important; color:#000; }
.ts_up2 #text_size a.active3 { background:#e6e7e9 !important; color:#000; }
</style>

		<?php if($col_name) { ?>
			<?php if($col_name == "two") { ?>
					</div>
					<div class="col-md-<?php echo $col_side;?><?php echo ($at_set['side']) ? ' pull-left' : '';?> at-col at-side">
						<?php include_once($is_side_file); // Side ?>
					</div>
				</div>
			<?php } else { ?>
				</div><!-- .at-content -->
			<?php } ?>
			</div><!-- .at-container -->
		<?php } ?>
		<?php if(G5_IS_MOBILE) {?>
		<div class="at-container">
		<div class="widget-box" style="padding:10px 15px; margin:0; border-top:1px solid #ddd; border-bottom:1px solid #ddd;">
			<div id="text_size">
				<span class="pull-right go-top cursor font-16" style="color:#727272; padding-top:8px;"><i class="fa fa-arrow-up fa-lg"></i></span>
				<div class="btn-group" role="group">
					<a role="button" id="size_down" onclick="font_resize('body_text', 'ts_up ts_up2 ts_up0', 'ts_up0');" class="btn btn-sm active1" style="font-size:14px;" title="기본">
						가
					</a>
					<a role="button" id="size_def" onclick="font_resize('body_text', 'ts_up2 ts_up0 ts_up', 'ts_up');" class="btn btn-sm active2" style="font-size:15px;" title="크게">
						가
					</a>
					<a role="button" id="size_up" onclick="font_resize('body_text', 'ts_up ts_up2 ts_up0', 'ts_up2');" class="btn btn-sm active3" style="font-size:16px;" title="더크게">
						가
					</a>
				</div>
			</div>
		</div>
		</div>
		<?php } ?>
	</div><!-- .at-body -->

	<?php if(!$is_main_footer) { ?>
		<footer class="at-footer">
			<?php if(!G5_IS_MOBILE) {?>
			<div class="pc-footer">
				<nav class="at-links">
					<div class="at-container">
						<ul class="pull-left">
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보처리방침</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=noemail">이메일 무단수집거부</a></li>
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=disclaimer">책임의 한계와 법적고지</a></li>
						</ul>
						<ul class="pull-right">
							<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=guide">이용안내</a></li>
							<li><a href="<?php echo $at_href['secret'];?>">문의하기</a></li>
							<li><a href="<?php echo $as_href['pc_mobile'];?>"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일';?>버전</a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
				</nav>
				<div class="at-infos">
					<div class="at-container">
						<?php if(IS_YC) { // YC5 ?>
							<div class="media">
								<div class="pull-right hidden-xs">
									<!-- 하단 우측 아이콘 -->
								</div>
								<div class="pull-left hidden-xs">
									<!-- 하단 좌측 로고 -->
									<i class="fa fa-leaf"></i>
								</div>
								<div class="media-body">
							
									<ul class="at-about hidden-xs">
										<li><b><?php echo $default['de_admin_company_name']; ?></b></li>
										<li>대표 : <?php echo $default['de_admin_company_owner']; ?></li>
										<li><?php echo $default['de_admin_company_addr']; ?></li>
										<li>전화 : <span><?php echo $default['de_admin_company_tel']; ?></span></li>
										<li>사업자등록번호 : <span><?php echo $default['de_admin_company_saupja_no']; ?></span></li>
										<li><a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a></li>
										<li>통신판매업신고 : <span><?php echo $default['de_admin_tongsin_no']; ?></span></li>
										<li>개인정보관리책임자 : <?php echo $default['de_admin_info_name']; ?></li>
										<li>이메일 : <span><?php echo $default['de_admin_info_email']; ?></span></li>
									</ul>
									
									<div class="clearfix"></div>

									<div class="copyright">
										<strong><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></strong>
										<span>All rights reserved.</span>
									</div>

									<div class="clearfix"></div>
								</div>
							</div>
						<?php } else { // G5 ?>
							<div class="at-copyright">
								<i class="fa fa-leaf"></i>
								<strong><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></strong>
								All rights reserved.
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } else {?>
			<div class="m-footer">
				<nav class="at-links">
					<div class="at-container">
						<div>
							<ul class="pull-right">
								<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=guide">이용안내</a></li>
								<li><a href="<?php echo $at_href['secret'];?>">문의하기</a></li>
								<li><a href="<?php echo $as_href['pc_mobile'];?>"><?php echo (G5_IS_MOBILE) ? 'PC' : '모바일';?>버전</a></li>
							</ul>
						</div>
						<div class="h10"></div>
						<div>
							<ul class="pull-left">
								<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=intro">사이트 소개</a></li> 
								<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=provision">이용약관</a></li> 
								<li><a href="<?php echo G5_BBS_URL;?>/page.php?hid=privacy">개인정보처리방침</a></li>
							</ul>
						</div>
						<div class="clearfix"></div>
					</div>
				</nav>
				<div class="at-infos">
					<div class="at-container">
						<?php if(IS_YC) { // YC5 ?>
							<div class="media">
								<div class="pull-right hidden-xs">
									<!-- 하단 우측 아이콘 -->
								</div>
								<div class="pull-left hidden-xs">
									<!-- 하단 좌측 로고 -->
									<i class="fa fa-leaf"></i>
								</div>
								<div class="media-body">
							
									<ul class="at-about hidden-xs">
										<li><b><?php echo $default['de_admin_company_name']; ?></b></li>
										<li>대표 : <?php echo $default['de_admin_company_owner']; ?></li>
										<li><?php echo $default['de_admin_company_addr']; ?></li>
										<li>전화 : <span><?php echo $default['de_admin_company_tel']; ?></span></li>
										<li>사업자등록번호 : <span><?php echo $default['de_admin_company_saupja_no']; ?></span></li>
										<li><a href="http://www.ftc.go.kr/info/bizinfo/communicationList.jsp" target="_blank">사업자정보확인</a></li>
										<li>통신판매업신고 : <span><?php echo $default['de_admin_tongsin_no']; ?></span></li>
										<li>개인정보관리책임자 : <?php echo $default['de_admin_info_name']; ?></li>
										<li>이메일 : <span><?php echo $default['de_admin_info_email']; ?></span></li>
									</ul>
									
									<div class="clearfix"></div>

									<div class="copyright">
										<strong><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></strong>
										<span>All rights reserved.</span>
									</div>

									<div class="clearfix"></div>
								</div>
							</div>
						<?php } else { // G5 ?>
							<div class="at-copyright">
								<span><?php echo $config['cf_title'];?> <i class="fa fa-copyright"></i></span>
								All rights reserved.
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</footer>
	<?php } ?>
</div><!-- .wrapper -->

<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo THEMA_URL;?>/assets/js/respond.js"></script>
<![endif]-->

<!-- JavaScript -->
<script>
var sub_show = "<?php echo $at_set['subv'];?>";
var sub_hide = "<?php echo $at_set['subh'];?>";
var menu_startAt = "<?php echo ($m_sat) ? $m_sat : 0;?>";
var menu_sub = "<?php echo $m_sub;?>";
var menu_subAt = "<?php echo ($m_subsat) ? $m_subsat : 0;?>";
</script>
<script src="<?php echo THEMA_URL;?>/assets/bs3/js/bootstrap.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/sly.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/swiper.jquery.min.js"></script>
<script src="<?php echo THEMA_URL;?>/assets/js/custom.js"></script>
<script>
window.onload = function() {
  
function setCurrentSlide(ele,index){
	$(".swiper-tab .swiper-slide").removeClass("active");
	ele.addClass("active");
}

var swiper_tab = new Swiper('.swiper-tab', {
	<?php if(!G5_IS_MOBILE) {?>
		slidesPerView: 10,
		spaceBetween: 10,
	<?php } else {?>
		slidesPerView: 5,
		spaceBetween: 0,
	<?php } ?>
	paginationClickable: true,
	freeMode: true,
	loop: false,
	onTab:function(swiper){
	  var n = swiper_tab.clickedIndex;
	  alert(1);
	}
});

swiper_tab.slides.each(function(index,val){
	var ele=$(this);
	ele.on("click",function(){
	  setCurrentSlide(ele,index);
	  swiper_body.slideTo(index, 500, false);
	});
});

var swiper_body = new Swiper ('.swiper-body', {
    direction: 'horizontal',
    loop: false,
    autoHeight: true,
	spaceBetween: 10,
    onSlideChangeEnd: function(swiper){
      var n=swiper.activeIndex;
      setCurrentSlide($(".swiper-tab .swiper-slide").eq(n),n);
      swiper_tab.slideTo(n, 500, false);
    }
  });
}
</script>
<?php if($is_sticky_nav) { ?>
<script src="<?php echo THEMA_URL;?>/assets/js/sticky.js"></script>
<?php } ?>

<?php echo apms_widget('brex-sidebar'); //사이드바 및 모바일 메뉴(UI) ?>

<?php if($is_designer || $is_demo) include_once(THEMA_PATH.'/assets/switcher.php'); //Style Switcher ?>
