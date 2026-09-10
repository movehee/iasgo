<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	$stamp_chk = $conn->getOne("select count(*) from booth_stamp where booth_sid='$booth_sid' and usid='".$_COOKIE['wmember_sid']."'");
	if($stamp_chk>0){
		PutMessageBack("Thank you for participating");
		exit;
	}
	$query = "insert into booth_stamp set booth_sid='$booth_sid'";
	$query .= ", usid='$_COOKIE[wmember_sid]'";
	$query .= ", signdate='".time()."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageRefreshURL("Thank you for participating", "index.php?booth_sid=".$booth_sid."&booth_page=op6");
?>