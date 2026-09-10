<?include "./../header2.php";
$day = 1;
$d=null;
if(!empty($sid))
{
	$query="SELECT * FROM faculty_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
} 	

$query="SELECT * FROM session_set_tbl where code='".$_COOKIE['code']."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


?>
 
<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Faculty 등록</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
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
									<th><label class="tooltipPoint" title="국문이름 입력 / 세션 > setting > 패컬티 노출 타입 국문으로 설정할 경우 해당부분 입력 필수 / 동명이인 일 경우 <!---> 주석표시 / 동명이인 3명 ~ 일 경우 <!--1--> (숫자로 구분) 명수만큼/ " for="">성함(국문)</label></th>
									<td><input style="width:250px" type="text" name="name" id="name"  value="<?=$d['name']?>" /></td>
									<th><label class="tooltipPoint" title="영문이름 입력"  for="">성함(영문)</label></th>
									<td colspan='3'><input style="width:250px" type="text" name="name_en" id="name_en"  value="<?=$d['name_en']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="국문 소속 입력 / 세션 > setting > 패컬티 노출 타입 국문으로 설정할 경우 해당부분 입력 필수 "  for="">소속(국문)</label></th>
									<td colspan='3'><input style="width:650px" type="text" name="office" id="office"  value="<?=$d['office']?>" /></td> 
								</tr>
								<tr>
									<th><label class="tooltipPoint" title=""  for="">소속(영문)</label></th>
									<td colspan='3'><input style="width:650px" type="text" name="office_en" id="office_en"  value="<?=$d['office_en']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title=""  for="">국가</label></th>
									<td colspan='3'><input style="width:650px" type="text" name="country" id="country"  value="<?=$d['country']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title=""  for="">역할</label></th>
									<td colspan='3'><input style="width:650px" type="text" name="role" id="role"  value="<?=$d['role']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="리스트에서 그룹핑에 사용"  for="">그룹구분</label></th>
									<td>
									<!--
									<input style="width:450px" type="text" name="group_gubun" id="group_gubun"  value="<?=$d['group_gubun']?>" />
									<select name="group_gubun_order" style="width:80px">
										<option value="">순서</option>
										<?for($i=1;$i<=20;$i++){?>
											<option value="<?=$i?>" <?if($d['group_gubun_order']==$i)echo"selected";?> ><?=$i?></option>
										<?}?>
									</select>-->
									
									<select style="width:80%" name="group_code">
										<option value="">선택</option>
									<?
										$query_f_group = "select * from faculty_group_tbl where code='$code'";
										$result_f_group = mysqli_query($conn, $query_f_group);
										while($g = mysqli_fetch_array($result_f_group)) {
									?>
										<option value="<?=$g['sid']?>" <?if($d['group_code']==$g['sid']){?>selected<?}?> ><?=$g['orderby']?>. <?=$g['faculty_group_name']?></option>
									
									<?}?>
									</select>
										<span class="btn"><input type="button" onclick="add_group('<?=$code?>')" value="등록" class="btnDef btnSmall" /></span>
									</td>
									<th>
										외국인
									</th>
									<td><select name="foreigner" id="foreigner">
									<option <?if($d['foreigner']=="N"){?>selected<?}?> value="N">No</option>
									<option <?if($d['foreigner']=="Y"){?>selected<?}?> value="Y">Yes</option>
									
									</select></td>
								</tr>
								<tr>
								<th><label class="tooltipPoint" title="앱 패컬티 메뉴에 노출 여부 / Y일 경우에만 App 패컬티 메뉴에 노출됨"  for="">앱 패컬티메뉴 <br/>노출여부</label></th>
									<td><select name="viewYN" id="viewYN">
									<option <?if($d['viewYN']=="Y"){?>selected<?}?> value="Y">노출</option>
									<option <?if($d['viewYN']=="N"){?>selected<?}?> value="N">미노출</option>
									</select></td>
								<th><label class="tooltipPoint" title=""  for="">특별연자</label></th>
									<td><select name="invitedYN" id="invitedYN">
									<option <?if($d['invitedYN']=="N"){?>selected<?}?> value="N">N</option>
									<option <?if($d['invitedYN']=="Y"){?>selected<?}?> value="Y">Y</option>
									</select></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title=""  for="">사진</label></th>
									<td colspan='3'><input style="width:205px" type="file" name="photo" id="photo"/><?if($d['photo']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image','<?=$d['sid']?>')">파일삭제</a><?}?></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="" for="">CV</label></th>
									<td colspan='3'>
									<?if($s['cv_file']=="Y"){?>
									<input style="width:205px" type="file" name="cv_file" id="cv_file"/>
									<?if($d['cv_file']){?>
									<a class="inputBtndel" onclick="javascript:del_file('cv_file','<?=$d['sid']?>')">파일삭제</a><?}?>
									<?}else{?>
									<input style="width:205px" type="text" name="cv_file" id="cv_file"  value="<?=$d['cv_file']?>" />
									<?}?>
									
									
									</td>
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

	function add_group(code) {
		window.open("group_add.php?code="+code,"","width=1230,height=950");
	}

	function del_file(val,sid) {
		if(confirm("삭제하시겠습니까?")){
	
			$.ajax({
				type:"POST",
				url:"./del_file.php",
				data:"sid="+sid+"&val="+val,
				success:function(msg){
					alert(msg);
				}
			});


		}
	}

</script>
<?include "./../footer.php";?>