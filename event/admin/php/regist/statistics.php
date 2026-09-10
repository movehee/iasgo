<?include "./../header2.php";


	$set_query="SELECT * FROM session_set_tbl where code='".$code."' ";
	$set_result = mysqli_query($conn, $set_query);
	$set_d = mysqli_fetch_array($set_result);


	$reg_query="SELECT * FROM regist_set_tbl where code='".$code."' and del='N'";
	$reg_result = mysqli_query($conn, $reg_query);




?>
<style>
	table.inputTbl td { text-align:right;}
</style>
<div id="container" style="width:1000px">
<div class="contents" style="width:1000px">
			<h2>통계</h2>

			<div class="conArea" style="width:1000px">
				
				<form enctype="multipart/form-data" name="registform" id="registform" action="./reg_set_post.php" method="post"> 
				<input type="hidden" name="code" id="code" value="<?=$code?>" /><br /> 
					<fieldset>
					
						<table class="inputTbl" style="width:1000px">
						<tr><th></th>
						<th>사전등록<br/>(금액)</th>
						<th>사전등록<br/>(명)</th>

							<?
							$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
							while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
								<th><?=$tab_col['name']?><br/>(금액)</th>
								<th><?=$tab_col['name']?><br/>(명)</th>
							<?}
							mysqli_data_seek($tab_result,0); 
							?>
							<th>현장<br/>(금액)</th>
							<th>현장<br/>(명)</th>
							
						



							<tbody>
							
								
							<?	
								$temp_query = "select * from regist_set_tbl where sid='".$set_d['reg_money']."' and del='N'";
								
								$temp_result = mysqli_query($conn, $temp_query);
								$temp_d = mysqli_fetch_array($temp_result);
								$info2_type = $temp_d['type'];
					
								$info2 = $temp_d['info_orderby'];


								$temp_result = mysqli_query($conn, "select type, info_orderby from regist_set_tbl where sid='".$set_d['reg_money_gubun']."'");
								$temp_d = mysqli_fetch_array($temp_result);
								$info1 = $temp_d['info_orderby'];

								

								
								$type_sub_query = "select * from regist_type_sub_tbl where type_sid='".$temp_d['type']."' and del='N'";
								$type_sub_result = mysqli_query($conn, $type_sub_query);
								//echo $type_sub_query;
								
								$tab_col = mysqli_fetch_array($tab_result);
								$event_time = $tab_col['eventdate'];
								mysqli_data_seek($tab_result,0); 


								while(is_array($type_sub_d = mysqli_fetch_array($type_sub_result))){?>
								<tr>
									<th><?=$type_sub_d['info']?></th>
									<?
									$temp_sum2 = $temp_count2 = 0;

									if($info2_type>1000){

											
										$temp_query = "SELECT sum(b.info) sum, count(info".$info2.") count FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.info".$info1."='".$type_sub_d['sid']."' and a.del='N' and a.pay_chk='Y' and a.pre_regist=1";
										
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);

										
									}else{

										$temp_query = "select sum(info".$info2.") sum, count(info".$info2.") count from regist_tbl where code='".$code."' and info".$info1."='".$type_sub_d['sid']."' and del='N' and pay_chk='Y' and pre_regist=1";
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);
									
									}?>

									<td><?=number_format($temp_d['sum'])?></td>
									<td><?=$temp_d['count']?></td>

									<?while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
									<?
										if($info2_type>1000){

											
											$temp_query = "SELECT sum(b.info) sum, count(b.info) count FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.info".$info1."='".$type_sub_d['sid']."' and a.del='N' and a.pay_chk='Y' and a.pay_date>".$tab_col['eventdate']." and a.pay_date<".($tab_col['eventdate']+86400);
											$temp_result = mysqli_query($conn, $temp_query);
											$temp_d = mysqli_fetch_array($temp_result);

											
										}else{
											$temp_query = "select sum(info".$info2.") sum, count(info".$info2.") count from regist_tbl where code='".$code."' and info".$info1."='".$type_sub_d['sid']."' and del='N' and pay_chk='Y' and pay_date>".$tab_col['eventdate']." and pay_date<".($tab_col['eventdate']+86400);
											$temp_result = mysqli_query($conn, $temp_query);
											$temp_d = mysqli_fetch_array($temp_result);
										}
										$temp_sum2 += $temp_d['sum'];
										$temp_count2 += $temp_d['count'];
										?>
										<td><?=number_format($temp_d['sum'])?></td>
										<td><?=number_format($temp_d['count'])?></td>

									<?}?>
									<?
									mysqli_data_seek($tab_result,0); 
									?>
									<td><?=number_format($temp_sum2)?></td>
									<td><?=number_format($temp_count2)?></td>
									
									</tr>
								<?}?>


								<tr>
									<th>합계</th>
									<?
									$temp_sum2 = $temp_count2 = 0;

									if($info2_type>1000){

											
										$temp_query = "SELECT sum(b.info) sum, count(b.info) count FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.del='N' and a.pay_chk='Y' and a.pay_date<".$event_time;
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);

										
									}else{

										$temp_query = "select sum(info".$info2.") sum, count(info".$info2.") count from regist_tbl where code='".$code."' and del='N' and pay_chk='Y' and pay_date<".$event_time;
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);
									
									}?>
									<td><?=number_format($temp_d['sum'])?></td>
									<td><?=$temp_d['count']?></td>


									<?while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
									<?
										if($info2_type>1000){

											
											$temp_query = "SELECT sum(b.info) sum, count(b.info) count FROM regist_tbl a, regist_type_sub_tbl b WHERE a.info".$info2."=b.sid and a.code='".$code."' and a.del='N' and a.pay_chk='Y' and a.pay_date>".$tab_col['eventdate']." and a.pay_date<".($tab_col['eventdate']+86400);
											$temp_result = mysqli_query($conn, $temp_query);
											$temp_d = mysqli_fetch_array($temp_result);

											
										}else{
											$temp_query = "select sum(info".$info2.") sum, count(info".$info2.") count from regist_tbl where code='".$code."' and del='N' and pay_chk='Y' and pay_date>".$tab_col['eventdate']." and pay_date<".($tab_col['eventdate']+86400);
											$temp_result = mysqli_query($conn, $temp_query);
											$temp_d = mysqli_fetch_array($temp_result);
										}
										$temp_sum2 += $temp_d['sum'];
										$temp_count2 += $temp_d['count'];
										?>
										<td><?=number_format($temp_d['sum'])?></td>
										<td><?=number_format($temp_d['count'])?></td>

									<?}?>
									<?
									mysqli_data_seek($tab_result,0); 
									?>
									<td><?=number_format($temp_sum2)?></td>
									<td><?=number_format($temp_count2)?></td>
									
									

								</tr>
									

						


								<tr>
									<th><label for="">출결</label></th>
									<td>-</td>
									<td>-</td>
									

									<?
									mysqli_data_seek($tab_result,0); 
									
									while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
										
								
									<td>-</td>
									<td>
									<?
									
										$temp_query = "select count(*) cnt from regist_tbl where code='".$code."' and del='N' and check_in".$tab_col['day'].">'0'";
										$temp_result = mysqli_query($conn, $temp_query);
										$temp_d = mysqli_fetch_array($temp_result);?>
										<?=$temp_d['cnt']?>
										
									</td>
									
									<?}?>
									<td>-</td>
									<td>-</td>
							


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