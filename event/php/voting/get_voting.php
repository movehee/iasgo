<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$result = mysqli_query($conn, "select sid from voting_tbl where code='".$code."' and status in ('1','3')");
$row = mysqli_fetch_array($result);

	echo $row['sid'];
	// echo $code;

?>
