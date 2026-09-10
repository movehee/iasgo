<?include "./../header.php";?>

<?

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

/*$result_ss_chk = mysqli_query($conn, "SELECT score_settingYN FROM event_tbl where code='".$code."' ");
$result_ss_chk_row = mysqli_fetch_array($result_ss_chk);
$score_setting_yn = $result_ss_chk_row['score_settingYN'];*/

$score_set_arr = array();
$score_set_result = mysqli_query($conn, "SELECT agenda_sid FROM score_set_tbl where del='N' and code='".$code."' group by agenda_sid");
while(is_array($score_set_col = mysqli_fetch_assoc($score_set_result))){
	$score_set_arr[] = $score_set_col['agenda_sid'];
}



$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
while(is_array($tab_col = mysqli_fetch_assoc($tab_result))){
	$tab_cols[] = $tab_col;
}mysqli_data_seek($tab_result,0); 

$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");

$num_per_page2 = 5;
$num_per_page = 20;
if(empty($page)) $page = 0;
$query="SELECT * FROM regist_tbl where code='".$code."' and del='N'";


$result = mysqli_query($conn, "SELECT count(*) cnt FROM regist_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);
$totalRecord2 = $row['cnt'];



$temp_query = "select * from regist_set_tbl where del='N' and code='$code' and sid in (".$setting_col['reg_money_gubun'].",".$setting_col['reg_vip'].",".$setting_col['reg_mem_gubun'].")";
$temp_result = mysqli_query($conn, $temp_query);
while(is_array($temp_d = mysqli_fetch_assoc($temp_result))){
	if($temp_d['sid'] == $setting_col['reg_money_gubun']) { //Payment Type
		$reg_money_gubun_type = $temp_d['type'];
		$reg_money_gubun_orderby = $temp_d['info_orderby'];

	} else if($temp_d['sid'] == $setting_col['reg_vip']) { //VIP Type
		$reg_vip_gubun_type = $temp_d['type'];
		$reg_vip_gubun_orderby = $temp_d['info_orderby'];
	} else if($temp_d['sid'] == $setting_col['reg_mem_gubun']) { //VIP Type
		$reg_mem_gubun_type = $temp_d['type'];
		$reg_mem_gubun_orderby = $temp_d['info_orderby'];
	}
}



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

if($reg_mem_gubun) {
	$search_txt .= " and info".$reg_mem_gubun_orderby." = '".$reg_mem_gubun."'";
	$search .= "&amp;reg_mem_gubun=$reg_mem_gubun";
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

	$search .= "&amp;inout_type=$inout_type";

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

if($code == 'ksic2020') {
	$db_arr = array();
	$db_result = mysqli_query($conn, "SELECT info11 FROM regist_tbl where code='".$code."' and del='N'".$search_txt." group by info11 having count(*)>1");
	while(is_array($db = mysqli_fetch_array($db_result))){
		$db_arr[] = $db['info11'];
	}
}

$result = mysqli_query($conn, $query);


$reg_set_query="SELECT * FROM regist_set_tbl where code='".$code."' and listchk='Y' and del='N'";


$reg_set_query.=" order by orderby asc";

$reg_set_result = mysqli_query($conn, $reg_set_query);

$cnt = $totalRecord - $page*$num_per_page;


$break_array = array();

?>
<div id="container" style="width:1600px;">
	
		<h2 class="tooltipPoint" title="사용대상 : 1.학회사이트와 연동이 없이 별도 진행해야 할 경우 2.등록항목이 까다롭지 않은 범위에서 현장등록 페이지가 따로 없는경우(심초음파 워크샵 정도 사이즈에 적합함)
		*셋팅 순서*  1)등록항목관리에서 접수하는 데이터 등록/사전등록 있을 경우 데이터 보고 필드 맞추는게 좋음 (상황에 따라 Type도 등록) 2) 사전등록 Excel파일은 개발자가 일괄 등록 3) Setting 작업 4)개발자가 Print 페이지 제작(./print/code.php)후 프린트 맞추기 / code는 해당 행사 코드값">등록 관리</h2>
		
		<div class="btnArea" style="width:100%;">
			<span class="btn" style="float:right; margin-right:10px;">

					<?if($code == "korl2019"){?>
					<a onclick='window.open("/admin/php/unit/korl2019/list.php?code=<?=$code?>","","width=1230,height=950")'  class="btnDef tooltipPoint" title="self registration용 화면/현장등록 self desk운영 시 해당 화면 전체보기로 띄워놓고 사용"><i class="fas fa-eye"></i>보기</a>
					<?}?>
					
					<a onclick="window.open('sms/index.php?code=<?=$code?>','','width=1230,height=950');" title="사용자들한테 바코드 확인 가능한 URL SMS으로 전달" class="btnPoint tooltipPoint"><i class="fas fa-cog"></i>SMS 전송</a>
					<a href="http://ezv.kr//php/mobile/index.php?code=<?=$code?>" target="_blank" title="사용자들이 사용하게 될 페이지" class="btnDef tooltipPoint"><i class="fas fa-cog"></i>행사 사용자 웹페이지</a>
					
					<a onclick="javascript:money_set('<?=$code?>')"  class="btnDef tooltipPoint" title="현장,사전등록 금액 입력값 셋팅(self registration용 금액선택할때 사용)"><i class="fas fa-cog"></i>Money</a>
					<a onclick="javascript:add2('<?=$code?>')"  class="btnDef tooltipPoint" title="self registration용 화면/현장등록 self desk운영 시 해당 화면 전체보기로 띄워놓고 사용"><i class="fas fa-plus-circle"></i>사용자 등록</a>
					
					<select class="excel_proc" e-link="excel.php?code=<?=$code?>" style=" font-size:13px; width: 140px;  height: 40px; ">
						<option value="">엑셀</option>
						<option value="view">엑셀보기</option>
						<option value="down">엑셀다운</option>
					</select>

					<a onclick="javascript:print2('<?=$code?>')" class="btnDef tooltipPoint" title="전체 출력 / 체크박스 선택 후 프린트 누르면 선택된 것만 출력/개별 출력은 등록자 우측 프린트 아이콘누르면 개별 출력가능/print.php 생성 후 소스 에서 행사별 위치 맞춰야함"><i class="fas fa-print"></i>프린트</a>
					<a onclick="javascript:statistics('<?=$code?>')" class="btnDef tooltipPoint" title="사전, 현장 금액통계/입금상태 완료만 통계로 잡힘"><i class="far fa-chart-bar"></i>금액통계</a>
					<a onclick="javascript:set('<?=$code?>')" class="btnDef tooltipPoint" title="등록항목관리에서 항목 셋팅 후 전체 설정 셋팅해야함"><i class="fas fa-cog"></i>Setting</a>
					<a  onclick="javascript:set2('<?=$code?>')" class="btnDef tooltipPoint" title="등록 폼 설정/사전등록데이터 있을 경우 동일하게 맞추는게좋음"><i class="fas fa-cog"></i>등록항목관리</a>
					<a  onclick="javascript:add('<?=$code?>')" class="btnDef tooltipPoint" title="관리자 등록(기존 사용하는 임의등록과 동일)"><i class="fas fa-plus-circle"></i>관리자등록</a>
				</span>
		</div>
		<div class="contents member">

		 	<div class="registTotal" style="float:left">총 등록자 수 : <span class="registNum"><?=$totalRecord2?></span>명</div> 
			<div style="position:absolute;top:-4px;right:0">
				<span class="btn"><a onclick="javascript:search_select('<?=$code?>')" class="btnDef">검색</a></span>
				<span class="btn"><a href="./list.php?code=<?=$code?>" class="btnOrg">초기화</a></span>
			</div>

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
					

					<th><label for="" class="tooltipPoint" title="카드,현금, 계좌이체 등 결제방법으로 조회가능 / 등록항목 관리에서 셋팅 후 setting에서 검색항목을 설정해줘야함)">결제방법구분</label></th>

					<?
						
						$temp_query = "select * from regist_type_sub_tbl where del='N' and type_sid='".$reg_money_gubun_type."'";
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

					<th><label for="" class="tooltipPoint" title="입금상태 조회(입금,미입금)">입금여부</label></th>

				
					<td><select onchange="javascript:search_select('<?=$code?>')" name="pay_chk" id="pay_chk">


						<option value="">:: ALL ::</option>
						<option<?=$pay_chk=="Y"?' selected="true"':''?> value="Y">입금</option>
						<option<?=$pay_chk=="N"?' selected="true"':''?> value="N">미입금</option>
					</select></td>

					<th><label for="" class="tooltipPoint" title="사전,현장(day별)조회">등록구분</label></th>

				
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

					<th><label for="" class="tooltipPoint" title="메모내역있는 등록자만 조회">메모여부</label></th>

				
					<td><select onchange="javascript:search_select('<?=$code?>')" name="memoYN" id="memoYN">

						<option value="">:: ALL ::</option>
						<option value="Y" <?if($memoYN=="Y"){?>selected<?}?>>메모있음</option>

						

					</select></td>
				</tr>

				<tr>
					<th><label for="" class="tooltipPoint" title="day별, 전체 체크인,체크아웃 상태 조회">입출여부</label></th>

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

					<th><label class="tooltipPoint" title="등록항목 관리에 VIP구분값이 있을 경우 VIP조회 가능 (등록항목 관리에서 셋팅 후 setting에서 검색항목을 설정해줘야함)">VIP구분</label></th>
					
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


					<th>회원구분</th>
					<td>
						<?
						$temp_query = "select * from regist_type_sub_tbl where type_sid='".$reg_mem_gubun_type."'";
						$temp_result = mysqli_query($conn, $temp_query);
						?>
						<select onchange="javascript:search_select('<?=$code?>')" name="reg_mem_gubun" id="reg_mem_gubun">
						<option value="">:: ALL ::</option>
						<?
						while(is_array($temp_d = mysqli_fetch_array($temp_result))){?>
							<option<?=$reg_mem_gubun==$temp_d['sid']?' selected="true"':''?> value="<?=$temp_d['sid']?>"><?=$temp_d['info']?></option>
						<?}?>
						</select>
					</td>


					<th><label for="" class="tooltipPoint" title="이름,소속,휴대폰,면허번호,e-mail등(등록항목 값 있을경우) 조회가능">Keyword<br>(이름,소속,휴대폰,면허번호등)</label></th>
					<td><input onchange="javascript:search_select('<?=$code?>')" type="text" name="keyword" id="keyword"  value="<?=htmlspecialchars($keyword)?>" /></td>

					

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
				<?
					if($code=='ksic2020') {

						$bb = "";
						if(in_array($d['info11'], $db_arr) && $d['info11']!='' && $d['info15']!='359') {
							$bb = "Y";
						}
					}
				?>
					<tr class="" id="<?=$d['sid']?>" style="background-color:yellow !important;">

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
										$temp_arr = explode("&&", $temp[$kk]);
										if($temp_arr[1]) {
											echo $temp_arr[1];
										}
										else {
											echo $type[$reg_set_d['type']][$temp_arr[0]];
										}
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
							
							<?}else if($reg_set_d['type']==120){?>
								<td><?=str_replace("&&"," ",$d['info'.$reg_set_d['info_orderby']])?></td>

							<?}else{?>
								<td <?if($reg_set_d['type']==100){?>class="tdMemo"<?}?> style="min-width:10%;max-width:40%;<?if($bb){?>color:red<?}?>"><?=$d['info'.$reg_set_d['info_orderby']]?></td>
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
							if($d['check_out'.$tab_col['day']] && $d['check_in'.$tab_col['day']]){

							$someTimeOrg = gmdate("H:i:s", $d['check_out'.$tab_col['day']] - $d['check_in'.$tab_col['day']]);

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
							
							echo $d['info40']."<br>";
							//echo "<font color='red'>".$aReturnValue['H'].":".$aReturnValue['i'];
							

							$score2 = 0;
							if($tab_col['score']){
								
								if(in_array($tab_col['sid'], $score_set_arr)) {
									$time_n = 60*60;
									
									$score_set_result = mysqli_query($conn, "select * from score_set_tbl where code='".$code."' and agenda_sid='$tab_col[sid]' and del='N' order by time asc");
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

							//echo "<br />(".$score2."점)</font>";

							

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
				<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page-$num_per_page2>0){ echo (floor($page/$num_per_page2)-1)*$num_per_page2+($num_per_page2-1);}else{echo "0";}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-left"></i></a></li>
				<?

					for($i = $s; $i < $e ; $i++)
					{?>	
						<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?><?=$search?><?}?>"><?=$i+1?></a></li>
					<?}
				?>

				<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?if($page+$num_per_page2>$max-1){echo $max-1;}else{echo (floor($page/$num_per_page2)+1)*$num_per_page2;}?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-right"></i></a></li>
				<li><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$max-1?><?if($search){?><?=$search?><?}?>"><i class="fas fa-angle-double-right"></i></a></li>

			</ul>
		</div>
		<!-- //contents -->
			
		
    <p id="adminTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
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