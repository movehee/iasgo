<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	$query = "update workshop_session_detail_tbl set hide_yn='N'";
	$result = $conn->query($query);
	if(DB::isError($result2)) {
		die($result->getMessage());
	}

	if($chkval=='Y'){
		$query = "update workshop_session_detail_tbl set hide_yn='Y' where sid='$keyval'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	echo "Y";
	exit;
?>