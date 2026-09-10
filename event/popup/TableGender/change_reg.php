<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	procAdminLoginChk();
	$query = "update workshop_schedule_tbl set del='N'";
	if($w_size) $query .= ",w_size='$w_size'";
	if($h_size) $query .= ",h_size='$h_size'";
	if($bold) $query .= ",bold='$bold'";
	if($italic) $query .= ",italic='$italic'";
	if($bg_color) $query .= ",bg_color='$bg_color'";
	if($font_color) $query .= ",font_color='$font_color'";
	if($vertical_RL) $query .= ",vertical_RL='$vertical_RL'";
	if($content_position) $query .= ",content_position='$content_position'";
	if($tr_class) $query .= ",tr_class='$tr_class'";
	if($td_class) $query .= ",td_class='$td_class'";
	
	$query .= " where sid in ($chksid)";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	//include_once $_SERVER['DOCUMENT_ROOT']."program/html_create.php";

	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");

?>