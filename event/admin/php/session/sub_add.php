<?include "./../header2.php";
$day = 1;
$d=null;
if(!empty($sid))
{
	$query="SELECT * FROM session_tbl where sid='".$sid."'";
	$result = mysqli_query($conn, $query);
	$d = mysqli_fetch_array($result);
} 	

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>Session 등록</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./sub_post.php" method="post">
				<!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000000" /> -->
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
				<input type="hidden" name="link_session" id="link_session" value="<?=$session?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:700px">
							<colgroup>
								<col style="width: 15%;" />
								<col style="width: 35%;" />
								<col style="width: 15%;" />
								<col style="width: 35%;" />
							</colgroup>
							<tbody>
							
								<tr>
								<?$cnt=1;?>
									<th><label for="">Time</label></th>
									<td><input style="width:205px" type="text" name="time" id="time"  value="<?=$d['time']?>" /></td>
								


								<!-- <?if($s['speaker']){?>
									<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for=""><?=$s['speaker']?></label></th>
									<td><input style="width:205px" type="text" name="speaker" id="speaker"  value="<?=$d['speaker']?>" /></td>
									<?if($cnt%2==0){?></tr><?}?>
								<?}?> -->
								<?if($d['speaker']){?>
									<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">speaker</label></th>
									<td><input style="width:205px" type="text" name="speaker" id="speaker"  value="<?=$d['speaker']?>" /></td>
									<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								

								<?if($s['title']=="Y"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">title</label></th>
									<td><input style="width:205px" type="text" name="title" id="title"  value="<?=htmlspecialchars($d['title'])?>" /></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['abs_sid']!="N"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">abs_sid</label></th>
									<td><input style="width:205px" type="text" name="abs_sid" id="abs_sid"  value="<?=$d['abs_sid']?>" /></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['abs_no']!="N"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">abs_no</label></th>
									<td><input style="width:205px" type="text" name="abs_no" id="abs_no"  value="<?=$d['abs_no']?>" /></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['abs_info']=="Y"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">abs_info</label></th>
									<td><textarea style="width:205px" name="abs_info" id="abs_info"  value="<?=$d['abs_info']?>"><?=$d['abs_info']?></textarea></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['purpose']=="Y"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">purpose</label></th>
									<td><textarea style="width:205px" type="text" name="purpose" id="purpose"  value="<?=$d['purpose']?>"><?=$d['purpose']?></textarea></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>


								<?if($s['methods']=="Y"){?>
								<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">methods</label></th>
									<td><textarea style="width:205px" type="text" name="methods" id="methods"  value="<?=$d['methods']?>"><?=$d['methods']?></textarea></td>
								<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['results']=="Y"){?>
							<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">results</label></th>
									<td><textarea style="width:205px" type="text" name="results" id="results"  value="<?=$d['results']?>"><?=$d['results']?></textarea></td>
							<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['conclusions']=="Y"){?>
							<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">conclusions</label></th>
									<td><textarea style="width:205px" type="text" name="conclusions" id="conclusions"  value="<?=$d['conclusions']?>"><?=$d['conclusions']?></textarea></td>
						<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								<?if($s['keywords']=="Y"){?>
						<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">keywords</label></th>
									<td><textarea style="width:205px" type="text" name="keywords" id="keywords"  value="<?=$d['keywords']?>"><?=$d['keywords']?></textarea></td>
							<?if($cnt%2==0){?></tr><?}?>
								<?}?>

								
							<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">Lecture File</label></th>
									<td><input style="width:205px" type="file" name="lecture_file" id="lecture_file"/>
									<?if($d['lecture_file']){?>
									<a onclick="javascript:del_file('lecture_file','<?=$d['sid']?>')">파일삭제</a><?}?>
									</td>
							<?if($cnt%2==0){?></tr><?}?>
							
							<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">Abstract File</label></th>
									<td><input style="width:205px" type="file" name="abstract_file" id="abstract_file"/>
									<?if($d['abstract_file']){?>
									<br><?=$d['abstract_file']?><br>

									<a onclick="javascript:del_file('abstract_file','<?=$d['sid']?>')">파일삭제</a><?}?></td>
							<?if($cnt%2==0){?></tr><?}?>

							<?if($s['faculty_type']=="2"){?>
							<?if($cnt%2==0){?><tr><?}?>
									<?$cnt++;?>
									<th><label for="">CV File</label></th>
									<td><input style="width:205px" type="file" name="cv_file" id="cv_file"/>
									<?if($d['cv_file']){?>
									<a onclick="javascript:del_file('cv_file','<?=$d['sid']?>')">파일삭제</a><?}?></td>
							<?if($cnt%2==0){?></tr><?}?>
							<?}?>



							<?if($cnt%2==0){?><tr><?}?>
								<?$cnt++;?>
								<th><label for="" title="Type2 선택시 입력된 time이 있다면 표시된다" class="tooltipPoint">Sub_Session</label></th>

								<td><select name="sub_session" id="sub_session">
									<option <?if($d['sub_session']=="0"){?>selected<?}?> value="0">No</option>
									<option <?if($d['sub_session']=="1"){?>selected<?}?> value="1">Type1</option>
									<option <?if($d['sub_session']=="2"){?>selected<?}?> value="2">Type2</option>
								</select></td>
							<?if($cnt%2==0){?></tr><?}?>
								

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