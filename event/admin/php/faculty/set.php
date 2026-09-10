<?include "./../header2.php";

	$query="SELECT * FROM session_set_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Setting</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./set_post.php" method="post"> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:800px">
							<colgroup>
								<col style="width: 20%;" />
								<col style="width: 30%;" />
								<col style="width: 20%;" />
								<col style="width: 30%;" />
							</colgroup>
							<tbody>
							
								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="즐겨찾기 사용여부 설정 Y일 경우에만 리스트에 즐겨찾기 버튼 노출됨" for=" ">즐겨찾기 <br/>사용여부</label></th>
									<td><select name="faculty_favor" id="faculty_favor">
									<option <?if($d['faculty_favor']=="1"){?>selected<?}?> value="1">사용</option>
									<option <?if($d['faculty_favor']=="2"){?>selected<?}?> value="2">미사용</option>
									</select></td>

									<th style="background-color:#bbccee"><label class="tooltipPoint" title="사진 노출 여부 설정 / Y일 경우에만 리스트에 사진 노출" for=" ">사진 사용여부</label></th>
									<td><select name="faculty_photo" id="faculty_photo">
									<option <?if($d['faculty_photo']=="1"){?>selected<?}?> value="1">사용</option>
									<option <?if($d['faculty_photo']=="2"){?>selected<?}?> value="2">미사용</option>
									</select></td>
									
								</tr>

								<tr>
									<!-- <th style="background-color:#bbccee"><label for="">표현방식</label></th>
									<td><select name="faculty_txt_type" id="faculty_txt_type">
									<option <?if($d['faculty_txt_type']=="1"){?>selected<?}?> value="1">이름</option>
									<option <?if($d['faculty_txt_type']=="2"){?>selected<?}?> value="2">이름(소속)</option>
									<option <?if($d['faculty_txt_type']=="3"){?>selected<?}?> value="3">이름(소속, 국가)</option>
									</select></td> -->

									<th style="background-color:#bbccee"><label class="tooltipPoint" title="UI타입 설정 / 기본 : default 강조 : 사진 크게 보여지는 ui" for=" ">UI</label></th>
									<td><select name="faculty_view_type" id="faculty_view_type">
									<option <?if($d['faculty_view_type']=="1"){?>selected<?}?> value="1">기본</option>
									<option <?if($d['faculty_view_type']=="2"){?>selected<?}?> value="2">강조</option>
									
									</select></td>
									<th></th>
									<td></td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="목록에 보여질 표현방식 , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택/<dt></dt>사이에 넣어야 bold처리됨 /예) <dt>{성함(국문)}</dt> ,{소속(국문)}" for=" ">표현방식-List(Eng)</label></th>
									<td colspan="3">
										<input type="text" name="faculty_txt_type_list_eng" id="faculty_txt_type_list_eng" value="<?=htmlspecialchars($d['faculty_txt_type_list_eng']);?>" style="width:500px;">



										<select style="width:100px;" class="faculty_txt_type" s-target="list_eng">
											<option value="">선택</option>
											<option value="{성함(국문)}">성함(국문)</option>
											<option value="{성함(영문)}">성함(영문)</option>
											<option value="{소속(국문)}">소속(국문)</option>
											<option value="{소속(영문)}">소속(영문)</option>
											<option value="{국가}">국가</option>
											<option value="{역할}">역할</option>
										</select>
									</td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="view 페이지에 보여질 표현방식 , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택/" for=" " >표현방식-View(Eng)</label></th>
									<td colspan="3">
										<input type="text" name="faculty_txt_type_view_eng" id="faculty_txt_type_view_eng" value="<?=htmlspecialchars($d['faculty_txt_type_view_eng'])?>" style="width:500px;">
										<select style="width:100px;" class="faculty_txt_type" s-target="view_eng">
											<option value="">선택</option>
											<option value="{성함(국문)}">성함(국문)</option>
											<option value="{성함(영문)}">성함(영문)</option>
											<option value="{소속(국문)}">소속(국문)</option>
											<option value="{소속(영문)}">소속(영문)</option>
											<option value="{국가}">국가</option>
											<option value="{역할}">역할</option>
										</select>
									</td>
								</tr>


								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="목록에 보여질 표현방식 , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택/<dt></dt>사이에 넣어야 bold처리됨 /예) <dt>{성함(국문)}</dt> ,{소속(국문)}" for=" ">표현방식-List(Kor)</label></th>
									<td colspan="3">
										<input type="text" name="faculty_txt_type_list_kor" id="faculty_txt_type_list_kor" value="<?=htmlspecialchars($d['faculty_txt_type_list_kor'])?>" style="width:500px;">
										<select style="width:100px;" class="faculty_txt_type" s-target="list_kor">
											<option value="">선택</option>
											<option value="{성함(국문)}">성함(국문)</option>
											<option value="{성함(영문)}">성함(영문)</option>
											<option value="{소속(국문)}">소속(국문)</option>
											<option value="{소속(영문)}">소속(영문)</option>
											<option value="{국가}">국가</option>
											<option value="{역할}">역할</option>
										</select>
									</td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="view 페이지에 보여질 표현방식 , () / <br/>등 직접 입력 / 입력 항목은 slecet box 에서 선택/" for=" " >표현방식-View(Kor)</label></th>
									<td colspan="3">
										<input type="text" name="faculty_txt_type_view_kor" id="faculty_txt_type_view_kor" value="<?=htmlspecialchars($d['faculty_txt_type_view_kor'])?>" style="width:500px;">
										<select style="width:100px;" class="faculty_txt_type" s-target="view_kor">
											<option value="">선택</option>
											<option value="{성함(국문)}">성함(국문)</option>
											<option value="{성함(영문)}">성함(영문)</option>
											<option value="{소속(국문)}">소속(국문)</option>
											<option value="{소속(영문)}">소속(영문)</option>
											<option value="{국가}">국가</option>
											<option value="{역할}">역할</option>
										</select>
									</td>
								</tr>

								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="Faculty 메뉴 상단 타이틀 직접 입력" for=" ">Faculty문구 입력</label></th>
									<td><input style="width:205px" type="text" name="faculty" id="faculty"  value="<?=$d['faculty']?>" /></td>

									<th style="background-color:#bbccee"><label class="tooltipPoint" title="패컬티 이미지 사용시 기본으로 보여질 이미지 업로드" for="">기본이미지</label></th>
									<td><input style="width:205px" type="file" name="image" id="image"/></td>

								</tr>

								<tr>
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="Y일 경우 패컬티 view페이지에서 해당 패컬티가 스피커 일 경우 스피커도 세션으로 노출 / N일 경우 해당 강의만 노출" for="">스피커도 세션으로<br/> 노출</label></th>

									<td><select name="faculty_session_type" id="faculty_session_type">
									<option <?if($d['faculty_session_type']=="1"){?>selected<?}?> value="1">기본</option>
									<option <?if($d['faculty_session_type']=="2"){?>selected<?}?> value="2">speaker도 session으로 검색</option>
									
									</select></td>
									
									<th style="background-color:#bbccee"><label class="tooltipPoint" title="검색 정렬방법" for="">정렬방법</label></th>

									<td><select name="faculty_orderby" id="faculty_orderby">
									<option <?if($d['faculty_orderby']=="0"){?>selected<?}?> value="0">기본(이름)</option>
									<option <?if($d['faculty_orderby']=="1"){?>selected<?}?> value="1">마지막 단어(국문이름 입력 기준)</option>
									<option <?if($d['faculty_orderby']=="4"){?>selected<?}?> value="4">마지막 단어(영문이름 입력 기준)</option>
									<option <?if($d['faculty_orderby']=="2"){?>selected<?}?> value="2">그룹,이름</option>
									<option <?if($d['faculty_orderby']=="3"){?>selected<?}?> value="3">그룹,마지막 단어</option>
									
									</select></td>

							
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

		$("select.faculty_txt_type").on("change", function() {
			var pre_val = $("#faculty_txt_type_"+$(this).attr("s-target")).val();
			$("#faculty_txt_type_"+$(this).attr("s-target")).val(pre_val + $(this).val())
		});
	});

</script>
<?include "./../footer.php";?>