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
							<!-- 
								<tr>
									<th><label class="tooltipPoint" title="" for="">모든 설문 참여(서술형 제외)</label></th>
									<td><select name="feedback_all_chk" id="feedback_all_chk">
									<option <?if($d['feedback_all_chk']=="0"){?>selected<?}?> value="0">미사용</option>
									<option <?if($d['feedback_all_chk']=="1"){?>selected<?}?> value="1">사용</option>
									</select></td>
							
							
								</tr> -->
								<tr>
									<th><label class="tooltipPoint" title="피드백 페이지를 특정 날짜 이상되면 노출하지 않을 경우 사용 (피드백 종료 이미지 보여짐) "  for="">Feedback 종료일</label></th>

									<td><input style="width:205px" type="text" name="feedback_end_time" id="feedback_end_time" readonly  value="<?if($d['feedback_end_time']>0){?><?=date("y-m-d",$d['feedback_end_time'])?><?}?>" /> <a class="inputBtndel" onclick="javascript:end_reset()">초기화</a></td>
								

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
		$('#feedback_end_time').datepicker({dateFormat:"yy-mm-dd"});
	});


	function end_reset(){
		document.getElementById('feedback_end_time').value="";
	}

</script>
<?include "./../footer.php";?>