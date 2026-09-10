<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$query = "SELECT * FROM session_memo_tbl where session_sid='".$session_sid."' and deviceid='".$deviceid."'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
echo $row['memo'];
echo "||".$row['file1'];
echo "||".$row['file2'];
echo "||".$row['file3'];
?>