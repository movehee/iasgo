<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($kind=='pass'){ //시간초과
		
		$chking = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$Eday."' and usid='".$_COOKIE['wmember_sid']."' and exam_num='".$Enum."' and kind='".$category."'");
		if($chking==0){
			$query = "insert into exam_result_each_tbl set day='".$Eday."'";
			$query .= ", usid='".$_COOKIE['wmember_sid']."'";
			$query .= ", exam_num='".$Enum."'";
			$query .= ", exam_pass='P'";
			$query .= ", kind='".$category."'";
			$query .= ", signdate='".time()."'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}

		$Tnum = $conn->getOne("select count(*) from exam_tbl where day='".$Eday."' and del='N' and exam_num>".$Enum." and category='".$category."'");
		if($Tnum>0){
			$Next_num = $Enum+1;
		}else{
			$Next_num = "N";
		}
		echo json_encode(array('push'=>"P",'exam_num'=>$Next_num));
		exit;
	
	
	}else if($kind=='end'){ //종료
		
		$query = "insert into exam_result_each_tbl set day='".$Eday."'";
		$query .= ", usid='".$_COOKIE['wmember_sid']."'";
		$query .= ", exam_num='".$Enum."'";
		$query .= ", exam_pass='N'";
		$query .= ", kind='".$category."'";
		$query .= ", signdate='".time()."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		echo json_encode(array('push'=>"E",'exam_num'=>$Next_num));
		exit;
	
	}else if($kind=='send'){ //제출
		$exam_pass = "N";	
		
		if(strlen($exam_answer)>1){
			$exam_answer = implode(",",$exam_answer);
		}
		if($answer==$exam_answer){
			$exam_pass = "Y";
		}


		
		$chking = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$Eday."' and exam_num='".$Enum."' and kind='".$category."' and usid='".$_COOKIE['wmember_sid']."'");
		if($chking>0){
			$query = "update exam_result_each_tbl set exam_pass='".$exam_pass."'";
			$query .= ", exam_answer='".$exam_answer."'";
			$query .= ", modifydate='".time()."'";
			$query .= " where day='".$Eday."' and exam_num='".$Enum."' and kind='".$category."' and usid='".$_COOKIE['wmember_sid']."'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}else{
			$query = "insert into exam_result_each_tbl set day='".$Eday."'";
			$query .= ", usid='".$_COOKIE['wmember_sid']."'";
			$query .= ", exam_num='".$Enum."'";
			$query .= ", exam_pass='".$exam_pass."'";
			$query .= ", exam_answer='".$exam_answer."'";
			$query .= ", kind='".$category."'";
			$query .= ", signdate='".time()."'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
	

		$Tnum = $conn->getOne("select count(*) from exam_tbl where day='".$Eday."' and del='N' and exam_num>".$Enum." and category='".$category."'");
		if($Tnum>0){
			$Next_num = $Enum+1;
		}else{
			$Next_num = "N";
		}

		echo json_encode(array('push'=>"A",'exam_num'=>$Next_num));
		exit;
	}
	$conn->disconnect();
?>