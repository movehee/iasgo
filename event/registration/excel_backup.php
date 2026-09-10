<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=inout_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$ev_date = isset($ev_date) ? (int)$ev_date : 1;
	if ($ev_date < 1 || !isset($_TIME['session'][$ev_date])) {
		$ev_date = 1;
	}
	$time_max_count = count($_TIME['session'][$ev_date]);

	$search_type = isset($search_type) && $search_type ? $search_type : 'and';

	$not_search_Arr = array();
	foreach($_COOKIE as $tkey=>$tval){
		$not_search_Arr[] = $tkey;
	}
	$not_search_field = array('page','order','stand','redirect','num_per_page','search_query','li_page','sort_field','orderby','result_code','ev_date');
	foreach($not_search_field as $tkey=>$tval){
		$not_search_Arr[] = $tval;
	}

	$search_query = array();
	$day_query = array();
	foreach($_REQUEST as $tkey=>$tval){
		if($tval && !in_array($tkey,$not_search_Arr)){
			if($tkey!="search_type"){
				if($tkey=='key'){
					$search_query[] = " usid = '".(int)$tval."' ";
				}else if (preg_match('/^s([0-9]+)_(sdate|edate)$/', $tkey, $sm) && (int)$sm[1] >= 1 && (int)$sm[1] <= $time_max_count) {
					if($tval=='Y'){
						$search_query[] = " ".$tkey.">0 ";
					}else if($tval=='N'){
						$search_query[] = " (".$tkey."='' or ".$tkey." is null) ";
					}
				}else if (preg_match('/^s([0-9]+)_(stime|etime)$/', $tkey, $sm) && (int)$sm[1] >= 1 && (int)$sm[1] <= $time_max_count) {
					if (!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $tval)) {
						continue;
					}
					$sessionNo = (int)$sm[1];
					if ($sm[2] == 'stime') {
						$search_query[] = " s".$sessionNo."_sdate>=unix_timestamp(concat(substr(from_unixtime(s".$sessionNo."_sdate),1,10),' ".$tval."'))";
					} else {
						$search_query[] = " s".$sessionNo."_edate<=unix_timestamp(concat(substr(from_unixtime(s".$sessionNo."_edate),1,10),' ".$tval."'))";
					}
				}else if($tkey=='id'){
					$day_query[] = " $tkey like '%".$tval."%' ";
				}else{
					$search_query[] = " $tkey like '%".$tval."%' ";
				}
			}
		}
	}
	if($day_query){
		$search_query[] = " (".implode(" or ",$day_query).")";
	}

	if($search_query){
		$fsql = " where ".implode($search_type,$search_query) . " and del='N' and day='".$ev_date."'";
	}else{
		$fsql = " where del='N' and day='".$ev_date."' ";
	}

	$sort_sql = " order by day desc, first_date asc";
	$session_field = array();
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}

	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,name_eng,license_number,id,aff_kor,aff_eng,email,classification,title,country,modify,member_level,chking,etc_field2,memo,cell,".getSessionStayTimeSql($ev_date);

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid";
	$query .= ") A ".$fsql.$sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) {
		error_log('[ExcelBackup] query failed: '.$result->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	
?>
<style>
td{mso-number-format:\@;} 
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>행사일</th>
		<th>등록구분</th>
		<th>등록번호</th>
		<th>ID</th>
		<th>성명</th>
		<th>성명(영문)</th>
		<th>면허번호</th>
		<th>카테고리</th>
		<th>소속</th>
		<th>소속(영문)</th>
		<th>연락처</th>
		<th>강의실 입장</th>
		<?for($i=1;$i<=$time_max_count;$i++){?>
		<th>S<?=$i?>입장</th>
		<th>S<?=$i?>퇴장</th>
		<?}?>
		<th>최종퇴장</th>
		<th>체류시간</th>
		<th>평점</th>
		<th>메모</th>
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$stayInfo = getSessionStayScore(isset($d['total_time']) ? $d['total_time'] : 0, $scoreMaxHour);
			$stay_hours = $stayInfo['stay_hours'];
			$stay_min = $stayInfo['stay_min'];
			$score = $stayInfo['score'];

			$feeLabel = $d['title'];
			$isDomestic = ($d['country'] == 'K');
			$isOverseas = ($d['country'] == 'F');
			if ($isDomestic && isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if ($isOverseas && isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			}
			$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : '';
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
		<td><?=$classLabel?></td>
		<td><?=$d['etc_field2']?></td>
		<td><?=$d['id']?></td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['name_eng']?></td>
		<td><?=$d['license_number']?></td>
		<td><?=$feeLabel?></td>
		<td><?=$d['aff_kor']?></td>
		<td><?=$d['aff_eng']?></td>
		<td><?=$d['cell']?></td>

		<td style="background:#FCEBF1;"><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?></td>
		
		<?for($i=1;$i<=$time_max_count;$i++){?>
		<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
			<?if($d['s'.$i.'_sdate']>0){?>
				<?=date("H:i",$d['s'.$i.'_sdate'])?>
			<?}?>
		</td>
		<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}else{?>style="background:#ECF8F9;"<?}?>>
			<?if($d['s'.$i.'_edate']>0){?>
				<?=date("H:i",$d['s'.$i.'_edate'])?>
			<?}?>
		</td>
		<?}?>
		<td style="background:#FCEBF1;">
		<?
			if($d['last_date']) echo date('H:i',$d['last_date']);
		?>
		</td>
		<td><?=$stay_hours !== '' ? $stay_hours.':'.$stay_min : ''?></td>
		<td><?=(int)$score?></td>
		<td><?=$d['memo']?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>
