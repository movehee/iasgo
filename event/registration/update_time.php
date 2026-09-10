<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	procAdminLoginChk();

	if (!isset($_TIME['session']) || !$_TIME['session']) {
		PutMessageBack('세션 설정이 없습니다.');
	}

	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;
	$allowedTables = array('checkin_tbl');

	$n = 1;
	foreach ($_TIME['session'] as $day => $sessionList) {
		$timeMaxCount = count($sessionList);
		if ($timeMaxCount < 1) {
			continue;
		}

		$sessionField = array();
		for ($s = 1; $s <= $timeMaxCount; $s++) {
			$sessionField[] = 's'.$s.'_sdate, s'.$s.'_edate';
		}
		$addField = ',usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,chking,gubun1,reg_kind,country';

		$query = 'SELECT '.implode(',', $sessionField).$addField.',sid,tbl_name FROM (';
		$query .= 'SELECT '.implode(',', $sessionField).$addField.',t1.sid,\'checkin_tbl\' AS tbl_name FROM checkin_tbl AS t1 INNER JOIN registration_tbl AS t2 ON t1.usid=t2.sid';
		$query .= ') A WHERE chking != ? AND day = ?';

		$result = $conn->query($query, array('Y', $day));
		if (DB::isError($result)) {
			error_log('[UpdateTime] select failed: day='.$day.' '.$result->getMessage());
			PutMessageBack('시스템 장애입니다.다시시도해주세요');
		}

		while (is_array($d = $result->fetchRow(DB_FETCHMODE_ASSOC))) {
			// 국외(F)는 출결만 유지, 평점 부여 안 함
			if ((isset($d['country']) && $d['country'] == 'F') || (isset($d['group_key']) && $d['group_key'] == 'F')) {
				continue;
			}

			// 체류·평점은 최초~최종 구간 기준 (config_time.php 와 동일 규칙)
			$totalMin = getSessionStayMinutes($d['day'], $d);
			$stayInfo = getSessionStayScore($totalMin, $scoreMaxHour);
			$stayHours = (int)($totalMin / 60);
			$score = $stayInfo['score'];

			// 만점자만 평점을 확정 저장한다
			if ($stayHours < $scoreMaxHour) {
				continue;
			}

			$tblName = $d['tbl_name'];
			if (!in_array($tblName, $allowedTables)) {
				error_log('[UpdateTime] skip invalid table: '.$tblName.' sid='.(int)$d['sid']);
				continue;
			}

			$upd = $conn->query(
				'UPDATE '.$tblName.' SET score = ?, chking = ? WHERE sid = ? AND day = ?',
				array($score, 'Y', (int)$d['sid'], $day)
			);
			if (DB::isError($upd)) {
				error_log('[UpdateTime] update failed: sid='.(int)$d['sid'].' '.$upd->getMessage());
				PutMessageBack('시스템 장애입니다.다시시도해주세요');
			}

			echo $n.'=='.$tblName.' sid='.(int)$d['sid'].' day='.$day.' score='.$score.'<br>';
			$n++;
		}
	}
?>
