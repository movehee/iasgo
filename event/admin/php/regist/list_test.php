<?include "./../header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$result_ss_chk = mysqli_query($conn, "SELECT score_settingYN FROM event_tbl where code='".$code."' ");
$result_ss_chk_row = mysqli_fetch_array($result_ss_chk);
$score_setting_yn = $result_ss_chk_row['score_settingYN'];
if($score_setting_yn == 'Y') {
	$score_set_result = mysqli_query($conn, "select * from score_set_tbl where code='".$code."' and del='N' order by time asc");
}

$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
while(is_array($tab_col = mysqli_fetch_assoc($tab_result))){
	$tab_cols[] = $tab_col;
}mysqli_data_seek($tab_result,0); 

$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");

$num_per_page2 = 5;
$num_per_page = 300;
if(empty($page)) $page = 0;
$query="SELECT * FROM regist_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);
$totalRecord2 = $row['cnt'];

//Payment Type
$temp_query = "select * from regist_set_tbl where sid='".$setting_col['reg_money_gubun']."'";
$temp_result = mysqli_query($conn, $temp_query);
$temp_d = mysqli_fetch_array($temp_result);
$reg_money_gubun_type = $temp_d['type'];
$reg_money_gubun_orderby = $temp_d['info_orderby'];

//VIP Type
$temp_vip_query = "select * from regist_set_tbl where sid='".$setting_col['reg_vip']."'";
$temp_vip_result = mysqli_query($conn, $temp_vip_query);
$temp_vip_d = mysqli_fetch_array($temp_vip_result);
$reg_vip_gubun_type = $temp_vip_d['type'];
$reg_vip_gubun_orderby = $temp_vip_d['info_orderby'];


$search_txt = "";


if($reg_money_gubun){
	$search_txt .= " and info".$reg_money_gubun_orderby." = '".$reg_money_gubun."'";
	$search .= "&amp;reg_money_gubun=$reg_money_gubun";
}
if($pay_chk){
	$search_txt .= " and pay_chk = '".$pay_chk."'";
	$search .= "&amp;pay_chk=$pay_chk";
}

if($reg_vip_gubun){

	if($reg_vip_gubun == '-1') {
		$search_txt .= " and ifnull(info".$reg_vip_gubun_orderby.",'')!=''";
	}
	else if($reg_vip_gubun == '-2') {
		$search_txt .= " and ifnull(info".$reg_vip_gubun_orderby.",'')=''";
	}
	else {
		$search_txt .= " and info".$reg_vip_gubun_orderby." = '".$reg_vip_gubun."'";
	}

	$search .= "&amp;reg_vip_gubun=$reg_vip_gubun";
}

if($eventdate){

	$search .= "&amp;eventdate=$eventdate";

	if($eventdate=="-1"){

		$tab_col = mysqli_fetch_array($tab_result);
		$event_time = $tab_col['eventdate'];
		mysqli_data_seek($tab_result,0); 


		$search_txt .= " and signdate < '".$event_time."'";
	}else{
		$search_txt .= "and signdate>=".$eventdate." and signdate<".($eventdate+86400);
	}

}
if($memoYN=="Y"){
	$search_txt .= " and memo not in ('')";
	$search .= "&amp;memoYN=$memoYN";
}

if($inout_type) {

	$inout_arr = explode("_",$inout_type);
	
	if($inout_arr[1] == 'all') {
		
		while(is_array($tab_col = mysqli_fetch_array($tab_result))){
		
			$search_txt .= " and check_".$inout_arr[0].$tab_col['day'].">'0'";

		}mysqli_data_seek($tab_result,0); 

	}
	else {

		$search_txt .= " and check_".$inout_arr[0].$inout_arr[1].">'0'";
	}	

}

if($indate){
	
	//$search_txt .= "and pay_date>".$eventdate." and pay_date<".($eventdate+86400);
	$a_result = mysqli_query($conn, "select * from agenda_tbl where del='N' and sid='".$indate."'");
	$a = mysqli_fetch_array($a_result);
	$search_txt .= " and check_in".$a['day'].">'0'";

	$search .= "&amp;indate=$indate";
}

if($keyword){

	$search_txt .= " and (";

	for($i=1;$i<41;$i++){
		if($i>1){
			$search_txt .= " or ";
		}
		$search_txt .= "info".$i." like '%".$keyword."%'";

	}
	$search_txt .= " )";

	$search .= "&amp;keyword=$keyword";
}

