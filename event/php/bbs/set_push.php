<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update token_tbl set pushYN='".$val."' where deviceid='".$deviceid."' and code='".$code."'";	
$result = mysqli_query($conn, $query);
echo $val;
?>