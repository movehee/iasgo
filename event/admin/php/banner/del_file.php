<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update banner_tbl set ".$val."='' where sid=".$sid;
mysqli_query($conn, $query);
echo "삭제 완료되었습니다.";
?>