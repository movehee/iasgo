<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$chking = $conn->getOne("select count(*) from exam_manager_tbl where day='$chkday' and category='$category'");
	if($term_reset=='Y'){
		$query = "delete from exam_manager_tbl where day='$chkday' and category='$category'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		
	}else{
		$start_date = $sdate." ".$stime;
		$end_date = $sdate." ".$etime;
		if($chking){
			$query = "update exam_manager_tbl set sdate='$start_date'";
			$query .= ", edate='$end_date'";
			$query .= ", time_set='$time_set'";
			$query .= ", time_limit='$time_limit'";
			$query .= " where day='$chkday' and category='$category'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
		}else{
			$query = "insert into exam_manager_tbl set day='$chkday'";
			$query .= ", category='$category'";
			$query .= ", sdate='$start_date'";
			$query .= ", edate='$end_date'";
			$query .= ", time_set='$time_set'";
			$query .= ", time_limit='$time_limit'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());	
		}
	}
	
	
	if($conn){
		$conn->disconnect();
	}
?>