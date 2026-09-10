<?include "./../header2.php";

	$query="SELECT * FROM abstract_set_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	
	$ATM_info = explode("|", $d['abs_top_menu_info']);
?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Setting</h2>
			<p style="font-size:14px; clear: both; line-height: 20px;padding-top:10px;">abs_info 1 ~ 16 사이에 초록 타이틀 명을 입력합니다. 입력 순서대로 app에 노출 / ex) 저자명, 저자속, 공저자, Objectives, Methods, Results, Keywords 등 각 필드 옆 체크박스에 선택된 항목은 초록 목록에 표시됩니다.<br/>(default는 초록 title만 표시) / ex) 공저자명,저자명 등이 초록 목록에 표시되어야 할 경우 </p>
			<p style="font-size:14px; padding-top:10px;">초록 목록 표현 방식:<br>
			1. View 우선으로 설정(기존방식)  <br/> 초록 필드(abs_info1~16)에 입력된 데이터가 있을 경우, 앱 > 초록 리스트 > 해당초록view 페이지 <br/>
			2. PDF 우선으로 설정 <br/>
			1) 세션등록 시 등록된 첨부파일이 있을 경우, 앱> 초록리스트 > 바로 PDF연결 <br/>
			2) 세션에 등록된 첨부파일 없고, 초록 DB일괄 등록 시 upload/code/행사코드/ 폴더에 파일 있고, 해당 파일명과 동일한 abs_no 데이터가 입력되어 있을 경우/ <br/>ex) 정형 초록 리스트 > PDF 우선설정</p>
			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./set_post.php" method="post"> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:800px">
							<colgroup>
								<col style="width: 15%;" />
								<col style="width: 35%;" />
								<col style="width: 15%;" />
								<col style="width: 35%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label class="tooltipPoint" title="" for="">초록 상단텍스트</label></th>
									<td colspan=" ">
										<input type="text" name="abstract_txt" value="<?=$d['abstract_txt']?>" >
									</td>
									<th><label class="tooltipPoint" title="" for="">초록 버튼<br/>텍스트</label></th>
									<td colspan=" ">
										<input type="text" name="abstract_btn_txt" value="<?=$d['abstract_btn_txt']?>" >
									</td>
								<tr>

								<tr>
									<th><label class="tooltipPoint" title="사용 으로 설정할 경우 초록 상단 영역에 해당 카테고리명 노출(탭으로 구분 가능) 카테고리: oral / poster / case 등 구분할 경우 사용" for="">초록 상단메뉴</label></th>
									<td colspan="3">
									
									<select name="abs_top_menu" id="abs_top_menu" style="width:50%">
									<option <?if($d['abs_top_menu']=="0"){?>selected<?}?> value="0">미사용</option>
									<option <?if($d['abs_top_menu']=="1"){?>selected<?}?> value="1">카테고리</option>
									<option <?if($d['abs_top_menu']=="2"){?>selected<?}?> value="2">카테고리+지정info</option>
									</select>
									
									<span class="abs_top_menu_info" <?if($d['abs_top_menu']!=2){?>style="display:none"<?}?>>
									&nbsp;TEXT : 
									<input type="text" name="abs_top_menu_txt1" value="<?=$d['abs_top_menu_txt1']?>" style="width:150px;" >
									</span>
									</td>
								<tr>

								<tr class="abs_top_menu_info" <?if($d['abs_top_menu']!=2){?>style="display:none;"<?}?>>
									<th>
										<label title="지정된 정보를 값을 보여주고, 검색함">
										지정info
										</label>
									</th>
									<td colspan="4">
										<select style="width:100px;" name="abs_top_menu_info1">
											<option value="">선택</option>
											<?for($i=1;$i<=16;$i++){?>
											<?if($d['abs_info'.$i]){?>
											<option value="<?=$i?>" <?if($ATM_info[0]==$i){?>selected<?}?> ><?=$d['abs_info'.$i]?></option>
											<?}?>
											<?}?>
										</select>

										<select style="width:100px;" name="abs_top_menu_info2">
											<option value="">선택</option>
											<?for($i=1;$i<=16;$i++){?>
											<?if($d['abs_info'.$i]){?>
											<option value="<?=$i?>" <?if($ATM_info[1]==$i){?>selected<?}?> ><?=$d['abs_info'.$i]?></option>
											<?}?>
											<?}?>
										</select>

										<select style="width:100px;" name="abs_top_menu_info3">
											<option value="">선택</option>
											<?for($i=1;$i<=16;$i++){?>
											<?if($d['abs_info'.$i]){?>
											<option value="<?=$i?>" <?if($ATM_info[2]==$i){?>selected<?}?>  ><?=$d['abs_info'.$i]?></option>
											<?}?>
											<?}?>
										</select>

										<select style="width:100px;" name="abs_top_menu_info4">
											<option value="">선택</option>
											<?for($i=1;$i<=16;$i++){?>
											<?if($d['abs_info'.$i]){?>
											<option value="<?=$i?>" <?if($ATM_info[3]==$i){?>selected<?}?> ><?=$d['abs_info'.$i]?></option>
											<?}?>
											<?}?>
										</select>

										&nbsp;TEXT:&nbsp;
										<input type="text" name="abs_top_menu_txt2" value="<?=$d['abs_top_menu_txt2']?>" style="width:150px;" >
									
									</td>
									
								</tr>

								<tr>
									<th>초록 즐겨찾기</th>
									<td>
										<select name="abs_favor" id="abs_favor" style="width:50%">
											<option <?if($d['abs_favor']=="N"){?>selected<?}?> value="N">미사용</option>
											<option <?if($d['abs_favor']=="Y"){?>selected<?}?> value="Y">사용</option>
										</select>
									</td>
									<th><label class="tooltipPoint" title="일자, 시간, 장소 표시됨" for="">초록 페이지<br /> 정보표시</label></th>
									<td>
										<select name="abs_detail_top_info" id="abs_detail_top_info" style="width:50%">
											<option <?if($d['abs_detail_top_info']=="0"){?>selected<?}?> value="0">미사용</option>
											<option <?if($d['abs_detail_top_info']=="1"){?>selected<?}?> value="1">사용</option>
										</select>
									</td>
								</tr>

								<tr>
									<th><label class="tooltipPoint" title="초록 텍스트 정렬방식" for="">초록 텍스트<BR/>정렬방식</label></th>
									<td><select name="abs_align" id="abs_align">
									<option <?if($d['abs_align']=="0"){?>selected<?}?> value="0">좌측정렬</option>
									<option <?if($d['abs_align']=="1"){?>selected<?}?> value="1">양쪽정렬</option>
									</select></td>
									<th><label class="tooltipPoint" title="view 우선 : 초록 필드(abs_info1~16)에 입력된 데이터가 있을 경우, 앱 > 초록 리스트 > 해당초록view 페이지 / PDF 우선 : 1) 세션등록 시 등록된 첨부파일이 있을 경우, 앱> 초록리스트 > 바로 PDF연결 / 2) 세션에 등록된 첨부파일 없고, 초록 DB일괄 등록 시 upload/code/행사코드/ 폴더에 파일 있고, 해당 파일명과 동일한 abs_no 데이터가 입력되어 있을 경우/ ex) 정형 초록 리스트 > PDF 우선설정" for="">초록 리스트 > 초록 표현 타입</label></th>
									<td><select name="abs_view_type" id="abs_view_type">
									<option <?if($d['abs_view_type']=="0"){?>selected<?}?> value="0">View 우선</option>
									<option <?if($d['abs_view_type']=="1"){?>selected<?}?> value="1">PDF 우선</option>
									<option <?if($d['abs_view_type']=="2"){?>selected<?}?> value="2">View Page</option>
									</select></td>
								</tr>

							
								<tr>
									<th><label class="tooltipPoint" title=""   for="">abs_info1</label></th>
									<td><input style="width:205px" type="text" name="abs_info1" id="abs_info1"  value="<?=$d['abs_info1']?>" /> <input type='checkbox' name='abs_info1_chk' value='Y' <?if($d['abs_info1_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info2</label></th>
									<td><input style="width:205px" type="text" name="abs_info2" id="abs_info2"  value="<?=$d['abs_info2']?>" /> <input type='checkbox' name='abs_info2_chk' value='Y' <?if($d['abs_info2_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info3</label></th>
									<td><input style="width:205px" type="text" name="abs_info3" id="abs_info3"  value="<?=$d['abs_info3']?>" /> <input type='checkbox' name='abs_info3_chk' value='Y' <?if($d['abs_info3_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info4</label></th>
									<td><input style="width:205px" type="text" name="abs_info4" id="abs_info4"  value="<?=$d['abs_info4']?>" /> <input type='checkbox' name='abs_info4_chk' value='Y' <?if($d['abs_info4_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info5</label></th>
									<td><input style="width:205px" type="text" name="abs_info5" id="abs_info5"  value="<?=$d['abs_info5']?>" /> <input type='checkbox' name='abs_info5_chk' value='Y' <?if($d['abs_info5_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info6</label></th>
									<td><input style="width:205px" type="text" name="abs_info6" id="abs_info6"  value="<?=$d['abs_info6']?>" /> <input type='checkbox' name='abs_info6_chk' value='Y' <?if($d['abs_info6_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info7</label></th>
									<td><input style="width:205px" type="text" name="abs_info7" id="abs_info7"  value="<?=$d['abs_info7']?>" /> <input type='checkbox' name='abs_info7_chk' value='Y' <?if($d['abs_info7_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info8</label></th>
									<td><input style="width:205px" type="text" name="abs_info8" id="abs_info8"  value="<?=$d['abs_info8']?>" /> <input type='checkbox' name='abs_info8_chk' value='Y' <?if($d['abs_info8_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info9</label></th>
									<td><input style="width:205px" type="text" name="abs_info9" id="abs_info9"  value="<?=$d['abs_info9']?>" /> <input type='checkbox' name='abs_info1_chk' value='Y' <?if($d['abs_info9_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info10</label></th>
									<td><input style="width:205px" type="text" name="abs_info10" id="abs_info10"  value="<?=$d['abs_info10']?>" /> <input type='checkbox' name='abs_info10_chk' value='Y' <?if($d['abs_info10_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info11</label></th>
									<td><input style="width:205px" type="text" name="abs_info11" id="abs_info11"  value="<?=$d['abs_info11']?>" /> <input type='checkbox' name='abs_info11_chk' value='Y' <?if($d['abs_info11_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info12</label></th>
									<td><input style="width:205px" type="text" name="abs_info12" id="abs_info12"  value="<?=$d['abs_info12']?>" /> <input type='checkbox' name='abs_info12_chk' value='Y' <?if($d['abs_info12_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info13</label></th>
									<td><input style="width:205px" type="text" name="abs_info13" id="abs_info13"  value="<?=$d['abs_info13']?>" /> <input type='checkbox' name='abs_info13_chk' value='Y' <?if($d['abs_info13_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info14</label></th>
									<td><input style="width:205px" type="text" name="abs_info14" id="abs_info14"  value="<?=$d['abs_info14']?>" /> <input type='checkbox' name='abs_info14_chk' value='Y' <?if($d['abs_info14_chk']=="Y"){?>checked<?}?> /></td>
								</tr>

								<tr>
									<th><label for="">abs_info15</label></th>
									<td><input style="width:205px" type="text" name="abs_info15" id="abs_info15"  value="<?=$d['abs_info15']?>" /> <input type='checkbox' name='abs_info15_chk' value='Y' <?if($d['abs_info15_chk']=="Y"){?>checked<?}?> /></td>
								
									<th><label for="">abs_info16</label></th>
									<td><input style="width:205px" type="text" name="abs_info16" id="abs_info16"  value="<?=$d['abs_info16']?>" /> <input type='checkbox' name='abs_info16_chk' value='Y' <?if($d['abs_info16_chk']=="Y"){?>checked<?}?> /></td>
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

		$("select#abs_top_menu").on("change", function() {
			var $val = $(this).val();

			if($val == '2') {
				$(".abs_top_menu_info").show();
			}
			else {
				$(".abs_top_menu_info").find("input[type='text'], select").val("");
				$(".abs_top_menu_info").hide();
			}
		});
	});

</script>
<?include "./../footer.php";?>