<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	if($kind=='notice'){

		$query = "update w_notice_tbl set push='N'";
		//$result=$conn->query($query);
		//if(DB::isError($result)) die($result->getMessage());
		
		
		if(trim($chking)=="Y"){
			
			$query2 = "update w_notice_tbl set push='Y'";
			$query2 .= " where sid='$sid'";
			$result2=$conn->query($query2);
			if(DB::isError($result2)) die($result2->getMessage());
		}
		if(trim($chking)=="N"){
			$query2 = "update w_notice_tbl set push='N'";
			$query2 .= " where sid='$sid'";
			$result2=$conn->query($query2);
			if(DB::isError($result2)) die($result2->getMessage());
		}
	}else if($kind=='question'){
		$query = "update question_tbl set `show`='$chking' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='proccess'){
		
		$query = "update technical_tbl set proccess='$chking'";
		$query .= " where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	
	}else if($kind=='answer_ok'){
		$query = "update question_tbl set answer_ok='$chking' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='view'){
		$room = $conn->getOne("select room from question_tbl where sid='$sid'");

		$query = "update question_tbl set view='' where room='$room'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		$query = "update question_tbl set view='$chking' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

	echo "Y";

?>