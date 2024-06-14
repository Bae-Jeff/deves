<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

// 버튼컬러
$btn_login = (isset($wset['login']) && $wset['login']) ? $wset['login'] : 'color';
$btn_logout = (isset($wset['logout']) && $wset['logout']) ? $wset['logout'] : 'color';

//필요한 전역변수 선언
global $member, $is_member, $at_href, $urlencode;

//add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);

?>
<style>
<?php if($is_member) {?>
	.brex-outlogin { padding:15px; border-bottom:0px; }
<?php } else {?>
	.brex-outlogin { padding:15px; }
<?php } ?>
</style>
<div class="brex-outlogin">
	<?php if($is_member) { //Login ?>
		<div class="pull-right">
			<a href="<?php echo $at_href['logout'];?>">
				<span class="text-muted" style="background:#fff; padding:2px; border:1px solid #ccc;">로그아웃</span>
			</a>
		</div>
		<div class="profile">
			<!--a href="<?php echo $at_href['myphoto'];?>" target="_blank" class="win_memo" title="사진등록">
				<div class="photo pull-left">
					<img src="<?php echo ($member['photo']) ? $member['photo'] : $widget_url.'/img/photo.png';?>">
				</div>
			</a-->
			<span><b><?php echo $member['mb_nick'];?></b> 님</span>
			<span class="font-12 text-muted" style="letter-spacing:-1px;">
				<?php echo $member['grade'];?>
				<?php if($member['partner']) { ?>
					<span class="lightgray">&nbsp;|&nbsp;</span>
					<a href="<?php echo $at_href['myshop'];?>"><span class="text-muted">마이샵</span></a>
				<?php } ?>
				<?php if($member['admin']) { ?>
					<span class="lightgray">&nbsp;|&nbsp;</span>
					<a href="<?php echo G5_ADMIN_URL;?>"><span class="text-muted">관리</span></a>
				<?php } else {?>
					<span class="lightgray">&nbsp;|&nbsp;</span>
					<a href="<?php echo $at_href['edit'];?>">
					<span class="text-muted"><i class="fa fa-cog"></i></span>
					</a>
				<?php } ?>
			</span>
			<div class="clearfix"></div>
		</div>

		<div class="at-tip" data-original-title="<?php echo number_format($member['exp_up']);?>점 추가획득시 레벨업합니다." data-toggle="tooltip" data-placement="top" data-html="true" style="float:left; width:50%; margin:5px 0px;">
			<div class="div-progress progress progress-striped" style="margin:0px; height:20px !important; border:1px solid #eee !important; -webkit-box-shadow:0 !important;">
				<div class="progress-bar progress-bar-exp" role="progressbar" aria-valuenow="<?php echo round($member['exp_per']);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo round($member['exp_per']);?>%; background:#333333 !important;">
					<span class="sr-only" style="height:18px !important; line-height:18px !important; margin-left:5px !important; color:#fff !important;">
						Lv.<?php echo $member['level'];?>
					</span>
				</div>
			</div>
			<div class="sr-score pull-right" style="color:#fff; margin-top:-28px;"><?php echo number_format($member['exp']);?> (<?php echo $member['exp_per'];?>%)</div>
		</div>
		<div style="float:left; width:50%; font-size:13px; text-align:center; padding:3px;">
			<a href="<?php echo $at_href['point'];?>" target="_blank" class="win_point">
				 <?php echo AS_MP;?> <b class="red"><?php echo number_format($member['mb_point']);?></b>
			</a>
		</div>

		<div class="clearfix"></div>

		<div class="login-line" style="text-align:center; padding:0px;">
				<div class="login-menu" style="position:relative;" id="alarm">
				<span>알림</span>
					<div class="alarm-icon"<?php echo ($member['response']) ? '' : ' style="display:none;"';?>>
						<span class="addLabel">
							<b class="addCount"><?php echo $member['response'];?></b>
						</span>
						<div class="alarm-icon-tri tri">
							
						</div>
					</div>
				</div>
				<div class="login-menu" id="memo" style="position:relative;">
				<a href="<?php echo $at_href['memo'];?>" target="_blank" class="win_memo">
					<span>쪽지</span>
					<div class="memo-icon"<?php echo ($member['memo']) ? '' : ' style="display:none;"';?>>
						<span>
							<b>N</b>
						</span>
						<div class="memo-icon-tri tri">
							
						</div>
					</div>
				</a>
				</div>
				<!--<?php if(IS_YC) { //쿠폰 ?>
					<span class="lightgray">&nbsp;|&nbsp;</span>
					<a href="<?php echo $at_href['coupon'];?>" target="_blank" class="win_point">
						쿠폰<?php if ($member['as_coupon']) { ?> <span class="orangered"><?php echo number_format($member['as_coupon']);?></span><?php } ?>
					</a>		
				<?php } ?>-->
				<div class="login-menu" id="scrap">
				<a href="<?php echo $at_href['scrap'];?>" target="_blank" class="win_scrap">
					<span>스크랩</span>
				</a>
				</div>
				<div class="login-menu" style="border-right:0;" id="user">
				<a href="javascript:;" onclick="sidebar_open('sidebar-user');">
					<span>내정보</span>
				</a>
				</div>

			<div class="clearfix"></div>
		</div>

	<?php } else { //Logout ?>

		<form id="basic_outlogin" name="basic_outlogin" method="post" action="<?php echo $at_href['login_check'];?>" autocomplete="off" role="form" class="form" onsubmit="return basic_outlogin_form(this);">
		<input type="hidden" name="url" value="<?php echo $urlencode; ?>">

		<div style="">
		<div class="small-input" style="float:left; width:70%;">
			<div class="form-group">
				<input type="text" name="mb_id" id="mb_id" class="form-control input-sm" placeholder="아이디" tabindex="21">
			</div>
			<div class="form-group">
				<input type="password" name="mb_password" id="mb_password" class="form-control input-sm" placeholder="비밀번호" tabindex="22">
			</div>
		</div>
		<div style="float:left; width:30%; padding-left:0px;">
			<div class="form-group">
				<button type="submit" class="btn btn-brex-2nd btn-block en" style="height:70px;" tabindex="23">
					로그인
				</button>    
			</div>
		</div>
		</div>

		<div style="position:absolute; width:100%; padding:0 15px; left:0; bottom:0;">
			<div style="letter-spacing:-1px;">
				<div class="pull-left text-muted hidden-xs">
					<label><input type="checkbox" name="auto_login" value="1" id="remember_me" class="remember-me"> <label style="margin-top:5px;">자동로그인</label></label>
				</div>
				<div class="pull-right text-muted">
					<a href="<?php echo $at_href['reg'];?>"><span class="text-muted">회원가입</span></a>
					<span>&nbsp;&nbsp;</span>
					<a href="<?php echo $at_href['lost'];?>" class="win_password_lost"><span class="text-muted">정보찾기</span></a>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		</form>
		<script>
		function basic_outlogin_form(f) {
			if (f.mb_id.value == '') {
				alert('아이디를 입력해 주세요.');
				f.mb_id.focus();
				return false;
			}
			if (f.mb_password.value == '') {
				alert('비밀번호를 입력해 주세요.');
				f.mb_password.focus();
				return false;
			}
			return true;
		}
		</script>
	<?php } //End ?>
</div>