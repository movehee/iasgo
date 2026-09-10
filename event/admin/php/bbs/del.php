<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result = mysqli_query($conn, "select orderby,code from bbs_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

//$query = "update bbs_tbl SET del='Y'  where sid=".$sid;
$query = "update bbs_tbl SET del='Y' , pushYN='Y' where sid=".$sid;
mysqli_query($conn, $query);


$query = "update bbs_tbl SET orderby=orderby-1 where code='".$row['code']."' and orderby>".$row['orderby'];
mysqli_query($conn, $query);

?>