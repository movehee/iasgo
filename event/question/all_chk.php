<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	
	$query = "update question_tbl set `show`='N' where room='$room'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	echo "Y";
?>