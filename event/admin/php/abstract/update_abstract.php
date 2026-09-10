<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update abstract_tbl SET ";
$query .= "abstract_tbl.".$info."='".urldecode($val)."'";
$query .= " where sid=".$sid;
$conn->query($query);
echo $query;
?>
