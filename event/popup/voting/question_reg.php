<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	if($_POST['sid']){
		
		$query = "update voting_tbl set question='$question'";
		$query .= " ,answer1='".$answer1."'";
		$query .= " ,answer2='".$answer2."'";
		$query .= " ,answer3='".$answer3."'";
		$query .= " ,answer4='".$answer4."'";
		$query .= " ,answer5='".$answer5."'";
		$query .= " where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
		
		$orderby = $conn->getOne("select max(orderby) from voting_tbl where code='$code' and lecture='$lecture' and del='N'");
		if(!$orderby){
			$order = 1;
		}else{
			$order = $orderby+1;
		}
		$query = "insert into voting_tbl set question='$question'";
		$query .= " ,answer1='".$answer1."'";
		$query .= " ,answer2='".$answer2."'";
		$query .= " ,answer3='".$answer3."'";
		$query .= " ,answer4='".$answer4."'";
		$query .= " ,answer5='".$answer5."'";
		$query .= " ,code='".$code."'";
		$query .= " ,lecture='".$lecture."'";
		$query .= " ,room='".$room."'";
		$query .= " ,delay='5'";
		$query .= " ,correct='0'";
		$query .= " ,orderby='$order'";
		$query .= " ,signdate='".time()."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>