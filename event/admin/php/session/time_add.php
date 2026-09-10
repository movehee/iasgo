<?include "./../header2.php";

	$query="SELECT * FROM session_time_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>Time 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./time_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
				<input type="hidden" name="tab" id="tab" value="<?=$tab?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
								
								<tr>
									<th class="tooltipPoint" title="프로그램에 보여질 시간을 등록해 주세요"><label for="">시간</label></th>
									<td><input style="width:205px" type="text" name="time" id="time"  value="<?=$d['time']?>" /></td>
								</tr>

								<tr>
									<th  class="tooltipPoint" title=" 보임 여부 는 설정 > setting > glance_time_type 이 시간설정 연동 일 경우 사용 됩니다 ** 등록된 시간 중 시작시간이 동일한것이 여러개 일  경우 종료시간이 첫번째 인 것만 Y로 설정하면 됨 /glance 시간 행의 표현 여부 / "><label for="">보임여부</label></th>
									<td><select name="showYN" id="showYN">
									<option <?if($d['showYN']=="Y"){?>selected<?}?> value="Y">Y</option>

									<option <?if($d['showYN']=="N"){?>selected<?}?> value="N">N</option>

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


<?include "./../footer.php";?>