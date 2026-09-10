<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
$query="SELECT * FROM token_tbl where deviceid='".$deviceid."' and code='".$code."'";
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);
echo $col['sid'];
?>