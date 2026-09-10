<?include "./../header2.php";

	$query="SELECT * FROM abstract_category_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);

?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>Category 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./category_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								
							
								<tr>
									<th><label for="">name</label></th>
									<td><input style="width:205px" type="text" name="info" id="info"  value="<?=$d['info']?>" /></td>
								</tr>
								<tr>
									<th><label for="">Color</label></th>
									<td><input style="width:205px" type="text" name="color" id="color"  value="<?=$d['color']?>" /></td>
								</tr>

								
								<tr>
									<th><label for="">parent</label></th>
									<td><select name="parent" id="parent">
									<option 
									<?if($d['parent']=="0"){?>selected<?}?> value="0">없음</option>
									<?
										$room_query="SELECT * FROM abstract_category_tbl WHERE code='".$code."' order by orderby asc";
										$room_result=mysqli_query($conn, $room_query);
										while(is_array($room_d = mysqli_fetch_array($room_result))){?>
											<option<?=$d['add_room']==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['info']?></option>
										<?}?>
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