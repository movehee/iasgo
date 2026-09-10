<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query="SELECT session FROM question_tbl where del='N' and code='".$code."' group by session";
$result = mysqli_query($conn, $query);
while(is_array($d = mysqli_fetch_array($result))){ 
	if($d['session']) $session_sids[] = $d['session'];
}

echo json_encode($session_sids);