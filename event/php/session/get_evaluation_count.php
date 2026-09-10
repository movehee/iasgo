<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

//개별 강의평가 갯수 리턴

$query = "SELECT sid FROM session_evaluation_tbl where code='".$code."' and deviceid='".$deviceid."' and left(FROM_UNIXTIME(signdate),10) = '".date('Y-m-d')."'";
$result = mysqli_query($conn, $query);
$num = $result->num_rows;
echo $num;
?>