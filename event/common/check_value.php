<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	if($kind=='faculty_award'){
		$query = "update faculty_tbl set award='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='faculty_none'){
		$query = "update faculty_tbl set faculty_none='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='session_detail_hide'){
		$query = "update workshop_session_detail_tbl set hiding='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='session_detail_hide_room'){
		$query = "update workshop_session_detail_tbl set hiding_room='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='broc_stamp'){
		$query = "update booth_brochures set stamp='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='vod_stamp'){
		$query = "update booth_company set vod_stamp='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='faculty_award_kind'){
		$query = "update faculty_tbl set award_kind='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='poster_withdraw'){
		$query = "update e_poster set withdraw='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='session_hide'){
		$query = "update workshop_session_tbl set hiding='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}else if($kind=='session_hide_room'){
		$query = "update workshop_session_tbl set hiding_room='$keyval' where sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

	echo json_encode(array('result'=>'Y'));
?>