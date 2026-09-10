<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$stand_time = strtotime(date("Y-m-d H:i:s")."- 1 minutes");
	
	$chking_sum = 0;

	$chking = $conn->getOne("select count(*) from checkin_detail_tbl where check_in<$stand_time ");
	$chking_sum += $chking;
	$query = "insert into checkin_detail_tbl_history (key_val,day,room,usid,session_in,check_in,chk_type,location_kind)";
	$query .= " select key_val,day,room,usid,session_in,check_in,chk_type,location_kind from checkin_detail_tbl where check_in<$stand_time";
	
	$result = $conn->query($query);
	if(DB::isError($result)) {
		echo "N";
		exit;
	}
	$del_query = "delete from checkin_detail_tbl where check_in<$stand_time";
	$del_result = $conn->query($del_query);

	echo $chking_sum;
?>
