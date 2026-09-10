<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	if($sid) {
		$query = "update booth set booth_sid='$booth_sid', title='$title', op1='$op1', op2='$op2', op3='$op3', op4='$op4', op5='$op5', op6='$op6', linkurl='$linkurl',
		ai_stage_title='$ai_stage_title', ai_stage='$ai_stage', ai_stage_open='$ai_stage_open', 
		ai_stage_title2='$ai_stage_title2', ai_stage2='$ai_stage2', ai_stage_open2='$ai_stage_open2', 
		in_theater_title='$in_theater_title', in_theater='$in_theater', in_theater_open='$in_theater_open', 
		
		id='$id', booth_type='$booth_type' where sid = $sid";

		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

	PutMessageCloseOpenerReload("등록되었습니다.");

?>