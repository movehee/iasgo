<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update session_tbl SET ";
$query .= "session_tbl.".$info."='".rawurldecode($val)."'";
$query .= " where sid=".$sid;
$conn->query($query);
echo $query;
?>
