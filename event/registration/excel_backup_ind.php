<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=inout_ind_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();


	
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	//$time_max_count=count($_TIME['session'][$ev_date]);
	if($ev_date=='1'){
		$time_max_count=2; //총 세션의 갯수 정의
	}else{
		$time_max_count=3; //총 세션의 갯수 정의
	}

	$sort_sql = "   order by day desc, first_date asc";
	for($s=$time_max_count;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}

	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking,reg_kind,gubun1,etc_field1,etc_field2";

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl_ind as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	$query .= ") A where del='N' and day='$ev_date' ". $sort_sql; //and member_level!='M' and classification not in ('M','X','Z') 
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border=1>
	<tr>
		<th>No</th>
		<th>행사일</th>
		<th>등록번호</th>
		<th>회원구분</th>
		<th>상세구분</th>
		<th>성명</th>
		<th>면허번호 </th>
		<th>강의실 입장</th>
		<?for($i=$time_max_count;$i<=$time_max_count;$i++){?>
		<th>필수세션 입장</th>
		<th>필수세션 퇴장</th>
		<?}?>
		<th>최종퇴장</th>
		<th>체류시간</th>
		<th>필수 평점</th>
	</tr>
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
				if($ind>0){
					$sum_times_ind = $ind;
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
	<tr>
		<td><?=$n?></td>
		<td><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]));?></td>
		<td><?=$d['etc_field2']?></td>
		<td><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td><?=$_REG['gubun1'][$d['gubun1']]?></td>
		<td><?=$d['name_kr']?></td>
		
		
		<td><?=$d['license_number']?></td>
		<td style="background:#FCEBF1;"><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?><!-- <br><?=$d['first_date']?> --></td>
		
		<?for($i=$time_max_count;$i<=$time_max_count;$i++){?>

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
					echo $score-$score_ind;
					//echo $score;
				}else{
					echo $score;
				}
			}
		?>
		</td>
	</tr>
	<?$n++;?>
	<?}?>
</table>