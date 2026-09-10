<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	

	if($kind=='in'){
		$query = "update faculty_tbl set usid='$usid' where sid='$fsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{
		$query = "update faculty_tbl set usid='' where sid='$fsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	echo json_encode(array('result'=>'Y'));
?>