<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($mode=='add'){
		$chking = $conn->getOne("select count(*) from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$sid'");
		if($chking>0){
			$query = "delete from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		
			$conn->disconnect();
			echo json_encode(array('push'=>'R'));
		}else{
			$query = "insert into session_favor_tbl set usid='".$_COOKIE['wmember_sid']."'";
			$query .= ", session_sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		
			$conn->disconnect();

			echo json_encode(array('push'=>'Y'));
		}
	}else{
		$query = "delete from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	
		$conn->disconnect();

		echo json_encode(array('push'=>'D'));
	}
?>