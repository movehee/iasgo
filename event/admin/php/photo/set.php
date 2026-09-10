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
							
								<tr>
									<th style="background-color:#bbccee"><label for="">정렬방식</label></th>
									<td><select name="photo_order" id="photo_order">
									<option <?if($d['photo_order']=="1"){?>selected<?}?> value="1">시간순</option>
									<option <?if($d['photo_order']=="2"){?>selected<?}?> value="2">좋아요 우선</option>
									</select></td>

									<th style="background-color:#bbccee"><label for="">View</label></th>
									<td><select name="photo_type" id="photo_type">
									<option <?if($d['photo_type']=="1"){?>selected<?}?> value="1">기본</option>
									<option <?if($d['photo_type']=="2"){?>selected<?}?> value="2">크고작고작고작고작고...</option>
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
	});

</script>
<?include "./../footer.php";?>