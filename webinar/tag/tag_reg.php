<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';

	$tagNumber = isset($_POST['tag_number']) ? trim($_POST['tag_number']) : '';
	$roomIn = '';
	if (isset($_POST['room'])) {
		$roomIn = trim($_POST['room']);
	} else if (isset($_GET['room'])) {
		$roomIn = trim($_GET['room']);
	} else if (isset($_COOKIE['tag_room'])) {
		$roomIn = trim($_COOKIE['tag_room']);
	}
	$room = (int)$roomIn;
	if ($room < 1 || $room > 99) {
		$room = 1;
	}
	setcookie('tag_room', (string)$room, 0, '/');
	$indexUrl = 'index.php?room='.$room;

	// 최고관리자 스위치: 아이패드/태그 출결 사용 여부
	if (!isset($_MASTER['tag_checkin']) || $_MASTER['tag_checkin'] != 'Y') {
		PutMessageLocation('출결 태그가 일시 중지되었습니다.', $indexUrl);
		exit;
	}

	if ($tagNumber == '') {
		PutMessageLocation('정상적인 접근이 아닙니다.', $indexUrl);
		exit;
	}

	$len = mb_strlen($tagNumber, 'UTF-8') - 1;
	$lastTxt = mb_substr($tagNumber, $len, 1, 'UTF-8');
	if ($lastTxt == 'A' || $lastTxt == 'ㅁ') {
		$tagNumber = mb_substr($tagNumber, 0, $len, 'UTF-8');
	} else {
		PutMessageLocation('정상적인 접근이 아닙니다.', $indexUrl);
		exit;
	}

	if (!is_numeric($tagNumber)) {
		PutMessageLocation('코드값이 숫자가 아닙니다.', $indexUrl);
		exit;
	}
	$usid = (int)$tagNumber;

	$memberResult = $conn->query(
		'SELECT sid, group_key, country FROM registration_tbl WHERE sid = ?',
		array($usid)
	);
	if (DB::isError($memberResult)) {
		error_log('[Tag] member select failed: usid='.$usid.' '.$memberResult->getMessage());
		PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
		exit;
	}
	$member = $memberResult->fetchRow(DB_FETCHMODE_ASSOC);
	$memberResult->free();
	if (!$member || !(int)$member['sid']) {
		PutMessageLocation('등록되어있는 회원이 아닙니다.', $indexUrl);
		exit;
	}

	$groupKey = isset($member['group_key']) ? trim($member['group_key']) : '';

	$checkinTbl = 'checkin_tbl';
	$detailTbl = 'checkin_detail_tbl';

	// 시간설정 사용함이면 고정 시각 유지 (비관리자 include 시 time()으로 덮이는 것 보정)
	$tagTime = isset($_Time['ing']) ? (int)$_Time['ing'] : time();
	$timeIngFile = $_SERVER['DOCUMENT_ROOT'].'/func/config_time_ing.php';
	if (is_file($timeIngFile)) {
		$timeIngRaw = @file_get_contents($timeIngFile);
		if ($timeIngRaw !== false && strpos($timeIngRaw, "\$_Time['use'] = true") !== false) {
			if (preg_match('/\$_Time\[\'ing\'\]\s*=\s*"([0-9]+)"/', $timeIngRaw, $timeIngMatch)) {
				$fixedIng = (int)$timeIngMatch[1];
				if ($fixedIng > 0) {
					$tagTime = $fixedIng;
					$_Time['ing'] = $fixedIng;
					$_Time['use'] = true;
				}
			}
		}
	}
	$today = date('Y-m-d', $tagTime);

	// 행사일(config_time 세션 날짜)만 허용. 그 외 날짜는 저장하지 않음.
	// 테스트: 관리자 base_setting/time 에서 $_Time['ing'] 을 행사일 시각으로 설정
	$day = 0;
	if (isset($_TIME['session']) && is_array($_TIME['session'])) {
		foreach ($_TIME['session'] as $dkey => $sessions) {
			if (!isset($sessions['1'][0])) {
				continue;
			}
			$sessionDay = substr($sessions['1'][0], 0, 10);
			if ($today == $sessionDay) {
				$day = (int)$dkey;
				break;
			}
		}
	}
	if ($day < 1 || !isset($_TIME['session'][$day]) || !$_TIME['session'][$day]) {
		PutMessageLocation('행사 기간에만 출결 태그가 가능합니다.', $indexUrl);
		exit;
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
		PutMessageLocation('세션 설정이 없습니다.', $indexUrl);
		exit;
	}

	$sCol = 's'.$sessionNum.'_sdate';
	$eCol = 's'.$sessionNum.'_edate';
	$chkType = 'I';
	$inout = 'In';

	$rowResult = $conn->query(
		'SELECT * FROM '.$checkinTbl.' WHERE usid = ? AND day = ?',
		array($usid, $day)
	);
	if (DB::isError($rowResult)) {
		error_log('[Tag] checkin select failed: '.$rowResult->getMessage());
		PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
		exit;
	}
	$row = $rowResult->fetchRow(DB_FETCHMODE_ASSOC);
	$rowResult->free();

	if (!$row || !(int)$row['sid']) {
		$ins = $conn->query(
			'INSERT INTO '.$checkinTbl.' SET usid = ?, day = ?, first_date = ?, last_date = ?, '.$sCol.' = ?',
			array($usid, $day, $tagTime, $tagTime, $tagTime)
		);
		if (DB::isError($ins)) {
			error_log('[Tag] checkin insert failed: '.$ins->getMessage());
			PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
			exit;
		}
	} else {
		$rowSid = (int)$row['sid'];
		$sessionSdate = isset($row[$sCol]) ? $row[$sCol] : '';
		if ($sessionSdate > 0) {
			$chkType = 'O';
			$inout = 'Out';
			$upd = $conn->query(
				'UPDATE '.$checkinTbl.' SET '.$eCol.' = ?, last_date = ? WHERE sid = ?',
				array($tagTime, $tagTime, $rowSid)
			);
		} else {
			$upd = $conn->query(
				'UPDATE '.$checkinTbl.' SET '.$sCol.' = IF('.$sCol.' > 0, '.$sCol.', ?), last_date = ?, first_date = IF(first_date > 0, first_date, ?) WHERE sid = ?',
				array($tagTime, $tagTime, $tagTime, $rowSid)
			);
		}
		if (DB::isError($upd)) {
			error_log('[Tag] checkin update failed: '.$upd->getMessage());
			PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
			exit;
		}
	}

	$keyVal = $usid.'_'.$tagTime;
	$detailIns = $conn->query(
		'INSERT INTO '.$detailTbl.' SET key_val = ?, day = ?, room = ?, usid = ?, session_in = ?, check_in = ?, chk_type = ?, location_kind = ?',
		array($keyVal, $day, (string)$room, (string)$usid, (string)$sessionNum, (string)$tagTime, $chkType, 'T')
	);
	if (DB::isError($detailIns)) {
		error_log('[Tag] detail insert failed: '.$detailIns->getMessage());
		PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
		exit;
	}
?>
<form name="tagF" id="tagF" method="post" action="tag_result.php">
	<input type="hidden" name="usid" value="<?=(int)$usid?>">
	<input type="hidden" name="day" value="<?=(int)$day?>">
	<input type="hidden" name="group_key" value="<?=htmlspecialchars($groupKey, ENT_QUOTES, 'UTF-8')?>">
	<input type="hidden" name="room" value="<?=(int)$room?>">
	<input type="hidden" name="session" value="<?=(int)$sessionNum?>">
	<input type="hidden" name="inout" value="<?=htmlspecialchars($inout, ENT_QUOTES, 'UTF-8')?>">
	<input type="hidden" name="tag_time" value="<?=(int)$tagTime?>">
</form>
<script>
	document.tagF.submit();
</script>
