<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=vod_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$time_max_count = 4;

	$fsql = " where del='N' and login2='Y' and login_day2>0 and member_level!='M' and classification not in ('M','X','Z')";

	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking,reg_kind,gubun1";

	$query = "select * from registration_tbl " .$fsql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$time_max_count = count($_TIME['session']['1']);
	for($i=1;$i<=count($_TIME['session']);$i++){
		if($time_max_count<count($_TIME['session'][$i])){
			$time_max_count = count($_TIME['session'][$i]);
		}
	}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>구분</th>
		<th>상세구분</th>
		<th>성명</th>
		<th>면허번호</th>	
		<th>복부초음파</th>
		<th>갑상선초음파</th>
		<th>근골격계초음파</th>
		<th>심초음파</th>
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?if($d['reg_kind']=='B'){?><?=$d['major_year']?>년차<?}else{?><?=$_REG['gubun1'][$d['gubun1']]?><?}?></td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['license_number']?></td>

		<?
		$vod_number = array('1','2','3','4');
			foreach($vod_number as $tkey=>$tval){
				$progress_query = "select * from vod_result_tbl where vsid='$tval' and usid='".$d['sid']."'";
				$progress_result = $conn->query($progress_query);
				$progress_result->fetchInto(&$p,DB_FETCHMODE_ASSOC);
				$progress_result->free();
				unset($progress);
				if($p['sid']){
					if($p['c_time']>0){
						$progress = round(($p['c_time']/$p['r_time'])*100);
					}
				}else{
					$progress = 0;
				}
		?>
		<td><?=number_format($progress)?>%</td>
		<?}?>
	</tr>
	<?$n++;?>
	<?}?>
</table>