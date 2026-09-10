<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$query = "SELECT * FROM photo_tbl where sid='".$sid."'";
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);
$directory = "../../../upload/photo/".$col['url'];
unlink($directory);



$query = "update photo_tbl SET del='Y' where sid=".$sid;
mysqli_query($conn, $query);

?>