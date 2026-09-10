<?include $_SERVER['DOCUMENT_ROOT']."/include.header.php"?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	


	

	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	

	
	
	if(!$ev_date) $ev_date = 5;
	//$time_max_count=count($_TIME['session'][$ev_date]);
	if($ev_date=='1'){
		$time_max_count=2; //총 세션의 갯수 정의
	}else{
		$time_max_count=3; //총 세션의 갯수 정의
	}
	
	$num_per_page = 10;
	if($li_page) $num_per_page = $li_page;

	if(!$search_type) $search_type = "and";
	
	$sort_sql = "   order by day desc, first_date asc";
	if($sort_field) $sort_sql = " order by ".$sort_field;
	if($orderby) $sort_sql .= " ".$orderby;


	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date');

	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}
	

	if(!$result_code) $result_code='1';
	
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='key'){
					$search_query[] = " usid = '".$tval."' ";
				}else if($tkey=='program_day1'){
					$day_query[] = " day ='1'";
				}else if($tkey=='program_day2'){
					$day_query[] = " day ='2'";
				}else if($tkey=='program_day3'){
					$day_query[] = " day ='3'";
				}else if($tkey=='program_day4'){
					$day_query[] = " day ='4'";
				}else if($tkey=='s1_sdate' || $tkey=='s1_edate' || $tkey=='s2_sdate' || $tkey=='s2_edate' || $tkey=='s3_sdate' || $tkey=='s3_edate' || $tkey=='s4_sdate' || $tkey=='s4_edate'){
					if($tval=='Y'){
						$search_query[] = " $tkey>0 ";
					}else if($tval=='N'){
						$search_query[] = " ($tkey='' or $tkey is null) ";
					}
				}else if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime' || $tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
					if($tkey=='s1_stime' || $tkey=='s2_stime' || $tkey=='s3_stime' || $tkey=='s4_stime'){
						$search_query[] = " ".str_replace("_stime","_sdate",$tkey).">=unix_timestamp(concat(substr(from_unixtime(".str_replace("_stime","_sdate",$tkey)."),1,10),' ".$tval."'))";
					}else if($tkey=='s1_etime' || $tkey=='s2_etime' || $tkey=='s3_etime' || $tkey=='s4_etime'){
						$search_query[] = " ".str_replace("_etime","_edate",$tkey)."<=unix_timestamp(concat(substr(from_unixtime(".str_replace("_etime","_edate",$tkey)."),1,10),' ".$tval."'))";
					}
				}else if($tkey=='id'){
					$day_query[] = " $tkey like '%".$tval."%' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
			$search_url .= "&$tkey=".$tval;
		}
	}
	if($day_query){
		$search_query[] = " (".implode(" or ",$day_query).")";
	}
	if($inout_query){
		$search_query[] = " (".implode(" and ",$inout_query).")";
	}

	if($li_page) $search_url .= "&li_page=".$li_page;
	$search_url .= "&ev_date=".$ev_date;
	
	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and day='$ev_date'";//and t2.member_level!='M'
	}else{
		$fsql = " where del='N' and day='$ev_date'";//and t2.member_level!='M'
	}
	

	
	
	//$query = "select count(*) from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;
	for($s=$time_max_count;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking,reg_kind,gubun1";
	
	$query = "select count(usid) from (";
	$query .= "(select ".implode(",",$session_field). $add_field." from checkin_tbl_ind as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	
	$query .= ") A" . $fsql;
	//$query .= " and t2.member_level!='M'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220' || $_SERVER['REMOTE_ADDR']=='218.235.94.212' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522'){
		//$query .= " and usid in ('2531','1886','951','517','2','519','1264','1035','2089','809','1027','1545','1029','1034','1036','1038','1952','1954','1037','1031','1898','2022','306','1349','273','2009','1947','1629','1224','2102','1726','627','629','1720','1719','1721','1916','1730','1919','952','2360','2444','430','1931','1183','2028','2606','2408','1664','970','145','2048','759','607','1128','2047','1577')";
		//$query .= " and chking!='Y' and day='1'";
		//$query .= " and member_level!='M' and classification not in ('M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}
	if($_SERVER['REMOTE_ADDR']=='218.235.94.2204'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}
	//master_echo($query);
	
	$totalRecord=$conn->getOne($query);

	$num_per_page = 50;
	if(DB::isError($totalRecord)) die($totalRecord->getMessage());
	$pageNav=new Page($page,$totalRecord,$num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	
	//$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid,t2.classification,t2.logout_day1,t2.logout_day2,t2.logout_day3,t2.logout_day4,t2.reg_kind,t2.gubun1,t2.gubun2 from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid " . $fsql;

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl_ind as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	
	$query .= ") A" . $fsql;
	// echo $query;
	//$query .= " and t1.day='2' and t1.score='4'";
	//$query .= " and t1.usid not in ($pass_sid_arr)";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'  || $_SERVER['REMOTE_ADDR']=='218.235.94.212' || $_SERVER['REMOTE_ADDR']=='218.235.94.20522' ){
		//$query .= " and usid in ('2531','1886','951','517','2','519','1264','1035','2089','809','1027','1545','1029','1034','1036','1038','1952','1954','1037','1031','1898','2022','306','1349','273','2009','1947','1629','1224','2102','1726','627','629','1720','1719','1721','1916','1730','1919','952','2360','2444','430','1931','1183','2028','2606','2408','1664','970','145','2048','759','607','1128','2047','1577')";
		//$query .= " and member_level!='M' and classification not in ('M','X','Z')"; //and reg_kind in ('K','L','M','R','U')
	}
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//$query .= " and first_date>unix_timestamp('2021-04-11 10:40:00')";
	}
	//$query .= " and t2.member_level!='M'";

	$query .= $sort_sql; //and t2.day='2' and t1.score='6' //id asc, t1.day asc, 
	
		
	if($_SERVER['REMOTE_ADDR']!='218.235.94.2204'){
		$query .= " LIMIT ".$pageNav->getFirstRecordInPage().",". $num_per_page;
	}
	
	//echo ($query);
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	

	$virtualRecordNo=$pageNav->getVirtualRecordNoInPage($totalRecord);
	
	# 블럭단위 계산
	$blockNav = new Block("", $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if($block >= $totalBlock) $lastPageInBlock = $totalPage;
	
	
	
?>
<div class="btn bp10" style="float:left;">
	<?for($date=5;$date<=$date_count;$date++){?>	
	<a href="<?=$PHP_SELF?>?ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
	<?}?>
</div>
<div class="searchArea" style="clear:both;">
	
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
		<fieldset>
			<legend>상세 검색</legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
					<col style="width: 5%;">
					<col style="width: 10%;">
				</colgroup>
				<tbody>
					<tr>
						<th>ID</th>
						<td class="al"><input type="text" name="id" id="id" value="<?=$id?>" style="width:95%;"></td>
						<th>성명</th>
						<td class="al"><input type="text" name="name_kr" id="name_kr" value="<?=$name_kr?>" style="width:95%;"></td>
						<th>소속</th>
						<td class="al"><input type="text" name="aff_kor" id="aff_kor" value="<?=$aff_kor?>" style="width:95%;"></td>
						<th>E-mail</th>
						<td class="al"><input type="text" name="email" id="email" value="<?=$email?>" style="width:95%;"></td>
						<th>면허번호</th>
						<td class="al"><input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;"></td>
					</tr>
					
					
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$exam_result?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel_backup_ind.php?ev_date=<?=$ev_date?>'" class="btnMint initialism fade_open btn btn-success ex_btn">
			</div>
		</fieldset>
	</form>
</div>
<div class="bp10"  style="clear:both;"></div>
<script>
	function change_paystat(str,sid,kind){
		$.ajax({
			type:"POST",
			url:"/registration/stat_change.php",
			data:"str="+str+"&sid="+sid+"&kind="+kind,
			success:function(msg){
			}
		});
	}
</script>
<table class="tblDef">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="">
		<col style="width: 8%;">
		<?for($i=$time_max_count;$i<=$time_max_count;$i++){?>
		<col style="width: 9%;">
		<col style="width: 9%;">
		<?}?>

		

		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="width: 5%;">

		<col style="width: 3%;">
		<col style="width: 3%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>행사일</th>
			<th>회원구분</th>
			<th>상세구분</th>
			<th>성명</th>
			<th>면허번호 </th>
			<th><?=admin_orderby("강의실 입장","first_date",$sort_field,$orderby,$search_url)?></th>
			<?for($i=$time_max_count;$i<=$time_max_count;$i++){?>
			<th><?=admin_orderby("필수세션 입장","s".$i."_sdate",$sort_field,$orderby,$search_url)?></th>
			<th><?=admin_orderby("필수세션 퇴장","s".$i."_edate",$sort_field,$orderby,$search_url)?></th>
			<?}?>
			
			

			<th>최종퇴장</th>
			<th>체류시간</th>
			<th>필수 평점</th>

			<th>조정</th>
			<th>삭제</th>
			<!-- <th>상세</th> -->
		</tr>
	</thead>
	<tbody>
		<?
			$n=1;
		
			while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				
				unset($stay_hours);
				unset($stay_min);
				unset($score);
				unset($sum_score);
				unset($sum_times);
				unset($score_kaim);
				

				unset($stay_hours_ind);
				unset($stay_min_ind);
				unset($score_ind);
				unset($sum_score_ind);
				unset($ind_time);
				unset($ind);
				unset($sum_times_ind);
				
				for($i=$time_max_count;$i<=$time_max_count;$i++){ //세션갯수만큼
					${"mm".$i}=0;
					${"s".$i."_sdate"} = "";
					${"s".$i."_edate"} = "";

					//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
					if($d['s'.$i.'_sdate']) ${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$d['s'.$i.'_sdate']));
					
					${"s".$i."_edate"} = $d['s'.$i.'_edate'];
					if(strtotime($_TIME['session_ind'][$d['day']][$i][0])>$d['s'.$i.'_sdate'] && $d['s'.$i.'_sdate']){
						${"s".$i."_sdate"} = strtotime($_TIME['session_ind'][$d['day']][$i][0]);
					}
					if(strtotime($_TIME['session_ind'][$d['day']][$i][1])<$d['s'.$i.'_edate'] && $d['s'.$i.'_edate']){
						${"s".$i."_edate"} = strtotime($_TIME['session_ind'][$d['day']][$i][1]);
					}
					if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session_ind'][$d['day']][$i][0])){
						${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
						${"mm".$i} = (${"s".$i."_time"}/60);

					}
					if(${"mm".$i}>0){
						$sum_times += (${"mm".$i});
					}
				}
				

				
				$sum_score = floor($sum_times);
				$sum_score_ind = floor($sum_times_ind);
				
				if($sum_score>0){
					if($sum_score>=60){
						$stay_hours = sprintf("%02d", floor($sum_score/60));
						$stay_min = sprintf("%02d", floor($sum_score%60));
						$score = floor($stay_hours);
						$score_kaim = floor($stay_hours);

					}else{
						$stay_hours = 0;
						$stay_min = sprintf("%02d", floor($sum_score%60));
						$score = floor($stay_hours);
						$score_kaim = 0;
					}
					
					if($score>6){
						$score = 6;
					}
					if($score_kaim>6){
						$score_kaim = 6;
					}
				}

				if($sum_score_ind>0){
					if($sum_score_ind>=60){
						$stay_hours_ind = sprintf("%02d", floor($sum_score_ind/60));
						$stay_min_ind = sprintf("%02d", floor($sum_score_ind%60));
						$score_ind = floor($stay_hours_ind);

					}else{
						$stay_hours_ind = 0;
						$stay_min_ind = sprintf("%02d", floor($sum_score_ind%60));
						$score_ind = floor($stay_hours_ind);
					}
				}

		?>
		<tr <?if($d['modify']=='Y'){?>style="background:#EDEDED"<?}?>>
			<td><?=$virtualRecordNo?><?if($_SERVER['REMOTE_ADDR']=='218.235.94.2220'){?> / <?=$n?><?}?></td>
			<td><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
			<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
			<td><?=$_REG['gubun1'][$d['gubun1']]?><?=$d['room']?></td>
			<td><a href="javascript:popup_call('registration/postform','sid=<?=$d['usid']?>')"><?=$d['name_kr']?></a><?if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){?> / <?=$d['usid']?><?}?></td>
			
			<td><?=$d['license_number']?></td>
			<td style="background:#FCEBF1;"><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?><!-- <br><?=$d['first_date']?> --></td>
			
			<?for($i=$time_max_count;$i<=$time_max_count;$i++){?>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_sdate']>0){?>
					<a href="javascript:popup_call('registration/session_time_ind','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_sdate'])?></a>
				<?}?>
			</td>
			<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
				<?if($d['s'.$i.'_edate']>0){?>
					<a href="javascript:popup_call('registration/session_time_ind','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"><?=date("H:i",$d['s'.$i.'_edate'])?></a>
				<?}?>
			</td>
			<?}?>

			

			<td style="background:#FCEBF1;">
			<?
				// if($d['last_date']>$d['logout_day'.$d['day']]){
				// 	echo date('H:i',$d['last_date']);
				// }else{
				// 	echo date('H:i',$d['logout_day'.$d['day']]);
				// }
				if($d['last_date']) echo date('H:i',$d['last_date']);
			?>
			</td>
			<td><?=$stay_hours.":".$stay_min?></td>
			<td >
			<?
				if($sum_score>0){
					if($score_ind>0){
						echo $score;
					}else{
						echo $score;
					}
				}
			?>
			</td>

			<td><i class="far fa-clock" style="cursor:pointer;font-size:18px;" onclick="popup_call('registration/session_time_ind','sid=<?=$d['sid']?>&day=<?=$d['day']?>&group_key=<?=$d['group_key']?>')"></i></td>
			<!-- <td><span class="rBtnAdmin small darkPink"><button type="button" onclick="popup_call('registration/checkin_list','sid=<?=$d['usid']?>&day=<?=$day?>')">View</button></span></td> -->
			<td><img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$d['sid']?>','checkin_ind')"></td>
		</tr>
		<?$n++;?>
		<?$virtualRecordNo--;}?>

		<!-- <?=$n?> -->
	</tbody>
</table>
<?
	if($add_search2) $search_url .= $add_search2;
	if($sort_field) $search_url .= "&sort_field=".$sort_field;
	if($orderby) $search_url .= "&orderby=".$orderby;
?>
<div class="btnArea posRel tp0">
	<?include $_SERVER['DOCUMENT_ROOT']."/include.page.php"?>						
</div>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>
 