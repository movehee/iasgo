<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query = "update voting_tbl SET ";
$query .= " voting_tbl.status='0'";
$query .= " where sid='".$sid."'";

mysqli_query($conn, $query);



$query = "delete from voting_result_tbl ";
$query .= " where voting_sid='".$sid."'";

mysqli_query($conn, $query);

?>
