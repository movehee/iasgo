<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	//if($_COOKIE['wmember_level']!='M'){
		$query = "update booth set bcnt=bcnt+1 where sid='$booth_sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		$conn->disconnect();
	//}
	echo json_encode(array('result'=>'Y'));
?>