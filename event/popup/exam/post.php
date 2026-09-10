<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	
	if($answer){
		$answer_chk = implode(",",$answer);
	}

	if(strlen($answer_chk)>1){
		$exam_kind = "K";
	}else{
		$exam_kind = "A";
	}
	
	if($sid) {
		$query = "update exam_tbl set question='$question'";
		$query .= ", category='$category'";
		$query .= ", exam_kind='$exam_kind'";
		$query .= ", name_kr='$name_kr'";
		$query .= ", que1='$que1'";
		$query .= ", que2='$que2'";
		$query .= ", que3='$que3'";
		$query .= ", que4='$que4'";
		$query .= ", que5='$que5'";
		$query .= ", answer='$answer_chk'";
		$query .= ", commentary='$commentary'";
		$query .= ", score='$score'";
		$query .= " where sid = '$sid'";

		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		PutMessageCloseOpenerReload("수정되었습니다.");
	} else {
		$exam_num=1;
		$max_num = $conn->getOne("select max(exam_num) from exam_tbl where kind='$kind' and day='$chkday' and del='N' and category='$category'");
		if($max_num){
			$exam_num=$max_num+1;
		}
		$query = "insert into exam_tbl set kind='$kind'";
		$query .= ", category='$category'";
		$query .= ", exam_kind='$exam_kind'";
		$query .= ", day='$chkday'";
		$query .= ", name_kr='$name_kr'";
		$query .= ", question='$question'";
		$query .= ", que1='$que1'";
		$query .= ", que2='$que2'";
		$query .= ", que3='$que3'";
		$query .= ", que4='$que4'";
		$query .= ", que5='$que5'";
		$query .= ", exam_num='$exam_num'";
		$query .= ", answer='$answer_chk'";
		$query .= ", commentary='$commentary'";
		$query .= ", score='$score'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		PutMessageCloseOpenerReload("등록되었습니다.");
	}

	

?>