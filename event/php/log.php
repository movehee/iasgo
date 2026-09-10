<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

if ($device_id) {
	$deviceid = $device_id;
}

$query = "insert into log_tbl (info,info2,info3,deviceid,code,signdate) VALUES ('".$info."','".$info2."','".$info3."','".$deviceid."','".$code."','".time()."')";
//echo $query;
$result = mysqli_query($conn, $query);
?>
