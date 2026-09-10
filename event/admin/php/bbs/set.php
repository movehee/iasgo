<?include "./../header2.php";

	$query="SELECT * FROM event_tbl where code='".$code."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>세팅</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./set_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> <br /> 
				<input type="hidden" name="oldPushCode" id="oldPushCode" value="<?=$d['pushcode']?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label for="" title="쌓아가는 앱 일경우 푸시코드 입력해야함 이거 입력된 상태에서는 앱 배포 전 테스트버전이여도, 테스트여부 N으로 설정 후 푸시테스트 할 경우 해당 푸시코드 입력된 모든앱에 발송됨">PushCode</label></th>
									<td><input style="width:205px" type="text" name="push_code" id="push_code"  value="<?=$d['pushcode']?>" /></td>
								</tr>
								<tr>
									<th><label for="">android_key</label></th>
									<td><input style="width:205px" type="text" name="android_key" id="android_key"  value="<?=$d['android_key']?>" /></td>
								</tr>
								<tr>
									<th><label for="">IOS_key</label></th>
									<td><input style="width:205px" type="text" name="ios_key" id="ios_key"  value="<?=$d['ios_key']?>" /></td>
								</tr>

								<tr>
									<th><label for="">작성자</label></th>
									<td><input style="width:205px" type="text" name="bbs_name" id="bbs_name"  value="<?=$d['bbs_name']?>" /></td>
								</tr>
								
								<tr>
									<th><label for="">테스트 Token</label></th>
									<td><input style="width:205px" type="text" name="test_token1" id="test_token1"  value="<?=$d['test_token1']?>" /></td>
								</tr>

								<tr>
									<th><label for="">테스트 Token</label></th>
									<td><input style="width:205px" type="text" name="test_token2" id="test_token2"  value="<?=$d['test_token2']?>" /></td>
								</tr>

								<tr>
									<th><label for="">테스트여부</label></th>
									<td>
									<select name="testYN" id="testYN">
									<option <?if($d['testYN']=="Y"){?>selected<?}?> value="Y">Y</option>
									<option <?if($d['testYN']=="N"){?>selected<?}?> value="N">N</option>
									</select>
									</td>
								</tr>

								<tr>
									<th><label for="">Push Title<br>미입력시 해당글 제목</label></th>
									<td><input style="width:205px" type="text" name="push_title" id="push_title"  value="<?=$d['push_title']?>" /></td>
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