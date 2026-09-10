<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($type=='S'){
		$query = "update faculty_matching set session_sid='$sid' where sid='$dsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			echo "N";
			exit;
		}
	}else if($type=='D'){
		$session_sid = $conn->getOne("select session_sid from workshop_session_detail_tbl where sid='$sid'");

		$query = "update faculty_matching set session_sid='$session_sid', session_detail_sid='$sid' where sid='$dsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			echo "N";
			exit;
		}
	}else if($type=='T'){
		$query = "update faculty_matching set session_sid='', session_detail_sid='' where sid='$dsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			echo "N";
			exit;
		}
	}
	$conn->disconnect();

	echo "Y";
	exit;
?>