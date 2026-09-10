<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($kind=="A"){
	$que1 = "매우 만족	";
	$que2 = "만족	";
	$que3 = "보통";
	$que4 = "불만족	";
	$que5 = "매우불만족";
	$que6 = "모르겠다";
	}

	if($sid){
		$query = "update feedback_tbl set kind='$kind'";
		$query .= ", question='$question'";
		$query .= ", que1='$que1'";
		$query .= ", que2='$que2'";
		$query .= ", que3='$que3'";
		$query .= ", que4='$que4'";
		$query .= ", que5='$que5'";
		$query .= ", que6='$que6'";
		$query .= " where sid='$sid'";
		
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		$conn->disconnect();
		PutMessageCloseOpenerReload("수정되었습니다.");
	}else{
		$sort_num = $conn->getOne("select max(sort_num) from feedback_tbl where del='N'");
		if($sort_num>0){
			$sort_num = $sort_num+1;
		}else{
			$sort_num=1;
		}
		$query = "insert into feedback_tbl set kind='$kind'";
		$query .= ", question='$question'";
		$query .= ", que1='$que1'";
		$query .= ", que2='$que2'";
		$query .= ", que3='$que3'";
		$query .= ", que4='$que4'";
		$query .= ", que5='$que5'";
		$query .= ", que6='$que6'";
		$query .= ", sort_num='$sort_num'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		$conn->disconnect();
		PutMessageCloseOpenerReload("등록되었습니다.");
	}
	

?>