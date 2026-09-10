<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$a_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and day='".$day."'");
$a = mysqli_fetch_array($a_result);


if($val) {
	$temp= split(":",$val);
	$val = $a['eventdate']+$temp[0]*60*60+$temp[1]*60;
}

$query = "update regist_tbl SET ";


$query .= "regist_tbl.".$info."='".rawurldecode($val)."'";
$query .= " where sid=".$sid;

$conn->query($query);

?>
