<?
$equery = "select * from event_tbl where code='".$code."'";
$eresult = $conn->query($equery);
$eresult->fetchInto(&$e,DB_FETCHMODE_ASSOC);
$eresult->free();

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = $conn->query($setting_query);
$setting_result->fetchInto(&$setting_col,DB_FETCHMODE_ASSOC);
$setting_result->free();

if($setting_col['reg_name']) { //셋팅 이름
	$temp_query = "select * from regist_set_tbl where sid='".$setting_col['reg_name']."'";
	$temp_result = $conn->query($temp_query);
	$temp_result->fetchInto(&$temp_d,DB_FETCHMODE_ASSOC);
	$temp_result->free();
	$name_col = "info".$temp_d['info_orderby'];
}

if($setting_col['reg_hp']) { //셋팅 휴대폰
	$temp_query = "select * from regist_set_tbl where sid='".$setting_col['reg_hp']."'";
	$temp_result = $conn->query($temp_query);
	$temp_result->fetchInto(&$temp_d,DB_FETCHMODE_ASSOC);
	$temp_result->free();
	$hp_col = "info".$temp_d['info_orderby'];
}

if($setting_col['reg_license']) { //셋팅 휴대폰
	$temp_query = "select * from regist_set_tbl where sid='".$setting_col['reg_license']."'";
	$temp_result = $conn->query($temp_query);
	$temp_result->fetchInto(&$temp_d,DB_FETCHMODE_ASSOC);
	$temp_result->free();
	$license_col = "info".$temp_d['info_orderby'];
}
?>