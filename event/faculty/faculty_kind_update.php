<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if(!$sid){
		$query = "insert into faculty_matching set faculty_kind='$kindval', faculty_sid='$fsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else{

		$query = "update faculty_matching set faculty_kind='$kindval' where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}
	$conn->disconnect();
	echo "Y";
	exit;
?>