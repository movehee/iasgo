<?include "./../header2.php";

	$query="SELECT * FROM session_set_tbl where code='".$code."' ";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);


	$reg_query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N'";
	$reg_result = mysqli_query($conn, $reg_query);


	if($d['pre_regist_sdate']){
		$pre_regist_sdate= date("Y-m-d",$d['pre_regist_sdate']);
	}

	if($d['pre_regist_edate']){
		$pre_regist_edate= date("Y-m-d",$d['pre_regist_edate']);
	}



?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Setting</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./reg_set_post.php" method="post"> 
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
									<th><label for="" class="tooltipPoint" title="사용자 등록 페이지 상단에 직접html코드 삽입 가능 (상단 로고 등 사용) ">상단 html소스 직접추가</label></th>
									<td colspan='3'><textarea name="regist_top_text" id="regist_top_text"><?=$d['regist_top_text']?></textarea></td>
								</tr>

								<tr>
									<th><label for="" class="tooltipPoint" title="등록완료 후 보여질 얼alert 창 문구내용">완료문구</label></th>
									<td colspan='3'><textarea name="regist_alert_message" id="regist_alert_message"><?=$d['regist_alert_message']?></textarea></td>
								</tr>

								<tr>
								<td colspan="4">등록항목 관리에 셋팅된 내용중 검색 영역, 소속, 우편번호 등 구분값이나 특정 기능이 필요한 것들 셋팅<br/>(개발단에서 추가적으로 검색항목이나 기능이 필요할 경우 이곳에 추가되어야 함)</td>
								</tr>
								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint" title="금액 통계시에 사용/해당부분 설정안되어있으면 금액 통계 안됨/등록항목 관리에서 항목 설정해야함">금액</label></th>

									<td><select name="reg_money" id="reg_money">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_money']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>

									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"  title="결제방법 검색 조회시 사용 / 등록항목 관리에서 항목 설정해야함">결제방법</label></th>

									<td><select name="reg_money_gubun" id="reg_money_gubun">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_money_gubun']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
								</tr>
								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"   title="">이름(국문)</label></th>

									<td><select name="reg_name" id="reg_name">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_name']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>

									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"   title="">이름(영문)</label></th>

									<td><select name="reg_name_en" id="reg_name_en">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_name_en']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
								</tr>
								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"   title=" 셋팅할 경우 소속 자동입력 기능 사용 ">소속(국문)</label></th>

									<td><select name="reg_office" id="reg_office">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_office']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"   title=" 셋팅할 경우 소속 자동입력 기능 사용 ">소속(영문)</label></th>

									<td><select name="reg_office_en" id="reg_office_en">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_office_en']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint" title="vip 구분있을 경우 검색 조회 가능/등록항목관리에서 셋팅해야함(셋팅 안하면 vip조회 안됨)">VIP구분</label></th>

									<td><select name="reg_vip" id="reg_vip">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_vip']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>

									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint"  title="셋팅 할 경우 우편번호 찾기 기능 사용">우편번호</label></th>

									<td><select name="reg_office_post" id="reg_office_post">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_office_post']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									

								</tr>

								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint" title="">휴대폰번호</label></th>

									<td><select name="reg_hp" id="reg_hp">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_hp']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint" title="">면허번호</label></th>

									<td><select name="reg_license" id="reg_license">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_license']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									

								</tr>


								<tr>
									<th style="background-color: #ffe0de;" ><label for="" class="tooltipPoint" title="">회원구분</label></th>

									<td><select name="reg_mem_gubun" id="reg_mem_gubun">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['reg_mem_gubun']==$reg_d['sid']?' selected="true"':''?> value="<?=$reg_d['sid']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									
									<td></td>
									<td></td>
								</tr>



								<tr>
									<th style="background-color: #fff9c0;"><label for="" class="tooltipPoint"   title="">사전등록<BR>시작일</label></th>
									<td><input style="width:230px" type="text" name="pre_regist_sdate" id="eventdate" readonly value="<?=$pre_regist_sdate?>" /></td>
									<th style="background-color: #fff9c0;" ><label for="" class="tooltipPoint"  title="">사전등록<BR>종료일</label></th>
									<td><input style="width:230px" type="text" name="pre_regist_edate" id="eventdate2" readonly value="<?=$pre_regist_edate?>" /></td>
								</tr>

								<tr>
								<td colspan="4"> 사용자등록용 화면에서 금액 선택 을 위해 셋팅 해야함 / money 에서 설정한 금액이 보여짐 <br/>ex전문의, 전공의, 간호사 등 회원구분에 따라 금액이 다를 경우 금액구분1을 회원구분 으로 선택 / 세부 항목으로 또 금액이 나뉠 경우 금액설정 2~3에 셋팅함 / 이 항목들은 등록항목관리 에서 셋팅 해야함 </td>
								</tr>
								<tr>
									<th style="background-color: #c8e4fb;" ><label for="" class="tooltipPoint"  title="">금액설정1</label></th>
									<td><select name="regist_money_type1" id="regist_money_type1">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['regist_money_type1']==$reg_d['type']?' selected="true"':''?> value="<?=$reg_d['type']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
									<th style="background-color: #c8e4fb;"><label for="" class="tooltipPoint"  title="">금액설정2</label></th>
									<td><select name="regist_money_type2" id="regist_money_type2">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['regist_money_type2']==$reg_d['type']?' selected="true"':''?> value="<?=$reg_d['type']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
									</select></td>
								</tr>

								<tr>
									<th style="background-color: #c8e4fb;"><label for="" class="tooltipPoint"   title="">금액설정3</label></th>
									<td><select name="regist_money_type3" id="regist_money_type3">
										<option value="">:: select ::</option>
										<?
										while(is_array($reg_d = mysqli_fetch_array($reg_result))){?>
											<option<?=$d['regist_money_type3']==$reg_d['type']?' selected="true"':''?> value="<?=$reg_d['type']?>"><?=$reg_d['info']?></option>
										<?}
										mysqli_data_seek($reg_result,0); 
										?>
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
		$('#eventdate2').datepicker({dateFormat:"yy-mm-dd"});
	});

</script>
<?include "./../footer.php";?>