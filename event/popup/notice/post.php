<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($room_sid){
		$room_key = implode(",",$room_sid);
	}
	if($sid) {
		$query = "update w_notice_tbl set subject='$subject', content='$content', use_yn='$use_yn',push='$push', room_sid='$room_key' where sid = $sid";

		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		PutMessageCloseOpenerReload("수정되었습니다.");
	} else {
		$code = GenerateString(10); 

		$total_count = $conn->getOne("select count(*) from w_notice_tbl where del='N'");
		if(!$total_count){
			$sort_num=1;
		}else{
			$sort_num = $total_count+1;
		}
		$query = "insert into w_notice_tbl set subject='$subject', content='$content', code='$code', use_yn='$use_yn',push='$push', room_sid='$room_key', sort_num='$sort_num', signdate=". time();
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());



		PutMessageCloseOpenerReload("등록되었습니다.");
	}

	

?>