<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "select count(*) cnt from regist_tbl where code='".$code."' and info".$key."='".$val."' and del='N' and not in ('".$sid."')";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_array($result);
echo $d['cnt'];

?>