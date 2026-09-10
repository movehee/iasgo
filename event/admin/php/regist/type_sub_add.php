<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result = mysqli_query($conn, "select max(orderby) max from regist_type_sub_tbl where code='".$code."' and type_sid = '".$type_sid."'");
$row = mysqli_fetch_array($result);

$maxs = $row['max'];

$query = "INSERT INTO regist_type_sub_tbl SET ";
$query .= "code='".$code."'";
$query .= ", type_sid='".$type_sid."'";
$query .= ", orderby='".($maxs+1)."'";

$conn->query($query);
?>
