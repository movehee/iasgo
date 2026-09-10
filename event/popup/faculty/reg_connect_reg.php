<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";
	
	if($fac_reset=='Y'){
		$reset_query = "update faculty_tbl set usid=''";
		$reset_result=$conn->query($reset_query);
		if(DB::isError($reset_result)) die($reset_result->getMessage());
	}
	
	if($fac_reset=='Y'){
		$query = "select * from faculty_tbl";
	}else{
		$query = "select * from faculty_tbl where usid='' or usid is null";
	}
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$n=0;
	if($kind=='A'){ //이메일이 일치하는경우
		
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$usid = $conn->getOne("select sid from registration_tbl where email='".$d['faculty_email']."' and email!=''");
			if($usid){
				$update_query = "update faculty_tbl set usid='".$usid."' where sid='".$d['sid']."'";
				$update_result=$conn->query($update_query);
				if(DB::isError($update_result)) die($update_result->getMessage());
				$n++;
			}
		}

	}else if($kind=='B'){ //세션 코드가 일치하는경우
		/*
		아직없음.
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$usid = $conn->getOne("select sid from registration_tbl where email='".$d['faculty_email']."'");
			
			$update_query = "update faculty_tbl set usid='".$usid."' where sid='".$d['sid']."'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
			$n++;
		}*/
		
	}else if($kind=='C'){ //이름이 일치하는경우
		
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$usid = $conn->getOne("select sid from registration_tbl where (name_kr='".$d['faculty_name']."' or name_eng='".$d['faculty_name']."')");
			if($usid){
				$update_query = "update faculty_tbl set usid='".$usid."' where sid='".$d['sid']."'";
				$update_result=$conn->query($update_query);
				if(DB::isError($update_result)) die($update_result->getMessage());
				$n++;
			}
		}
		
	}

	$conn->disconnect();
	PutMessageCloseOpenerReload("총 ".$n."건이 연결 되었습니다.");
?>