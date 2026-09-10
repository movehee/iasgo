<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	$query = "delete from session_evaluation_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$session_sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	
	$query = "insert into session_evaluation_tbl set usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", session_sid='$session_sid'";
	$query .= ", detail_key='first'";
	$query .= ", eval1='$first'";	
	$query .= ", eval1_txt='$answereval1_txt1'";	
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	

	foreach($detail_sid as $tkey=>$tval){
		$query = "insert into session_evaluation_tbl set usid='".$_COOKIE['wmember_sid']."'";
		$query .= ", session_sid='$session_sid'";
		$query .= ", detail_key='$tval'";
		$query .= ", eval1='".${'answer'.$tval.'_1'}."'";	
		$query .= ", eval2='".${'answer'.$tval.'_2'}."'";
		$query .= ", eval1_txt='".${'answer'.$tval.'_txt1'}."'";
		$query .= ", eval2_txt='".${'answer'.$tval.'_txt2'}."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}



	$query = "insert into session_evaluation_tbl set usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", session_sid='$session_sid'";
	$query .= ", detail_key='etc1'";
	$query .= ", eval1_txt='$etc1'";	
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$query = "insert into session_evaluation_tbl set usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", session_sid='$session_sid'";
	$query .= ", detail_key='etc2'";	
	$query .= ", eval1_txt='$etc2'";	
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}


	$conn->disconnect();
	echo json_encode(array('push'=>"Y"));
	exit;
?>