<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	procAdminLoginChk();

	$backup_day = $conn->getOne("select bsid from workshop_schedule_tbl_copy where backup_time='$backup_time'");
	
	$copy_time = time();

	$query = "insert into workshop_schedule_tbl_copy (backup_time,category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del) ";
	$query .= " (select '".$copy_time."',category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del from workshop_schedule_tbl where bsid='$backup_day')";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	

	//현재 일자의 프로그램을 삭제한다.
	$query = "delete from workshop_schedule_tbl where bsid='$backup_day'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());



	$query = "insert into workshop_schedule_tbl (category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del) ";
	$query .= " (select category,code,bsid,tr,td,content,content2,content_position,content2_position,session,bg_color,font_color,colspan,rowspan,w_size,h_size,bold,italic,code1,code2,code3,place,radio,class_name,linkurl,session_total_time,session_chair,program1,program2,del from workshop_schedule_tbl_copy where backup_time='$backup_time')";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());


	PutMessageLocation("복원되었습니다.","/program/?ev_date=".$backup_day);
?>