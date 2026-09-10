<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$query = "update voting_tbl SET ";
$query .= "start_type='1', delay='".$delay."' where del='N' and code='$code' and lecture='$lecture'";

mysqli_query($conn, $query);
?>
