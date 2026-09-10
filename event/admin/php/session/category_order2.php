<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include $DOCUMENT_ROOT . 'func/include.function.php';



$query = "update session_category_tbl SET orderby='".$orderby."' where sid=".$sid;
$conn->query($query);

?>

