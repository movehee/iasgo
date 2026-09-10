<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Booth_Event_Day".$_GET['day']."_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}

	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$day=$_GET['day'];
	$query = "select usid,count(*) as bcnt from booth_stamp group by usid having bcnt>=33";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$user_sid[] = $d['usid'];
	}

	if(count($user_sid)==0){
		exit;
	}
	$query = "select t1.*,t2.name_kr,t2.reg_kind,t2.license_number,t2.gubun2,t2.aff_kor,t2.cell,t2.email,t2.event_chk from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.usid in (".implode(",",$user_sid).")  and t2.event_chk='Y' and t1.day='$day' order by t2.name_kr asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th>No</th>
		<th>구분</th>
		<th>소속과</th>
		<th>성명</th>
		<th>면허번호</th>	
		<th>소속</th>	
		<th>연락처</th>	
		<th>이메일</th>
		<th>당첨여부</th>
		<th>당첨시간</th>
	</tr>
<?	
	$pnum=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
		unset($stay_hours);
		unset($stay_min);
		unset($score);
		unset($sum_score);
		unset($sum_times);
		for($i=1;$i<=4;$i++){ //세션갯수만큼
			${"mm".$i}=0;
			${"s".$i."_sdate"} = "";
			${"s".$i."_edate"} = "";

			${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
			${"s".$i."_edate"} = $d['s'.$i.'_edate'];
			if(strtotime($_TIME['session'][$d['day']][$i][0])>$d['s'.$i.'_sdate']){
				${"s".$i."_sdate"} = strtotime($_TIME['session'][$d['day']][$i][0]);
			}
			if(strtotime($_TIME['session'][$d['day']][$i][1])<$d['s'.$i.'_edate']){
				${"s".$i."_edate"} = strtotime($_TIME['session'][$d['day']][$i][1]);
			}
			if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$d['day']][$i][0])){
				${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
				${"mm".$i} = (${"s".$i."_time"}/60);
			}
			$sum_times += (${"mm".$i});
		}
		
		$sum_score = floor($sum_times);
		$stay_hours = floor($sum_score/60);
		if($stay_hours>=3){
?>
<tr>
	<td><?=$pnum?></td>
	<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
	<td><?=$d['gubun2']?></td>
	<td><?=$d['name_kr']?></td>
	<td><?=$d['license_number']?></td>
	<td><?=$d['aff_kor']?></td>
	<td><?=$d['cell']?></td>
	<td><?=$d['email']?></td>
	<td><?=$d['pick']?></td>
	<td><?if($d['pick_time']>0 && $d['pick']=='Y'){?><?=date("Y-m-d H:i:s",$d['pick_time'])?><?}?></td>
</tr>

<?$pnum++;}?>
<?}?>
</table>