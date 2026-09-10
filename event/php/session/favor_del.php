<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($type == "session") {

	$query = "delete from session_favor_tbl where code='".$code."' and session_sid='".$sid."' and deviceid='".$deviceid."'";

}
else if($type == "abstract") {

	$query = "delete from abstract_favor_tbl where code='".$code."' and abstract_sid='".$sid."' and deviceid='".$deviceid."'";

}
else {
	exit;
}

$conn->query($query);
//echo $query;

?>