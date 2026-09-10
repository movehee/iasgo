<?include "./../header2.php";

	$query="SELECT * FROM session_room_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>Room 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./room_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
				<input type="hidden" name="tab" id="tab" value="<?=$tab?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
								
								<tr>
									<th class="tooltipPoint" title="프로그램에 보여질 룸 이름을 등록해 주세요"><label for="">룸이름</label></th>
									<td><input style="width:205px" type="text" name="name" id="name"  value="<?=$d['name']?>" /></td>
								</tr>
								<tr>
									<th class="tooltipPoint" title="룸별 도면이 있을경우 업로드 해 주세요 /  앱에서 해당 룸을 누르면 도면이 보여집니다."><label for="">Image</label></th>
									<td><input style="width:205px" type="file" name="photo" id="photo"/></td>
								</tr>
								<tr>
									<th class="tooltipPoint" title="룸 합칠 경우 사용 / add_room에는 첫번째 룸이름을 선택, add_cnt에는 합쳐지는 룸의 수를 입력하시면 됩니다.(Glance에 표현에 필요) -> ex) ROOM A+B+C의 경우 add_room=ROOM A add_cnt= 3 / Glance에 Room D 이지만 Room A와 같은 열에 표현을 원할 경우 add_room에 Room A add_cnt에 1을 입력해주세요 / Room 표시 폰트 컬러 및 사이즈 수정은 css > glance Room 에서 가능합니다."><label for="">add_room</label></th>
									<td><select name="add_room" id="add_room">
									<option 
									<?if($d['add_room']=="0"){?>selected<?}?> value="0">없음</option>
									<?
										$room_query="SELECT * FROM session_room_tbl WHERE code='".$code."' and tab='".$tab."' and del='N' order by orderby asc";
										$room_result=mysqli_query($conn, $room_query);
										while(is_array($room_d = mysqli_fetch_array($room_result))){?>
											<option<?=$d['add_room']==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['name']?></option>
										<?}?>
								</tr>
								<tr>
									<th class="tooltipPoint" title="add_room에 선택 하합치는 룸 수를 입력해 주세요 / ex) ROOM A+B+C의 경우 add_room=ROOM A add_cnt= 3입력"><label for="">add_cnt</label></th>
									<td><input style="width:205px" type="text" name="add_cnt" id="add_cnt"  value="<?=$d['add_cnt']?>" /></td>
								</tr>

								<tr>
									<th class="tooltipPoint" title="Room 지정은 하지만, 프로그램에서 룸을 표시하지 않을 경우 사용여부를 미사용으로 변경해 주세요 / ex) 룸 한개에서 진행할 경우 사용 / setting > 프로그램 상단 추가 (직접소스코딩) 부분에 룸 정보 표시 / (룸 하나인데 프로그램마다 룸 정보 표시하고 싶지 않을 경우 사용)/room표시 border 사용여부 체크"><label for="">View YN</label></th>

									<td>
										<select name="viewYN" id="viewYN" style="width:60px;">
										<option <?if($d['viewYN']=="Y"){?>selected<?}?> value="Y">사용</option>
										<option <?if($d['viewYN']=="N"){?>selected<?}?> value="N">미사용</option>
										</select>

										<select name="view_type" id="view_type" style="width:120px" >
										<option <?if($d['view_type']=="1"){?>selected<?}?> value="1">Border(o)</option>
										<option <?if($d['view_type']=="2"){?>selected<?}?> value="2">Border(x)</option>
										</select>
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


<?include "./../footer.php";?>