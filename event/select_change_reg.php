<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	if(!$kind){
		echo "N";
		exit;
	}


	if($kind=="booth_type"){
		$query = "update booth_grade set b_type='$kind_val' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}


	echo "Y";
?>