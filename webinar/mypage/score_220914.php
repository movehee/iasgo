<div class="pointNote">
	<ul class="listBl typeA">
		<li>
			연수평점은 데이터 누락을 최소화 하기 위해 <span class="underline fcRed">당일 세션이 모두 종료된 후 2시간 이후부터 확인 가능합니다.</span><br>
			(단, 당일 체류시간에는 Break 시간이 포함되어 있으므로 대회 종료 후 실제 평점 인정 시간과 다를 수 있습니다.)
		</li>
		<li>
			<span class="underline">평점 관련 문의사항이 있으실 경우, 전화 문의는 누락될 수가 있기 때문에&nbsp;가급적 사무국 메일(<a href="mailti:ask@kcr4u.org" class="fcBlue">ask@kcr4u.org</a>)로 문의 주시면 순차적으로 확인 후 답변 드리겠습니다.</span> <br>
			대회 기간 문의가 많아 시간이 소요될 수 있는 점 양해 부탁드립니다.<br>
			(단, 평점 관련 문의 시, <span class="underline fcRed">성명/ 면허번호/ 세션명/ 세션 수강한 시간 정보와 함께 문의</span> 주시면 조속한 확인이 가능합니다.)
		</li>
		<li>
			필수평점교육 당일 일반평점 인정 기준이 <span class="fcRed underline">2022년 부터 필수평점교육 수강 여부에 관계없이 일반평점은 최대 4평점까지만 이수 가능한 것으로 변경</span>되었기 때문에 하기의 평점 인정 기준 내용을 반드시 숙지하여 주시기 바랍니다.
		</li>
	</ul>

	<div class="util">
		<a href="/load/score_guide.php" class="viewPopup Load_Base"  Wsize='1000'  Hsize='578'>평점 인정 기준 및 취득 방법</a>
		<a href="/load/score_faq.php" class="viewPopup Load_Base"  Wsize='1000'  Hsize='578'>평점 관련 FAQ</a>
	</div>
</div>

<?
$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
$date_count = date("d",$chkdate);
$ex_sdate = explode("-",$_Webinar['sdate']);


for($ii=1; $ii<=5; $ii++) {

	$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid,t2.classification,t2.logout_day1,t2.logout_day2,t2.logout_day3,t2.logout_day4,t2.logout_day5,t2.reg_kind,t2.gubun1,t2.gubun2 ";
	$query .= " from checkin_tbl".$_COOKIE['Gkey']." as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.usid='".$_COOKIE['wmember_sid']."' and t1.day=".$ii;
	$query .= "  order by t1.day asc, sid asc";
	$result=$conn->query($query);

	$result->fetchInto(&$d, DB_FETCHMODE_ASSOC);
	$result->free();


	if(DB::isError($result)) die($result->getMessage());
	
	$Days = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ii-1), $ex_sdate[0]));
	
	unset($_Time);
	
	$time_max_count = count($_TIME['session_standard'][$ii]);

	
	for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼
		$_Time['mm'.$i]=0;
		$_Time['s'.$i.'_sdate'] = "";
		$_Time['s'.$i.'_edate'] = "";
		$_Time['s'.$i.'_time'] = "";
		
		$_Time['ind_mm'.$i]=0;
		$_Time['ind_s'.$i.'_sdate_ind'] = "";
		$_Time['ind_s'.$i.'_edate_ind'] = "";
		$_Time['ind_s'.$i.'_time_ind'] = "";
		

		if($d['s'.$i.'_sdate']) $_Time['s'.$i.'_sdate'] = strtotime(date("Y-m-d H:i",$d['s'.$i.'_sdate']));
		$_Time['s'.$i.'_edate'] = $d['s'.$i.'_edate'];
		if(strtotime($_TIME['session_standard'][$d['day']][$i][0])>$d['s'.$i.'_sdate'] && $d['s'.$i.'_sdate']){
			$_Time['s'.$i.'_sdate'] = strtotime($_TIME['session_standard'][$d['day']][$i][0]);
		}
		if(strtotime($_TIME['session_standard'][$d['day']][$i][1])<$d['s'.$i.'_edate'] && $d['s'.$i.'_edate']){
			$_Time['s'.$i.'_edate'] = strtotime($_TIME['session_standard'][$d['day']][$i][1]);
		}
		if($_Time['s'.$i.'_sdate']>0 && $_Time['s'.$i.'_edate']>0 && $_Time['s'.$i.'_edate']>strtotime($_TIME['session_standard'][$d['day']][$i][0])){
			$_Time['s'.$i.'_time'] = $_Time['s'.$i.'_edate']-$_Time['s'.$i.'_sdate'];
			$_Time['mm'.$i] = ($_Time['s'.$i.'_time']/60);
		}
		if($_Time['mm'.$i]>0) { 

			if($i==3 && $ii==5) { //마지막날 마지막세션(필수평점세션) 은 따로저장
				$_Time['ind_sum_times'] += ($_Time['mm'.$i]);
			} else {
				$_Time['sum_times'] += ($_Time['mm'.$i]);
			}
		}
	}

	
	$_Time['sum_score'] = floor($_Time['sum_times']);
	$_Time['ind_sum_score'] = floor($_Time['ind_sum_times']);
	
	if($_Time['sum_score']>0){
		if($_Time['sum_score']>=60){
			$_Time['stay_hours'] = sprintf("%02d", floor($_Time['sum_score']/60));
			$_Time['stay_min'] = sprintf("%02d", floor($_Time['sum_score']%60));
		}else{
			$_Time['stay_hours'] = 0;
			$_Time['stay_min'] = sprintf("%02d", floor($_Time['sum_score']%60));
		}
		$_Time['score'] = floor($_Time['stay_hours']);
		if($_Time['score']>6){
			$_Time['score'] = 6;
		}
	}
	if($_Time['ind_sum_score']>0){
		if($_Time['ind_sum_score']>=60){
			$_Time['ind_stay_hours'] = sprintf("%02d", floor($_Time['ind_sum_score']/60));
			$_Time['ind_stay_min'] = sprintf("%02d", floor($_Time['ind_sum_score']%60));
		}else{
			$_Time['ind_stay_hours'] = 0;
			$_Time['ind_stay_min'] = sprintf("%02d", floor($_Time['ind_sum_score']%60));
		}
		$_Time['ind_score'] = floor($_Time['ind_stay_hours']);
		if($_Time['ind_score']>6){
			$_Time['ind_score'] = 6;
		}
	}
