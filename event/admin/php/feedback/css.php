<?include "./../header2.php";


	$query="SELECT * FROM css_tbl where code='".$_COOKIE['code']."'";
	$result=$conn->query($query);
	$d=$result->fetchRow(DB_FETCHMODE_ASSOC);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>CSS 관리</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./css_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
								<tr>
									<th><label for="">질문번호 BG</label></th>
									<td><input style="width:205px" type="text" name="feedback_bg_bold" id="feedback_bg_bold"  value="<?=$d['feedback_bg_bold']?>" /></td>
								</tr>
								<tr>
									<th><label for="">질문번호 font</label></th>
									<td><input style="width:205px" type="text" name="feedback_font_bold" id="feedback_font_bold"  value="<?=$d['feedback_font_bold']?>" /></td>
								</tr>

								<tr>
									<th><label for="">질문타이틀 BG</label></th>
									<td><input style="width:205px" type="text" name="feedback_bg" id="feedback_bg"  value="<?=$d['feedback_bg']?>" /></td>
								</tr>
								<tr>
									<th><label for="">질문타이틀 font</label></th>
									<td><input style="width:205px" type="text" name="feedback_font" id="feedback_font"  value="<?=$d['feedback_font']?>" /></td>
								</tr>

								<tr>
									<th><label for="">버튼 BG</label></th>
									<td><input style="width:205px" type="text" name="feedback_btn" id="feedback_btn"  value="<?=$d['feedback_btn']?>" /></td>
								</tr>
								<tr>
									<th><label for="">버튼 font</label></th>
									<td><input style="width:205px" type="text" name="feedback_btn_font" id="feedback_btn_font"  value="<?=$d['feedback_btn_font']?>" /></td>
								</tr>

								<tr>
									<th><label for="">텍스트</label></th>
									<td><input style="width:205px" type="text" name="feedback_font2" id="feedback_font2"  value="<?=$d['feedback_font2']?>" /></td>
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