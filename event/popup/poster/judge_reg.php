<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();
	if($sid) {
		$query = "update e_poster_judge_tbl set score1='$score1'";
		$query .= " , score2='$score2'";
		$query .= " , score3='$score3'";
		$query .= " , score4='$score4'";
		$query .= " , score5='$score5'";
		$query .= " , total_score='$total_score'";
		$query .= " , p_rank='$p_rank'";
		$query .= " , final_confirm='$final_confirm'";
		$query .= "where sid = '$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");

?>