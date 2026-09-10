<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	foreach($_TIME['session'][$day][$room] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		$ind[$tkey] = $tval[2];
		if($_Time['ing']<=strtotime($tval[1])){
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			$ind_chk = $tval[2];
			break;
		}else{
			if($tkey=='C') continue;
			$befor_session = $tkey;
			$before_edate = $_TIME['session'][$day][$room][$tkey][1];
			$befor_ind = $_TIME['session'][$day][$room][$tkey][2];
		}
	}
	if(!$session){ //세션이 없는경우 마지막 세션을 가져옴
		$session = end(array_keys($_TIME['session'][$day][$room]));
	}
	
	if($key_val){
		$session_insert = "insert into checkin_detail_tbl".$_COOKIE['Gkey']." set room='$room'";
		$session_insert .= ", session_in='$session'";
		$session_insert .= ", day='$day'";
		$session_insert .= ", key_val='$key_val'";
		$session_insert .= ", chk_type='O'";
		$session_insert .= ", location_kind='P'";
		$session_insert .= ", usid='".$_COOKIE['wmember_sid']."'";
		$session_insert .= ", check_in='".$_Time['ing']."'";
		$session_result=$conn->query($session_insert);
		if(DB::isError($session_result)) die($session_result->getMessage());
	}
	if($session!='N' && $session!='N2'){
		if($ind_chk!='Y'){
			$query2 = "update checkin_tbl".$_COOKIE['Gkey']." set last_date='".$_Time['ing']."' ";
			if($session){
				$query2 .= ", s".$session."_edate=if(s".$session."_sdate>0,'".$_Time['ing']."',null)";
			}
			$query2 .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
			$result2 = $conn->query($query2);
			if(DB::isError($result2)) {
				die($result2->getMessage());
			}
		}
	}

	// if($day=='1'){
	// 	if($room=='6' && strtotime("2021-10-14 13:00:00")<$_Time['ing'] && strtotime("2021-10-14 14:15:00")>$_Time['ing']){
	// 		$ind_chk="Y";
	// 	}
	// }else if($day=='2'){
	// 	if($room=='6' && strtotime("2021-10-15 16:20:00")<$_Time['ing'] && strtotime("2021-10-15 17:30:00")>$_Time['ing']){
	// 		$ind_chk="Y";
	// 	}
	// }

	
	if($ind_chk=='Y' || $befor_ind=='Y'){
		$query2 = "update checkin_tbl_ind set last_date='".$_Time['ing']."' ";
		if($session){
			$query2 .= ", s".$session."_edate=if(s".$session."_sdate>0,'".$_Time['ing']."',null)";
		}
		$query2 .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
		$result2 = $conn->query($query2);
		if(DB::isError($result2)) {
			die($result2->getMessage());
		}
	}

	$query3 = "update registration_tbl set room='' where sid='".$_COOKIE['wmember_sid']."'";
	$result3 = $conn->query($query3);
	if(DB::isError($result3)) {
		die($result3->getMessage());
	}

	$conn->disconnect();
	echo json_encode(array('inout'=>'Y'));
	//echo "Y";
?>