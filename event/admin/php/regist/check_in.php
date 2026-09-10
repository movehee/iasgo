<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";

$query="SELECT * FROM regist_tbl WHERE sid='".$sid."' and code='".$code."' and del='N' ";

$result = mysqli_query($conn, $query);

$d = mysqli_fetch_array($result);

$day_query="SELECT * FROM agenda_tbl WHERE del='N' and code='".$code."' and eventdate<".time()." and eventdate>".(time()-86400);

$day_result = mysqli_query($conn, $day_query);
$day_d = mysqli_fetch_array($day_result);

if($day_d){
	if($d){
		if($day_d['start_time']){
			$temp = split(":",$day_d['start_time']);
			$start_time = $day_d['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
		}

		if($day_d['end_time']){
			$temp = split(":",$day_d['end_time']);
			$end_time = $day_d['eventdate'] + $temp[0] * 60 * 60 +  $temp[1] * 60;
		}
		$break_array = array();

		for($i=1;$i<6;$i++){
			if($day_d['break_time'.$i]){
				$temp = split("-",$day_d['break_time'.$i]);

				$temp1 = split(":",$temp[0]);
				$temp2 = split(":",$temp[1]);

				$break_array[$i] = array($day_d['eventdate'] + $temp1[0] * 60 * 60 +  $temp1[1] * 60,$day_d['eventdate'] + $temp2[0] * 60 * 60 +  $temp2[1] * 60);
			}
		}
		
		$set_query="SELECT * FROM session_set_tbl where code='".$code."' ";
		$set_result = mysqli_query($conn, $set_query);
		$set_d = mysqli_fetch_array($set_result);


		$temp_query = "select * from regist_set_tbl where sid='".$set_d['reg_name']."'";
		$temp_result = mysqli_query($conn, $temp_query);
		$temp_d = mysqli_fetch_array($temp_result);
		$info1 = $temp_d['info_orderby'];
		
		$temp_query_en = "select * from regist_set_tbl where sid='".$set_d['reg_name_en']."'";
		$temp_result_en = mysqli_query($conn, $temp_query_en);
		$temp_d_en = mysqli_fetch_array($temp_result_en);
		$info1_en = $temp_d_en['info_orderby'];
		

		$temp_query = "select * from regist_set_tbl where sid='".$set_d['reg_office']."'";
		$temp_result = mysqli_query($conn, $temp_query);
		$temp_d = mysqli_fetch_array($temp_result);
		$info2 = $temp_d['info_orderby'];
		
		$temp_query_en = "select * from regist_set_tbl where sid='".$set_d['reg_office_en']."'";
		$temp_result_en = mysqli_query($conn, $temp_query_en);
		$temp_d_en = mysqli_fetch_array($temp_result_en);
		$info2_en = $temp_d_en['info_orderby'];
		
		$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' and day = '".$day_d['day']."' order by sid asc");
		$tab_col = mysqli_fetch_array($tab_result);

		if($d['check_in'.$day_d['day']]){

			$timer = time();
			
			//로직순서가 잘못되서 기본값 처리.- 190703 YC
			$d['check_out'.$day_d['day']] = $timer;
			
			
			//들어온 시간이  등록된시작시간보다 작으면 (  일찍왔을때.. ) 등록된 시간으로 계산 - 190703 YC
		if (  $d['check_in'.$day_d['day']] <  $start_time ) {
			$d['check_in'.$day_d['day']] = $start_time;
		}
		
		//나간시간이 등록된 시간보다 크면 등록된 시간으로 변경 -190703 YC
		if ( $d['check_out'.$day_d['day']]  > $end_time  ) {
			$d['check_out'.$day_d['day']] = $end_time;
		}
		
		
			$someTime= $d['check_out'.$day_d['day']] - $d['check_in'.$day_d['day']];
				

			foreach($break_array as $key=>$val){
				if($d['check_in'.$day_d['day']] < $val[0])
				{
					if($d['check_out'.$day_d['day']] > $val[1]) {
						$someTime += $val[0]-$val[1];
					} else if($d['check_out'.$day_d['day']] < $val[0]) {

					} else {
						$someTime += $val[0]-$d['check_out'.$day_d['day']];
					}
				}else if($d['check_in'.$day_d['day']] < $val[1]) {
					if($d['check_out'.$day_d['day']] > $val[1]) {
						$someTime += $d['check_in'.$day_d['day']]-$val[1];
					} else if($d['check_out'.$day_d['day']] < $val[0]) {

					} else {
						$someTime += $d['check_in'.$day_d['day']]-$d['check_out'.$day_d['day']];
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
			//ksic2020행사후 삭제
			if ( $code == 'ksic2020' && $day_d['day'] == 1 ) {
				$score2 = 1;
			} else {
				$score2 = 0;				
			}


			if($aReturnValue['H']>=5)
				$score2 = 6;
			else if($aReturnValue['H']>=4)
				$score2 = 5;
			else if($aReturnValue['H']>=3)
				$score2 = 4;
			else if($aReturnValue['H']>=2)
				$score2 = 3;
				
			if($tab_col['score']<$score2){
				$score2 =$tab_col['score'];
			}


			$query_in="update regist_tbl set check_out".$day_d['day']." = '".$timer."' where sid='".$sid."'";
			$name = $d['info'.$info1];
			if ( $name == "" ) {
				$name = $d['info'.$info1_en]; 
			}
			
			$office = $d['info'.$info2];
			if ( $office == "" ) {
				$office = $d['info'.$info2_en];
			}
			
			//koa 행사 끝내고 삭제
			if (  $code == "koa191018" ) {
				$office =$d['info2'];
				$json = array(

									'name'=>$name, 
									'office'=>$office,
									'in_time' => date("Y.m.d H시i분",$d['check_in'.$day_d['day']]),
									'out_time' => date("Y.m.d H시i분",$d['check_out'.$day_d['day']]),
									'time'=>$info_ment,
									'score'=>"");	
			} else {
				$json = array(
									'success'=>"Y",
									'name'=>$name, 
									'office'=>$office,
									'in_time' => date("Y.m.d H시i분",$d['check_in'.$day_d['day']]),
									'out_time' => date("Y.m.d H시i분",$d['check_out'.$day_d['day']]),
									'time'=>$info_ment,
									'license_numbrer'=>$d['info9'],
									'score'=>$score2);
			}
			
			


			mysqli_query($conn, $query_in);

		}else{
			$timer = time();
/* 출결을 언제 처음 찍은지를 알아야 하기 때문에..
			if($start_time>0 && time() < $start_time) {
				$timer = $start_time;
			}
*/


			$query_in="update regist_tbl set check_in".$day_d['day']." = '".$timer."' where sid='".$sid."'";
			$name = $d['info'.$info1];
			if ( $name == "" ) {
				$name = $d['info'.$info1_en]; 
			}
			
			$office = $d['info'.$info2];
			if ( $office == "" ) {
				$office = $d['info'.$info2_en];
			}
			
			// 일단 급해서..koa 행사끝나면  삭제
			if ( $code == "koa191018" ) {
				$office = $d['info2'];
			}
			
			$json = array(
			'success'=>"Y",
			'name'=>$name, 
			'office'=>$office,
			'in_time' => date("Y.m.d H시i분",$timer),
			'out_time' => "",
			'license_numbrer'=>$d['info9'],
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


