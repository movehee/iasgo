<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	$code = "day".$day;

	$to_time = $_Time['ing'];
	
	foreach($_TIME['session'][$day] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		if($to_time<=strtotime($tval[1])){
			$before_edate = $end_date[($tkey-1)];
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			break;
		}
	}

	foreach($_TIME['session_detail'][$day][$room] as $tkey=>$tval){
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		if($to_time>strtotime($tval[0]) && $to_time<=strtotime($tval[1])){
			$lecture_time = $tval[0]."~".$tval[1];
			$session_detail = $tkey;
			break;
		}
	}

	$query = "insert into technical_tbl set code='$code'";
	$query .= ", name='".$_COOKIE['wmember_name']."'";
	$query .= ", usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", day='".$day."'";
	$query .= ", room='".$room."'";
	$query .= ", session='".$session_detail."'";
	$query .= ", question='".$tech_question."'";
	$query .= ", signdate='".$_Time['ing']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

	echo "Y";

?>