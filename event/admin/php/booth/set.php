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
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 메뉴 상단 html 직접소스 추가" >Sponsor<br>상단 추가</label></th>
									<td colspan='3'><textarea name="sponsor_top_text" id="sponsor_top_text"><?=$d['sponsor_top_text']?></textarea></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 메뉴 하단 html 직접소스 추가" >Sponsor<br>하단 추가</label></th>
									<td colspan='3'><textarea name="sponsor_bottom_text" id="sponsor_bottom_text"><?=$d['sponsor_bottom_text']?></textarea></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="부스 메뉴 상단 html 직접소스 추가"  >Booth<br>상단 추가</label></th>
									<td colspan='3'><textarea name="booth_top_text" id="booth_top_text"><?=$d['booth_top_text']?></textarea></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="부스 메뉴 하단 html 직접소스 추가" >Booth<br>하단 추가</label></th>
									<td colspan='3'><textarea name="booth_bottom_text" id="booth_bottom_text"><?=$d['booth_bottom_text']?></textarea></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="부스메뉴 탭에 보여질 문구 입력/예) 부스, Booth등" >부스</label></th>
									<td><input style="width:205px" type="text" name="booth_txt" id="booth_txt"  value="<?=$d['booth_txt']?>" /></td>

									<th><label for="" class="tooltipPoint btnDef" title="스폰서 탭에 보여질 문구 입력/예) 스폰서, Sponsor등" >스폰서</label></th>
									<td><input style="width:205px" type="text" name="sponsor_txt" id="sponsor_txt"  value="<?=$d['sponsor_txt']?>" /></td>
								</tr>


								<?for($i=1;$i<=8;$i++){?>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" ><?=$i?>등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info<?=$i?>" id="vip_info<?=$i?>"  value="<?=$d['vip_info'.$i]?>" maxlength="30" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width<?=$i?>" id="vip_width<?=$i?>"  value="<?=$d['vip_width'.$i]?>" maxlength="10" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color<?=$i?>" id="vip_color<?=$i?>"  value="<?=$d['vip_color'.$i]?>" maxlength="10" /></td>
								</tr>

								<?}?>
									<!--
								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >1등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info1" id="vip_info1"  value="<?=$d['vip_info1']?>" maxlength="30" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width1" id="vip_width1"  value="<?=$d['vip_width1']?>" maxlength="10" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color1" id="vip_color1"  value="<?=$d['vip_color1']?>" maxlength="10" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >2등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info2" id="vip_info2"  value="<?=$d['vip_info2']?>" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width2" id="vip_width2"  value="<?=$d['vip_width2']?>" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color2" id="vip_color2"  value="<?=$d['vip_color2']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >3등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info3" id="vip_info3"  value="<?=$d['vip_info3']?>" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width3" id="vip_width3"  value="<?=$d['vip_width3']?>" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color3" id="vip_color3"  value="<?=$d['vip_color3']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >4등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info4" id="vip_info4"  value="<?=$d['vip_info4']?>" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width4" id="vip_width4"  value="<?=$d['vip_width4']?>" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color4" id="vip_color4"  value="<?=$d['vip_color4']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >5등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info5" id="vip_info5"  value="<?=$d['vip_info5']?>" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width5" id="vip_width5"  value="<?=$d['vip_width5']?>" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color5" id="vip_color5"  value="<?=$d['vip_color5']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서 등급 구분(명칭, 해당 당급의 로고 노출 width값 예)Diamond, Platinum등" >6등급</label></th>
									<td>info<br><input style="width:205px" type="text" name="vip_info6" id="vip_info6"  value="<?=$d['vip_info6']?>" /></td>

									<td>width(%)<br><input style="width:130px" type="text" name="vip_width6" id="vip_width6"  value="<?=$d['vip_width6']?>" /></td>

									<td>color(%)<br><input style="width:205px" type="text" name="vip_color6" id="vip_color6"  value="<?=$d['vip_color6']?>" /></td>
								</tr>

								-->

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="스폰서UI타입 설정 / type1 : 기본 등급구분 / type2 : 한줄당 한개씩 정렬 / type3 : 부스번호, 스폰서설명 등 " >UI_type1</label></th>

									<td><select name="booth_ui_type" id="booth_ui_type">
									<option <?if($d['booth_ui_type']=="1"){?>selected<?}?> value="1">type1</option>
									<option <?if($d['booth_ui_type']=="2"){?>selected<?}?> value="2">type2</option>
									<option <?if($d['booth_ui_type']=="3"){?>selected<?}?> value="3">type3</option>
									</select></td>

									<th><label for="" class="tooltipPoint btnDef" title="" >UI_type2</label></th>

									<td><select name="booth_ui_type2" id="booth_ui_type2">
									<option <?if($d['booth_ui_type2']=="1"){?>selected<?}?> value="1">type1</option>
									<option <?if($d['booth_ui_type2']=="2"){?>selected<?}?> value="2">type2</option>
									</select></td>
									
									
									
								</tr>

								


								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="부스이벤트 할 경우 부스이벤트 조건 예)30개 이상 방문해야 조건성립 될 경우 30입력" >부스 이벤트 수</label></th>
									<td><input style="width:205px" type="text" name="booth_event_cnt" id="booth_event_cnt"  value="<?=$d['booth_event_cnt']?>" /></td>

									<th><label for="" class="tooltipPoint btnDef" title="부스이벤트 진행 시 필수조건 수 / 예) 일반부스30개 이상, 필수부스 3개 이상 이여야 조건 성립할 경우 3입력 / 정형외과학회 참조" >부스 VIP 이벤트 수</label></th>
									<td><input style="width:205px" type="text" name="booth_event_cnt2" id="booth_event_cnt2"  value="<?=$d['booth_event_cnt2']?>" /></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint btnDef" title="상단 탭 메뉴 사용여부 (스폰서, 부스)" >상단 탭메뉴</label></th>
									<td><select name="booth_group_YN" id="booth_group_YN">
									<option <?if($d['booth_group_YN']=="1"){?>selected<?}?> value="1">사용</option>
									<option <?if($d['booth_group_YN']=="2"){?>selected<?}?> value="2">미사용</option>
									</select></td>

									<th><label for="" class="tooltipPoint btnDef" title="부스이벤트 진행 시 booth event화면에 부스번호 노출여부" >부스번호 노출여부</label></th>
									<td><select name="booth_event_num_YN" id="booth_event_num_YN">
									<option <?if($d['booth_event_num_YN']=="0"){?>selected<?}?> value="0">미사용</option>
									<option <?if($d['booth_event_num_YN']=="1"){?>selected<?}?> value="1">사용</option>
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
	});

</script>
<?include "./../footer.php";?>