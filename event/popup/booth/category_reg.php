<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	if($_POST['sid']){
		
		$query = "update booth_grade set title='$title'";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
	
		$query = "insert into booth_grade set title='$title'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>