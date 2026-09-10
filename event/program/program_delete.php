<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();

	$code = "webinar";
	$query = "delete from workshop_schedule_tbl where code='$code' and bsid='$ev_date'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	PutLocation("/program/?ev_date=".number_format($ev_date));
?>