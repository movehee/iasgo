<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "update workshop_schedule_tbl set code1='$code1', code2='$code2' where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

	echo "Y";
?>