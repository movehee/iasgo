<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	procAdminLoginChk();

	$inDay = isset($_POST['in_day']) ? trim($_POST['in_day']) : '';
	$sessionDay = isset($_POST['session_day']) ? trim($_POST['session_day']) : '';
	$groupKey = isset($_POST['group_key']) ? trim($_POST['group_key']) : '';
	$rowSid = isset($_POST['sid']) ? (int)$_POST['sid'] : 0;
	$firstDateIn = isset($_POST['first_date']) ? trim($_POST['first_date']) : '';
	$lastDateIn = isset($_POST['last_date']) ? trim($_POST['last_date']) : '';

	if ($rowSid < 1 || $sessionDay == '') {
		PutMessageBack('잘못된 접근입니다.');
	}
	if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $sessionDay)) {
		PutMessageBack('잘못된 접근입니다.');
	}
	if ($inDay == '' || !isset($_TIME['session'][$inDay])) {
		PutMessageBack('잘못된 접근입니다.');
	}

	$sessionCount = 0;
	if (isset($_TIME['session'][$inDay])) {
		$sessionCount = count($_TIME['session'][$inDay]);
	}

	$sessionTimes = array();
	for ($i = 1; $i <= $sessionCount; $i++) {
		$stime = isset($_POST['session'.$i.'_stime']) ? trim($_POST['session'.$i.'_stime']) : '';
		$etime = isset($_POST['session'.$i.'_etime']) ? trim($_POST['session'.$i.'_etime']) : '';
		if ($stime != '' && !preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $stime)) {
			PutMessageBack('시간 형식이 올바르지 않습니다.');
		}
		if ($etime != '' && !preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $etime)) {
			PutMessageBack('시간 형식이 올바르지 않습니다.');
		}
		if ($stime != '' && $etime != '' && $stime > $etime) {
			PutMessageBack('퇴장 시간이 입장 시간보다 빠를 수 없습니다.');
		}
		$sessionTimes[$i] = array(
			'sdate' => $stime != '' ? strtotime($sessionDay.' '.$stime) : '',
			'edate' => $etime != '' ? strtotime($sessionDay.' '.$etime) : ''
		);
	}

	if ($firstDateIn != '' && !preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $firstDateIn)) {
		PutMessageBack('시간 형식이 올바르지 않습니다.');
	}
	if ($lastDateIn != '' && !preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9]$/', $lastDateIn)) {
		PutMessageBack('시간 형식이 올바르지 않습니다.');
	}

	$firstDate = $firstDateIn != '' ? strtotime($sessionDay.' '.$firstDateIn) : '';
	$lastDate = $lastDateIn != '' ? strtotime($sessionDay.' '.$lastDateIn) : '';

	$allowedTables = array('checkin_tbl');

	$chkinTbl = 'checkin_tbl';
	if (!in_array($chkinTbl, $allowedTables)) {
		error_log('[SessionTime] invalid table: '.$chkinTbl);
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	$query = 'UPDATE '.$chkinTbl.' SET modify = ?';
	$params = array('Y');
	if ($firstDate) {
		$query .= ', first_date = ?';
		$params[] = $firstDate;
	}
	if ($lastDate) {
		$query .= ', last_date = ?';
		$params[] = $lastDate;
	}
	for ($i = 1; $i <= $sessionCount; $i++) {
		$query .= ', s'.$i.'_sdate = ?';
		$params[] = $sessionTimes[$i]['sdate'];
		$query .= ', s'.$i.'_edate = ?';
		$params[] = $sessionTimes[$i]['edate'];
	}
	$query .= ' WHERE sid = ?';
	$params[] = $rowSid;

	$result = $conn->query($query, $params);
	if (DB::isError($result)) {
		error_log('[SessionTime] update failed: sid='.$rowSid.' '.$result->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	// 필수세션 없음 — checkin_tbl_ind 저장 안 함
	/*
	if ($ind_session_stime || $ind_session_etime) {
		...
	}
	*/

	$conn->disconnect();
	PutMessageCloseOpenerReload('등록되었습니다.');
?>
