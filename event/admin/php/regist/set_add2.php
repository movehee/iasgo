<?include "./../header2.php";

if(!empty($sid))
{
	$query="SELECT * FROM agenda_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
} 	
?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>Agenda 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./agenda_post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" /><br /> 
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" /><br /> 
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:340px">
							<colgroup>
								<col style="width: 30%;" />
								<col style="width: 70%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label for="">순서</label></th>
									<td><select name="day" id="day">
									<? for($i=1;$i<6;$i++){?>
										<option <?if($day==$i){?>selected<?}?> value="<?=$i?>"><?=$i?></option>
									<?}?>
									</select></td>
								</tr>
								
								<tr>
									<th><label for="">행사일</label></th>
									<td><input style="width:205px" type="text" name="eventdate" id="eventdate" readonly  value="<?if($d['eventdate']){?><?=date("y-m-d",$d['eventdate'])?><?}?>" /></td>
								</tr>
								<tr>
									<th><label for="">이름</label></th>
									<td><input style="width:205px" type="text" name="name" id="name"  value="<?=$d['name']?>" /></td>
								</tr>
								<tr>
									<th><label for="">Image</label></th>
									<td><input style="width:205px" type="file" name="image" id="image"/></td>
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