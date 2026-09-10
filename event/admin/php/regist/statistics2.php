<?include "./../header2.php";


	$set_query="SELECT * FROM session_set_tbl where code='".$code."' ";
	$set_result = mysqli_query($conn, $set_query);
	$set_d = mysqli_fetch_array($set_result);


	$reg_query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N'";
	$reg_result = mysqli_query($conn, $reg_query);




?>

<div id="container" style="width:800px">
<div class="contents" style="width:800px">
			<h2>통계</h2>

			<div class="conArea" style="width:800px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./reg_set_post.php" method="post"> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:800px">
						<tr><th></th>
						<th>사전등록</th>

							<?
							$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
							while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
								<th><?=$tab_col['name']?></th>
							<?}
							mysqli_data_seek($tab_result,0); 
							?>

						



							<tbody>
							
								<tr>
									<th><label for="">금액</label></th>



									<td>
									<?
										$temp_query = "select * from regist_set_tbl where sid='".$set_d['reg_money']."' and del='N'";
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);
										$info2_type = $temp_d['type'];
							
										$info2 = $temp_d['orderby'];


										$temp_result = mysqli_query($conn, "select type, orderby from regist_set_tbl where sid='".$set_d['reg_money_gubun']."'");
										$temp_d = mysqli_fetch_array($temp_result);
										$info1 = $temp_d['orderby'];

										

										
										$type_sub_query = "select * from regist_type_sub_tbl where type_sid='".$temp_d['type']."'";
										$type_sub_result = mysqli_query($conn, $type_sub_query);
										//echo $type_sub_query;
										
										$tab_col = mysqli_fetch_array($tab_result);
										$event_time = $tab_col['eventdate'];
										mysqli_data_seek($tab_result,0); 
										 
										
										while(is_array($type_sub_d = mysqli_fetch_array($type_sub_result))){

											if($info2_type>1000){

												
												$temp_query = "SELECT sum(b.info) sum FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.info".$info1."='".$type_sub_d['sid']."' and a.del='N' and a.pay_chk='Y' and a.pay_date<".$event_time;
												$temp_result = mysqli_query($conn, $temp_query);
												$temp_d = mysqli_fetch_array($temp_result);

												
											}else{

												$temp_query = "select sum(info".$info2.") sum from regist_tbl where code='".$code."' and info".$info1."='".$type_sub_d['sid']."' and del='N' and pay_chk='Y' and pay_date<".$event_time;
												$temp_result = mysqli_query($conn, $temp_query);
												$temp_d = mysqli_fetch_array($temp_result);
											
											}?>
										<?=$type_sub_d['info']?> : <?=$temp_d['sum']?><br>
										<?}?>

										
									</td>


									<?
									mysqli_data_seek($type_sub_result,0);
									while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
										
								

									<td>
									<?
										while(is_array($type_sub_d = mysqli_fetch_array($type_sub_result))){
											if($info2_type>1000){

												
												$temp_query = "SELECT sum(b.info) sum FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.info".$info1."='".$type_sub_d['sid']."' and a.del='N' and a.pay_chk='Y' and a.pay_date>".$tab_col['eventdate']." and a.pay_date<".($tab_col['eventdate']+86400);
												$temp_result = mysqli_query($conn, $temp_query);
												$temp_d = mysqli_fetch_array($temp_result);

												
											}else{
												$temp_query = "select sum(info".$info2.") sum from regist_tbl where code='".$code."' and info".$info1."='".$type_sub_d['sid']."' and del='N' and pay_chk='Y' and pay_date>".$tab_col['eventdate']." and pay_date<".($tab_col['eventdate']+86400);
												$temp_result = mysqli_query($conn, $temp_query);
												$temp_d = mysqli_fetch_array($temp_result);
											}?>
										<?=$type_sub_d['info']?> : <?=$temp_d['sum']?><br>
										<?}
										mysqli_data_seek($type_sub_result,0);?>
									</td>
									<?}?>
					
								</tr>


								<tr>
									<th><label for="">출결</label></th>
									<td></td>
									

									<?
									mysqli_data_seek($tab_result,0); 
									
									while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
										
								

									<td>
									<?
									
										$temp_query = "select count(*) cnt from regist_tbl where code='".$code."' and del='N' and check_in".$tab_col['day'].">'0'";
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);?>
										<?=$temp_d['cnt']?>
										
									</td>
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

	
<script type="text/javascript">

	$( function(){
		$('#eventdate').datepicker({dateFormat:"yy-mm-dd"});
	});

</script>
<?include "./../footer.php";?>