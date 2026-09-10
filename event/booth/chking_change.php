<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($all=='Y'){
		$query = "update booth set ".$op_kind."='$chkval' where sid in ($sort_val)";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($all=='N'){
		$query = "update booth set ".$op_kind."='$chkval' where sid ='$sort_val'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
			
	}else{
		echo "N";
		exit;
	}
	$conn->disconnect();


	echo "Y";
?>