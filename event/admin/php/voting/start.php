<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$query="update voting_tbl set status='2' where status in ('1','3') and code='".$code."'";
mysqli_query($conn, $query);
$query="update voting_tbl set status='1' where sid='".$sid."' and code='".$code."'";
mysqli_query($conn, $query);
echo "1";
?>

