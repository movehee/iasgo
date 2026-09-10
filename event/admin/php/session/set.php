 <?include "./../header2.php";

	$query="SELECT * FROM session_set_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Setting</h2>
			<div style="clear: both;margin: 10px 0;float: left;">타이틀 부분에 마우스를 올리면 기능 설명이 보여집니다.</div>
			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./set_post.php" method="post"> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:800px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 10%;" />
								<col style="width: 30%;" />
								<col style="width: 10%;" />
							</colgroup>
							<tbody>

								<tr>
									<th><label class="tooltipPoint" for="" title="session 페이지 처음에 나오는 소스 / ex) 상단 룸표시, 장소표시 등 직접 html코딩 가능 / ex) 방 하나에서 하는 행사일 경우 룸 표시를 N으로 변경 후 해당 룸 정보 표시 / 심초음파 38회 워크샵 참조 /">프로그램 상단<br/>(직접소스코딩) </label></th>
									<td colspan='4'><!-- <input style="width:600px; height:150px;" type="text" name="session_top_txt" id="session_top_txt"  value="<?=$d['session_top_txt']?>" /> -->
									<textarea name="session_top_txt" id="session_top_txt" style="font-size:13px; width:600px;height:100px"><?=$d['session_top_txt']?></textarea>
									 
								</tr>
							
								<tr>
									<th class="settingBgred"><label class="tooltipPoint" for="" title="좌장 자리에 표시될 내용을 써주세요 ex) 좌장,chair, Chairperson 등 / 예)Chairperson 입력 후  옆 input box에 s 를 붙일 경우 / 입력된 좌장이 1명 이상일 경우 Chairpersons로 보여짐(Faculty 연동 사용시에만 가능)">Chair</label></th>
									<td><input style="width:190px" type="text" name="chair" id="chair"  value="<?=$d['chair']?>" />
									<input style="width:55px" type="text" name="chair2" id="chair2"  value="<?=$d['chair2']?>" /></td>
								
									<th class="settingBgred"><label for="" class="tooltipPoint" title="패널 자리에 표시될 내용을 써주세요 ex) 패널,Panel 등">Panel</label></th>
									<td><input style="width:250px" type="text" name="panel" id="panel"  value="<?=$d['panel']?>" /></td>
								</tr>

								<tr>
									<th class="settingBgred"><label for="" class="tooltipPoint" title="Discusser 자리에 표시될 내용을 써주세요 ex) 지정토론,Discusser 등">Discusser</label></th>
									<td><input style="width:250px" type="text" name="discusser" id="discusser"  value="<?=$d['discusser']?>" /></td>



									<th class="settingBgred"><label for="" class="tooltipPoint" title="사용(미노출)시 리스트 및 뷰에서만 안보임">etc_faculty</label></th>
									<td><select name="etc_faculty" id="etc_faculty">
									<option <?if($d['etc_faculty']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['etc_faculty']=="A"){?>selected<?}?> value="A">사용(미노출)</option>
									<option <?if($d['etc_faculty']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								</tr>

								<tr>
									<th class="settingBgred"><label for="" class="tooltipPoint" title="Speaker 자리에 표시될 내용을 써주세 / 프로그램에 Speaker 텍스트를 표시하고 싶지 않을 경우 빈칸으로 / 요 ex)Speaker, 연자,발표자 등">Speaker</label></th>
									<td><input style="width:250px" type="text" name="speaker" id="speaker"  value="<?=$d['speaker']?>" /></td>

									<th class="settingBgred"><label for="" class="tooltipPoint" title="사용(미노출)시 리스트 및 뷰에서만 안보임">etc_speaker</label></th>
									<td><select name="etc_speaker" id="etc_speaker">
									<option <?if($d['etc_speaker']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['etc_speaker']=="A"){?>selected<?}?> value="A">사용(미노출)</option>
									<option <?if($d['etc_speaker']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
									
								</tr>
									
								


								<tr>
									<th class="settingBgyellow"><label for="" class="tooltipPoint" title="프로그램 목록 카테고리 노출 타입">카테고리 <br/>노출 타입</label></th>
									<td>
										<select name="category_view" id="category_view">
											<option <?if($d['category_view']=="1"){?>selected<?}?> value="1">카테고리 1+카테고리 2</option>
											<option <?if($d['category_view']=="2"){?>selected<?}?> value="2">카테고리 1</option>
											<option <?if($d['category_view']=="3"){?>selected<?}?> value="3">카테고리 2</option>
											<option <?if($d['category_view']=="4"){?>selected<?}?> value="4">미노출</option>
										</select>
									</td>

									<th class="settingBgyellow"><label for="" class="tooltipPoint" title="카테고리 텍스트 노출여부 선택 / 1: 기본 텍스트 2: 카테고리 설정에 셋팅된 컬러값 / 3: 텍스트 미노출" >카테고리 <br/>텍스트 노출</label></th>
									<td>
										<select name="category_text_font" id="category_text_font">
											<option <?if($d['category_text_font']=="1"){?>selected<?}?> value="1">기본</option>
											<option <?if($d['category_text_font']=="2"){?>selected<?}?> value="2">category에 설정된 font</option>
											<option <?if($d['category_text_font']=="4"){?>selected<?}?> value="4">약어만</option>
											<option <?if($d['category_text_font']=="3"){?>selected<?}?> value="3">미노출</option>
										</select>
									</td>
								</tr>
								<tr>
									<th class="settingBgyellow"><label for="" class="tooltipPoint" title="세션별 카테고리 선택 / session → Category 설정에서 카테고리 추가 후 사용 가능 예) Symposium, Special Lecture 등">카테고리 1<br/>대분류</label></th>
									<td>
										<select name="category1" id="category1">
											<option <?if($d['category1']=="Y"){?>selected<?}?> value="Y">사용</option>
											<option <?if($d['category1']=="N"){?>selected<?}?> value="N">미사용</option>
										</select>
									</td>
								
									<th class="settingBgyellow"><label for="" class="tooltipPoint" title="카테고리 선택 후 세부적으로 구분할때 사용 예)Category1에서 Symposium 선택 후 Category 2에 (1) 을 쓸 경우 해당 카테고리는 Symposium 1 이 된다">카테고리 2<br/>소분류</label></th>
									<td>
										<select name="category2" id="category2">
											<option <?if($d['category2']=="Y"){?>selected<?}?> value="Y">사용</option>
											<option <?if($d['category2']=="N"){?>selected<?}?> value="N">미사용</option>
										</select>
									</td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="프로그램 하단메뉴에 표시될 부분을 체크박스로 선택 할 수 있음 해당부분bg컬러는 css수정에서 가능">하단 메뉴</label></th>
									<!--
									<td><select name="bottom_menu" id="bottom_menu">
									<option <?if($d['bottom_menu']=="1"){?>selected<?}?> value="1">NOW+glace+myfav</option>
									<option <?if($d['bottom_menu']=="2"){?>selected<?}?> value="2">NOW+glace+myfav+cateegory</option>
									<option <?if($d['bottom_menu']=="3"){?>selected<?}?> value="3">NOW+myfav+cateegory</option>
									<option <?if($d['bottom_menu']=="0"){?>selected<?}?> value="0">미사용</option>
									</select></td>
									-->
									<td colspan='3'>

										<input <?if($d['bottom_menu_now']=="Y"){?>checked<?}?> type='checkbox' name='bottom_menu_now' value="Y"/>NOW
										
										<input <?if($d['bottom_menu_program']=="Y"){?>checked<?}?> type='checkbox' name='bottom_menu_program' value="Y"/>Program

										<input <?if($d['bottom_menu_glance']=="Y"){?>checked<?}?> type='checkbox' name='bottom_menu_glance' value="Y"/>Glance

										<input <?if($d['bottom_menu_myfav']=="Y"){?>checked<?}?> type='checkbox' name='bottom_menu_myfav' value="Y"/>Myfav

										<input <?if($d['bottom_menu_category']=="Y"){?>checked<?}?> type='checkbox' name='bottom_menu_category' value="Y"/>Category

									 
								</tr>

								 

								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="세션 제목 입력 영역 /  Y 일 경우에만 제목영역 활성화 됨">세션 제목</label></th>
									<td><select name="theme" id="theme">
									<option <?if($d['theme']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['theme']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="세션 Sub 제목 입력 영역 /  Y 일 경우에만 제목영역 활성화 됨">세션 Sub 제목</label></th>
									<td><select name="sub_theme" id="sub_theme">
									<option <?if($d['sub_theme']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['sub_theme']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>

								</tr>

								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="세션 제목">세션 제목 표시방법</label></th>
									<td colspan="3">
										<select name="session_title_style" id="session_title_style" style="width:30%">
											<option <?if($d['session_title_style']=="1"){?>selected<?}?> value="1">기본(세션제목+세션sub제목)</option>
											<option <?if($d['session_title_style']=="2"){?>selected<?}?> value="2">직접입력 사용</option>
										</select>

										<input type="text" name="session_title_txt" id="session_title_txt" value="<?=$d['session_title_txt']?>" style="width:50%" placeholder="직접입력시 사용">

										<select style="width:100px;" class="txt_style_set" s-target="session_title_txt">
											<option value="">선택</option>
											<option value="{theme}">세션 제목</option>
											<option value="{sub_theme}">세션 Sub제목</option>
										</select>

									</td>
								</tr>

								<tr>
								
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="강의 제목 입력 영역 / Y일 경우에만 강의제목 영역 활성화 됨">강의 제목</label></th>
									<td><select name="title" id="title">
									<option <?if($d['title']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['title']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
									
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="강의평가 사용여부 / 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능 / 1:사용(view페이지 버튼생성) / 2: 미사용 / 3:사용(view페이지 하단 노출)">강의평가<br/>타입</label></th>
									<td><select name="evaluation" id="evaluation">
									<option <?if($d['evaluation']=="Y"){?>selected<?}?> value="Y">사용(버튼)</option>
									
									<option <?if($d['evaluation']=="Y2"){?>selected<?}?> value="Y2">사용(하단:상중하)</option>
									<option <?if($d['evaluation']=="Y3"){?>selected<?}?> value="Y3">사용(하단:별)</option>
									<option <?if($d['evaluation']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>

									
								</tr>
								
								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="초록 sid와 매칭할 경우 사용 / abs_sid보단 abs_no을 사용하는게 좋음(초록번호 노출되야 할 때 사용)" >abs_sid</label></th>
									<td><select name="abs_sid" id="abs_sid">
									<option <?if($d['abs_sid']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['abs_sid']=="A"){?>selected<?}?> value="A">사용(미노출)</option>
									<option <?if($d['abs_sid']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="프로그램에서 해당 초록 보여줘야 할 경우 프로그램/초록의 abs_no를 동일하게 입력 한다 / PT order기능 예)SY1-1 등..">abs_no</label></th>
									<td><select name="abs_no" id="abs_no">
									<option <?if($d['abs_no']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['abs_no']=="A"){?>selected<?}?> value="A">사용(미노출)</option>
									<option <?if($d['abs_no']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								</tr>

								<tr>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title="메모 기능 사용 여부 / 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능 / 해당기능Y일 경우 메모 타입도 설정 가능">메모(버튼)</label></th>
									<td><select name="memo" id="memo">
									<option <?if($d['memo']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['memo']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title="1:기본(일반 메모기능) / 2:이미지 기능(메모에서 사진 업로드 가능) / ">메모 타입</label></th>
									<td><select name="memo_type" id="memo_type">
									<option <?if($d['memo_type']=="1"){?>selected<?}?> value="1">기본</option>
									<option <?if($d['memo_type']=="2"){?>selected<?}?> value="2">이미지기능</option>
									</select></td>
								</tr>
								<tr>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title=" Y 일 경우 프로그램 view 페이지에 버튼 생성 / 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능/ 버튼 컬러는 css 에서 수정 가능 / 좋아요,Like등 ">좋아요(버튼)</label></th>
									<td><select name="islike" id="islike">
									<option <?if($d['islike']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['islike']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title="세션 즐겨찾기 말고 강의별로 즐겨찾기 기능 사용 N일 경우 프로그램 view 페이지에 즐겨찾기 버튼 안보임/ 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능/ 버튼 컬러는 css 에서 수정 가능 ">서브(강의)<br/> 즐겨찾기(버튼)</label></th>
									<td><select name="sub_favor" id="sub_favor">
									<option <?if($d['sub_favor']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['sub_favor']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>

								</tr>

								 
								
								<tr>
								
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="즐겨찾기 할 경우 10분전 알림 사용여부 / Y일 경우 앱에서 링크 확인 한번 더 해야함">10분전<br/> 알람기능(버튼)</label></th>
									<td><select name="alarm" id="alarm">
									<option <?if($d['alarm']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['alarm']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>


									<th class="settingBgblue"><label for="" class="tooltipPoint" title="Y일 경우 해당 연자 정보 보기 버튼 생성됨 / 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능/ 프로그램 view페이지에서 확인 가능">연자정보(버튼)</label></th>
									<td><select name="speaker_info" id="speaker_info">
									<option <?if($d['speaker_info']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['speaker_info']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
								</tr>

								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="세션 리스트에서 Q&A 바로 보여지게끔 사용 가능 / 해당기능 사용 시 앱단 링크 연결 확인 필요 /해당 버튼 텍스트는 session_set_tbl 에서 수정 가능/ 버튼 컬러는 css 에서 수정 가능 ">세션 Q&A<br/>(버튼)</label></th>
									<td><select name="session_question" id="session_question">
									<option <?if($d['session_question']=="0"){?>selected<?}?> value="0">미사용</option>
									<option <?if($d['session_question']=="1"){?>selected<?}?> value="1">사용</option>
									</select></td>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title="프로그램 view페이지 세션평가 사용 여부 / 해당 버튼 텍스트는 session_set_tbl 에서 수정 가능/ 버튼 컬러는 css 에서 수정 가능">세션평가(버튼)</label></th>
									<td><select name="session_evaluation" id="session_evaluation">
									<option <?if($d['session_evaluation']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['session_evaluation']=="Y"){?>selected<?}?> value="Y">사용</option>
									</select></td>
								
								</tr>

								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="강의 view 페이지에서 share 버튼 표시여부">강의 Share<br/>(버튼)</label></th>
									<td><select name="isshare" id="isshare">
									<option <?if($d['isshare']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['isshare']=="Y"){?>selected<?}?> value="Y">사용</option>
									</select></td>

									<th class="settingBgblue"><label for="" class="tooltipPoint" title="기타정보를 추가하여 glance 에 표기할수있음">세션 기타정보</label></th>
									<td>
										<select name="session_etc_info" id="session_etc_info">
										<option <?if($d['session_etc_info']=="N"){?>selected<?}?> value="N">미사용</option>
										<option <?if($d['session_etc_info']=="Y"){?>selected<?}?> value="Y">사용</option>
										</select>
									</td>
								
								</tr>

								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="Q&A 눌렀을때 세션명 표시방법 (미입력시 theme)">Q&A 세션<br />표시방법</label></th>
									<td colspan="3">
										<input type="text" name="qna_sesstion_style" id="qna_sesstion_style" value="<?=$d['qna_sesstion_style']?>" style="width:450px;">
										<select style="width:190px;" class="txt_style_set" s-target="qna_sesstion_style">
											<option value="">선택</option>
											<option value="{theme}">theme</option>
											<option value="{sub_theme}">sub_theme</option>
										</select>

									</td>
								</tr>


								<tr>
									<th class="settingBgblue"><label for="" class="tooltipPoint" title="Q&A 눌렀을때 강의명 표시방법 (미입력시 강의명)">Q&A 강의<br />표시방법</label></th>
									<td colspan="3">
										<input type="text" name="qna_lecture_style" id="qna_lecture_style" value="<?=$d['qna_lecture_style']?>" style="width:450px;">
										<select style="width:190px;" class="txt_style_set" s-target="qna_lecture_style">
											<option value="">선택</option>
											<option value="{lecture}">강의명</option>
											<option value="{speaker}">speaker(국문)</option>
											<option value="{speaker_en}">speaker(영문)</option>
										</select>

									</td>
								</tr>
					<!--
								<tr>
									<th style="background-color:#bbccee"><label for="">abs_info</label></th>
									<td><select name="abs_info" id="abs_info">
									<option <?if($d['abs_info']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['abs_info']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
									<th style="background-color:#bbccee"><label for="">purpose</label></th>
									<td><select name="purpose" id="purpose">
									<option <?if($d['purpose']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['purpose']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label for="">methods</label></th>
									<td><select name="methods" id="methods">
									<option <?if($d['methods']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['methods']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
									<th style="background-color:#bbccee"><label for="">results</label></th>
									<td><select name="results" id="results">
									<option <?if($d['results']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['results']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label for="">conclusions</label></th>
									<td><select name="conclusions" id="conclusions">
									<option <?if($d['conclusions']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['conclusions']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								
									<th style="background-color:#bbccee"><label for="">keywords</label></th>
									<td><select name="keywords" id="keywords">
									<option <?if($d['keywords']=="Y"){?>selected<?}?> value="Y">사용</option>
									<option <?if($d['keywords']=="N"){?>selected<?}?> value="N">미사용</option>
									</select></td>
								</tr>
								-->

								<tr>

									<th><label for=""  class="tooltipPoint" title="사용여부Y 일경우 glance,program 리스트에 아이콘 생김 해당 / 예)eng세션 kor세션 구분할때 사용 / kor/eng 설정은 세션 에서 설정가능">eng/kor세션</br/>언어구분 <!-- language --></label></th>
									<td><select name="language" id="language">
									<option <?if($d['language']=="Y"){?>selected<?}?> value="Y">사용(아이콘표시O)</option>
									<option <?if($d['language']=="N"){?>selected<?}?> value="N">미사용(아이콘표시X)</option>
									</select></td>

									
									
									<th><label for=""  class="tooltipPoint" title="같은 시간을 모아서 표현해줌 / Type1:시간별 구분O / Type2:시간별 구분X">프로그램 시간 <br/>표시 타입 <!-- time_type --></label></th>
									<td><select name="time_type" id="time_type">
									<option <?if($d['time_type']=="1"){?>selected<?}?> value="1">type1(시간별구분 O)</option>
									<option <?if($d['time_type']=="2"){?>selected<?}?> value="2">type2(시간별구분 X)</option>
									</select></td>


								</tr>	

								<tr>
									<th><label for="" class="tooltipPoint" title="프로그램 목록 상단에 노출 / 정렬 대상 선택 / 1: Room별(기본) 2: 카테고리별 3: 해당 영역 안안보임">프로그램 상단(정렬)<br/>select box타입 </label></th>
									<td>
										<select name="selected_box" id="selected_box">
											<option <?if($d['selected_box']=="1"){?>selected<?}?> value="1">룸별 정렬</option>
											<option <?if($d['selected_box']=="2"){?>selected<?}?> value="2">카테고리별 정렬</option>
											<!-- <option <?if($d['selected_box']=="3"){?>selected<?}?> value="3">Category2</option> --><!-- 이건 뭐에요? -->

											<option <?if($d['selected_box']=="3"){?>selected<?}?> value="3">룸+카테고리별 정렬</option>
											<option <?if($d['selected_box']=="4"){?>selected<?}?> value="4">미사용</option>
										</select>
									</td>
									
									<th><label for=""  class="tooltipPoint" title="프로그램 날짜 노출 타입 탭 컬러는 css에서 설정 가능 / Type 1 : 탭 형식 / Type 2 : 달력UI/Type2일 경우css 컬러 수정가능">날짜 타입</label></th>
									<td>
										<select name="day_type" id="day_type">
											<option <?if($d['day_type']=="1"){?>selected<?}?> value="1">탭UI</option>
											<option <?if($d['day_type']=="2"){?>selected<?}?> value="2">달력UI (영문)</option>
											<option <?if($d['day_type']=="3"){?>selected<?}?> value="3">달력UI (한글)</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<th><label for="" class="tooltipPoint" title="세부페이지에서 해당 세션 표시 여부 / ex) Symposium 1 세션의 S01 강의 뷰페이지 하단에 Symposium 1 세션 노출 ">프로그램 뷰페이지 하단 해당세션 노출 여부</label></th>
									<td>
										<select name="session_show" id="session_show">
										<option <?if($d['session_show']=="0"){?>selected<?}?> value="0">미사용</option>
										<option <?if($d['session_show']=="1"){?>selected<?}?> value="1">사용</option>
										</select>
									</td>
									
									<th><label for="" class="tooltipPoint" title="타입 : Session Faculty 눌러보이기 선택 시 프로그램 리스트에서 좌장정보 바로 안보이고, 해당 세션 눌러야  좌장 정보가 보여짐">프로그램 좌장정보 노출타입</label></th>
									<td>
										<select name="program_view_type" id="program_view_type">
										<option <?if($d['program_view_type']=="1"){?>selected<?}?> value="1">기본</option>
										<option <?if($d['program_view_type']=="2"){?>selected<?}?> value="2">Session Faculty 눌러보이기</option>
										</select>
									</td>

									 
								</tr>
								 
								<tr>
									<th><label for="" class="tooltipPoint" title="세션 설명, Session 구분..할때 사용/ 1: 기본 타입(css에서 해당 컬러 변경 가능) 2:Session Description 사용 가능(ex:킹카)  해당 강의  수정 페이지에서 Sub_Session 타입 선택 후 사용">서브세션 구분<br/>타입 설정</label></th>
									<td>
										<select name="sub_theme_type" id="sub_theme_type">
										<option <?if($d['sub_theme_type']=="1"){?>selected<?}?> value="1">기본</option>
										<option <?if($d['sub_theme_type']=="2"){?>selected<?}?> value="2">Session Description</option>
										</select>
									</td>
									
									<th></th>
									<td></td>
								</tr>
						
								<tr>
									<th class="settingBggreen"><label for="" class="tooltipPoint" title="Faculty 연동 시 좌장 이름,소속 등 보여주는 타입 설정 [] , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택 ">좌장 표시방법<br>(Faculty 연동시)</label></th>
									<td colspan="3"><input type="text" name="faculty_style_chair" id="faculty_style_chair" value="<?=htmlspecialchars($d['faculty_style_chair'])?>" style="width:450px;">
										<select style="width:190px;" class="txt_style_set" s-target="faculty_style_chair">
											<option value="">선택</option>
											<option value="{이름}">이름</option>
											<option value="{소속}">소속</option>
											<option value="{국가}">국가</option>
										</select>
									</td>
									<!--
									<td>
										<select name="faculty_style" id="faculty_style">
											<option <?if($d['faculty_style']=="1"){?>selected<?}?> value="1">이름 (소속)</option>
											<option <?if($d['faculty_style']=="2"){?>selected<?}?> value="2">이름 \n(소속, 국가)</i></option>
											<option <?if($d['faculty_style']=="3"){?>selected<?}?> value="3">이름 (소속, 국가)</i></option>
											<option <?if($d['faculty_style']=="4"){?>selected<?}?> value="4">이름 / 소속</i></option>
											<option <?if($d['faculty_style']=="5"){?>selected<?}?> value="5">이름</i></option>
										</select>
									</td>
									-->
								</tr>
								<tr>
									<th class="settingBggreen"><label for="" class="tooltipPoint" title="Faculty 연동 시 연자 이름,소속 등 보여주는 타입 설정 [] , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택  ">연자 표시방법<br>(Faculty 연동시)</label></th>

									<td colspan="3"><input type="text" name="faculty_style_speaker" id="faculty_style_speaker" value="<?=$d['faculty_style_speaker']?>" style="width:450px;">
										<select style="width:100px;" class="txt_style_set" s-target="faculty_style_speaker">
											<option value="">선택</option>
											<option value="{이름}">이름</option>
											<option value="{소속}">소속</option>
											<option value="{국가}">국가</option>
										</select>
										<input type="text" style="width:90px;" placeholder="구분자" name="faculty_style_speaker_gubun" value="<?=htmlspecialchars($d['faculty_style_speaker_gubun'])?>">
									</td>
									<!--
									<td>
										<select name="faculty_style1" id="faculty_style1">
											<option <?if($d['faculty_style1']=="1"){?>selected<?}?> value="1">이름 (소속)</option>
											<option <?if($d['faculty_style1']=="2"){?>selected<?}?> value="2">이름 \n(소속, 국가)</i></option>
											<option <?if($d['faculty_style1']=="3"){?>selected<?}?> value="3">이름 (소속, 국가)</i></option>
											<option <?if($d['faculty_style1']=="4"){?>selected<?}?> value="4">이름 / 소속</i></option>
											<option <?if($d['faculty_style1']=="5"){?>selected<?}?> value="5">이름</i></option>
										</select>
									</td>
									-->
								</tr>
								<tr>
									<th class="settingBggreen" ><label for="" class="tooltipPoint" title="Faculty 연동 시 보여줄 타입 선택 / Faculty 메뉴에 정보가 다 입력 되어있어야 함 / 영문 이름,소속 입력 안해놓고 타입을 영문으로 설정하면 내용 안나오는게 정상../ 1:국문 데이터만 노출 / 2:영문 데이터만 노출 / 3:eng세션만 영문노출(세션 언어가 eng일 경우) ">패컬티 노출타입<br>(Faculty 연동시)</label></th>
									<td>
										<select name="faculty_style2" id="faculty_style2">
											<option <?if($d['faculty_style2']=="1"){?>selected<?}?> value="1">국문</option>
											<option <?if($d['faculty_style2']=="2"){?>selected<?}?> value="2">영문</option>
											<option <?if($d['faculty_style2']=="3"){?>selected<?}?> value="3">Eng세션만 영문</option>
										</select>
									</td>
									

									<th class="settingBggreen"><label for="" class="tooltipPoint" title="faculty 연동 / Y 일 경우 Faculty메뉴에 등록된 사람만 등록 가능 / 먼저 Faculty에 정보를 입력 해야함 ">패컬티 연동기능</label></th>
									<td>
										<select name="faculty_type" id="faculty_type">
											<option <?if($d['faculty_type']=="1"){?>selected<?}?> value="1">Faculty 연동</option>
											<option <?if($d['faculty_type']=="2"){?>selected<?}?> value="2">기본</option>
										</select>
									</td>

								</tr>

								<tr>
									<th class="settingBgorange"><label for="" class="tooltipPoint" title="glance에 보여지는 방식 / [] , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택 ">glance 표현방법</label></th>

									<td colspan="3"><input type="text" name="glance_view_style" id="glance_view_style" value="<?=htmlspecialchars($d['glance_view_style'])?>" style="width:450px;">
										<select style="width:190px;" class="txt_style_set" s-target="glance_view_style">
											<option value="">선택</option>
											<option value="{theme}">theme</option>
											<option value="{sub_theme}">sub_theme</option>
											<option value="{cate1}">cate1</option>
											<option value="{cate1(abb)}">cate1(abb)</option>
											<option value="{cate2}">cate2</option>
											<option value="{s_etc_info}">세션 기타정보</option>
										</select>
									</td>


									

									
								</tr>

								<tr>
									<th class="settingBgorange"><label for="" class="tooltipPoint" title="glance 넓이설정 (미입력시 120)" >glance 넓이설정 (미입력시 120)</label></th>
									<td><input style="width:250px" type="text" name="glance_width" id="glance_width"  value="<?=$d['glance_width']?>" /></td>

									<th class="settingBgorange"><label for="" class="tooltipPoint" title="glance 높이설정 (미입력시 144)" >glance 높이설정 (미입력시 144)</label></th>
									<td><input style="width:250px" type="text" name="glance_height" id="glance_height"  value="<?=$d['glance_height']?>" /><br><font color="#FF0000">* 12의 배수로 입력</font></td>
								</tr>

								<tr>

									<th class="settingBgorange"><label for="" class="tooltipPoint" title="glacne 시간 설정 / 세션 > 시간설정 에서 시간셋팅을 합니다. / 시간이 룸별로 다를 경우 시간설정 연동을 사용합니다 ex) 견주/ ">glance 시간표시 타입설정</label></th>
									<td><select name="glance_type" id="glance_type">
									<!--
									<option <?if($d['glance_type']=="1"){?>selected<?}?> value="1">type1</option>
									-->
									<option <?if($d['glance_type']=="2"){?>selected<?}?> value="2">한시간 단위 (H - H)</option>
									<option <?if($d['glance_type']=="6"){?>selected<?}?> value="6">한시간 단위 (H)</option>
									<option <?if($d['glance_type']=="5"){?>selected<?}?> value="5">30분 단위</option>
									<option <?if($d['glance_type']=="3"){?>selected<?}?> value="3">시간설정 연동</option>
									<option <?if($d['glance_type']=="4"){?>selected<?}?> value="4">시간,룸 반전</option>

									<option <?if($d['glance_type']=="M"){?>selected<?}?> value="M">Glance Maker</option>
									</select></td>

									<th class="settingBgorange"><label for="" class="tooltipPoint" title="glance 화면에 꽉차는 여부(룸이 4개 이하일때만 사용)">glance full <br/>표현타입 설정</label></th>
									<td>
										<select name="glance_full" id="glance_full">
											<option <?if($d['glance_full']=="N"){?>selected<?}?> value="N">미사용</option>
											<option <?if($d['glance_full']=="Y"){?>selected<?}?> value="Y">사용(룸4개 이하시에만)</option>
										</select>
									</td>

									
								</tr>

								<tr>

									<th class="settingBgorange"><label for="" class="tooltipPoint" title="Glanec 아이콘 노출위치 ">Glance 아이콘<br/> 노출위치</label></th>
									<td>
										<select name="bullet_type" id="bullet_type">
										<option <?if($d['bullet_type']=="1"){?>selected<?}?> value="1">타이틀옆노출</option>
										<option <?if($d['bullet_type']=="2"){?>selected<?}?> value="2">좌측상단노출</option>
										<option <?if($d['bullet_type']=="3"){?>selected<?}?> value="3">타이틀옆노출-원</option>
									</td>

									<th class="settingBgorange"><label for="" class="tooltipPoint" title="기본값: ENG, KOR(glane에 Kor,K,eng,E등 표시">Glanec 아이콘 <br/>텍스트 직접입력</label></th>
									<td>
										KOR: <input type="text" name="bullet_txt_kor" maxlength="10" value="<?=$d['bullet_txt_kor']?>" style="width:60px;">
										&nbsp;&nbsp;
										ENG: <input type="text" name="bullet_txt_eng" maxlength="10" value="<?=$d['bullet_txt_eng']?>" style="width:60px;">
									</td>
								
								<tr>

									<th  class="tooltipPoint" title="CV 첨부파일 형식 설정 / 첨부파일 : pdf파일로 업로드 / 주소 : url직접 입력"><label for="">CV_file</label></th>
									<td>
										<select name="cv_file" id="cv_file">
											<option <?if($d['cv_file']=="Y"){?>selected<?}?> value="Y">첨부파일</option>
											<option <?if($d['cv_file']=="N"){?>selected<?}?> value="N">주소</option>
										</select>
									</td>
									<th></th>
									<td></td>
								</tr>

							</tbody>
						</table>

						<div class="btnArea btn">
							
							<input type="submit" value="저장" class="btnDef btnBig" />
							<input type="reset" onclick="window.close()" value="취소" class="btnGrey btnBig" />
						</div>
					</fieldset>
				</form>

			</div>
			<!--  //conArea -->

		</div>	
		</div>

	
<script type="text/javascript">

	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
		$("select.txt_style_set").on("change", function() {
			var pre_val = $("#"+$(this).attr("s-target")).val();
			$("#"+$(this).attr("s-target")).val(pre_val + $(this).val())
		});
	});


</script>
<?include "./../footer.php";?>