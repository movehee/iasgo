<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "select pushYN from token_tbl where deviceid='".$deviceid."' and code='".$code."'";	
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);
echo $col['pushYN'];
?>