$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_tbl where code='".$code."' and del='N'".$search_txt);
$row = mysqli_fetch_array($result);

$totalRecord = $row['cnt'];

$query.=$search_txt;

$query.=" order by sid desc LIMIT ".$page*$num_per_page.",".$num_per_page;

if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	echo $query;
}


$result = mysqli_query($conn, $query);


$reg_set_query="SELECT * FROM regist_set_tbl where code='".$code."' and listchk='Y' and del='N'";


$reg_set_query.=" order by orderby asc";

$reg_set_result = mysqli_query($conn, $reg_set_query);

$cnt = $totalRecord - $page*$num_per_page;


$break_array = array();

?>
<div id="container" style="width: 1700px;">
	
		<h2 class="tooltipPoint" title="*셋팅 순서*  1)접수내역관리에서 접수하는 데이터 등록 (상황에 따라 Type도 등록) 2) 사전등록 Excel파일은 개발자가 일괄 등록 3) Setting 작업 4)개발자가 Print 페이지 제작(./print/code.php) code는 해당 행사 코드값">등록 관리</h2>
		 
		<div class="contents member">
			

			<p class="btn" style="top: -44px; right: 900px; position: absolute;"><a onclick="javascript:money_set('<?=$code?>')"  class="btnDef"><i class="fas fa-eye"></i>Money</a></p>


			<p class="btn" style="top: -44px; right: 750px; position: absolute;"><a onclick="javascript:add2('<?=$code?>')"  class="btnDef"><i class="fas fa-eye"></i>사용자 등록</a></p>

			<p class="btn" style="top: -44px; right: 645px; position: absolute;"><a href="./excel.php?code=<?=$code?>"  class="btnDef"><i class="fas fa-eye"></i>Excel</a></p>

			<p class="btn" style="top: -44px; right: 530px; position: absolute;"><a onclick="javascript:print2('<?=$code?>')" class="btnDef"><i class="fas fa-eye"></i>프린트</a></p>

			<p class="btn" style="top: -44px; right: 400px; position: absolute;"><a onclick="javascript:statistics('<?=$code?>')" class="btnDef"><i class="fas fa-eye"></i>통계보기</a></p>

			<p class="btn" style="top: -44px; right: 280px; position: absolute;"><a onclick="javascript:set('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>Setting</a></p>
		
			<p class="btn" style="top: -44px; right: 118px; position: absolute;"><a  onclick="javascript:set2('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>접수내역관리</a></p>

			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$code?>')" class="btnDef">등록</a></p>
			
		 	<div class="registTotal">총 등록자 수 : <span class="registNum"><?=$totalRecord2?></span>명</div> 


			<table class="inputTbl" id="search_tbl">
				<colgroup>
					<col style="width: 10%;">
					<col style="width: 15%;">
					<col style="width: 10%;">
					<col style="width: 15%;">
					<col style="width: 10%;">
					<col style="width: 15%;">
				</colgroup>

				<tr>
					

					<th><label for="">금액구분</label></th>

					<?
						
						$temp_query = "select * from regist_type_sub_tbl where type_sid='".$reg_money_gubun_type."'";
						$temp_result = mysqli_query($conn, $temp_query);
					?>
					<td><select onchange="javascript:search_select('<?=$code?>')" name="reg_money_gubun" id="reg_money_gubun">


						<option value="">:: ALL ::</option>
						<?
						while(is_array($temp_d = mysqli_fetch_array($temp_result))){?>
							<option<?=$reg_money_gubun==$temp_d['sid']?' selected="true"':''?> value="<?=$temp_d['sid']?>"><?=$temp_d['info']?></option>
						<?}
						mysqli_data_seek($reg_result,0); 
						?>
					</select></td>

					<th><label for="">입금여부</label></th>

				
					<td><select onchange="javascript:search_select('<?=$code?>')" name="pay_chk" id="pay_chk">


						<option value="">:: ALL ::</option>
						<option<?=$pay_chk=="Y"?' selected="true"':''?> value="Y">입금</option>
						<option<?=$pay_chk=="N"?' selected="true"':''?> value="N">미입금</option>
					</select></td>

					<th><label for="">등록여부</label></th>

				
					<td><select onchange="javascript:search_select('<?=$code?>')" name="eventdate" id="eventdate">

						<option value="">:: ALL ::</option>
						<option<?=$eventdate=="-1"?' selected="true"':''?> value="-1">사전</option>

						<?
						$tab_group_result = mysqli_query($conn, "select eventdate, name, count(sid) as cnt from agenda_tbl where code='".$code."' and del='N' group by eventdate order by sid asc");
						while(is_array($tab_col = mysqli_fetch_array($tab_group_result))){
							
							if($tab_col['cnt']>1) {
								$tab_col_name = date('Y-m-d', $tab_col['eventdate']);
							}
							else {
								$tab_col_name = $tab_col['name'];
							}
						?>
							<option<?=$eventdate==$tab_col['eventdate']?' selected="true"':''?> value="<?=$tab_col['eventdate']?>"><?=$tab_col_name?></option>
						<?}?>

					</select></td>

					<th><label for="">메모여부</label></th>

				
					<td><select onchange="javascript:search_select('<?=$code?>')" name="memoYN" id="memoYN">

						<option value="">:: ALL ::</option>
						<option value="Y" <?if($memoYN=="Y"){?>selected<?}?>>메모있음</option>

						

					</select></td>
				</tr>

				<tr>
					<th><label for="">입출여부</label></th>

					<td><select onchange="javascript:search_select('<?=$code?>')" name="inout_type" id="inout_type">

						<option value="">:: ALL ::</option>

						<?
						
						while(is_array($tab_col = mysqli_fetch_array($tab_result))){
							
							$tab_val_in = "in_".$tab_col['day'];
							$tab_val_out = "out_".$tab_col['day'];
						?>
							<option<?=$inout_type==$tab_val_in?' selected="true"':''?> value="<?=$tab_val_in?>"><?=$tab_col['name']." IN"?></option>
							<option<?=$inout_type==$tab_val_out?' selected="true"':''?> value="<?=$tab_val_out?>"><?=$tab_col['name']." OUT"?></option>
						<?}mysqli_data_seek($tab_result,0);?>
							
							<option value="in_all" <?=$inout_type=="in_all"?' selected="true"':''?>>ALL DAY IN</option>
							<option value="out_all" <?=$inout_type=="out_all"?' selected="true"':''?>>ALL DAY OUT</option>
						
						

					</select></td>

					<th>VIP</th>
					
					<?
						
						$temp_query = "select * from regist_type_sub_tbl where type_sid='".$reg_vip_gubun_type."'";
						$temp_result = mysqli_query($conn, $temp_query);
					?>
					<td><select onchange="javascript:search_select('<?=$code?>')" name="reg_vip_gubun" id="reg_vip_gubun">


						<option value="">:: ALL ::</option>
						<option value="-1" <?=$reg_vip_gubun=='-1'?' selected="true"':''?>>VIP ALL</option>
						<option value="-2" <?=$reg_vip_gubun=='-2'?' selected="true"':''?>>NOT VIP ALL</option>
						<?
						while(is_array($temp_d = mysqli_fetch_array($temp_result))){?>
							<option<?=$reg_vip_gubun==$temp_d['sid']?' selected="true"':''?> value="<?=$temp_d['sid']?>"><?=$temp_d['info']?></option>
						<?}
						?>
					</select></td>


					<th><label for="">Keyword</label></th>
					<td><input onchange="javascript:search_select('<?=$code?>')" type="text" name="keyword" id="keyword"  value="<?=htmlspecialchars($keyword)?>" /></td>

					<td>
					<span class="btn"><a onclick="javascript:search_select('<?=$code?>')" class="btnDef">검색</a></span>
					<span class="btn"><a href="./list.php?code=<?=$code?>" class="btnOrg">초기화</a></span>
					
					</td>

				</tr>



			</table>


			<div class="registTotal">등록자 수 : <span class="registNum"><?=$totalRecord?></span>명</div> 
			<table class="tblList">
				<thead>
					<tr>
						<th width="2%"><input type='checkbox' name='all_chk' onclick="javascript:all_chk(this)"/></th>
						<th width="3%">No</th>
					<?while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){?>

							<?if($reg_set_d['type']>1000){
								$reg_type_set_query = "SELECT * FROM regist_type_sub_tbl where type_sid in (".$reg_set_d['type'].")";
								//echo $reg_type_set_query;
								$reg_type_set_result = mysqli_query($conn, $reg_type_set_query);
								while(is_array($reg_type_set_d = mysqli_fetch_array($reg_type_set_result))){
									$type[$reg_set_d['type']][$reg_type_set_d['sid']] = $reg_type_set_d['info'];
								}


							}?>

						<th style="min-width:100px;max-width:500px"><?=$reg_set_d['info']?></th>
					<?}mysqli_data_seek($reg_set_result,0);?>
					<th  width="6%">입금여부</th>
					<?
					while(is_array($tab_col = mysqli_fetch_array($tab_result))){?>
						<th colspan=2><?=$tab_col['name']?></th>

				
					<?
					for($i=1;$i<6;$i++){
						if($tab_col['break_time'.$i]){
							$temp = split("-",$tab_col['break_time'.$i]);

							$temp1 = split(":",$temp[0]);
							$temp2 = split(":",$temp[1]);

							$break_array[$tab_col['sid']][$i] = array($tab_col['eventdate'] + $temp1[0] * 60 * 60 +  $temp1[1] * 60,$tab_col['eventdate'] + $temp2[0] * 60 * 60 +  $temp2[1] * 60);
						}
					}
					
					}
					mysqli_data_seek($tab_result,0); 
					?>
						
						<th  width="7%">관리</th>
					</tr>
				</thead>
				<tbody>
				<?while(is_array($d = mysqli_fetch_array($result))){?>
					<tr class="bg" id="<?=$d['sid']?>">

						<td width="2%">
						<input type='checkbox' name='chk_sid[]' value="<?=$d['sid']?>"/>
						</td>

						<td  width="3%"><?=$cnt?></td>
						<?while(is_array($reg_set_d = mysqli_fetch_array($reg_set_result))){?>
							<?if($reg_set_d['type']>1000){?>
								<td style="min-width:10%;max-width:40%">
								<?
								$temp = split(",",$d['info'.$reg_set_d['info_orderby']]);

					

								if(count($temp)=="1" && $setting_col['reg_money_gubun']==$reg_set_d['sid']){?>

									<select onchange="changeVal(this,'info<?=$reg_set_d['info_orderby']?>','<?=$d['sid']?>')" name="info<?=$reg_set_d['info_orderby']?>" id="info<?=$reg_set_d['info_orderby']?>">
									<option value="">select</option>
									<?
										$temp_query2 = "select * from regist_set_tbl a, regist_type_sub_tbl b where a.type=b.type_sid and a.type='".$reg_set_d['type']."' and a.del='N' and b.del='N'";
										$temp_result2 = mysqli_query($conn, $temp_query2);
										while(is_array($temp_d2 = mysqli_fetch_array($temp_result2))){?>
											<option<?=$d['info'.$reg_set_d['info_orderby']]==$temp_d2['sid']?' selected="true"':''?> value="<?=$temp_d2['sid']?>"><?=$temp_d2['info']?></option>

										<?}

									?>
										
									</select>
								<?}else{

									for($kk=0;$kk<count($temp);$kk++){
										if($kk>0){
											echo ", ";
										}
										echo $type[$reg_set_d['type']][$temp[$kk]];
									}
								}
								?>
								
								
								</td>
							<?}else if($reg_set_d['type']==90){
								if($d['info'.$reg_set_d['info_orderby']]){
								$country_result = mysqli_query($conn, "select * from country_tbl where sid=".$d['info'.$reg_set_d['info_orderby']]);
								$country_d = mysqli_fetch_array($country_result);
								}
							
							?>
								<td style="min-width:10%;max-width:40%"><?=$country_d['name']?></td>
							
							
							<?}else{?>
								<td <?if($reg_set_d['type']==100){?>class="tdMemo"<?}?> style="min-width:10%;max-width:40%"><?=$d['info'.$reg_set_d['info_orderby']]?></td>
							<?}?>
						<?}mysqli_data_seek($reg_set_result,0);?>

						<td width="6%">
						<select onchange="changeVal(this,'pay_chk','<?=$d['sid']?>')" name="pay_chk" id="pay_chk">
							<option<?=$d['pay_chk']=="Y"?' selected="true"':''?> value="Y">입금</option>
							<option<?=$d['pay_chk']=="N"?' selected="true"':''?> value="N">미입금</option>
						</select>
						</td>

						<?
						while(is_array($tab_col = mysqli_fetch_array($tab_result))){
							
							
							
							if($tab_col['start_time']){
								$temp = split(":",$tab_col['start_time']);
								$start_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
							}

							if($tab_col['end_time']){
								$temp = split(":",$tab_col['end_time']);
								$end_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
							}
							?>
							<td>
							
							<input placeholder="체크인" style="width:90px; margin-bottom: 5px;" onchange="javascript:inoutVal(this,'<?=$code?>','<?=$tab_col['day']?>','check_in<?=$tab_col['day']?>','<?=$d['sid']?>')" type="text" <?if($d['check_in'.$tab_col['day']]){?> value="<?=date("H:i",$d['check_in'.$tab_col['day']])?>" <?}?> /><br><input style="width:90px"  placeholder="체크아웃"onchange="javascript:inoutVal(this,'<?=$code?>','<?=$tab_col['day']?>','check_out<?=$tab_col['day']?>','<?=$d['sid']?>')" type="text" <?if($d['check_out'.$tab_col['day']]){?> value="<?=date("H:i",$d['check_out'.$tab_col['day']])?>" <?}?> />


				
							
							</td>
							<td><?
							if($d['check_out'.$tab_col['day']]){

							if (  $d['check_in'.$tab_col['day']] <  $start_time ) {
								$d['check_in'.$tab_col['day']] = $start_time;
							}
							
							//나간시간이 등록된 시간보다 크면 등록된 시간으로 변경 -190703 YC
							if ( $d['check_out'.$tab_col['day']]  > $end_time  ) {
								$d['check_out'.$tab_col['day']] = $end_time;
							}

							$someTime = $d['check_out'.$tab_col['day']] - $d['check_in'.$tab_col['day']];

							if($break_array[$tab_col['sid']]){
								foreach($break_array[$tab_col['sid']] as $key=>$val){
								if($d['check_in'.$tab_col['day']] < $val[0])
								{
									if($d['check_out'.$tab_col['day']] > $val[1]) {
										$someTime += $val[0]-$val[1];
									} else if($d['check_out'.$tab_col['day']] < $val[0]) {

									} else {
										$someTime += $val[0]-$d['check_out'.$tab_col['day']];
									}
								}else if($d['check_in'.$tab_col['day']] < $val[1]) {
									if($d['check_out'.$tab_col['day']] > $val[1]) {
										$someTime += $d['check_in'.$tab_col['day']]-$val[1];
									} else if($d['check_out'.$tab_col['day']] < $val[0]) {

									} else {
										$someTime += $d['check_in'.$tab_col['day']]-$d['check_out'.$tab_col['day']];
									}
								}
							}
						}




							$aReturnValue['d'] = floor($someTime/60/60/24); //일
							$aReturnValue['H'] = sprintf("%02d", ($someTime/60/60)%24); //시간
							$aReturnValue['i'] = sprintf("%02d", ($someTime/60)%60); //분
							$aReturnValue['s'] = sprintf("%02d", ($someTime%60)); //초
							
							if($aReturnValue['H'] < 0 || $aReturnValue['i'] < 0 ) { // 아젠다시작시간기준일경우 시작시간보다 일찍 찍었을경우 -로 보이는형상있음
								echo "00:00";
							}
							else {
								echo $aReturnValue['H'].":".$aReturnValue['i'];
							}

							$score2 = 0;
							if($tab_col['score']){
								
								if($score_setting_yn=='Y') {
									$time_n = 60*60;

									while(is_array($ss_col = mysqli_fetch_array($score_set_result))){
										if($ss_col['ine']=='1') {
											if($someTime >= $time_n*$ss_col['time']) {
												$score2 = $ss_col['score'];
											}

										}
										else if($ss_col['ine']=='2') {
											if($someTime > $time_n*$ss_col['time']) {
												$score2 = $ss_col['score'];
											}
										}
									}

									mysqli_data_seek($score_set_result,0);									
								}
								else { //기존방식
									if($aReturnValue['H']>=5)
										$score2 = 6;
									else if($aReturnValue['H']>=4)
										$score2 = 5;
									else if($aReturnValue['H']>=3)
										$score2 = 4;
									else if($aReturnValue['H']>=2)
										$score2 = 3;
									if($tab_col['score']<$score2){
										$score2 = $tab_col['score'];
									}
								}
								
								
							}
							echo "<br>".$score2."점";

							

							}?></td>
						<?}
						mysqli_data_seek($tab_result,0); 
						?>
						
						<td width="7%">
							<a onclick="javascript:print('<?=$code?>','<?=$d['sid']?>')"> <img src="/admin/image/btn_print.png" alt="출력" /></a>
							<a href="" onclick="javascript:modify('<?=$code?>','<?=$d['sid']?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
							<a href="" onclick="javascript:del('<?=$d['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
						</td>
					</tr>
				<?
					$cnt--;
						}?>
					
				</tbody>
			</table>

			<ul class="pager">

			<?
				$s = floor($page / $num_per_page2);
				$s = $s * $num_per_page2;
				$max = ceil($totalRecord / $num_per_page);
				if($max>$s+$num_per_page2){
					$e = $s+$num_per_page2;
				}else{
					$e = $max;
				}
			?>


			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=0<?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-double-left"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page-$num_per_page2>0){ echo $page-3;}else{echo "0";}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-left"></i></a></li>
			<?

				for($i = $s; $i < $e ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?><?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>

			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page+$num_per_page2>$max-1){echo $max-1;}else{echo $page+$num_per_page2;}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-right"></i></a></li>
			<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$max-1?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-double-right"></i></a></li>
			</ul>
		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">

