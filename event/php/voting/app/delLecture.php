<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query="update lecture_tbl set del='Y' where sid='".$sid."'";
$result = mysqli_query($conn, $query);
echo "Y";


?>
