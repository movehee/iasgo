<?include "./../header2.php";
$day = 1;
$d=null;
if(!empty($sid))
{
	$query="SELECT * FROM agenda_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
	$day = $d['day'];
} 	
?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Agenda 등록</h2>

			<div class="conArea" style="width:700px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./agenda_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:700px">
							<colgroup>
								<col style="width: 15%;" />
								<col style="width: 35%;" />
								<col style="width: 15%;" />
								<col style="width: 35%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label class="tooltipPoint" title="순서는 행사일 또는 탭에 보여지는 순서로 입력 / ex) 3일짜리 행사일 경우 : day1_5월24일 (순서1) , day1_5월25일 (순서2), day1_5월26일 (순서3) 로 입력해야 제대로 보여짐" for="">순서</label></th>
									<td><select name="day" id="day">
									<? for($i=1;$i<6;$i++){?>
										<option <?if($day==$i){?>selected<?}?> value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select></td>
							
									<th><label class="tooltipPoint" title="행사일은 NOW 기능, Program 눌렀을때 해당날짜로 자동 이동 되는 중요한 정보"  for="">행사일</label></th>
									<td><input style="width:205px" type="text" name="eventdate" id="eventdate" readonly  value="<?if($d['eventdate']){?><?=date("y-m-d",$d['eventdate'])?><?}?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="탭, 프로그램 메뉴 등에 보여질 이름 / 예) day1 ,2019.05.06 등 "  for="">이름</label></th>
									<td><input style="width:205px" type="text" name="name" id="name"  value="<?=$d['name']?>" /></td>
							
									<th><label class="tooltipPoint" title="아젠다를 세션이 아닌 이미지로 사용할 경우 이미지 추가"  for="">Agenda<br/> 이미지</label></th>
									<td><input style="width:205px" type="file" name="image" id="image"/>

									<?if($d['image']){?>
									<a class="inputBtndel" onclick="javascript:del_file('image','<?=$d['sid']?>')">사진삭제</a><?}?>

									</td>
								</tr>

								<tr>
									<th><label class="tooltipPoint" title="출결 시작시간"  for="">시작시간</label></th>
									<td><input style="width:205px" type="text" name="start_time" id="start_time"  value="<?=$d['start_time']?>" /></td>
								
									<th><label class="tooltipPoint" title="출결 종료시간"  for="">종료시간</label></th>
									<td><input style="width:205px" type="text" name="end_time" id="end_time"  value="<?=$d['end_time']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="최대 평점"  for="">최대평점</label></th>
									<td><input style="width:205px" type="text" name="score" id="score"  value="<?=$d['score']?>" /></td>
							
									<th><label class="tooltipPoint" title="출결에서 쉬는시간 제외할 경우 입력"  for="">쉬는시간1</label></th>
									<td><input style="width:205px" type="text" name="break_time1" id="break_time1"  value="<?=$d['break_time1']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="출결에서 쉬는시간 제외할 경우 입력"  for="">쉬는시간2</label></th>
									<td><input style="width:205px" type="text" name="break_time2" id="break_time2"  value="<?=$d['break_time2']?>" /></td>
							
									<th><label class="tooltipPoint" title="출결에서 쉬는시간 제외할 경우 입력"  for="">쉬는시간3</label></th>
									<td><input style="width:205px" type="text" name="break_time3" id="break_time3"  value="<?=$d['break_time3']?>" /></td>
								</tr>
								<tr>
									<th><label class="tooltipPoint" title="출결에서 쉬는시간 제외할 경우 입력"  for="">쉬는시간4</label></th>
									<td><input style="width:205px" type="text" name="break_time4" id="break_time4"  value="<?=$d['break_time4']?>" /></td>
							
									<th><label class="tooltipPoint" title="출결에서 쉬는시간 제외할 경우 입력"  for="">쉬는시간5</label></th>
									<td><input style="width:205px" type="text" name="break_time5" id="break_time5"  value="<?=$d['break_time5']?>" /></td>
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