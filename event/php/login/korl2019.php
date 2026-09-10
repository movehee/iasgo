<?php
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$code = "korl2019";

$hostName = "121.254.129.80";
$userName = "korl";
$userPassword = "dlqldls";
$dbName = "korl";

$conn_korl = mysqli_connect($hostName, $userName, $userPassword, $dbName);
if ($conn_korl->connect_errno) {
	die('Not connected : ' . mysqli_connect_error());
}
$conn_korl->query("set names utf8");


//type: 1 > 사전등록
//type: 2 > 회원가입
/*
if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
$type = 1;
$name= " 유신영";
$license = "58223";
$postion = "포지션";
$office = "엠투";
$mobile = "010-6236-0556";
}
*/

$name = trim(str_replace(" ","",$name));
$office = trim(str_replace(" ","",$office));
$postion = trim(str_replace(" ","",$postion));
$mobile = trim(str_replace(" ","",$mobile));
$mobile = str_replace("-","",$mobile);

$login_query = "select * from login_tbl where code='$code' and type='$type' ";
if($type == '1') {

	if(!$name && !$license) {
		$json  = array('rows'=>'N');
		echo json_encode($json);
		exit;
	}

	//$login_query .= " and name='$name' and license_number='$license'";
	$login_query .= " and name='$name' and license_number='$license' and deviceID='$deviceid'";
}
else if($type == '2') {

	if(!$name && !$office && !$mobile && !$postion) {
		$json  = array('rows'=>'N');
		echo json_encode($json);
		exit;
	}

	$login_query .= " and name='$name' and office='$office' and mobile='$mobile' and postion='$postion' and deviceID='$deviceid'";
}

$login_result = mysqli_query($conn, $login_query);
$num = $login_result->num_rows;

if(!$num) {

	if($type == '1') {

		$pre_query = "SELECT * FROM korl_prepare where cat='25' and user_name='$name' and license_number='$license'";
		$pre_result = $conn_korl->query($pre_query);
		$pre_rows = $pre_result->num_rows;
		
		if($pre_rows) { //사전등록 정보 확인 > insert 후 end

			$p = $pre_result->fetch_assoc();


			$login_query_in = "insert into login_tbl (code, type, deviceID, name, office, license_number, signdate) values ('$code', '$type', '$deviceid', '$name', '$p[position]' , '$license', '".time()."')";
			mysqli_query($conn, $login_query_in);
			$regist_sid = mysqli_insert_id($conn);
			$json  = array('rows'=>'Y', 'regist_sid'=>$regist_sid);
			echo json_encode($json);
			exit;
		}
		else { //사전등록 정보 미확인
			$json  = array('rows'=>'N');
			echo json_encode($json);
			exit;
		}


	}
	else if ($type == '2') {

		$login_query_in = "insert into login_tbl (code, type, deviceID, name, office, mobile, postion, signdate) values ('$code', '$type', '$deviceid', '$name', '$office', '$mobile', '$postion', '".time()."')";
		mysqli_query($conn, $login_query_in);
		$regist_sid = mysqli_insert_id($conn);
		$json  = array('rows'=>'Y', 'regist_sid'=>$regist_sid);
		echo json_encode($json);
		exit;
	}

}
else //로그인 성공
{
	$login_result = mysqli_query($conn, $login_query);
	$row = mysqli_fetch_array($login_result);
	
	$json  = array('rows'=>'Y', 'regist_sid'=>$row['sid']);
	echo json_encode($json);
	exit;

}