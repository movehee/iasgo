<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	procAdminLoginChk();

	$code = GenerateString(10); 
	$query = "update w_notice_tbl set code='$code'";
	$query .= " where sid='$sid'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$conn->disconnect();
	echo "Y";

?>