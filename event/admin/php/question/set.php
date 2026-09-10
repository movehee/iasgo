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
							<div style="padding: 10px 5px; font-size: 13px; border: 1px solid #999; margin: 10px 0;">행사 시 룸을 구분해서 동시에 Q&A 진행 할 경우아이패드 코드에 해당 룸 번호를 입력해야함 좌장용 / 콘솔용에  같은 코드로 매칭 해야 함<br>
							** 룸 1개 이상 일 경우 동시에 테스트 해봐야함 room sid는 seesion 메뉴 room에서 등록한 room의 sid값을 입력 해야함 Session room부분에 해당 룸의 sid값 표시 <br/>
							ex) room4 room2에서  동시에 진행할경우 236 / 205 각 입력해야함 하루 이상 행사 일 경우 같은 방이어도 room sid값은 달라지므로 필수로 확인 해야함</div>
								<tr>
									<th style="background-color:#aaaaee"><label class="tooltipPoint" for="" title="질문이 들어왔을 경우 좌장석에 바로 보여질지.관리자가 먼저 보고 사용여부로  좌장이 볼 수 있도록 제공할지 선택">기본설정(사용여부)</label></th>
									<td><select name="question_view_YN" id="question_view_YN">
									<option <?if($d['question_view_YN']=="Y"){?>selected<?}?> value="Y">보임</option>
									<option <?if($d['question_view_YN']=="N"){?>selected<?}?> value="N">안보임</option>
									</select></td>
								
								</tr>
								<tr>
									<th style="background-color:#aaaaee"><label class="tooltipPoint" title="학술대회 question 진행 시 강의명,또는 연자명 선택 할 경우 > 아젠다 기준으로 해당 시간만 보일것 인지, 전체 보일것인지 선택 /{해당 시간만} : 아젠다 기준 해당 시간 강의만  노출_ {해당 날짜만} : 아젠다 기준 해당날짜만 / 1일 행사일 경우 : 당일날짜/1일 이상 행사일 경우 : day별 노출" for="">강의명(연자명)노출법</label></th>
									<td><select name="question_lecture_view" id="question_lecture_view">
									<option <?if($d['question_lecture_view']=="1"){?>selected<?}?> value="1">해당 시간만</option>
									<option <?if($d['question_lecture_view']=="2"){?>selected<?}?> value="2">해당 날짜만</option>
									</select></td>
								
								</tr>

							
									

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