<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$query = "SELECT * FROM session_evaluation_tbl where session_sid='".$session_sid."' and deviceid='".$deviceid."'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
if($row){
echo $row['score'];
echo "||".$row['memo'];
}else{
	echo "0||";
}
?>