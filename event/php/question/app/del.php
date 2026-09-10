<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update question_tbl SET del='Y' where sid=".$sid;
mysqli_query($conn, $query);

echo "Y";

?>
