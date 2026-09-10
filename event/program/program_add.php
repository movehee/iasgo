<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();
	
	
	$td_max_count = $conn->getOne("select max(td) from workshop_schedule_tbl where code='$code' and bsid='$ev_date'");
	$tr_max_count = $conn->getOne("select max(tr) from workshop_schedule_tbl where code='$code' and bsid='$ev_date'");
	
	if($direction=='left'){

		$query = "update workshop_schedule_tbl set td=td+1 where bsid='$ev_date' and td>=$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}

		for($i=1;$i<=$tr_max_count;$i++){
			$add_query = "insert into workshop_schedule_tbl set bsid='$ev_date'";
			$add_query .= ",td='$key'";
			$add_query .= ",tr='$i'";
			$add_query .= ",code='$code'";
			$add_result = $conn->query($add_query);
			if(DB::isError($add_result)) {
			   die($add_result->getMessage());
			}
		}
	}else if($direction=='right'){
		
		$add_right = $conn->getOne("select count(*) from workshop_schedule_tbl where code='$code' and bsid='$ev_date' and rowspan='1' and td='".($key+1)."'");
		echo $add_right;
		exit;
		$query = "update workshop_schedule_tbl set td=td+1 where bsid='$ev_date' and td>$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		for($i=1;$i<=$tr_max_count;$i++){
			$add_query = "insert into workshop_schedule_tbl set bsid='$ev_date'";
			$add_query .= ",td='".($key+1)."'";
			$add_query .= ",tr='$i'";
			$add_query .= ",code='$code'";
			$add_result = $conn->query($add_query);
			if(DB::isError($add_result)) {
			   die($add_result->getMessage());
			}
		}
	}else if($direction=='up'){
		
		$query = "update workshop_schedule_tbl set tr=tr+1 where bsid='$ev_date' and tr>=$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		for($i=1;$i<=$td_max_count;$i++){
			$add_query = "insert into workshop_schedule_tbl set bsid='$ev_date'";
			$add_query .= ",td='".$i."'";
			$add_query .= ",tr='$key'";
			$add_query .= ",code='$code'";
			$add_result = $conn->query($add_query);
			if(DB::isError($add_result)) {
			   die($add_result->getMessage());
			}
		}
	}else if($direction=='down'){
		
		$query = "update workshop_schedule_tbl set tr=tr+1 where bsid='$ev_date' and tr>$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		for($i=1;$i<=$td_max_count;$i++){
			$add_query = "insert into workshop_schedule_tbl set bsid='$ev_date'";
			$add_query .= ",td='".$i."'";
			$add_query .= ",tr='".($key+1)."'";
			$add_query .= ",code='$code'";
			$add_result = $conn->query($add_query);
			if(DB::isError($add_result)) {
			   die($add_result->getMessage());
			}
		}
	}else if($direction=='del_cols'){
		
		$cols_count = $conn->getOne("select count(*) from workshop_schedule_tbl where bsid='$ev_date' and colspan='1' and td=$key");
		if($tr_max_count>$cols_count){
			PutMessageBack("선택하신 열은 삭제가 불가능합니다.");
			exit;
		}
		

		$query = "delete from workshop_schedule_tbl where bsid='$ev_date' and td=$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		$query = "update workshop_schedule_tbl set td=td-1 where bsid='$ev_date' and td>$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
	}else if($direction=='del_rows'){

		$cols_count = $conn->getOne("select sum(colspan) from workshop_schedule_tbl where bsid='$ev_date' and rowspan='1' and tr=$key");
		if($td_max_count>$cols_count){
			PutMessageBack("선택하신 행은 삭제가 불가능합니다.");
			exit;
		}

		$query = "delete from workshop_schedule_tbl where bsid='$ev_date' and tr=$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
		$query = "update workshop_schedule_tbl set tr=tr-1 where bsid='$ev_date' and tr>$key";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		   die($result->getMessage());
		}
	}

	$conn->disconnect();


	PutLocation("/program/?code=".$code."&ev_date=".$ev_date);
?>