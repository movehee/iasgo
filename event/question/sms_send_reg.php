<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	
	$query = "update technical_tbl set proccess='Y' where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("문자가 발송되었습니다.");
?>