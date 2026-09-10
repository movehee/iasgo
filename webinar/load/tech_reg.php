<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	$code = "day".$day;

	

	$query = "insert into technical_tbl set code='$code'";
	if(isLogined()){
		$query .= ", name='".$_COOKIE['wmember_name']."'";
		$query .= ", usid='".$_COOKIE['wmember_sid']."'";
		$query .= ", room='".$room."'";
		$query .= ", session='".$session_detail."'";
	}else{
		$query .= ", name='".$name_kr."'";
		$query .= ", cell='".$cell."'";
	}
	$query .= ", day='".$day."'";
	$query .= ", question='".$tech_question."'";
	$query .= ", signdate='".$_Time['ing']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

	echo "Y";

?>