function get_params() {


	var agent = navigator.userAgent.toLowerCase();
	if ( (navigator.appName == 'Netscape' && agent.indexOf('trident') != -1) || (agent.indexOf("msie") != -1)) {
		 // ie일 경우
		 $gubun = "&amp;";
	}else{
		 // ie가 아닐 경우
		 $gubun = "&";
	}

	var params = "";
	$("table#search_tbl").find("td").each(function() {
		var input_obj = $(this).find("select, input");
		var $id = typeof(input_obj.attr("id"))!="undefined"?input_obj.attr("id"):"";
		if($id) {
			params += $gubun+input_obj.attr("id")+"="+input_obj.val();
		}
	});
	
	return params;
}


function search_select(code){

	
	var params = get_params();

	//location.replace("./list.php?code="+code+"&reg_money_gubun="+document.getElementById("reg_money_gubun").value+"&pay_chk="+document.getElementById("pay_chk").value+"&eventdate="+document.getElementById("eventdate").value+"&inout_type="+document.getElementById("inout_type").value+"&reg_vip_gubun="+document.getElementById("reg_vip_gubun").value+"&keyword="+document.getElementById("keyword").value+"&memoYN="+document.getElementById("memoYN").value);

	location.replace("./list.php?code="+ code + params);
}


function changeVal(val,info,sid) {


	$.ajax({
		type:"POST",
		url:"./update_info.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){

		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}

function inoutVal(val,code,day,info,sid) {
	$.ajax({
		type:"POST",
		url:"./update_inout.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid+"&code="+code+"&day="+day,
		success:function(msg){
			//alert(msg);

		},error : function(request, status, error ) {   
			alert("입력실패 : "+val.value);
		
		}
	});
}



function print(code, sid) {
	window.open("./print/"+code+".php?code="+code+"&sid="+sid+",","","width=1020,height=1404");
}

function all_chk(key) {

	obj = document.getElementsByName("chk_sid[]");
	var chk_val = "";
	for(i=0;i<obj.length;i++){
		obj[i].checked = key.checked;
		
	}

}

function print2(code) {
	
	
	obj = document.getElementsByName("chk_sid[]");
	var chk_val = "";
	for(i=0;i<obj.length;i++){
		if(obj[i].checked==true){
			//chk_val += obj[i].value+",";
			//alert(obj[i].value);

			//alert($("input[name='chk_sid[]']")[i].value);
			chk_val += ""+obj[i].value+",";

		}
	}

	var params = get_params();

	window.open("./print/"+code+".php?code="+code+"&sid="+chk_val + params,"","width=1020,height=1404");

	//alert(chk_val);
	
	/*
	var fileValue = $("input[name='chk_sid']").length;
    var fileData = new Array(fileValue);
    for(var i=0; i<fileValue; i++){                        
		alert($("input[name='chk_sid']")[i].value);
         fileData[i] = $("input[name='chk_sid']")[i].value;
    }
	*/

}

function statistics(code) {
	window.open("statistics.php?code="+code,"","width=1230,height=950");
}

function set(code) {
	window.open("reg_set.php?code="+code,"","width=1230,height=950");
}


function money_set(code) {
	window.open("money.php?code="+code,"");
}

function set2(code) {
	window.open("set.php?code="+code,"");
}

function add(code) {
	window.open("add.php?code="+code,"","width=1230,height=950");
}
function add2(code) {
	window.open("/php/regist/?code="+code,"","width=1230,height=950");
}

function modify(code, sid) {

	window.open("add.php?code="+code+"&sid="+sid,"","width=1230,height=950");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./del.php",
			data:"sid="+sid,
			success:function(msg){
				location.reload();
			}
		});
	}
}

</script>

   
<?include "./../footer.php";?>