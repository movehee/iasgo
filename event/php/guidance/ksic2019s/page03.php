<div class="myInfo">
	<h3 class="subTit" style="margin-bottom:0;">나의 평점</h3>
	<p>학회장 내에 설치된 바코드 리더기에 네임카드에 인쇄된 <span class="fcRed">바코드를 1일2회(입장/퇴장 시) 스캔</span>해 주세요</p>
	<span class="fcRed" style=" display: inline-block; padding: 0 0 0 10px;">※ 체류시간 인정 기준은 세션 시작-종료시간 기준으로 계산됩니다. </span>
	<span class=" " style=" display: inline-block; padding: 0 0 0 25px;">07.05(금) : 10:30 - 18:30 /  07.06(토) : 09:00 - 17:00</span> 

	<?
	$week = array("(일)", "(월)", "(화)", "(수)", "(목)", "(금)", "(토)") ;


	$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
	$break_array = array();
	
	while(is_array($tab_col = mysqli_fetch_array($tab_result))){

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

	while(is_array($tab_col = mysqli_fetch_array($tab_result))){
		$aReturnValue = $score2 = "";



		if($tab_col['start_time']){
			$temp = split(":",$tab_col['start_time']);
			$start_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
		}

		if($tab_col['end_time']){
			$temp = split(":",$tab_col['end_time']);
			$end_time = $tab_col['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
		}
	?>
	<h4 class="sybTit" style="    margin-top: 10px;"><?=date('Y.m.d', $tab_col['eventdate'])?><?=$week[date('w', $tab_col['eventdate'])]?></h4>
	<dl>

		<dt>입장시간</dt>
		<dd>
		<p><?=$d['check_in'.$tab_col['day']]?date("H:i", $d['check_in'.$tab_col['day']]):"-";?></p>
		</dd>

		<dt>퇴장시간</dt>
		<dd>
		<p><?=$d['check_out'.$tab_col['day']]?date("H:i", $d['check_out'.$tab_col['day']]):"-";?></p>
		</dd>

		<dt>체류시간</dt>
		<dd><p>
		<?
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

			echo $aReturnValue['H'].":".$aReturnValue['i'];
			
		}else{
			echo"-";
		}
		?>
		
		</p></dd>

		<dt>평점</dt>
		<dd><p>
		<?
		if($tab_col['score']){

			$score2 = 0;
			$time_n = 60*60;
			$score_set_result = mysqli_query($conn, "select * from score_set_tbl where code='".$code."' and del='N' order by time asc");
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

			if($tab_col['score']<$score2){
				$score2 = $tab_col['score'];
			}
			
			echo $score2."점";
			

			/*
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
			
			echo $score2."점";
			*/
		}
		

		?>
		</p></dd>
	</dl>
	<?}?>
</div>