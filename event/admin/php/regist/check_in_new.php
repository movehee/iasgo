<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

$query="SELECT * FROM regist_tbl WHERE sid='".$sid."' and code='".$code."' and del='N' ";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_assoc($result);

$day_query="SELECT * FROM agenda_tbl WHERE del='N' and code='".$code."' and eventdate<".time()." and eventdate>".(time()-86400);
$day_result = mysqli_query($conn, $day_query);
$day_d = mysqli_fetch_assoc($day_result);

if($day_d) {
	if($d) {
		if($day_d['start_time']){
			$start_time = strtotime(date("Y-m-d", $day_d['eventdate'])." ".$day_d['start_time']);
		}
		if($day_d['end_time']){
			$end_time = strtotime(date("Y-m-d", $day_d['eventdate'])." ".$day_d['end_time']);
		}

		
		


		$set_query="SELECT * FROM session_set_tbl where code='".$code."' ";
		$set_result = mysqli_query($conn, $set_query);
		$set_d = mysqli_fetch_assoc($set_result);

		


		$temp_query = "select * from regist_set_tbl where del='N' and code='$code' and sid in (".$set_d['reg_name'].",".$set_d['reg_name_en'].",".$set_d['reg_office'].",".$set_d['reg_office_en'].",".$set_d['reg_license'].")";
		$temp_result = mysqli_query($conn, $temp_query);
		while(is_array($temp_d = mysqli_fetch_assoc($temp_result))){
			if($temp_d['sid'] == $set_d['reg_name']) { 
				$reg_name_order = $temp_d['info_orderby'];

			} else if($temp_d['sid'] == $set_d['reg_name_en']) { 
				$reg_name_en_order = $temp_d['info_orderby'];

			} else if($temp_d['sid'] == $set_d['reg_office']) { 
				$reg_office_order = $temp_d['info_orderby'];

			} else if($temp_d['sid'] == $set_d['reg_office_en']) { 
				$reg_office_en_order = $temp_d['info_orderby'];

			} else if($temp_d['sid'] == $set_d['reg_license']) { 
				$reg_license_order = $temp_d['info_orderby'];
			}
		}

		
		


		if($d['check_in'.$day_d['day']]) {

			$break_array = array();

			for($i=1;$i<6;$i++){
				if($day_d['break_time'.$i]){
					$temp = split("-",$day_d['break_time'.$i]);

					$break_array[$i] = array(
						strtotime(date("Y-m-d", $day_d['eventdate'])." ".$temp['0']),
						strtotime(date("Y-m-d", $day_d['eventdate'])." ".$temp['1'])
						);
				}
			}

			$check_out_time = time();
			$check_in_time = $d['check_in'.$day_d['day']];
				
			
			//들어온 시간이  등록된시작시간보다 작으면 (  일찍왔을때.. ) 등록된 시간으로 계산 - 190703 YC
			if ($check_in_time <  $start_time ) {
				$check_in_time = $start_time;
			}
			
			//나간시간이 등록된 시간보다 크면 등록된 시간으로 변경 -190703 YC
			if ( $check_out_time  > $end_time  ) {
				$check_out_time = $end_time;
			}
		
		
			$someTime = $check_out_time - $check_in_time;
				

			foreach($break_array as $key=>$val){
				if($check_in_time < $val[0])
				{
					if($check_out_time > $val[1]) {
						$someTime += $val[0]-$val[1];
					} else if($check_out_time < $val[0]) {

					} else {
						$someTime += $val[0]-$check_out_time;
					}
				}else if($check_in_time < $val[1]) {
					if($check_out_time > $val[1]) {
						$someTime += $check_in_time-$val[1];
					} else if($check_out_time < $val[0]) {

					} else {
						$someTime += $check_in_time-$check_out_time;
					}
				}
			}

			$aReturnValue['d'] = floor($someTime/60/60/24); //일
			$aReturnValue['H'] = sprintf("%02d", ($someTime/60/60)%24); //시간
			$aReturnValue['i'] = sprintf("%02d", ($someTime/60)%60); //분
			$aReturnValue['s'] = sprintf("%02d", ($someTime%60)); //초
			
			$info_ment = "";
			if($aReturnValue['H']>0){
				$info_ment .= $aReturnValue['H']."시간 "; 
			}
			if($aReturnValue['i']>0){
				$info_ment .= $aReturnValue['i']."분 "; 
			}
			

			$score_set_arr = array();
			$score_set_result = mysqli_query($conn, "SELECT agenda_sid FROM score_set_tbl where del='N' and code='".$code."' group by agenda_sid");
			while(is_array($score_set_col = mysqli_fetch_assoc($score_set_result))){
				$score_set_arr[] = $score_set_col['agenda_sid'];
			}


			if(in_array($day_d['sid'], $score_set_arr)) {
				$time_n = 60*60;
				$score_set_result = mysqli_query($conn, "select * from score_set_tbl where code='".$code."' and agenda_sid='".$day_d['sid']."' and del='N' order by time asc");
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
					$score2 =$day_d['score'];
				}
			}

			$query_in="update regist_tbl set check_out".$day_d['day']." = '".$check_out_time."' where sid='".$sid."'";
			$name = $d['info'.$reg_name_order];
			if ( $name == "" ) {
				$name = $d['info'.$reg_name_en_order]; 
			}
			
			$office = $d['info'.$reg_office_order];
			if ( $office == "" ) {
				$office = $d['info'.$reg_office_en_order];
			}
			
		
			$json = array(
			'success'=>"Y",
			'name'=>$name, 
			'office'=>$office,
			'in_time' => date("Y.m.d H시i분",$check_in_time),
			'out_time' => date("Y.m.d H시i분",$check_out_time),
			'time'=>$info_ment,
			'license_numbrer'=>$d['info9'],
			'score'=>$score2
			);
			
			
			


			mysqli_query($conn, $query_in);

		}else{

			$timer = time();

			$query_in="update regist_tbl set check_in".$day_d['day']." = '".$timer."' where sid='".$sid."'";

			$name = $d['info'.$reg_name_order];
			if ( $name == "" ) {
				$name = $d['info'.$reg_name_en_order]; 
			}
			
			$office = $d['info'.$reg_office_order];
			if ( $office == "" ) {
				$office = $d['info'.$reg_office_en_order];
			}

			$json = array(
			'success'=>"Y",
			'name'=>$name, 
			'office'=>$office,
			'in_time' => date("Y.m.d H시i분",$timer),
			'out_time' => "",
			'license_number'=>$d['info'.$reg_license_order],
			);


			mysqli_query($conn, $query_in);


		}
		echo json_encode($json);

		
	}else{
		echo "N";
	}
}else{
	echo "N";
}
?>


