<?php
include $_SERVER['DOCUMENT_ROOT'] . "lib.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "func/config_time.php";

$len = mb_strlen($tag_number, "UTF-8")-1;
$last_txt = mb_substr($tag_number,$len,1, "UTF-8");
if($last_txt=='A'){
	//$tag_number = mb_substr($tag_number,0,$len, "UTF-8");
}else{
	//PutMessageLocation("정상적인 접근이 아닙니다.",'index.php');
	//exit;
}

if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
	//$tag_number="2297";
}
$kind = "score";

$query="SELECT * FROM registration_tbl WHERE sid='".$tag_number."' ";
$result = $conn->query($query);
if(DB::isError($result)) die($result->getMessage());

$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();

$tag_name = $d['name_kr'];
$aff = $d['print_aff'];
if(!trim($tag_name)){
	$tag_name = $d['name_kr'];
}
if(!$aff){
	$aff = $d['aff_kor'];
}

if(!$n_day) $n_day = 1;
if(date("Y-m-d")=='2026-06-19'){
	$n_day=2;
}

$log_query = "insert into workshop_tag_log set usid='".$tag_number."'";
$log_query .= ", day='".$n_day."'";
$log_query .= ", room='".$room."'";
$log_query .= ", tag_time='".time()."'";
$log_result = $conn->query($log_query);
if(DB::isError($log_result)) {
	die($log_result->getMessage());
}


$query_time="SELECT * FROM workshop_tag_tbl WHERE usid='".$tag_number."' and day='".$n_day."' and kind='".$kind."'";
$result_time = $conn->query($query_time);
if(DB::isError($result_time)) die($result_time->getMessage());
$result_time->fetchInto(&$time,DB_FETCHMODE_ASSOC);
$result_time->free();





if($time['sid']) {

	if($time['stime']) {


		


		$check_out_time = time();
		//$check_out_time = strtotime("2025-05-29 16:30");
		$check_in_time = $time['stime'];

		if(strtotime("2025-05-30 08:30")>$check_in_time){
			//$check_in_time = strtotime("2025-05-30 08:30");	
		}
		if($check_out_time>strtotime("2025-05-30 11:50")){
			//$check_out_time = strtotime("2025-05-30 11:50");
		}
		

		$someTime = $check_out_time - $check_in_time;

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
		
		$query_in="update workshop_tag_tbl set etime = '".$check_out_time."' where usid='".$tag_number."' and day='".$n_day."' and kind='".$kind."'";
		$result = $conn->query($query_in);
		if(DB::isError($result)) die($result->getMessage());


		unset($_TC);
		if($time['stime']>0){
			 $_TC['stime'][$time['kind']] = date("H:i",$check_in_time);
			 $_TC['stime_real'][$time['kind']] = $check_in_time;
		}
		if($time['etime']>0){
			 $_TC['etime'][$time['kind']] = date("H:i",$check_out_time);
			 $_TC['etime_real'][$time['kind']] = $check_out_time;
		}

		if($n_day=='1'){
			if($check_out_time>strtotime("2025-05-29 17:50")){
				//$check_out_time = strtotime("2025-05-29 17:50");
			}
		}


		$_TC['etime'][$time['kind']] = date("H:i",$check_out_time);
		$_TC['etime_real'][$time['kind']] = $check_out_time;

		

		$_TC['S_unix'] = SetTimes($time['day'],$_TC['stime_real'][$time['kind']],$_TC['etime_real'][$time['kind']],"stay_unix");
		
		if($_TC['S_unix']>0){
			$info_ment = SetTimes($time['day'],$_TC['stime_real'][$time['kind']],$_TC['etime_real'][$time['kind']],"stay_time_real");
		}else{
			$info_ment = "";
		}
		if($check_out_time<$check_in_time){
			$check_out_time = $check_in_time;
		}
		$json = array(
		'success'=>"Y",
		'name'=>$tag_name,
		'office'=>$aff,
		'in_time' => date("Y.m.d H시i분",$check_in_time),
		'out_time' => date("Y.m.d H시i분",$check_out_time),
		'time'=>$info_ment,
		'license_number'=>$d['license_number'],
		);

	} else {
		
		$timer = time();

		$query_in="update workshop_tag_tbl set stime = '".$timer."' where usid='".$tag_number."' and day='".$n_day."' and kind='".$kind."'";
		$result = $conn->query($query_in);
		if(DB::isError($result)) die($result->getMessage());
		

		$json = array(
		'success'=>"Y",
		'name'=>$tag_name,
		'office'=>$aff,
		'in_time' => date("Y.m.d H시i분",$timer),
		'out_time' => "",
		'license_number'=>$d['license_number'],
		);
	}

	echo json_encode($json);

} else {
	$timer = time();

	$query_in="insert into workshop_tag_tbl set stime = '".$timer."' ,usid='".$tag_number."' , day='".$n_day."' , kind='".$kind."'";
	$result = $conn->query($query_in);
	if(DB::isError($result)) die($result->getMessage());


	$json = array(
	'success'=>"Y",
	'name'=>$tag_name,
	'office'=>$aff,
	'in_time' => date("Y.m.d H시i분",$timer),
	'out_time' => "",
	'license_number'=>$d['license_number'],
	);

	echo json_encode($json);
}