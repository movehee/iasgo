<?include "./../header2.php";
$max_col = 5;
?>

<div id="container" style="width:400px">
<div class="contents" style="width:400px">
			<h2>시간별 평점 등록</h2>

			<div class="conArea" style="width:400px">
				
				<form name="registform" id="registform" action="./score_post.php" method="post">
				<input type="hidden" name="max_col" value="<?=$max_col?>" />
				<input type="hidden" name="agenda_sid" id="agenda_sid" value="<?=$sid?>" /> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:400px">
							<colgroup>
								<col style="width: 33%;" />
								<col style="width: 33%;" />
								<col style="width: 33%;" />
							</colgroup>
							<tbody>
								<tr>
									<th>시간(H)</th>
									
									<th>기준</th>
									<th>점수</th>
								</tr>
								<?
								$query="SELECT * FROM score_set_tbl where del='N' and code='".$code."' and agenda_sid='".$sid."' order by  time desc";
								$result = mysqli_query($conn, $query);
								if($result->num_rows) {
									while(is_array($d = mysqli_fetch_array($result))) {
								?>
								<tr style="text-align:center;">
									<td><input type="text" name="time[]" style="width:50px;" value="<?=$d['time']?>"> 시간</td>
									
									<td>
										<select name="ine[]">
											<option value="2" <?if($d['ine']=='2'){?>selected<?}?>>초과</option>
											<option value="1" <?if($d['ine']=='1'){?>selected<?}?>>이상</option>
										</select>
									</td>
									<td><input type="text" name="score[]" style="width:50px;" value="<?=$d['score']?>"> 점</td>

								</tr>
								<input type="hidden" name="sid[]" value="<?=$d['sid']?>">
								<?
									$max_col--;
									}
								}

								for($i=1;$i<=$max_col;$i++) {
									
								?>
								<tr style="text-align:center;">
									<td><input type="text" name="time[]" style="width:50px;" > 시간</td>
									
									<td>
										<select name="ine[]">
											<option value="2">초과</option>
											<option value="1">이상</option>
										</select>
									</td>
									<td><input type="text" name="score[]" style="width:50px;" > 점</td>

								</tr>
								<?}?>
							</tbody>
						</table>

						
						<div style="text-align:right">시간 역순으로 등록</div>

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

	function del_file(val,sid) {
		if(confirm("삭제하시겠습니까?")){
	
			$.ajax({
				type:"POST",
				url:"./del_file.php",
				data:"sid="+sid+"&val="+val,
				success:function(msg){
					alert(msg);
				}
			});


		}
	}


</script>
<?include "./../footer.php";?>