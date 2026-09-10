<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=dedicated_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	procAdminLoginChk();

	if($kind=='A'){
		$login_sql = "login1='Y' or login2='Y'";
		$dd1=1;
		$dd2=2;
		$tt = "기본";
		$dt1 = "23";
		$dt2 = "24";
	}else{
		$login_sql = "login3='Y' or login4='Y'";
		$dd1=3;
		$dd2=4;
		$tt = "심화";
		$dt1 = "25";
		$dt2 = "26";
	}
	$fsql = " where del='N' and ($login_sql) and member_level!='M' ";

	$query = "select * from registration_tbl " .$fsql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>등록종류</th>
		<th>등록구분</th>
		<th>전문의구분</th>
		<!-- <th>연차</th> -->
		<th>ID</th>
		<th>성명</th>
		<th>면허번호</th>	
		<th>소속</th>
		<th>E-mail</th>
		<th>연락처</th>
		<th>교육과정</th>
		<th><?=$dt1?>일</th>
		<th><?=$dt2?>일</th>
		<th>감염관리 전담인력 교육시간</th>
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['class_kind'][$d['classification']]?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?=$_REG['gubun1'][$d['gubun1']]?><?if($d['gubun2']){?><br />(<?=$_REG['gubun2'][$d['gubun2']]?>)<?}?></td>
		<!-- <td><?=$d['major_year']?></td> -->
		<td><?=$d['id']?></td>
		<td><?=$d['name_kr']?></td>
		
		
		<td><?=$d['license_number']?></td>
		
		<td><?=$d['aff_kor']?></td>
		<td><?=$d['email']?></td>
		<td><?=$d['cell']?></td>
		<td><?=$tt?>과정</td>
		<td>
		<?
			$time1_query = "select * from checkin_tbl where usid='".$d['sid']."' and day='$dd1'";
			$result_t1 = $conn->query($time1_query);
			if(DB::isError($result_t1)) {
			  die($result_t1->getMessage());
			}
			$result_t1->fetchInto(&$t1,DB_FETCHMODE_ASSOC);
			$result_t1->free();
			$time_max_count=2;
			unset($stay_hours);
			unset($stay_min);
			unset($score);
			unset($score1);
			unset($sum_score);
			unset($sum_times);
			for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼

				${"mm".$i}=0;
				${"s".$i."_sdate"} = "";
				${"s".$i."_edate"} = "";

				//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
				${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$t1['s'.$i.'_sdate']));
				${"s".$i."_edate"} = $t1['s'.$i.'_edate'];
				if(strtotime($_TIME['session'][$t1['day']][$i][0])>$t1['s'.$i.'_sdate'] && $t1['s'.$i.'_sdate']){
					${"s".$i."_sdate"} = strtotime($_TIME['session'][$t1['day']][$i][0]);
				}
				if(strtotime($_TIME['session'][$t1['day']][$i][1])<$t1['s'.$i.'_edate'] && $t1['s'.$i.'_edate']){
					${"s".$i."_edate"} = strtotime($_TIME['session'][$t1['day']][$i][1]);
				}
				if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$t1['day']][$i][0])){
					${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
					${"mm".$i} = (${"s".$i."_time"}/60);
				}
				if(${"mm".$i}>0){
					$sum_times += (${"mm".$i});
				}
			}
			
			$sum_score = floor($sum_times);
			
			if($sum_score>0){
				if($sum_score>=60){
					$stay_hours = sprintf("%02d", floor($sum_score/60));
					$stay_min = sprintf("%02d", floor($sum_score%60));
				}else{
					$stay_hours = 0;
					$stay_min = sprintf("%02d", floor($sum_score%60));
				}
				$score = floor($stay_hours);
		
			}
			echo $stay_hours.":".$stay_min;

			if($stay_hours>=7){
				$score1 = 8;
			}else{
				$score1 = $stay_hours;
			}
		?>
		</td>
		
		<td>
		<?
			$time2_query = "select * from checkin_tbl where usid='".$d['sid']."' and day='$dd2'";
			
			$result_t2 = $conn->query($time2_query);
			if(DB::isError($result_t2)) {
			  die($result_t2->getMessage());
			}
			$result_t2->fetchInto(&$t2,DB_FETCHMODE_ASSOC);
			$result_t2->free();
			if($t2['day']=='2'){
				$time_max_count=3;
			}else{
				$time_max_count=2;
			}
			
			unset($stay_hours);
			unset($stay_min);
			unset($score);
			unset($score2);
			unset($sum_score);
			unset($sum_times);
			for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼

				${"mm".$i}=0;
				${"s".$i."_sdate"} = "";
				${"s".$i."_edate"} = "";

				//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
				${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$t2['s'.$i.'_sdate']));
				${"s".$i."_edate"} = $t2['s'.$i.'_edate'];
				if(strtotime($_TIME['session'][$t2['day']][$i][0])>$t2['s'.$i.'_sdate'] && $t2['s'.$i.'_sdate']){
					${"s".$i."_sdate"} = strtotime($_TIME['session'][$t2['day']][$i][0]);
				}
				if(strtotime($_TIME['session'][$t2['day']][$i][1])<$t2['s'.$i.'_edate'] && $t2['s'.$i.'_edate']){
					${"s".$i."_edate"} = strtotime($_TIME['session'][$t2['day']][$i][1]);
				}
				if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$t2['day']][$i][0])){
					${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
					${"mm".$i} = (${"s".$i."_time"}/60);
				}
				if(${"mm".$i}>0){
					$sum_times += (${"mm".$i});
				}
			}
			
			$sum_score = floor($sum_times);
			
			if($sum_score>0){
				if($sum_score>=60){
					$stay_hours = sprintf("%02d", floor($sum_score/60));
					$stay_min = sprintf("%02d", floor($sum_score%60));
				}else{
					$stay_hours = 0;
					$stay_min = sprintf("%02d", floor($sum_score%60));
				}
				$score = floor($stay_hours);
		
			}
			echo $stay_hours.":".$stay_min;
			if($stay_hours>=7){
				$score2 = 8;
			}else{
				$score2 = $stay_hours;
			}
		?>
		</td>
		<td><?=$score1+$score2?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>