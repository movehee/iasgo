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
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./post.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<?if(!empty($sid)){?>
				<input type="hidden" name="sid" id="sid" value="<?=$sid?>" />
				<?}?>
				<input type="hidden" name="code" id="code" value="<?=$code?>" />
				<input type="hidden" name="tab" id="tab" value="<?=$tab?>" />

				<input type="hidden" name="category1" id="category1" value="<?=$d['category1']?>" />
				<input type="hidden" name="category2" id="category2" value="<?=$d['category2']?>" />
					<fieldset>
					
						<table class="inputTbl" style="width:790px">
							<colgroup>
								<col style="width: 15%;" />
								<col style="width: 35%;" />
								<col style="width: 15%;" />
								<col style="width: 35%;" />
							</colgroup>
							<tbody>
								<tr>
									<th><label for="">Room</label></th>



									<td><select name="room" id="room">
										<option value="">:: select ::</option>
										<?
										$room_query="SELECT * FROM session_room_tbl WHERE code='".$code."' and del='N' order by orderby asc";
										$room_result=mysqli_query($conn, $room_query);
										while(is_array($room_d = mysqli_fetch_array($room_result))){?>
											<option<?=$d['room']==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['name']?></option>
										<?}?>
									</select></td>
									<th><label for="">Time</label></th>
										<td><select name="time" id="time">
										<option value="">:: select ::</option>
										<?
										$time_query="SELECT * FROM session_time_tbl WHERE code='".$code."' and del='N' and tab='".$tab."' order by sid asc";
										$time_result=mysqli_query($conn, $time_query);
										while(is_array($time_d = mysqli_fetch_array($time_result))){?>
											<option<?=$d['time']==$time_d['sid']?' selected="true"':''?> value="<?=$time_d['sid']?>"><?=$time_d['time']?></option>
										<?}?>
									</select></td>
								</tr>




								<?if($s['chair']){?>
								<tr>
									<th><label for=""><?=$s['chair']?></label></th>
									

									<?if($s['faculty_type']==1){?>
									<?
									$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='chair' and a.session_sid='".$d['sid']."' order by a.sid asc";
									$faculty_result=mysqli_query($conn, $faculty_query);
									
									$chair="";
									$i = 0;
									while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
										if($i!=0){
											$chair = $chair . ", ";
										}

										$chair .= $faculty_d['name'];
										$i++;
									}
									?>
										<td colspan='3'><input style="width:680px" type="text" name="chair" id="chair" onchange="changeVal2(this,'chair','<?=$d['sid']?>')" value="<?=htmlspecialchars($chair)?>" /></td>
										
									<?}else{?>
										<td><input type="text" name="chair" id="chair"  value="<?=htmlspecialchars($d['chair'])?>" /></td>
									<?}?>
										
									
									
								</tr>
								<?}?>

								<?if($s['panel']){?>
								<tr>
									<th><label for=""><?=$s['panel']?></label></th>

									<?if($s['faculty_type']==1){?>
									<?
									$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='panel' and a.session_sid='".$d['sid']."' order by a.sid asc";
									$faculty_result=mysqli_query($conn, $faculty_query);
									
									$chair="";
									$i = 0;
									while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
										if($i!=0){
											$chair = $chair . ", ";
										}

										$chair .= $faculty_d['name'];
										$i++;
									}
									?>
										<td colspan='3'><input style="width:680px" type="text" name="panel" id="panel" onchange="changeVal2(this,'panel','<?=$d['sid']?>')" value="<?=htmlspecialchars($chair)?>" /></td>
										
									<?}else{?>
										<td><input type="text" name="panel" id="panel"  value="<?=htmlspecialchars($d['panel'])?>" /></td>
									<?}?>


								</tr>
								<?}?>


								<?if($s['discusser']){?>
								<tr>
									<th><label for=""><?=$s['discusser']?></label></th>

									<?if($s['faculty_type']==1){?>
									<?
									$faculty_query="SELECT b.name FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='discusser' and a.session_sid='".$d['sid']."' order by a.sid asc";
									$faculty_result=mysqli_query($conn, $faculty_query);
									
									$chair="";
									$i = 0;
									while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
										if($i!=0){
											$chair = $chair . ", ";
										}

										$chair .= $faculty_d['name'];
										$i++;
									}
									?>
										<td colspan='3'><input style="width:680px" type="text" name="discusser" id="discusser" onchange="changeVal2(this,'discusser','<?=$d['sid']?>')" value="<?=htmlspecialchars($chair)?>" /></td>
										
									<?}else{?>
										<td><input type="text" name="discusser" id="discusser"  value="<?=htmlspecialchars($d['discusser'])?>" /></td>
									<?}?>

								</tr>
								<?}?>

								<?if($s['theme']=="Y"){?>
								<tr>
									<th><label for="">Theme</label></th>
									<td colspan='3'><input style="width:680px" type="text" name="theme" id="theme"  value="<?=htmlspecialchars($d['theme'])?>" /></td>
								</tr>
								<?}?>

								<?if($s['sub_theme']=="Y"){?>
								<tr>
									<th><label for="">sub_theme</label></th>
									<td colspan='3'><input style="width:680px" type="text" name="sub_theme" id="sub_theme"  value="<?=htmlspecialchars($d['sub_theme'])?>" /></td>
								</tr>
								<?}?>

								

								<tr>
									<th><label for="">program View</label></th>
									<td><select name="viewYN" id="viewYN">
									<option <?if($d['viewYN']=="Y"){?>selected<?}?> value="Y">보임</option>
									<option <?if($d['viewYN']=="N"){?>selected<?}?> value="N">안보임</option>
									</select></td>
						
									<th><label for="">glance View</label></th>
									<td><select name="viewYN2" id="viewYN2">
									<option <?if($d['viewYN2']=="Y"){?>selected<?}?> value="Y">보임</option>
									<option <?if($d['viewYN2']=="N"){?>selected<?}?> value="N">안보임</option>
									</select></td>
								</tr>

								<tr>
									<th><label for="">Session Score View</label></th>
									<td><select name="sc_viewYN" id="sc_viewYN">
									<option <?if($d['sc_viewYN']=="Y"){?>selected<?}?> value="Y">보임</option>
									<option <?if($d['sc_viewYN']=="N"){?>selected<?}?> value="N">안보임</option>
									</select></td>

									<th><label for="">Q&A View</label></th>
									<td><select name="qna_viewYN" id="qna_viewYN">
									<option <?if($d['qna_viewYN']=="Y"){?>selected<?}?> value="Y">보임</option>
									<option <?if($d['qna_viewYN']=="N"){?>selected<?}?> value="N">안보임</option>
									</select></td>
								</tr>


								<tr>
									<th><label for="">highlight</label></th>
									<td><select name="highlight" id="highlight">
									<option <?if($d['highlight']=="0"){?>selected<?}?> value="0">N</option>
									<option <?if($d['highlight']=="1"){?>selected<?}?> value="1">Y</option>
									</select></td>
									<th><label for="">연동</label></th>

									<td><select name="link_session" id="link_session">
										<option value="">:: select ::</option>
										<?
										$room_query="SELECT a.* FROM session_tbl a, session_tbl b WHERE a.code='".$code."' and a.sid=b.link_session and a.type='1' and b.type='2' group by a.sid";
										$room_result=mysqli_query($conn, $room_query);
										while(is_array($room_d = mysqli_fetch_array($room_result))){?>
											<option<?=$d['link_session']==$room_d['sid']?' selected="true"':''?> value="<?=$room_d['sid']?>"><?=$room_d['theme']?></option>
										<?}?>
									</select></td>

								</tr>
								<tr>
									<th><label for="">highlight Image</label></th>

									<td colspan='3'><input style="width:405px" type="file" name="highlight_image" id="highlight_image"/>
									<?if($d['highlight_image']){?>
									<a onclick="javascript:del_file('highlight_image','<?=$d['sid']?>')">파일삭제</a><?}?>
									</td>
								</tr>
								<?if(is_array($_SET['etc_info'])){?>
								<tr>
									<th>기타 카테고리</th>
									<td colspan="3">
									<?
									$etc_info_arr = explode("|", $d['etc_info']);
									if(!is_array($etc_info_arr)) $etc_info_arr = array();
									?>
									<?foreach($_SET['etc_info'] as $key => $val){?>
									<input type="checkbox" name="etc_info[]" id="etc_info<?=$key?>" value="<?=$key?>" <?if(in_array($key, $etc_info_arr)){?>checked<?}?> /><label for="etc_info<?=$key?>"><?=$val?></label>
									<?}?>
									</td>
								</tr>
								<?}?>


								<tr>
									<th><label for="">Live</label></th>
									<td colspan="3"><select name="liveYN" id="liveYN">
									<option <?if($d['liveYN']=="N"){?>selected<?}?> value="N">미사용</option>
									<option <?if($d['liveYN']=="Y"){?>selected<?}?> value="Y">사용</option>				
									</select></td>
								</tr>
								<tr>
									<th><label for="">Live URL (android)</label></th>
									<td>
										<input type="text" name="live_url_and" value="<?=$d['live_url_and']?>">
									</td>
									<th><label for="">Live URL (ios)</label></th>
									<td>
										<input type="text" name="live_url_ios" value="<?=$d['live_url_ios']?>">
									</td>
								</tr>

								<tr>
									<th><label for="">메모</label></th>
									<td colspan='3'> <textarea name="memo" id="memo" style="width:680px;height:100px"><?=$d['memo']?></textarea></td>
								
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

	function changeVal2(val,info,sid) {

		$.ajax({
			type:"POST",
			url:"./update_session2.php",
			data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
			success:function(msg){
				if(msg){
					alert(msg+"님이 Faculty에 등록되어있지 않습니다.");
					location.reload();
				}
			},error : function(request, status, error ) { 
				alert("입력실패 : " + val.value);
			
			}
		});
	}

</script>
<?include "./../footer.php";?>