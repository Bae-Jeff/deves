<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
	<colgroup>
		<col class="grid_1">
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col" colspan="2">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center" rowspan="2">공통</td>
		<td align="center">주소</td>
		<td>
			<input type="text" name="wset[href]" value="<?php echo $wset['href']; ?>" class="frm_input" size="20">
		</td>
	</tr>
	<tr>
		<td align="center">이미지</td>
		<td>
			<input type="text" name="wset[img]" value="<?php echo $wset['img'];?>" id="img" size="36" class="frm_input"> 
				<a href="<?php echo G5_BBS_URL;?>/widget.image.php?fid=img" class="btn_frmline win_scrap">이미지선택</a>
		</td>
	</tr>
	</tbody>
	</table>
</div>