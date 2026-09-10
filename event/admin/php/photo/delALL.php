<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";




$query = "SELECT * FROM photo_tbl where code='".$code."' and tab='".$sid."'";
$result = mysqli_query($conn, $query);

while(is_array($col = mysqli_fetch_array($result))){
	$directory = "../../../upload/photo/".$col['url'];
	unlink($directory);
}





$query = "update photo_tbl SET del='Y' where code='".$code."' and tab=".$sid ;
mysqli_query($conn, $query);

?>