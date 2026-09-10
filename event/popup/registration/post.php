<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	/**
	 * 관리자 등록폼 입/퇴장 시각 → checkin_tbl.first_date / last_date 동기화
	 * 세션(sN_*) 컬럼은 건드리지 않음. 둘 다 비어 있고 행이 없으면 skip.
	 * 시각이 실제로 바뀐 경우에만 checkin_detail_tbl 에 location_kind=A 로그를 남긴다.
	 */
	function postInsertAdminDetail($conn, $usid, $day, $checkIn, $chkType) {
		$usid = (int)$usid;
		$day = (int)$day;
		$checkIn = (int)$checkIn;
		$chkType = ($chkType == 'O') ? 'O' : 'I';
		if ($usid < 1 || $day < 1 || $checkIn < 1) {
			return;
		}
		$keyVal = $usid.'_A_'.$chkType.'_'.$checkIn.'_'.time();
		if (strlen($keyVal) > 50) {
			$keyVal = substr($keyVal, 0, 50);
		}
		$ins = $conn->query(
			'INSERT INTO checkin_detail_tbl SET key_val = ?, day = ?, room = ?, usid = ?, session_in = ?, check_in = ?, chk_type = ?, location_kind = ?',
			array($keyVal, (string)$day, '0', (string)$usid, '0', (string)$checkIn, $chkType, 'A')
		);
		if (DB::isError($ins)) {
			error_log('[Registration] admin detail insert failed: usid='.$usid.' day='.$day.' '.$ins->getMessage());
		}
	}

	function postSyncCheckinDay($conn, $usid, $day, $firstDate, $lastDate) {
		$usid = (int)$usid;
		$day = (int)$day;
		$firstDate = (int)$firstDate;
		$lastDate = (int)$lastDate;
		if ($usid < 1 || $day < 1) {
			return;
		}

		$chk = $conn->query(
			'SELECT sid, first_date, last_date FROM checkin_tbl WHERE usid = ? AND day = ?',
			array($usid, $day)
		);
		if (DB::isError($chk)) {
			error_log('[Registration] checkin select failed: usid='.$usid.' day='.$day.' '.$chk->getMessage());
			return;
		}
		$row = $chk->fetchRow(DB_FETCHMODE_ASSOC);
		$chk->free();
		$rowSid = ($row && isset($row['sid'])) ? (int)$row['sid'] : 0;
		$oldFirst = ($row && isset($row['first_date'])) ? (int)$row['first_date'] : 0;
		$oldLast = ($row && isset($row['last_date'])) ? (int)$row['last_date'] : 0;

		if ($rowSid < 1) {
			if ($firstDate < 1 && $lastDate < 1) {
				return;
			}
			$ins = $conn->query(
				'INSERT INTO checkin_tbl SET usid = ?, day = ?, first_date = ?, last_date = ?, modify = ?',
				array($usid, $day, $firstDate, $lastDate, 'Y')
			);
			if (DB::isError($ins)) {
				error_log('[Registration] checkin insert failed: usid='.$usid.' day='.$day.' '.$ins->getMessage());
				return;
			}
			if ($firstDate > 0) {
				postInsertAdminDetail($conn, $usid, $day, $firstDate, 'I');
			}
			if ($lastDate > 0) {
				postInsertAdminDetail($conn, $usid, $day, $lastDate, 'O');
			}
			return;
		}

		$upd = $conn->query(
			'UPDATE checkin_tbl SET first_date = ?, last_date = ?, modify = ? WHERE sid = ?',
			array($firstDate, $lastDate, 'Y', $rowSid)
		);
		if (DB::isError($upd)) {
			error_log('[Registration] checkin update failed: usid='.$usid.' day='.$day.' '.$upd->getMessage());
			return;
		}
		if ($firstDate > 0 && $firstDate != $oldFirst) {
			postInsertAdminDetail($conn, $usid, $day, $firstDate, 'I');
		}
		if ($lastDate > 0 && $lastDate != $oldLast) {
			postInsertAdminDetail($conn, $usid, $day, $lastDate, 'O');
		}
	}

	if($_POST['member_level']!='M'){
		$_POST['member_level'] = "A";	
	}

	$sid = (int)$sid;
	$etc_field8 = (isset($_POST['etc_field8']) && $_POST['etc_field8']=='Y') ? 'Y' : '';
	$free_yn = (isset($_POST['free_yn']) && $_POST['free_yn']=='Y') ? 'Y' : 'N';
	$reg_fee = isset($_POST['reg_fee']) ? $_POST['reg_fee'] : 0;
	$etc_field9 = isset($_POST['etc_field9']) ? $_POST['etc_field9'] : '';
	if (!isset($_POST['etc_field9']) && !$sid) {
		$etc_field9 = 'ADMIN';
	}
	$pay_status = isset($_POST['pay_status']) ? $_POST['pay_status'] : '';

	if ($country == 'K') {
		$etc_field1 = 'Korea';
	}

	$eventDays = ((strtotime($_Webinar['edate']) - strtotime($_Webinar['sdate'])) / 86400) + 1;
	if ($eventDays < 1) {
		$eventDays = 1;
	} else if ($eventDays > 5) {
		$eventDays = 5;
	}
	for ($di = 1; $di <= $eventDays; $di++) {
		$inRaw = isset($_POST['login_day'.$di]) ? trim($_POST['login_day'.$di]) : '';
		$outRaw = isset($_POST['logout_day'.$di]) ? trim($_POST['logout_day'.$di]) : '';
		${'login_day'.$di} = ($inRaw != '') ? strtotime($inRaw) : 0;
		${'logout_day'.$di} = ($outRaw != '') ? strtotime($outRaw) : 0;
		if (${'login_day'.$di} > 0) {
			${'login'.$di} = 'Y';
		}
	}
	$showLoginAttend = (isset($_CONFIG['show_login_attend']) && $_CONFIG['show_login_attend']);

	if($sid){
		$logCols = array(
			'country', 'id', 'gubun1', 'gubun2', 'first_name', 'last_name', 'name_kr',
			'aff_eng', 'aff_kor', 'email', 'license_number', 'title', 'free_yn', 'reg_fee',
			'title_sub', 'major_year', 'cell',
			'login1', 'login2', 'login3', 'login4', 'login5',
			'login_day1', 'login_day2', 'login_day3', 'login_day4', 'login_day5',
			'logout_day1', 'logout_day2', 'logout_day3', 'logout_day4', 'logout_day5',
			'councilor', 'reg_kind', 'name_eng',
			'etc_field1', 'etc_field2', 'classification', 'only_pil', 'member_level',
			'etc_field6', 'etc_field7', 'etc_field8', 'etc_field9',
			'pay_status', 'pay_date', 'etc_field3', 'etc_field5',
			'depart_kor', 'depart_eng',
			'lecture1', 'lecture2', 'lecture3', 'lecture4'
		);
		$oldRow = regLogSnapshot($sid, $logCols);

		$old_pay_status = isset($oldRow['pay_status']) ? $oldRow['pay_status'] : '';
		if($pay_status != $old_pay_status){
			$pay_date = date('Y-m-d H:i:s');
		}

		$query = "UPDATE registration_tbl SET country='$country'";
		$query .= ", id='$id'";
		$query .= ", gubun1='$gubun1'";
		$query .= ", gubun2='$gubun2'";
		$query .= ", first_name='$first_name'";
		$query .= ", last_name='$last_name'";
		$query .= ", name_kr='$name_kr'";
		
		$query .= ", aff_eng='$aff_eng'";
		$query .= ", aff_kor='$aff_kor'";
		$query .= ", email='$email'";
		$query .= ", license_number='$license_number'";
		$query .= ", title='$title'";
		$query .= ", free_yn='$free_yn'";
		$query .= ", reg_fee='$reg_fee'";
		$query .= ", passwd='$passwd'";
		$query .= ", title_sub='$title_sub'";
		$query .= ", major_year='$major_year'";
		$query .= ", cell='$cell'";
		
		if ($showLoginAttend) {
			$query .= ", login1='$login1'";
			$query .= ", login2='$login2'";
			$query .= ", login3='$login3'";
			$query .= ", login4='$login4'";
			$query .= ", login5='$login5'";
		} else {
			// 체크박스 숨김: QR로 켜진 loginN 유지. 입장시각 입력된 일차만 Y로 맞춤
			for ($di = 1; $di <= $eventDays; $di++) {
				if (${'login_day'.$di} > 0) {
					$query .= ", login".$di."='Y'";
				}
			}
		}
		for ($di = 1; $di <= $eventDays; $di++) {
			$query .= ', login_day'.$di.'='.${'login_day'.$di};
			$query .= ', logout_day'.$di.'='.${'logout_day'.$di};
		}

		$query .= ", councilor='$councilor'";
		$query .= ", reg_kind='$reg_kind'";
		$query .= ", name_eng='$name_eng'";
		$query .= ", etc_field1='$etc_field1'";
		$query .= ", etc_field2='$etc_field2'";
		$query .= ", classification='$classification'";
		$query .= ", only_pil='$only_pil'";
		$query .= ", member_level='".$_POST['member_level']."'";
		$query .= ", etc_field6='$etc_field6'";
		$query .= ", etc_field7='$etc_field7'";
		$query .= ", etc_field8='$etc_field8'";
		$query .= ", etc_field9='$etc_field9'";
		$query .= ", pay_status='$pay_status'";
		$query .= ", pay_date='$pay_date'";
		$query .= ", etc_field3='$etc_field3'";
		$query .= ", etc_field5='$etc_field5'";
		$query .= ", depart_kor='$depart_kor'";
		$query .= ", depart_eng='$depart_eng'";

		if (isset($_CONFIG['show_lecture_attend']) && $_CONFIG['show_lecture_attend']) {
			$query .= ", lecture1='$lecture1'";
			$query .= ", lecture2='$lecture2'";
			$query .= ", lecture3='$lecture3'";
			$query .= ", lecture4='$lecture4'";
		}
		
		$query .= " where sid='$sid'";
		
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}

		$newVals = array(
			'country' => $country,
			'id' => $id,
			'gubun1' => $gubun1,
			'gubun2' => $gubun2,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'name_kr' => $name_kr,
			'aff_eng' => $aff_eng,
			'aff_kor' => $aff_kor,
			'email' => $email,
			'license_number' => $license_number,
			'title' => $title,
			'free_yn' => $free_yn,
			'reg_fee' => $reg_fee,
			'title_sub' => $title_sub,
			'major_year' => $major_year,
			'cell' => $cell,
			'councilor' => $councilor,
			'reg_kind' => $reg_kind,
			'name_eng' => $name_eng,
			'etc_field1' => $etc_field1,
			'etc_field2' => $etc_field2,
			'classification' => $classification,
			'only_pil' => $only_pil,
			'member_level' => $_POST['member_level'],
			'etc_field6' => $etc_field6,
			'etc_field7' => $etc_field7,
			'etc_field8' => $etc_field8,
			'etc_field9' => $etc_field9,
			'pay_status' => $pay_status,
			'pay_date' => $pay_date,
			'etc_field3' => $etc_field3,
			'etc_field5' => $etc_field5,
			'depart_kor' => $depart_kor,
			'depart_eng' => $depart_eng
		);
		if ($showLoginAttend) {
			$newVals['login1'] = $login1;
			$newVals['login2'] = $login2;
			$newVals['login3'] = $login3;
			$newVals['login4'] = $login4;
			$newVals['login5'] = $login5;
		} else {
			for ($di = 1; $di <= $eventDays; $di++) {
				if (${'login_day'.$di} > 0) {
					$newVals['login'.$di] = 'Y';
				}
			}
		}
		for ($di = 1; $di <= $eventDays; $di++) {
			$newVals['login_day'.$di] = ${'login_day'.$di};
			$newVals['logout_day'.$di] = ${'logout_day'.$di};
		}
		if (isset($_CONFIG['show_lecture_attend']) && $_CONFIG['show_lecture_attend']) {
			$newVals['lecture1'] = $lecture1;
			$newVals['lecture2'] = $lecture2;
			$newVals['lecture3'] = $lecture3;
			$newVals['lecture4'] = $lecture4;
		}
		$changes = regLogBuildChanges($oldRow, $newVals);
		regLogWrite($sid, 'update', 'postform', $changes);

		for ($di = 1; $di <= $eventDays; $di++) {
			postSyncCheckinDay($conn, $sid, $di, ${'login_day'.$di}, ${'logout_day'.$di});
		}
		$conn->disconnect();
		PutMessageCloseOpenerReload("수정되었습니다.");
	}else{
		$idchk = $conn->getOne("SELECT COUNT(*) FROM registration_tbl WHERE license_number='$license_number'");
		if($idchk>0){
			//PutMessageBack("중복되는 면허번호 입니다.");
			//exit;
		}
		if($pay_status != 'N' && $pay_status != ''){
			$pay_date = date('Y-m-d H:i:s');
		}else{
			$pay_date = '';
		}
		$query = "INSERT INTO registration_tbl SET country='$country'";
		$query .= ", id='$id'";
		$query .= ", gubun1='$gubun1'";
		$query .= ", gubun2='$gubun2'";
		$query .= ", first_name='$first_name'";
		$query .= ", last_name='$last_name'";
		$query .= ", name_kr='$name_kr'";
		$query .= ", aff_eng='$aff_eng'";
		$query .= ", aff_kor='$aff_kor'";
		$query .= ", email='$email'";
		$query .= ", license_number='$license_number'";
		$query .= ", title='$title'";
		$query .= ", free_yn='$free_yn'";
		$query .= ", reg_fee='$reg_fee'";
		$query .= ", title_sub='$title_sub'";
		$query .= ", major_year='$major_year'";
		$query .= ", cell='$cell'";
		if ($showLoginAttend) {
			$query .= ", login1='$login1'";
			$query .= ", login2='$login2'";
			$query .= ", login3='$login3'";
			$query .= ", login4='$login4'";
			$query .= ", login5='$login5'";
		} else {
			for ($di = 1; $di <= $eventDays; $di++) {
				if (${'login_day'.$di} > 0) {
					$query .= ", login".$di."='Y'";
				}
			}
		}
		for ($di = 1; $di <= $eventDays; $di++) {
			$query .= ', login_day'.$di.'='.${'login_day'.$di};
			$query .= ', logout_day'.$di.'='.${'logout_day'.$di};
		}
		$query .= ", passwd='$passwd'";
		$query .= ", councilor='$councilor'";
		$query .= ", reg_kind='$reg_kind'";
		$query .= ", name_eng='$name_eng'";
		$query .= ", etc_field1='$etc_field1'";
		$query .= ", etc_field2='$etc_field2'";
		$query .= ", classification='$classification'";
		$query .= ", only_pil='$only_pil'";
		$query .= ", etc_field6='$etc_field6'";
		$query .= ", etc_field7='$etc_field7'";
		$query .= ", etc_field8='$etc_field8'";
		$query .= ", etc_field9='$etc_field9'";
		$query .= ", pay_status='$pay_status'";
		$query .= ", pay_date='$pay_date'";
		$query .= ", etc_field3='$etc_field3'";
		$query .= ", etc_field5='$etc_field5'";
		$query .= ", depart_kor='$depart_kor'";
		$query .= ", depart_eng='$depart_eng'";
		if (isset($_CONFIG['show_lecture_attend']) && $_CONFIG['show_lecture_attend']) {
			$query .= ", lecture1='$lecture1'";
			$query .= ", lecture2='$lecture2'";
			$query .= ", lecture3='$lecture3'";
			$query .= ", lecture4='$lecture4'";
		}
		$query .= ", member_level='".$_POST['member_level']."'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		$newSid = (int)mysql_insert_id();
		if ($newSid > 0) {
			$newLabel = trim($name_kr) != '' ? $name_kr : $name_eng;
			if ($newLabel == '') {
				$newLabel = $id;
			}
			regLogWrite($newSid, 'insert', 'postform', array(
				'(new)' => array('', $newLabel)
			));
			for ($di = 1; $di <= $eventDays; $di++) {
				postSyncCheckinDay($conn, $newSid, $di, ${'login_day'.$di}, ${'logout_day'.$di});
			}
		}
		$conn->disconnect();
		PutMessageCloseOpenerReload("등록되었습니다.");
	}
	

?>
