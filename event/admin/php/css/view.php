<?include "./../header.php";?>

<?
	$query="SELECT * FROM css_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>
<script>
jQuery(function($) {
	$('.colorpick').colpick({
		colorScheme:'dark',
		layout:'rgbhex',
		color:'ff8800',
		onBeforeShow: function(){
			$(this).colpickSetColor(this.value);
		},
		onSubmit:function(hsb,hex,rgb,el) {
			$(el).colpickHide();
		},
		onChange:function(hsb,hex,rgb,el,bySetColor) {
			//$(el).css('border-color','#'+hex);
			// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
			if(!bySetColor) $(el).val(hex);
		}
	}).keyup(function(){
		$(this).colpickSetColor(this.value);
	});
});
</script>
<div id="container">
	
	<h2>행사명</h2>

	<div class="contents">

		<h4 class="subTit" class="tooltipPoint" title="셋팅 시 기본CSS 값으로 적용됨 / 각 메뉴 버튼, 폰트사이즈,컬러등 CSS요소를 변경 할 수 있습니다.">CSS 설정</h4>
		<p>Agenda, Feedback 등의  컬러를 설정 할 수 있습니다.</p>

		<form id="" name="" action="./post.php" method="post">
		<input type="hidden" name="code" id="code" value="<?=$code?>" />
			<fieldset>
				<legend>CSS 설정</legend>

				<h4 class="subTitBl">메뉴 설정 <a href="#" class="viewInfo viewInfo"><img src="/admin/image/icon_viewInfo.png" alt="설명보기"></a></h4>
				<table class="inputTbl">
					<colgroup>
						<col style="width: 25%;">
						<col style="width: 75%;">
					</colgroup>
					<tbody>
						<tr>
							<th  class="tooltipPoint" title="상단 메뉴탭 (선택 전) 컬러를 수정 할 수있습니다. / bg color / font-color 수정 가능">메뉴 탭 (기본)</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" class="colorpick" value="<?=$d['menu_bg']?>" name="menu_bg"></span>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" class="colorpick" value="<?=$d['menu_font']?>" name="menu_font"></span>
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="상단 메뉴 탭 (선택 후 on상태) 컬러를 수정 할 수 있습니다. / bg color / font-color 수정 가능">메뉴 탭 (선택)</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['menu_bg_on']?>" name="menu_bg_on"></span>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['menu_font_on']?>" name="menu_font_on"></span>
							</td>
						</tr>
					</tbody>
				</table>
				<h4 class="subTitBl">Agenda 설정 <a href="#" class="viewInfo"><img src="/admin/image/icon_viewInfo.png" alt="설명보기"></a></h4>
				<table class="inputTbl">
					<colgroup>
						<col style="width: 25%;">
						<col style="width: 25%;">
						<col style="width: 25%;">
						<col style="width: 25%;">
					</colgroup>
					<tbody>
						<tr>
							<th></th>
							<th>1일</th>
							<th>2일</th>
							<th>3일</th>
						</tr>
						<tr>
							<th class="tooltipPoint" title="Agenda 메뉴 탭 (선택 전) 컬러를 수정 할 수 있습니다. / bg color / font-color 수정 가능">Day 탭 (기본)</th>
							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg1']?>" name="agenda_bg1" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font1']?>" name="agenda_font1" style="width:110px;">
							</td>

							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg2']?>" name="agenda_bg2" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font2']?>" name="agenda_font2" style="width:110px;">
							</td>

							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg3']?>" name="agenda_bg3" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font3']?>" name="agenda_font3" style="width:110px;">
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="Agenda 메뉴 탭 (선택 후 on상태) 컬러를 수정 할 수 있습니다. / bg color / font-color 수정 가능">Day 탭 (선택)</th>
							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg1_on']?>" name="agenda_bg1_on" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font1_on']?>" name="agenda_font1_on" style="width:110px;">
							</td>

							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg2_on']?>" name="agenda_bg2_on" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font2_on']?>" name="agenda_font2_on" style="width:110px;">
							</td>

							<td class="multi">
								<input type="text" placeholder="Bg color" value="<?=$d['agenda_bg3_on']?>" name="agenda_bg3_on" style="width:110px;">

								<input type="text" placeholder="Font color" value="<?=$d['agenda_font3_on']?>" name="agenda_font3_on" style="width:110px;">
							</td>
						</tr>
					</tbody>
				</table>

				<h4 class="subTitBl">Question 설정 <a href="#" class="viewInfo"><img src="/admin/image/icon_viewInfo.png" alt="설명보기"></a></h4>
				<table class="inputTbl">
					<colgroup>
						<col style="width: 25%;">
						<col style="width: 75%;">
					</colgroup>
					<tbody>
						<tr>
							<th class="tooltipPoint" title="">타이틀</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['question_bg']?>" name="question_bg" class="colorpick"></span>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['question_font']?>" name="question_font"></span>
							</td>
						</tr>
						
					</tbody>
				</table>

				<h4 class="subTitBl">Feedback 설정 <a href="#" class="viewInfo"><img src="/admin/image/icon_viewInfo.png" alt="설명보기"></a></h4>
				<table class="inputTbl">
					<colgroup>
						<col style="width: 25%;">
						<col style="width: 75%;">
					</colgroup>
					<tbody>
						<tr>
							<th class="tooltipPoint" title="피드백 질문번호 bg컬러 설정">질문번호</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['feedback_bg_bold']?>" name="feedback_bg_bold"></span>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['feedback_font_bold']?>" name="feedback_font_bold"></span>
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="피드백 질문 타이틀 bg컬러 설정">질문타이틀</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['feedback_bg']?>" name="feedback_bg"></span>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['feedback_font']?>" name="feedback_font"></span>
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="피드백 체크박스 bg컬러 설정">체크박스</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['feedback_btn']?>" name="feedback_btn"></span>
								
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['feedback_btn_font']?>" name="feedback_btn_font"></span>
								
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="피드백 text font color 설정">텍스트</th>
							<td class="multi">
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['feedback_font2']?>" name="feedback_font2"></span>
							</td>
						</tr>
						<tr>
							<th class="tooltipPoint" title="피드백 send bod bg컬러 설정 /  해당 버튼 텍스트는 session_set_tbl > feedback_send 필드에서 수정 가능">Send Box</th>
							<td class="multi">
								<span class="color"><span>Send Box</span><input type="text" placeholder="Send Box" value="<?=$d['feedback_send']?>" name="feedback_send"></span>

								<span class="color"><span>Send Border</span><input type="text" placeholder="Send Border" value="<?=$d['feedback_send_border']?>" name="feedback_send_border"></span>
							</td>
						</tr>
					</tbody>
				</table>

				<h4 class="subTitBl">Session 설정 <a href="#" class="viewInfo"><img src="/admin/image/icon_viewInfo.png" alt="설명보기"></a></h4>
				<table class="inputTbl">
					<colgroup>
						<col style="width: 20%;">
						<col style="width: 80%;">
					</colgroup>
					<tbody>
						<tr>
							<th class="tooltipPoint" title="각 메뉴 타이틀(back버튼 있는부분) bg/font color 설정 가능 / 각 메뉴 타이틀 텍스트는 session_set_tbl 에서 설정 가능">상단영역<br/>메뉴 타이틀 부분</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_topmenu_bg']?>" name="session_topmenu_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['session_topmenu_font']?>" name="session_topmenu_font"></span>
							</li>
							
							</td>
							
						</tr>


						<tr>
							<th class="tooltipPoint" title="카테고리,Abs No, Abs sid 폰트 컬러 설정 / " >카테고리</th>
							<td class="multi">
							<li>
								<span>Category color</span><br>
								<span class="color"><span>Category color</span><input type="text" placeholder="Category color" value="<?=$d['session_category_font']?>" name="session_category_font"></span>
							</li>
							<li>
								<span>Abs No color</span><br>
								<span class="color"><span>abs color</span><input type="text" placeholder="Abs No color" value="<?=$d['abs_no_font']?>" name="abs_no_font"></span>
							</li>
							<li>
								<span>Abs Sid color</span><br>
								<span class="color"><span>abs color</span><input type="text" placeholder="Abs Sid color" value="<?=$d['abs_sid_font']?>" name="abs_sid_font"></span>
							</li>
							</td>
							
						</tr>

						<tr>
							<th  class="tooltipPoint" title="세션타이틀,세션 서브타이틀, glance 타이틀 컬러, glance 폰트사이즈 설정" >세션,glance 타이틀</th>
							<td class="multi">
							<li>
								<span>Session Font color</span><br>
								<span class="color"><span>Session Font color</span><input type="text" placeholder="Session Font color" value="<?=$d['session_theme_font']?>" name="session_theme_font"></span>
							</li>
							<li>
								<span>Sub Font color</span><br>
								<span class="color"><span>Sub Font color</span><input type="text" placeholder="Sub Font color" value="<?=$d['session_title_font']?>" name="session_title_font"></span>
							</li>
							<li>
								<span>Glance Font color</span><br>
								<span class="color"><span>glance Font color</span><input type="text" placeholder="Glance Font color" value="<?=$d['glance_theme_font']?>" name="glance_theme_font"></span>
							</li>
							<li>
								<span>Glance Font Size</span><br>
								<span class="color"><span>glance Font Size</span><input type="text" placeholder="Session Font Size" value="<?=$d['glance_theme_font_size']?>" name="glance_theme_font_size"></span>

							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="Chair,Speaker 폰트 컬러 설정" >좌장,연자</th>
							<td class="multi">
							<li>
								<span>Chair Font color</span><br>
								<span class="color"><span>chair Font color</span><input type="text" placeholder="Chair Font color" value="<?=$d['session_chair_font']?>" name="session_chair_font"></span>
							</li>
							<li>
								<span>Speaker Font color</span><br>
								<span class="color"><span>speaker Font color</span><input type="text" placeholder="Speaker Font color" value="<?=$d['session_speaker_font']?>" name="session_speaker_font"></span>
							</td>
							</li>
						</tr>
						<tr>
							<th  class="tooltipPoint" title="프로그램 list/ view페이지에 보여지는 각 아이콘&버튼 컬러 설정" >메뉴 아이콘</th>
							<td class="multi">
							<li>
								<span>favor color</span><br>
								<span class="color"><span>favor color</span><input type="text" placeholder="favor color" value="<?=$d['session_favor']?>" name="session_favor"></span>
							</li>
							<li>
								<span>Lecture color</span><br>
								<span class="color"><span>Lecture color</span><input type="text" placeholder="Lecture color" value="<?=$d['session_lecture']?>" name="session_lecture"></span>
							</li>
							<li>
								<span>Abstract color</span><br>
								<span class="color"><span>Abstract color</span><input type="text" placeholder="Abstract color" value="<?=$d['session_abstract']?>" name="session_abstract"></span>
							</li>
							<li>
								<span>CV color</span><br>
								<span class="color"><span>CV color</span><input type="text" placeholder="CV color" value="<?=$d['session_cv']?>" name="session_cv"></span>
							</li>
							<li>
								<span>Memo color</span><br>
								<span class="color"><span>Memo color</span><input type="text" placeholder="memo color" value="<?=$d['session_memo']?>" name="session_memo"></span>
							</li>

							<li>
								<span>evaluation color</span><br>
								<span class="color"><span>evaluation color</span><input type="text" placeholder="evaluation color" value="<?=$d['session_evaluation']?>" name="session_evaluation"></span>
							</li>

							<li>
								<span>Q&A color</span><br>
								<span class="color"><span>Q&A color</span><input type="text" placeholder="question color" value="<?=$d['session_question']?>" name="session_question"></span>
							</li>

							</td>
						</tr>
						<tr>
							<th  class="tooltipPoint" title="프로그램 시간영역 설정 /세션 >  setting > 프로그램 시간 표시타입 Type 1 선택 할 경우 설정" >프로그램 시간 표시 영역<br/> (프로그램 시간 표시타입 1)</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_bar_bg']?>" name="session_bar_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="text color" value="<?=$d['session_bar_font']?>" name="session_bar_font"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="프로그램 > select box 컬러 설정" >프로그램 <br/>Select Box</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_select_bg']?>" name="session_select_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['session_select_font']?>" name="session_select_font"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="세션 > setting > 날짜타입 > 달력UI 일 경우 설정" >날짜 On bg컬러<br/> (달력UI 일 경우 사용)</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_day_bg']?>" name="session_day_bg"></span>
							</td>
						</tr>


						<tr>
							<th  class="tooltipPoint" title="세션 Sub (눌렀을때)bg 컬러 설정 / 서브세션 구분줄때 사용" >세션 SUB 배경</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_sub_bg']?>" name="session_sub_bg"></span>
							</td>
						</tr>


						<tr>
							<th  class="tooltipPoint" title="검색영역 bg/font color 설정" >검색영역</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_search_bg']?>" name="session_search_bg"></span>

								<span class="color"><span>font color</span><input type="text" placeholder="font color" value="<?=$d['session_search_font']?>" name="session_search_font"></span>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="세션 > setting > 하단 메뉴 사용할 경우 설정" >프로그램 <br/>하단 메뉴</th>
							<td class="multi">
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['session_bottom_menu_bg']?>" name="session_bottom_menu_bg"></span>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="세션 > setting > eng/kor세션 사용일 경우 / 프로그램,glance/ eng,kor 세션 아이콘 표시 /radius : 아이콘 동그랗게 하는것/ " >프로그램/glance <br/>eng/kor세션 아이콘</th>
							<td class="multi">
							<li>
							<span>radius</span><br>
								<span class="color"><span>radius</span><input type="text" placeholder="radius size" value="<?=$d['session_category_radius']?>" name="session_category_radius"></span>
								</li>
							<li>
							<span>Kor</span><br>
								<span class="color"><span>Kor</span><input type="text" placeholder="Kor bg color" value="<?=$d['session_bullet_kor']?>" name="session_bullet_kor"></span>
								</li>
							<li>
							<span>Eng</span><br>
								<span class="color"><span>Eng</span><input type="text" placeholder="Eng bg color" value="<?=$d['session_bullet_eng']?>" name="session_bullet_eng"></span>
								<li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="glance 룸/시간 영역 font,bg color, font size 설정" >룸 / 시간 (At a glance)</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['glance_top_bg']?>" name="glance_top_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['glance_top_font']?>" name="glance_top_font"></span>
							</li>
							<li>
								<span>Font Size</span><br>
								<span class="color"><span>Font Size</span><input type="text" placeholder="Font Size" value="<?=$d['glance_top_font_size']?>" name="glance_top_font_size"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="세션서브 bg,font color 변경 / 세션 > sub > 설정 > Sub_Session > Type 1, 2 / bg,font color 설정" >Sub_Session</th>
							<td class="multi">
							
							<li>
								<span>sub1_bg_color</span><br>
								<span class="color"><span>sub1_bg_color</span><input type="text" placeholder="sub1_bg_color" value="<?=$d['session_sub_session1_bg']?>" name="session_sub_session1_bg"></span>
							</li>
							<li>
								<span>sub1_font_color</span><br>
								<span class="color"><span>sub1_font_color</span><input type="text" placeholder="sub1_font_color" value="<?=$d['session_sub_session1_font']?>" name="session_sub_session1_font"></span>
							<li>

							<li>
								<span>sub2_bg_color</span><br>
								<span class="color"><span>sub2_bg_color</span><input type="text" placeholder="sub2_bg_color" value="<?=$d['session_sub_session2_bg']?>" name="session_sub_session2_bg"></span>
							</li>
							<li>
								<span>sub2_font_color</span><br>
								<span class="color"><span>sub2_font_color</span><input type="text" placeholder="sub2_font_color" value="<?=$d['session_sub_session2_font']?>" name="session_sub_session2_font"></span>
							<li>

							</td>
						</tr>
						<tr>
							<th  class="tooltipPoint" title="룸 합칠 경우 glance에 Room: 룸이름 표시되는 부분 font color 및 size 설정" >glance Room<br/>(룸 합칠 경우 표시)</th>
							<td class="multi">
							
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['glance_room_font']?>" name="glance_room_font"></span>
							</li>
							<li>
								<span>Font Size</span><br>
								<span class="color"><span>Font Size</span><input type="text" placeholder="Font Size" value="<?=$d['glance_room_font_size']?>" name="glance_room_font_size"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="booth ui type2일 경우 부스번호 bg컬러 설정" >Booth 번호 색상</th>
							<td class="multi">
							
							<li>
								<span>type1</span><br>
								<span class="color"><span>type1</span><input type="text" placeholder="type1" value="<?=$d['booth_num_type1']?>" name="booth_num_type1"></span>
							</li>
							<li>
								<span>type2</span><br>
								<span class="color"><span>type2</span><input type="text" placeholder="type2" value="<?=$d['booth_num_type2']?>" name="booth_num_type2"></span>
							</li>
							<li>
								<span>type3</span><br>
								<span class="color"><span>type3</span><input type="text" placeholder="type3" value="<?=$d['booth_num_type3']?>" name="booth_num_type3"></span>
							</li>
							<li>
								<span>type4</span><br>
								<span class="color"><span>type4</span><input type="text" placeholder="type4" value="<?=$d['booth_num_type4']?>" name="booth_num_type4"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="" >Facutly 상세페이지</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['facutly_top_bg']?>" name="facutly_top_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['facutly_top_font']?>" name="facutly_top_font"></span>
							</li>
							</td>
						</tr>

						<tr>
							<th  class="tooltipPoint" title="" >Facutly list 페이지 <Br/> Group</th>
							<td class="multi">
							<li>
								<span>Bg color</span><br>
								<span class="color"><span>Bg color</span><input type="text" placeholder="Bg color" value="<?=$d['facutly_list_group_bg']?>" name="facutly_list_group_bg"></span>
							</li>
							<li>
								<span>Font color</span><br>
								<span class="color"><span>Font color</span><input type="text" placeholder="Font color" value="<?=$d['facutly_list_group_font']?>" name="facutly_list_group_font"></span>
							</li>
							</td>
						</tr>




					</tbody>
				</table>
				<div class="btnArea btn">
				<input type="submit" value="저장" class="btnDef btnBig" />
				</div>
			</fieldset>
		</form>

	</div>

</div>

  <script type="text/javascript">

function color_change(val) {
	alert(val);
	//window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}


</script>
<?include "./../footer.php";?>