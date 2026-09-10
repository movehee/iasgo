<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();

	$copy_time = time();

	$query = "insert into workshop_schedule_tbl_copy (backup_time,category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del) ";
	$query .= " (select '".$copy_time."',category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del from workshop_schedule_tbl where bsid='$program_day')";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$conn->disconnect();
	echo "Y";
	exit;
?>

