<?php
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

if(!$day) $day = 1;

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

if($setting_col['reg_name']) { //셋팅 이름
	$temp_query = "select * from regist_set_tbl where sid='".$setting_col['reg_name']."'";

	$temp_result = mysqli_query($conn, $temp_query);
	$temp_d = mysqli_fetch_array($temp_result);
	$name_col = "info".$temp_d['info_orderby'];
}


$query = "select * from regist_tbl where code='$code' and del='N'";




$result = mysqli_query($conn, $query);
while(is_array($d = mysqli_fetch_array($result))){

	$in_time = $d['check_in'.$day]?date("Y.m.d H시i분",$d['check_in'.$day]):"";
	$out_time = $d['check_out'.$day]?date("Y.m.d H시i분",$d['check_out'.$day]):"";

	$arr[] = array("name" =>$d[$name_col], 'in_time' => $in_time, 'out_time' => $out_time);

}

echo json_encode($arr);