<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result = mysqli_query($conn, "select max(orderby) max from regist_type_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);

$maxs = $row['max'];

$query = "INSERT INTO regist_type_tbl SET ";
$query .= "code='".$code."'";
$query .= ",orderby='".($maxs+1)."'";

$conn->query($query);
?>
