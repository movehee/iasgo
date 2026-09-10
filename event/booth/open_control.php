<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "update booth set open_type='$open_type' where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

	echo "Y";
?>