<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=inout_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();

	$session_date2 = "2020-11-29";
	$_TIME['session']['2'] = array(
		'3' => array( $session_date2." 13:00", $session_date2." 17:55" )
	);


	
	$query = "select t1.*,t2.name_kr,t2.sid as usid,t2.id,t2.aff_kor,t2.license_number,t2.email,t2.cell,t2.score_chk from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where del='N' and t2.sleep_chk='Y' and t1.day='2' " . $fsql;
	$query .= "   order by t1.day asc, t1.first_date asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$time_max_count = count($_TIME['session']['1']);
	for($i=1;$i<=count($_TIME['session']);$i++){
		if($time_max_count<count($_TIME['session'][$i])){
			$time_max_count = count($_TIME['session'][$i]);
		}
	}
?>
<table border=1>
	<tr>
		<th>No</th>
		<th>행사</th>
		<th>ID</th>
		<th>Name</th>
		<th>면허번호</th>
		<th>이메일</th>
		<th>핸드폰</th>
		<th>소속</th>
		<th>수면다윈검사 입장</th>
		<th>수면다윈검사 퇴장</th>
		<th>체류시간</th>
		<th>평점</th>
		<th>평점여부</th>
		<!-- <th>상세</th> -->
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
			
			unset($stay_hours);
			unset($stay_min);
			unset($score);
			unset($sum_score);
			unset($sum_times);
			for($i=3;$i<=3;$i++){ //세션갯수만큼
				${"mm".$i}=0;
				${"s".$i."_sdate"} = "";
				${"s".$i."_edate"} = "";

				${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
				${"s".$i."_edate"} = $d['s'.$i.'_edate'];
				if(strtotime($_TIME['session'][$d['day']][$i][0])>$d['s'.$i.'_sdate'] && $d['s'.$i.'_sdate']){
					${"s".$i."_sdate"} = strtotime($_TIME['session'][$d['day']][$i][0]);
				}
				if(strtotime($_TIME['session'][$d['day']][$i][1])<$d['s'.$i.'_edate'] && $d['s'.$i.'_edate']){
					${"s".$i."_edate"} = strtotime($_TIME['session'][$d['day']][$i][1]);
				}
				if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$d['day']][$i][0])){
					${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
					${"mm".$i} = (${"s".$i."_time"}/60);
				}
				$sum_times += (${"mm".$i});
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
				if($score>6){
					$score = 6;
				}
			}
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$d['day']?>일차</td>
		<td><?=$d['id']?></td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['license_number']?></td>
		<td><?=$d['email']?></td>
		<td><?=$d['cell']?></td>
		<td><?=$d['aff_kor']?></td>
		
		<?for($i=3;$i<=3;$i++){?>
		<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}?>>
			<?if($d['s'.$i.'_sdate']>0){?><?=date("H:i",$d['s'.$i.'_sdate'])?><?}?>
		</td>
		<td <?if($i%2==0){?>style="background:#FEFFE1;"<?}?>>
			<?if($d['s'.$i.'_edate']>0){?><?=date("H:i",$d['s'.$i.'_edate'])?><?}?>
		</td>
		<?}?>
		<td style="mso-number-format:'\@'"><!-- <?=round($sum_score)?><br /> --><?=$stay_hours.":".$stay_min?></td>
		<td style="mso-number-format:'\@'">
			<?if($score>1){?><?=$score?><?}?>
		</td>
		<td><?=$d['score_chk']?></td>
		<!-- <td><span class="rBtnAdmin small darkPink"><button type="button" onclick="popup_call('registration/checkin_list','sid=<?=$d['usid']?>&day=<?=$day?>')">View</button></span></td> -->
	</tr>
	<?$n++;?>
	<?}?>
</table>