<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$result = mysqli_query($conn, "select orderby from abstract_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

$orderby = $row['orderby'];

$query = "delete from abstract_tbl where sid=".$sid;
mysqli_query($conn, $query);


$query = "update abstract_tbl SET orderby=orderby-1 where code='".$code."' and orderby>".$orderby;
mysqli_query($conn, $query);


?>

