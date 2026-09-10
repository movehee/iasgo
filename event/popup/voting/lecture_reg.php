<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	if($_POST['sid']){
		
		$query = "update lecture_tbl set name='$name', room='$room'";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
	
		$query = "insert into lecture_tbl set code='$code', room='$room', name='".$name."', signdate='".time()."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>