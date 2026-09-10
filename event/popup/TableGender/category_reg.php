<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	procAdminLoginChk();

	$query = "update workshop_session_category set title='$title' where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>