?>
<h3 class="subTit">DAY <?=$ii?>.<span> <?=Days_convert($Days,"M D (w)")?></span></h3>
<table class="tblDef">
	<colgroup>
		<col style="width: 6%;">

		<?php if($ii == "5"){?>

			<col style="width:5%;">
			<col style="width:5%;">
			<col style="width:5%;">
			<col style="width:5%;">

			<col style="width: 8%;">

			<col style="width:5%;">
			<col style="width:5%;">

		<?} else {?>
			<?foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){?>
			<col style="width:5%;">
			<col style="width:5%;">
			<?}?>
		<?}?>
		<col style="width: 8%;">
	</colgroup>
	<thead>
		<tr>
			<th rowspan="2">최초입장</th>

			<?php if($ii == "5"){?>
				<?
				foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){
					$stime = strtotime($_TIME['session_standard'][$ii][$tkey][0]);
					$etime = strtotime($_TIME['session_standard'][$ii][$tkey][1]);

					if($tkey == "3") break;
				?>
				<th colspan="2">Session <?=$tkey?> <br /><span class="fcRed">(<?=date("H:i",$stime)?> ~ <?=date("H:i",$etime)?>)</span></th>
				<?}?>

				<th rowspan="2">총 체류시간/<br>평점</th>
				<?php
				$stime = strtotime($_TIME['session_standard'][$ii][3][0]);
				$etime = strtotime($_TIME['session_standard'][$ii][3][1]);
				?>
				<th colspan="2">필수평점교육세션 <br /><span class="fcRed">(<?=date("H:i",$stime)?> ~ <?=date("H:i",$etime)?>)</span></th>
				<th rowspan="2">필수평점</th>

			<?} else {?>
				<?
				foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){
					$stime = strtotime($_TIME['session_standard'][$ii][$tkey][0]);
					$etime = strtotime($_TIME['session_standard'][$ii][$tkey][1]);
				?>
				<th colspan="2">Session <?=$tkey?> <br /><span class="fcRed">(<?=date("H:i",$stime)?> ~ <?=date("H:i",$etime)?>)</span></th>
				<?}?>
				<th rowspan="2">총 체류시간/<br>평점</th>
			<?}?>
		</tr>
		<tr>
			<?foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){?>
			<th class="bdLeft">입장</th>
			<th>퇴장</th>
			<?}?>
		</tr>
	</thead>
	<tbody>

	<?php if($ii == "5"){?>

		<tr>
			<td><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?></td>
			<?foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){
				if($tkey == "3") break;	
			?>
			<td><?if($d['s'.$tkey.'_sdate']>0){?><?=date("H:i",$d['s'.$tkey.'_sdate'])?><?}?></td>
			<td><?if($d['s'.$tkey.'_edate']>0){?><?=date("H:i",$d['s'.$tkey.'_edate'])?><?}?></td>
			<?}?>
			<td><?=$_Time['stay_hours'].":".$_Time['stay_min']?><?if($_Time['score']>0){?> / <?=$_Time['score']?><?}?></td>

			<td><?if($d['s3_sdate']>0){?><?=date("H:i",$d['s3_sdate'])?><?}?></td>
			<td><?if($d['s3_edate']>0){?><?=date("H:i",$d['s3_edate'])?><?}?></td>
			

			
			<td><?=$_Time['ind_stay_hours'].":".$_Time['ind_stay_min']?><?if($_Time['ind_score']>0){?> / <?=$_Time['ind_score']?>점<?}?></td>
		</tr>

	<?} else {?>
		<tr>
			<td><?if($d['first_date']>0){?><?=date("H:i",$d['first_date'])?><?}?></td>

			<?foreach($_TIME['session_standard'][$ii] as $tkey=>$tval){?>
			<td><?if($d['s'.$tkey.'_sdate']>0){?><?=date("H:i",$d['s'.$tkey.'_sdate'])?><?}?></td>
			<td><?if($d['s'.$tkey.'_edate']>0){?><?=date("H:i",$d['s'.$tkey.'_edate'])?><?}?></td>
			<?}?>


			<td><?=$_Time['stay_hours'].":".$_Time['stay_min']?><?if($_Time['score']>0){?> / <?=$_Time['score']?><?}?></td>
		</tr>
	<?}?>
	</tbody>	
</table>

<?}?>
<p class="tm15">*유의사항: 2022년부터 필수평점교육이 있는 당일(9월 24일)의 일반 평점은 필수평점교육 수강 여부와 관계없이, 일반평점 최대 4평점 까지만 인정됩니다.</p>