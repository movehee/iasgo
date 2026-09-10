<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	if($kind=="add"){
		$query = "insert into e_poster_like set usid='".$_COOKIE['wmember_sid']."', psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	}else if($kind=="del"){
		
		$query = "delete from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
	
	}


	$Tcnt = $conn->getOne("select count(*) from e_poster_like where psid='".$sid."'");

	$g1_cnt = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$sid."'");
	$g2_cnt = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$sid."'");
	echo $Tcnt."||".$g1_cnt."||".$g2_cnt;
?>