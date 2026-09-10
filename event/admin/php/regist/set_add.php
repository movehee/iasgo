<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result = mysqli_query($conn, "select max(orderby) max from regist_set_tbl where code='".$code."' and del='N'");
$row = mysqli_fetch_array($result);
$maxs = $row['max'];


$result2 = mysqli_query($conn, "select max(info_orderby) max from regist_set_tbl where code='".$code."' and del='N'");
$row2 = mysqli_fetch_array($result2);
$maxs2 = $row2['max'];


$query = "INSERT INTO regist_set_tbl SET ";
$query .= "code='".$code."'";
$query .= ",type='1'";
$query .= ",orderby='".($maxs+1)."'";
$query .= ",info_orderby='".($maxs2+1)."'";

$conn->query($query);

$query = "update regist_tbl SET info".($maxs+1)."='' where code='".$code."'";
mysqli_query($conn, $query);
?>
