<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$date_gap_old = date("Y-m-d", strtotime($date_gap) - ($date_cnt * 86400)); 

$old = array();
$sql2 = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date 
		between '$date_gap_old' and '$date_gap' 
		group by pp_word order 
		by cnt desc, 
		pp_word limit 0, 10 ";  
$qry2 = sql_query($sql2);
$count = sql_num_rows($qry2); 
for ($j=0; $row2=sql_fetch_array($qry2); $j++) {
	$old[$j] = $row2;
}

for ($i=0; $i<$pop_cnt; $i++) {

	for ($j=0; $j<$count; $j++) { 

		if ($old[$j][pp_word] == $list[$i][pp_word]) {
			break;
		}
	}

	$list[$i][pp_word] = urldecode($list[$i][pp_word]);
	$list[$i][pp_rank] = $i + 1;

	if ($count == $j) {
		$list[$i][old_pp_rank] = 0;
		$list[$i][rank_gap] = 0;
	} else {
		$list[$i][old_pp_rank] = $j + 1;
		$list[$i][rank_gap] = $list[$i][old_pp_rank] - $list[$i][pp_rank];
	}

	if ($list[$i][rank_gap] > 0)
		$list[$i][icon] = "up";
	else if ($list[$i][rank_gap] < 0)
		$list[$i][icon] = "down";
	else if ($list[$i][old_pp_rank] == 0)
		$list[$i][icon] = "new";
	else if ($list[$i][rank_gap] == 0)
		$list[$i][icon] = "nogap";
}

?>
<style>
#scroll-layer { position:absolute; top:3px; right: 0px; overflow:hidden; background:#fff; width:220px; z-index:2000; }
<?php if($stx) {?>
	#scroll-layer:hover { border:1px solid #cdcdcd; top:0px; }
<?php } else {?>
	#scroll-layer:hover { border:1px solid #cdcdcd; top:-1px; }
<?php } ?>
#scroll-layer ul,
#scroll-layer li { margin:0; padding:0; list-style:none; text-align:left; font-size:14px; height:39px; line-height:39px; }
#scroll-layer li a:hover { color:#000; text-decoration:underline; }

#popular-scroll li > div .gap { color:#444; font-size:14px; letter-spacing:-1px; padding-right:5px;  }
#popular-hidden { padding-bottom:5px;}
#popular-hidden li { height:25px; line-height:25px; }
#popular-hidden .popular-tit { height:35px; line-height:35px; color:#000; text-decoration:none; }
.rank-text { color:#df405a; font-size:14px; font-weight:bold; }
.box-big { height:300px; padding:0px 15px; }
.box-small { height:34px; }

</style>

<div id="scroll-layer" class="scroll-layer box-small">
  <ul id="popular-scroll" class="show">
    <?php
		for ($i=0; $i<$pop_cnt; $i++) {

    	if (!is_array($list[$i])) continue;
    ?>
    <li class="ellipsis">
    <div class="pull-right">
      <img src="<?php echo $popular_skin_url;?>/img/<?php echo $list[$i][icon];?>.gif" align=absmiddle>
      <span class="gap"><? if ($list[$i][icon] != "new" && $list[$i][icon] != "nogap") { echo abs($list[$i][rank_gap]); }?></span>
    </div>
    <span class="rank-text"><?php echo $i+1; ?></span>
    <a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>"><?php echo $list[$i][pp_word];?></a>
    </li> 
    <?
    }
    ?>
  </ul>
  <ul id="popular-hidden" class="hide">
    <li class="ellipsis popular-tit"><b>실시간 급상승</b></li>
    <?php
		for ($i=0; $i<$pop_cnt; $i++) {
    
    	if (!is_array($list[$i])) continue;
    ?>
    <li class="ellipsis">
    <div class="pull-right">
      <img src="<?php echo $popular_skin_url;?>/img/<?php echo $list[$i]['icon']?>.gif" align="absmiddle">
      <span class="gap"><?php if($list[$i][icon] != "new" && $list[$i]['icon'] != "nogap") { echo abs($list[$i]['rank_gap']); } ?></span>
    </div>
    <span class="rank-text"><?php echo $i+1; ?></span>
    <a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>"><?php echo $list[$i]['pp_word'];?></a>
    </li>
    <?
    }
    ?>
  </ul>
</div>

<script language="javascript">
$(function() {

	$("#scroll-layer").hover(

	// 마우스 오버시
	function(){
	$("#scroll-layer").removeClass('box-small');
	$("#scroll-layer").addClass('box-big');

	$("#popular-scroll").removeClass('show');
	$("#popular-scroll").addClass('hide');
	$("#popular-hidden").addClass('show');
	}
	,
	// 마우스 아웃시
	function(){
	$("#scroll-layer").removeClass('box-big');
	$("#scroll-layer").addClass('box-small');

	$("#popular-hidden").removeClass('show');
	$("#popular-hidden").addClass('hide');
	$("#popular-scroll").addClass('show');
	})

	var ticker = function() {
	setTimeout(function(){
	$('#popular-scroll li:first').animate( {marginTop: '-35px'}, 500, function()
	{
	$(this).detach().appendTo('ul#popular-scroll').removeAttr('style');
	});
	ticker();
	}, 3000);
	};
	ticker();

});
</script>
