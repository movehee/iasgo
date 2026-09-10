<?include "./../header2.php";


	$query="SELECT * FROM css_tbl where code='".$code."'";
	$result=$conn->query($query);
	$d=$result->fetchRow(DB_FETCHMODE_ASSOC);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>CSS 관리</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./css_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
				
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
								<tr>
									<th><label for="">agenda_bg</label></th>
									<td><input style="width:205px" type="text" name="agenda_bg" id="agenda_bg"  value="<?=$d['agenda_bg']?>" /></td>
								</tr>
								<tr>
									<th><label for="">agenda_bg_on</label></th>
									<td><input style="width:205px" type="text" name="agenda_bg_on" id="agenda_bg_on"  value="<?=$d['agenda_bg_on']?>" /></td>
								</tr>
								<tr>
									<th><label for="">agenda_font</label></th>
									<td><input style="width:205px" type="text" name="agenda_font" id="agenda_font"  value="<?=$d['agenda_font']?>" /></td>
								</tr>
								<tr>
									<th><label for="">agenda_font_on</label></th>
									<td><input style="width:205px" type="text" name="agenda_font_on" id="agenda_font_on"  value="<?=$d['agenda_font_on']?>" /></td>
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