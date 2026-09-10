<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$temp_result = mysqli_query($conn, "select count(*) cnt from session_favor_tbl WHERE session_sid='".$session_sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$fav = $temp_row['sid'];


if($temp_row['cnt']==0){
	$query = "insert into session_favor_tbl set code='".$code."',type='".$type."',session_sid='".$session_sid."', deviceid='".$deviceid."'";
	$conn->query($query);
	echo "Y";
	
}else{
	$query = "delete from session_favor_tbl where session_sid='".$session_sid."' and deviceid='".$deviceid."'";
	$conn->query($query);
	echo "N";
}
?>