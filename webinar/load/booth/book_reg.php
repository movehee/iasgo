<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	$query = "insert into booth_book set booth_sid='$booth_sid'";
	$query .= ", usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", name_kr='".$name_kr."'";
	$query .= ", email='".$email."'";
	$query .= ", content='".$content."'";
	$query .= ", signdate='".time()."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageRefreshURL("Thank you for participating", "index.php?booth_sid=".$booth_sid."&booth_page=op5");
?>