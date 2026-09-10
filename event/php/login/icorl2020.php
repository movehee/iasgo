<?php
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$code = "icorl2020";

$hostName = "121.254.129.80";
$userName = "korl";
$userPassword = "dlqldls";
$dbName = "korl";

$conn_korl = mysqli_connect($hostName, $userName, $userPassword, $dbName);
if ($conn_korl->connect_errno) {
	die('Not connected : ' . mysqli_connect_error());
}
$conn_korl->query("set names utf8");

/*
if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
	$mobile = "01090984257";
	$name = "Sung hwan LIM ";
	$deviceid = "d3";
}*/


if(!$deviceid) {
	$json  = array('rows'=>'N');
	echo json_encode($json);
	exit;
}

$name = strtolower(str_replace(" ","",$name));
$mobile = trim(str_replace(" ","",$mobile));

//$regist_query = "SELECT * FROM korl_prepare where cat='94' and status='Y' and trim(user_name)='$name' and trim(replace(phone,'-',''))='$mobile'";
$regist_query = "SELECT * FROM korl_prepare where cat='94' and status='Y' and trim(replace(phone,'-',''))='$mobile'";
//echo $regist_query;
$regist_result = $conn_korl->query($regist_query);
$regist_rows = $regist_result->num_rows;

if(!$regist_rows) { //등록정보 없을시
	$json  = array('rows'=>'N');
	echo json_encode($json);
	exit;

} else {

	$p = $regist_result->fetch_assoc();
	
	$user_name = str_replace(" ","",$p['user_name']);
	$eng_user_fname = strtolower($p['eng_user_fname']);
	$eng_user_lname = strtolower($p['eng_user_lname']);
	
	$eng_name1 = str_replace(" ", "", $eng_user_fname.$eng_user_lname);
	$eng_name2 = str_replace(" ", "", $eng_user_lname.$eng_user_fname);

	if($name != $user_name && $name != $eng_name1 && $name != $eng_name2) {
		$json  = array('rows'=>'N');
		echo json_encode($json);
		exit;
	}



	$login_query = "select * from login_tbl where code='$code' and mobile='$mobile' and deviceID = '$deviceid' and barcode='$p[sid]'";
	$login_result = mysqli_query($conn, $login_query);
	if(!$login_result->num_rows) {

		$login_query_in = "insert into login_tbl (code, deviceID, name, office, license_number, mobile, barcode, signdate) values ('$code', '$deviceid', '$name', '$p[position]' , '$p[license_number]', '$mobile', '$p[sid]','".time()."')";
		mysqli_query($conn, $login_query_in);
		$regist_sid = mysqli_insert_id($conn);

	} else {
		
		$row = mysqli_fetch_array($login_result);
		$regist_sid = $row['sid'];
		
	}

	$json  = array('rows'=>'Y', 'regist_sid'=>$regist_sid, 'barcode'=>$p['sid']);

	echo json_encode($json);
	exit;

}