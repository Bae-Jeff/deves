<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// input의 name을 wset[배열키] 형태로 등록
// 모바일 설정값은 동일 배열키에 배열변수만 wmset으로 지정 → wmset[배열키]

if(!$wset['new']) $wset['new'] = 'red';
if(!$wset['pbg']) $wset['pbg'] = 'navy';

?>

<div class="tbl_head01 tbl_wrap">
	<table>
	<caption>위젯설정</caption>
	<colgroup>
		<col class="grid_2">
		<col>
	</colgroup>
	<thead>
	<tr>
		<th scope="col">구분</th>
		<th scope="col">설정</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td align="center">스타일</td>
		<td>
			<select name="wset[more]">
				<option value="1"<?php echo get_selected('1', $wset['more']);?>>더보기형</option>
				<option value="2"<?php echo get_selected('2', $wset['more']);?>>무한스크롤</option>
				<option value="3"<?php echo get_selected('3', $wset['more']);?>>일반형</option>
			</select>
			&nbsp;
			더보기 버튼
			<select name="wset[moreb]">
				<?php echo apms_color_options($wset['moreb']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">썸네일</td>
		<td>
			<?php echo help('기본 400x500 - 미입력시 기본값 적용');?>
			<input type="text" name="wset[thumb_w]" value="<?php echo ($wset['thumb_w']);?>" size="4" class="frm_input">
			x
			<input type="text" name="wset[thumb_h]" value="<?php echo ($wset['thumb_h']);?>" size="4" class="frm_input">
			px
			&nbsp;
			<select name="wset[shadow]">
				<?php echo apms_shadow_options($wset['shadow']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">목록수</td>
		<td>
			<input type="text" name="wset[rows]" value="<?php echo $wset['rows']; ?>" class="frm_input" size="4"> 개 - PC
			&nbsp;
			<input type="text" name="wmset[rows]" value="<?php echo $wmset['rows']; ?>" class="frm_input" size="4"> 개 - 모바일
			&nbsp;
			<input type="text" name="wset[page]" value="<?php echo $wset['page'];?>" size="4" class="frm_input"> 페이지
		</td>
	</tr>
	<tr>
		<td align="center">반응형</td>
		<td>
			<table>
			<thead>
			<tr>
				<th scope="col">구분</th>
				<th scope="col">기본</th>
				<th scope="col">lg(1199px~)</th>
				<th scope="col">md(991px~)</th>
				<th scope="col">sm(767px~)</th>
				<th scope="col">xs(480px~)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td align="center">가로갯수(개)</td>
				<td align="center">
					<input type="text" name="wset[item]" value="<?php echo $wset['item']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lg]" value="<?php echo $wset['lg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[md]" value="<?php echo $wset['md']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[sm]" value="<?php echo $wset['sm']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xs]" value="<?php echo $wset['xs']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			<tr>
				<td align="center">좌우간격(px)</td>
				<td align="center">
					<input type="text" name="wset[gap]" value="<?php echo $wset['gap']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lgg]" value="<?php echo $wset['lgg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[mdg]" value="<?php echo $wset['mdg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[smg]" value="<?php echo $wset['smg']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xsg]" value="<?php echo $wset['xsg']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			<tr>
				<td align="center">상하간격(px)</td>
				<td align="center">
					<input type="text" name="wset[gapb]" value="<?php echo $wset['gapb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[lgb]" value="<?php echo $wset['lgb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[mdb]" value="<?php echo $wset['mdb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[smb]" value="<?php echo $wset['smb']; ?>" class="frm_input" size="4">
				</td>
				<td align="center">
					<input type="text" name="wset[xsb]" value="<?php echo $wset['xsb']; ?>" class="frm_input" size="4">
				</td>
			</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">출력설정</td>
		<td>
			적립 <select name="wset[pbg]">
				<?php echo apms_color_options($wset['pbg']);?>
			</select>
			&nbsp;
			별점 <select name="wset[star]">
				<option value="1">출력안함</option>
				<?php echo apms_color_options($wset['star']);?>
			</select>
			&nbsp;
			컨텐츠 <input type="text" name="wset[line]" value="<?php echo $wset['line']; ?>" class="frm_input" size="4"> 줄 출력(기본 3)
		</td>
	</tr>
	<tr>
		<td align="center">숨김항목</td>
		<td>
			<label><input type="checkbox" name="wset[buy]" value="1"<?php echo ($wset['buy']) ? ' checked' : '';?>> 구매수</label>
			&nbsp;
			<label><input type="checkbox" name="wset[cmt]" value="1"<?php echo ($wset['cmt']) ? ' checked' : '';?>> 댓글수</label>
			&nbsp;
			<label><input type="checkbox" name="wset[good]" value="1"<?php echo ($wset['good']) ? ' checked' : '';?>> 추천수</label>
		</td>
	</tr>
	<tr>
		<td align="center">보임항목</td>
		<td>
			<label><input type="checkbox" name="wset[use]" value="1"<?php echo ($wset['use']) ? ' checked' : '';?>> 후기수</label>
			&nbsp;
			<label><input type="checkbox" name="wset[qa]" value="1"<?php echo ($wset['qa']) ? ' checked' : '';?>> 문의수</label>
			&nbsp;
			<label><input type="checkbox" name="wset[hit]" value="1"<?php echo ($wset['hit']) ? ' checked' : '';?>> 조회수</label>
		</td>
	</tr>
	<tr>
		<td align="center">추출유형</td>
		<td>
			<?php echo apms_item_type_checkbox($wset);?>
		</td>
	</tr>
	<tr>
		<td align="center">분류지정</td>
		<td>
			<input type="text" name="wset[ca_id]" value="<?php echo $wset['ca_id']; ?>" size="20" class="frm_input">
			(분류는 1개만 지정가능, 분류코드 입력)
		</td>
	</tr>
	<tr>
		<td align="center">제외분류</td>
		<td>
			<input type="text" name="wset[ex_ca]" value="<?php echo $wset['ex_ca']; ?>" size="20" class="frm_input">
			(제외분류는 1개만 지정가능, 분류코드 입력)
		</td>
	</tr>
	<tr>
		<td align="center">새아이템</td>
		<td>
			<input type="text" name="wset[newtime]" value="<?php echo ($wset['newtime']);?>" size="4" class="frm_input"> 시간 이내 등록 아이템
			&nbsp;
			색상
			<select name="wset[new]">
				<?php echo apms_color_options($wset['new']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">정렬설정</td>
		<td>
			<select name="wset[sort]">
				<?php echo apms_item_rank_options($wset['sort']);?>
			</select>
			&nbsp;
			랭크표시
			<select name="wset[rank]">
				<option value=""<?php echo get_selected('', $wset['rank']); ?>>표시안함</option>
				<?php echo apms_color_options($wset['rank']);?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="center">기간설정</td>
		<td>
			<select name="wset[term]">
				<?php echo apms_term_options($wset['term']);?>
			</select>
			&nbsp;
			<input type="text" name="wset[dayterm]" value="<?php echo $wset['dayterm'];?>" size="4" class="frm_input"> 일전까지 자료(일자지정 설정시 적용)
		</td>
	</tr>
	<tr>
		<td align="center">파트너지정</td>
		<td>
			<?php echo help('파트너아이디를 콤마(,)로 구분해서 복수 등록 가능');?>
			<input type="text" name="wset[pt_list]" value="<?php echo $wset['pt_list']; ?>" size="46" class="frm_input">
			&nbsp;
			<label><input type="checkbox" name="wset[ex_pt]" value="1"<?php echo ($wset['ex_pt']) ? ' checked' : '';?>> 제외하기</label>
		</td>
	</tr>
	<tr>
		<td align="center">캐시사용</td>
		<td>
			<input type="text" name="wset[cache]" value="<?php echo $wset['cache']; ?>" class="frm_input" size="4"> 초 간격으로 캐싱
		</td>
	</tr>
	</tbody>
	</table>
</div>