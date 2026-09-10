<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	if($_POST['sid']){
		
		$query = "update event_tbl set code='$code'";
		$query .= " ,eventdate='".strtotime($eventdate)."'";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
	
		$query = "insert into event_tbl set code='$code', eventdate='".strtotime($eventdate)."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>