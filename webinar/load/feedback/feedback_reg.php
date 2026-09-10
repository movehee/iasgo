<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if(!$_COOKIE['wmember_sid']){
		echo json_encode(array('push'=>"O"));
		exit;
	}
	
	if($sid){
		$query = "update feedback_result_tbl set signdate='".time()."'";
		for($i=1;$i<=$Tcnt;$i++){
			$query .= ", answer".$i."='".${'answer'.$i}."'";
		}
		$query .= "where sid='".$sid."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
		$query = "insert into feedback_result_tbl set usid='".$_COOKIE['wmember_sid']."'";
		for($i=1;$i<=$Tcnt;$i++){
			$query .= ", answer".$i."='".${'answer'.$i}."'";
		}
		$query .= ", signdate='".time()."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		
	}
	$conn->disconnect();
	echo json_encode(array('push'=>"Y"));
	exit;
?>