<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query="SELECT session_sid FROM session_evaluation_tbl where code='".$code."' and lecture_sid=0 group by session_sid";
$result = mysqli_query($conn, $query);
while(is_array($d = mysqli_fetch_array($result))){ 
	if($d['session_sid']) $session_sids[] = $d['session_sid'];
}


$query="SELECT lecture_sid FROM session_evaluation_tbl where code='".$code."' and lecture_sid>0 group by lecture_sid";
$result = mysqli_query($conn, $query);
while(is_array($d = mysqli_fetch_array($result))){ 
	if($d['lecture_sid']) $lecture_sids[] = $d['lecture_sid'];
}

echo json_encode(array("session_sids"=>$session_sids, "lecture_sids"=>$lecture_sids));