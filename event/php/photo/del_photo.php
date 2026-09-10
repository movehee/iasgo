<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$directory = "../../upload/photo/".$image;
unlink($directory);


$query = "update photo_tbl SET del='Y' where url='".$image."'";
mysqli_query($conn, $query);

?>