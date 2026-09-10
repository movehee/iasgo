<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	echo $session_day;
	
	for($i=1;$i<=9;$i++){
		if(${"session".$i."_stime"}){
			${'s'.$i.'_sdate'} = strtotime($session_day." ".${'session'.$i.'_stime'});
		}
		if(${"session".$i."_etime"}){
			${'s'.$i.'_edate'} = strtotime($session_day." ".${'session'.$i.'_etime'});
		}
	}
	$first_date = strtotime($session_day." ".$first_date);
	
	
	$query = "update checkin_tbl_ind set modify='Y'";
	if($first_date) $query .= " , first_date='$first_date'";
	$query .= " , s1_sdate='$s1_sdate'";
	$query .= " , s1_edate='$s1_edate'";
	$query .= " , s2_sdate='$s2_sdate'";
	$query .= " , s2_edate='$s2_edate'";
	$query .= " , s3_sdate='$s3_sdate'";
	$query .= " , s3_edate='$s3_edate'";
	if($s4_sdate) $query .= " , s4_sdate='$s4_sdate'";
	if($s4_edate) $query .= " , s4_edate='$s4_edate'";
	if($s5_sdate) $query .= " , s5_sdate='$s5_sdate'";
	if($s5_edate) $query .= " , s5_edate='$s5_edate'";
	if($s6_sdate) $query .= " , s6_sdate='$s6_sdate'";
	if($s6_edate) $query .= " , s6_edate='$s6_edate'";
	if($s7_sdate) $query .= " , s7_sdate='$s7_sdate'";
	if($s7_edate) $query .= " , s7_edate='$s7_edate'";
	$query .= " where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
	
?>