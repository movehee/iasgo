<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	if(!$room){
		exit;
	}
	
	foreach($_TIME['session'][$day][$room] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		$ind[$tkey] = $tval[2];
		if($_Time['ing']<=strtotime($tval[1])){
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			$ind_chk = $tval[2];
			$delay_time = $tval[3];
			break;
		}else{
			if($tkey=='C') continue;
			$befor_session = $tkey;
			$before_edate = $_TIME['session'][$day][$room][$tkey][1];
			$befor_ind = $_TIME['session'][$day][$room][$tkey][2];
			$delay_time = $_TIME['session'][$day][$room][$tkey][3];
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
		$session_insert .= ", chk_type='S'";
		$session_insert .= ", location_kind='P'";
		$session_insert .= ", usid='".$_COOKIE['wmember_sid']."'";
		$session_insert .= ", check_in='".$_Time['ing']."'";
		$session_result=$conn->query($session_insert);
		if(DB::isError($session_result)) die($session_result->getMessage());
	}
	
	$chking = $conn->getOne("select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
	$hold_time = strtotime($before_edate."+ ".$delay_time." minutes"); //현재 시작세션으로부터 +5분
	
	if($session!='1'){	//첫번째 세션이 아닐경우 딜레이시간안에 이전세션의 체크아웃 시간이 강의종료보다 작은지 확인
		if($hold_time>=$_Time['ing']){
			$pre_query = "select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
			$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
			$pre_chk = $conn->getOne($pre_query);
		}
		if($pre_chk>0){ //이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작으면 기준이 되는 세션을 이전세션으로 변경
			$session = $befor_session;
		}
	}


	/*if($day=='1'){
		if($room=='6' && strtotime("2021-10-14 13:00:00")<$_Time['ing'] && strtotime("2021-10-14 14:15:00")>$_Time['ing']){
			$ind_chk="Y";
		}else if($room=='6' && strtotime("2021-10-14 14:15:00")<$_Time['ing'] && strtotime("2021-10-14 14:30:00")>$_Time['ing']){
			
			$ind_echk = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and s".$session."_edate>'".strtotime("2021-10-14 14:15:00")."' and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			if($ind_echk==0){
				$befor_ind="Y";
				$delay_time=270;
				$befor_session=2;
			}
		}
	}else if($day=='2'){
		if($room=='6' && strtotime("2021-10-15 16:20:00")<$_Time['ing'] && strtotime("2021-10-15 17:30:00")>$_Time['ing']){
			$ind_chk="Y";

		}else if($room=='6' && strtotime("2021-10-15 17:30:00")<$_Time['ing'] && strtotime("2021-10-15 17:40:00")>$_Time['ing']){
			$ind_echk = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and s".$session."_edate>'".strtotime("2021-10-15 17:30:00")."' and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			
			if($ind_echk==0){
				$befor_ind="Y";
				$delay_time=150;
				$befor_session=3;
			}
		}
	}*/

	
	if(($ind_chk=='Y' || $befor_ind=='Y')){ // 필수세션인경우
		if($ind_chk=='Y'){
			$chking = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			if($chking==0){
				$ind_inquery = "insert into checkin_tbl_ind set usid='".$_COOKIE['wmember_sid']."', day='".$day."'";
				$ind_result = $conn->query($ind_inquery);
				if(DB::isError($ind_result)) {
					die($ind_result->getMessage());
				}
			}
		}else{
			$chking = $conn->getOne("select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
		}
		$hold_time = strtotime($before_edate."+ ".$delay_time." minutes"); //현재 시작세션으로부터 +5분
		
		if($session!='1'){	
			if($hold_time>=$_Time['ing']){
				if($befor_ind!='Y'){
					$pre_query = "select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
					$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
					$pre_chk = $conn->getOne($pre_query);
				}else{
					$pre_query = "select count(*) from checkin_tbl_ind where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
					$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
					$pre_chk = $conn->getOne($pre_query);
				}
			}
			
			if($pre_chk>0){ //이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작으면 기준이 되는 세션을 이전세션으로 변경
				$session = $befor_session;
				if($_TIME['session'][$day][$room][($session-1)][2]=='Y'){
					$ind_chk="Y";
				}
			}
		}	
	}

	if($chking || $pre_chk>0){ //현재 세션의 시작시간이 이미 있거나, 이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작을때
		$query = "update checkin_tbl".$_COOKIE['Gkey']." set s".$session."_edate='".$_Time['ing']."', last_date='".$_Time['ing']."' ";
		$query .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		if($ind_chk=='Y'  || $befor_ind=='Y'){ // && $_COOKIE['wmember_exam']=='Y'
			$query = "update checkin_tbl_ind set s".$session."_edate='".$_Time['ing']."', last_date='".$_Time['ing']."', first_date=if(first_date>0,first_date,'".$_Time['ing']."') ";
			$query .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
		echo json_encode(array('inout'=>'Out'));
		//echo "Out";
		//exit;	
	}else{
		$query = "update checkin_tbl".$_COOKIE['Gkey']." set s".$session."_sdate=if(s".$session."_sdate>0,s".$session."_sdate,'".$_Time['ing']."'), last_date='".$_Time['ing']."' ";
		$query .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		if($ind_chk=='Y'){ // && $_COOKIE['wmember_exam']=='Y'
			$query = "update checkin_tbl_ind set s".$session."_sdate='".$_Time['ing']."', last_date='".$_Time['ing']."', first_date=if(first_date>0,first_date,'".$_Time['ing']."') ";
			$query .= " where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
		echo json_encode(array('inout'=>'In'));
		//echo "In";
		//exit;
	}
	$conn->disconnect();
	exit;
?>