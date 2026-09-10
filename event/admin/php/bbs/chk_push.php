<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "select * from bbs_tbl where pushYN='N' and push_date<='".time()."'";

$result = mysqli_query($conn, $query);

while(is_array($d = mysqli_fetch_array($result))){
	
	$querys = "update bbs_tbl set pushYN='Y' , showYN = 'Y' where sid='".$d['sid']."'";
	$results = mysqli_query($conn, $querys);
	
	//echo "./push.php?sid=".$d['sid']."&code=".$d['code'];
	$ch = curl_init();//
	curl_setopt ($ch, CURLOPT_URL, "http://ezv.kr/admin/php/bbs/push.php?sid=".$d['sid']."&code=".$d['code']);
	//curl_setopt ($ch, CURLOPT_URL, "http://kgca.m2comm.co.kr/upload/iostest/test.php?sid=".$d['sid']."&code=".$d['code']);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$contents = curl_exec($ch);
	curl_close($ch); 
	echo $contents;

}