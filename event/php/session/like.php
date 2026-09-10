<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE session_sid='".$session_sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$fav = $temp_row['sid'];


if($temp_row['cnt']==0){
	$query = "insert into session_like_tbl set code='$code',session_sid='".$session_sid."', deviceid='".$deviceid."',signdate='".time()."'";
	$conn->query($query);
	echo "Y|";
	
}else{
	$query = "delete from session_like_tbl where session_sid='".$session_sid."' and deviceid='".$deviceid."'";
	$conn->query($query);
	echo "N|";
}

$temp_result = mysqli_query($conn, "select count(*) cnt from session_like_tbl WHERE session_sid='".$session_sid."'");
$temp_row = mysqli_fetch_array($temp_result);
echo $temp_row['cnt'];
?>