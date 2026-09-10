<?php
	/**
	 * iPad QR 출결 API
	 * - 요청: barcode={sid}A (paraKey)
	 * - 응답: name, office, score, in_time, out_time 또는 complete=N + alert_msg
	 * - 기록: checkin_tbl + checkin_detail_tbl
	 * - registration_tbl: 첫 QR 시 loginN=Y, login_dayN=최초입장 / 두 번째 이후 QR 시 logout_dayN=마지막 태그
	 */
	ob_start();

	include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.connect.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';

	if (function_exists('date_default_timezone_set')) {
		date_default_timezone_set('Asia/Seoul');
	}

	$tagTime = getFixedNowTime();
	$timeIngFile = dirname(__FILE__).'/../func/config_time_ing.php';

	function checkInToUtf8($val) {
		$val = (string)$val;
		if ($val == '') {
			return '';
		}
		if (function_exists('mb_check_encoding') && mb_check_encoding($val, 'UTF-8')) {
			return $val;
		}
		if (function_exists('iconv')) {
			$conv = @iconv('EUC-KR', 'UTF-8//IGNORE', $val);
			if ($conv !== false && $conv != '') {
				return $conv;
			}
		}
		return $val;
	}

	function checkInJsonExit($payload) {
		while (ob_get_level() > 0) {
			ob_end_clean();
		}
		if (is_array($payload)) {
			foreach ($payload as $jsonKey => $jsonVal) {
				if (!is_int($jsonVal) && !is_float($jsonVal)) {
					$payload[$jsonKey] = checkInToUtf8($jsonVal);
				}
			}
		}
		// text/html 본문에 JSON. application/json 이면 구버전 앱이 화면을 안 그림.
		header('Content-Type: text/html; charset=utf-8');
		header('Access-Control-Allow-Origin: *');
		$json = json_encode($payload);
		if ($json === false || $json === null) {
			error_log('[CheckIn] json_encode failed');
			$json = '{"success":"N"}';
		}
		echo $json;
		exit;
	}

	function checkInFail($msg) {
		checkInJsonExit(array(
			'complete' => 'N',
			'name' => '',
			'office' => '',
			'in_time' => '',
			'out_time' => '',
			'time' => '',
			'score' => 0,
			'alert_msg' => $msg
		));
	}

	function checkInMarkLoginDay($conn, $usid, $day, $markTime, $updateLogout) {
		$day = (int)$day;
		$usid = (int)$usid;
		$markTime = (int)$markTime;
		if ($usid < 1 || $markTime < 1 || $day < 1 || $day > 5) {
			return;
		}
		$loginCol = 'login'.$day;
		$inCol = 'login_day'.$day;
		$outCol = 'logout_day'.$day;
		// loginN=Y, login_dayN=최초만 유지. 두 번째 이후 태그는 In/Out 구분 없이 logout_dayN 을 마지막 태그로 갱신
		$sql = 'UPDATE registration_tbl SET '.$loginCol.' = ?'
			.', '.$inCol.' = IF(IFNULL('.$inCol.', 0)+0 > 0, '.$inCol.', ?)';
		$params = array('Y', $markTime);
		if ($updateLogout) {
			$sql .= ', '.$outCol.' = ?';
			$params[] = $markTime;
		}
		$sql .= ' WHERE sid = ? AND del = ?';
		$params[] = $usid;
		$params[] = 'N';
		$upd = $conn->query($sql, $params);
		if (DB::isError($upd)) {
			error_log('[CheckIn] login'.$day.' update failed: usid='.$usid.' '.$upd->getMessage());
		}
	}

	function checkInFormatTime($ts) {
		$ts = (int)$ts;
		if ($ts < 1) {
			return '';
		}
		return date('Y.m.d H시i분', $ts);
	}

	/**
	 * 출결 저장 시각
	 * - time_clamp=Y 이면 당일 인정 시작~종료로 자른다 (행사 전→최초, 행사 후→최종)
	 * - N 이면 실제 태그 시각
	 */
	function checkInStoreTime($tagTime, $day) {
		global $_MASTER;
		$tagTime = (int)$tagTime;
		$day = (int)$day;
		if ($tagTime < 1) {
			return 0;
		}
		if (isset($_MASTER['time_clamp']) && $_MASTER['time_clamp'] == 'Y' && function_exists('clampToEventDayRange')) {
			return clampToEventDayRange($tagTime, $day);
		}
		return $tagTime;
	}

	// 아이패드/태그 출결 사용 여부
	if (!isset($_MASTER['tag_checkin']) || $_MASTER['tag_checkin'] != 'Y') {
		checkInFail('출결 태그가 일시 중지되었습니다.');
	}

	$barcode = isset($_REQUEST['barcode']) ? trim($_REQUEST['barcode']) : '';
	$barcode = str_replace(array("\r", "\n", "\0", "\t"), '', $barcode);
	if ($barcode == '') {
		checkInFail('정상적인 코드가 아닙니다.');
	}

	// 명찰 QR = {sid}A
	$len = mb_strlen($barcode, 'UTF-8') - 1;
	if ($len >= 0) {
		$lastTxt = mb_substr($barcode, $len, 1, 'UTF-8');
		$lastUpper = strtoupper($lastTxt);
		if ($lastUpper == 'A' || $lastTxt == 'ㅁ') {
			$barcode = mb_substr($barcode, 0, $len, 'UTF-8');
		}
	}

	if (!is_numeric($barcode)) {
		error_log('[CheckIn] bad barcode: hex='.bin2hex($barcode));
		checkInFail('정상적인 코드가 아닙니다.');
	}
	$usid = (int)$barcode;
	if ($usid < 1) {
		checkInFail('정상적인 코드가 아닙니다.');
	}

	$memberResult = $conn->query(
		'SELECT sid, group_key, name_kr, name_eng, aff_kor, aff_eng, country'
		.' FROM registration_tbl WHERE sid = ? AND del = ?',
		array($usid, 'N')
	);
	if (DB::isError($memberResult)) {
		error_log('[CheckIn] member select failed: usid='.$usid.' '.$memberResult->getMessage());
		checkInFail('시스템 장애입니다.다시시도해주세요');
	}
	$member = $memberResult->fetchRow(DB_FETCHMODE_ASSOC);
	$memberResult->free();
	if (!$member || !(int)$member['sid']) {
		checkInFail('등록된 내역이 없습니다.');
	}

	// group_key 는 등록 구분용. 출결 테이블은 단일 checkin_tbl 사용.
	$groupKey = isset($member['group_key']) ? trim($member['group_key']) : '';
	
	$name = $member['name_eng'];
	$office = $member['aff_eng'];
	if ($member['country'] == 'K') {
		if (trim($member['name_kr']) != '') {
			$name = $member['name_kr'];
		}
		if (trim($member['aff_kor']) != '') {
			$office = $member['aff_kor'];
		}
	} else {
		if (trim($name) == '' && trim($member['name_kr']) != '') {
			$name = $member['name_kr'];
		}
		if (trim($office) == '' && trim($member['aff_kor']) != '') {
			$office = $member['aff_kor'];
		}
	}

	$checkinTbl = 'checkin_tbl';
	$detailTbl = 'checkin_detail_tbl';

	$remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if ($remoteAddr == '218.235.94.219' && isset($_REQUEST['test_time']) && trim($_REQUEST['test_time']) != '') {
		$testTs = strtotime(trim($_REQUEST['test_time']));
		if ($testTs > 0) {
			$tagTime = $testTs;
		}
	}
	$today = date('Y-m-d', $tagTime);

	$day = 0;
	if (isset($_TIME['session']) && is_array($_TIME['session'])) {
		foreach ($_TIME['session'] as $dkey => $sessions) {
			if (!isset($sessions['1'][0])) {
				continue;
			}
			$sessionDay = substr($sessions['1'][0], 0, 10);
			$dayStart = strtotime($sessionDay.' 00:00:00');
			$dayEnd = strtotime($sessionDay.' 23:59:59');
			if ($today == $sessionDay || ($tagTime >= $dayStart && $tagTime <= $dayEnd)) {
				$day = (int)$dkey;
				break;
			}
		}
	}
	if ($day < 1 || !isset($_TIME['session'][$day]) || !$_TIME['session'][$day]) {
		error_log('[CheckIn] not event day: tagTime='.$tagTime.' today='.$today.' file='.$timeIngFile);
		checkInFail('행사일이 아닙니다.');
	}

	$session = '';
	foreach ($_TIME['session'][$day] as $tkey => $tval) {
		if ($tagTime <= strtotime($tval[1])) {
			$session = (string)$tkey;
			break;
		}
	}
	if ($session == '') {
		$sessionKeys = array_keys($_TIME['session'][$day]);
		$session = (string)end($sessionKeys);
	}
	$sessionNum = (int)$session;
	if ($sessionNum < 1 || !isset($_TIME['session'][$day][$sessionNum])) {
		checkInFail('세션 설정이 없습니다.');
	}

	$room = 1;
	if (isset($_REQUEST['room'])) {
		$roomIn = (int)$_REQUEST['room'];
		if ($roomIn >= 1 && $roomIn <= 99) {
			$room = $roomIn;
		}
	}

	$sCol = 's'.$sessionNum.'_sdate';
	$eCol = 's'.$sessionNum.'_edate';
	$chkType = 'I';
	$inout = 'In';
	// 세션 배정은 실제 태그시각, 저장·표시는 스위치에 따라 인정시간으로 자를 수 있다
	$storeTime = checkInStoreTime($tagTime, $day);

	$rowResult = $conn->query(
		'SELECT * FROM '.$checkinTbl.' WHERE usid = ? AND day = ?',
		array($usid, $day)
	);
	if (DB::isError($rowResult)) {
		error_log('[CheckIn] checkin select failed: '.$rowResult->getMessage());
		checkInFail('시스템 장애입니다.다시시도해주세요');
	}
	$row = $rowResult->fetchRow(DB_FETCHMODE_ASSOC);
	$rowResult->free();

	$isFirstTag = false;
	if (!$row || !(int)$row['sid']) {
		// 최초입장: last_date 는 비움 → 아이패드에 "나가실 때 QR" 안내
		$isFirstTag = true;
		$ins = $conn->query(
			'INSERT INTO '.$checkinTbl.' SET usid = ?, day = ?, first_date = ?, last_date = ?, '.$sCol.' = ?',
			array($usid, $day, $storeTime, 0, $storeTime)
		);
		if (DB::isError($ins)) {
			error_log('[CheckIn] checkin insert failed: '.$ins->getMessage());
			checkInFail('시스템 장애입니다.다시시도해주세요');
		}
		$row = array(
			'sid' => 0,
			'first_date' => $storeTime,
			'last_date' => 0,
			$sCol => $storeTime,
			$eCol => 0
		);
	} else {
		$rowSid = (int)$row['sid'];
		$sessionSdate = isset($row[$sCol]) ? $row[$sCol] : '';
		if ($sessionSdate > 0) {
			$chkType = 'O';
			$inout = 'Out';
			$upd = $conn->query(
				'UPDATE '.$checkinTbl.' SET '.$eCol.' = ?, last_date = ? WHERE sid = ?',
				array($storeTime, $storeTime, $rowSid)
			);
		} else {
			// 행이 이미 있으면 두 번째 이후 스캔이므로, 세션 입장이어도 최종시각을 갱신한다
			$upd = $conn->query(
				'UPDATE '.$checkinTbl.' SET '.$sCol.' = IF('.$sCol.' > 0, '.$sCol.', ?), first_date = IF(first_date > 0, first_date, ?), last_date = ? WHERE sid = ?',
				array($storeTime, $storeTime, $storeTime, $rowSid)
			);
		}
		if (DB::isError($upd)) {
			error_log('[CheckIn] checkin update failed: '.$upd->getMessage());
			checkInFail('시스템 장애입니다.다시시도해주세요');
		}
	}

	$keyVal = $usid.'_'.$tagTime;
	$detailIns = $conn->query(
		'INSERT INTO '.$detailTbl.' SET key_val = ?, day = ?, room = ?, usid = ?, session_in = ?, check_in = ?, chk_type = ?, location_kind = ?',
		array($keyVal, $day, (string)$room, (string)$usid, (string)$sessionNum, (string)$tagTime, $chkType, 'T')
	);
	if (DB::isError($detailIns)) {
		error_log('[CheckIn] detail insert failed: '.$detailIns->getMessage());
		checkInFail('시스템 장애입니다.다시시도해주세요');
	}

	// loginN=Y, login_dayN=최초입장. 두 번째 이후는 logout_dayN=마지막 태그 (실패해도 출결은 계속)
	checkInMarkLoginDay($conn, $usid, $day, $storeTime, !$isFirstTag);

	// 아이패드 표시: 하루 단위 최초입장 / 최종퇴장
	// out_time 이 비어 있을 때만 "나가실 때 QR" 안내가 뜨므로
	// 그날 첫 QR 은 last_date 가 있어도 out_time 을 비운다
	$displayIn = $storeTime;
	$displayOut = 0;
	$score = 0;
	$stayText = '';

	$fresh = $conn->query(
		'SELECT * FROM '.$checkinTbl.' WHERE usid = ? AND day = ?',
		array($usid, $day)
	);
	if (!DB::isError($fresh)) {
		$freshRow = $fresh->fetchRow(DB_FETCHMODE_ASSOC);
		$fresh->free();
		if (isset($freshRow['first_date']) && (int)$freshRow['first_date'] > 0) {
			$displayIn = (int)$freshRow['first_date'];
		}
		if (!$isFirstTag && isset($freshRow['last_date']) && (int)$freshRow['last_date'] > 0) {
			$displayOut = (int)$freshRow['last_date'];
		}
		$totalMin = getSessionStayMinutes($day, $freshRow);
		$scoreMax = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;
		$stayInfo = getSessionStayScore($totalMin, $scoreMax);
		$score = $stayInfo['score'];
		$stayH = (int)($totalMin / 60);
		$stayM = $totalMin % 60;
		if ($stayH > 0) {
			$stayText .= $stayH.'시간 ';
		}
		if ($stayM > 0) {
			$stayText .= $stayM.'분 ';
		}
	} else if (isset($row['first_date']) && (int)$row['first_date'] > 0) {
		$displayIn = (int)$row['first_date'];
	}

	checkInJsonExit(array(
		'success' => 'Y',
		'name' => $name,
		'office' => $office,
		'in_time' => checkInFormatTime($displayIn),
		'out_time' => ($displayOut > 0) ? checkInFormatTime($displayOut) : '',
		'time' => $stayText,
		'license_number' => (string)$usid,
		'score' => (int)$score
	));
?>
