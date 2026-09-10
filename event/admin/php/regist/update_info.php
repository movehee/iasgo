<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update regist_tbl SET ";
$query .= "regist_tbl.".$info."='".rawurldecode($val)."'";
$query .= " where sid=".$sid;
$conn->query($query);

if($info=="pay_chk"){
	$query = "update regist_tbl SET ";
	$query .= "pay_date='".time()."'";
	$query .= " where sid=".$sid;
	$conn->query($query);
}
echo $query;
?>
