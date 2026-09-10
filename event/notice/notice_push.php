<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();
	$query = "update w_notice_tbl set push='N'";
	//$result=$conn->query($query);
	//if(DB::isError($result)) die($result->getMessage());


	$query = "update w_notice_tbl set push='Y'";
	$query .= " where sid='$sid'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$conn->disconnect();
	echo "Y";

?>