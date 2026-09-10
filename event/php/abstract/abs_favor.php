<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$temp_result = mysqli_query($conn, "select count(*) cnt from abstract_favor_tbl WHERE code='$code' and abstract_sid='".$abstract_sid."' and deviceid='".$deviceid."'");
$temp_row = mysqli_fetch_array($temp_result);
$fav = $temp_row['sid'];


if($temp_row['cnt']==0){
	$query = "insert into abstract_favor_tbl set code='".$code."', abstract_sid='".$abstract_sid."', session_sid='".$session_sid."', deviceid='".$deviceid."'";
	$conn->query($query);
	echo "Y";
	
}else{
	$query = "delete from abstract_favor_tbl where code='".$code."' and abstract_sid='".$abstract_sid."' and deviceid='".$deviceid."'";
	$conn->query($query);
	echo "N";
}
?>