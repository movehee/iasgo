<?php
	/**
	 * IASGO Registration 통계 집계 (표 4종)
	 * 표1 국가별 day 입장 / 표2 국내 구분별 출결 / 표3 DESK별 금액 / 표4 단체등록(Memo 그룹)
	 *
	 * - 체크인 = checkin_tbl.first_date > 0 (해당 day)
	 * - 체크아웃 = checkin_tbl.last_date > 0 OR logout_dayN > 0
	 * - 금액 구분: DESK1=사전등록1, DESK2=사전등록2, DESK3=현장등록 (etc_field7)
	 * - 금액 day = pay_date 날짜. 행사일이면 해당 day, 행사 전이면 Day1, 행사 후면 Day3
	 * - 금액통계: pay_status 완료(Y)/현장납부(N)만, 무료(free_yn=Y) 제외
	 * - 표4 단체: 국내 [5인 이상 단체]Trainee
	 *   Memo 미입력 제외. LIKE 또는 앞부분 같으면 같은 단체. 2명 이상만 표시
	 */
	function getRegStatistics($conn) {
		global $_REG, $_ONSITE, $_Webinar;

		$baseWhere = ' del = ? AND IFNULL(member_level,\'\') <> ? ';
		$baseParams = array('N', 'M');

		$sdate = isset($_Webinar['sdate']) ? $_Webinar['sdate'] : '2026-09-09';
		$ex = explode('-', $sdate);
		$y = isset($ex[0]) ? $ex[0] : 2026;
		$m = isset($ex[1]) ? $ex[1] : 9;
		$d = isset($ex[2]) ? $ex[2] : 9;

		$dayDates = array(
			'1' => date('Y-m-d', mktime(0, 0, 0, $m, $d, $y)),
			'2' => date('Y-m-d', mktime(0, 0, 0, $m, $d + 1, $y)),
			'3' => date('Y-m-d', mktime(0, 0, 0, $m, $d + 2, $y))
		);
		$dayLabels = array(
			'1' => date('m/d', mktime(0, 0, 0, $m, $d, $y)),
			'2' => date('m/d', mktime(0, 0, 0, $m, $d + 1, $y)),
			'3' => date('m/d', mktime(0, 0, 0, $m, $d + 2, $y))
		);

		// 금액통계 구분 = DESK 매핑
		$deskTypeMap = array(
			'1' => '사전등록1',
			'2' => '사전등록2',
			'3' => '현장등록'
		);

		$stats = array(
			'day_labels' => $dayLabels,
			'day_dates' => $dayDates,
			'by_nation' => array('rows' => array(), 'sum' => array('day1' => 0, 'day2' => 0, 'day3' => 0)),
			'by_attend' => array('rows' => array(), 'sum' => array()),
			'by_amount' => array('rows' => array(), 'sum' => array()),
			'by_group' => array('groups' => array(), 'rows' => array(), 'sum' => array('fee' => 0, 'cnt' => 0))
		);

		// 출결: checkin_tbl.first_date / last_date (varchar → +0). 체크아웃은 관리자 수동 logout_dayN 포함
		$ciIn = array();
		$ciOut = array();
		for ($di = 1; $di <= 3; $di++) {
			$ciIn[$di] = 'EXISTS (SELECT 1 FROM checkin_tbl c WHERE c.usid = registration_tbl.sid'
				. ' AND c.day = '.$di.' AND IFNULL(c.first_date, 0) + 0 > 0)';
			$ciOut[$di] = '(EXISTS (SELECT 1 FROM checkin_tbl c WHERE c.usid = registration_tbl.sid'
				. ' AND c.day = '.$di.' AND IFNULL(c.last_date, 0) + 0 > 0)'
				. ' OR IFNULL(logout_day'.$di.', 0) + 0 > 0)';
		}

		// ----- 표1. 참여국가별 (입장 기록 있는 국가만) -----
		$query = 'SELECT IFNULL(NULLIF(TRIM(etc_field1), \'\'), \'\') AS nation'
			. ', SUM(CASE WHEN '.$ciIn[1].' THEN 1 ELSE 0 END) AS day1'
			. ', SUM(CASE WHEN '.$ciIn[2].' THEN 1 ELSE 0 END) AS day2'
			. ', SUM(CASE WHEN '.$ciIn[3].' THEN 1 ELSE 0 END) AS day3'
			. ' FROM registration_tbl'
			. ' WHERE '.$baseWhere
			. ' GROUP BY IFNULL(NULLIF(TRIM(etc_field1), \'\'), \'\')'
			. ' HAVING day1 > 0 OR day2 > 0 OR day3 > 0'
			. ' ORDER BY nation ASC';
		$result = $conn->query($query, $baseParams);
		if (DB::isError($result)) {
			error_log('[RegStats] by_nation: '.$result->getMessage());
		} else {
			$sum = array('day1' => 0, 'day2' => 0, 'day3' => 0);
			$rows = array();
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$item = array(
					'nation' => ($row['nation'] == '') ? '없음' : $row['nation'],
					'day1' => $row['day1'],
					'day2' => $row['day2'],
					'day3' => $row['day3']
				);
				$rows[] = $item;
				$sum['day1'] += $item['day1'];
				$sum['day2'] += $item['day2'];
				$sum['day3'] += $item['day3'];
			}
			$stats['by_nation'] = array('rows' => $rows, 'sum' => $sum);
		}

		// ----- 표2. 입장통계 (국내 + gubun1, 체크인/체크아웃) -----
		$gubunList = isset($_ONSITE['gubun1']) ? $_ONSITE['gubun1'] : array();
		$attendSum = array(
			'd1_in' => 0, 'd1_out' => 0,
			'd2_in' => 0, 'd2_out' => 0,
			'd3_in' => 0, 'd3_out' => 0
		);
		$attendRows = array();

		$query = 'SELECT gubun1'
			. ', SUM(CASE WHEN '.$ciIn[1].' THEN 1 ELSE 0 END) AS d1_in'
			. ', SUM(CASE WHEN '.$ciOut[1].' THEN 1 ELSE 0 END) AS d1_out'
			. ', SUM(CASE WHEN '.$ciIn[2].' THEN 1 ELSE 0 END) AS d2_in'
			. ', SUM(CASE WHEN '.$ciOut[2].' THEN 1 ELSE 0 END) AS d2_out'
			. ', SUM(CASE WHEN '.$ciIn[3].' THEN 1 ELSE 0 END) AS d3_in'
			. ', SUM(CASE WHEN '.$ciOut[3].' THEN 1 ELSE 0 END) AS d3_out'
			. ' FROM registration_tbl'
			. ' WHERE '.$baseWhere.' AND country = ?'
			. ' GROUP BY gubun1';
		$params = array_merge($baseParams, array('K'));
		$result = $conn->query($query, $params);
		$dataByGubun = array();
		if (DB::isError($result)) {
			error_log('[RegStats] by_attend: '.$result->getMessage());
		} else {
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$dataByGubun[$row['gubun1']] = $row;
			}
		}

		foreach ($gubunList as $gkey => $glabel) {
			$row = isset($dataByGubun[$gkey]) ? $dataByGubun[$gkey] : array();
			$item = array(
				'code' => $gkey,
				'label' => $glabel,
				'd1_in' => isset($row['d1_in']) ? $row['d1_in'] : 0,
				'd1_out' => isset($row['d1_out']) ? $row['d1_out'] : 0,
				'd2_in' => isset($row['d2_in']) ? $row['d2_in'] : 0,
				'd2_out' => isset($row['d2_out']) ? $row['d2_out'] : 0,
				'd3_in' => isset($row['d3_in']) ? $row['d3_in'] : 0,
				'd3_out' => isset($row['d3_out']) ? $row['d3_out'] : 0
			);
			$attendRows[] = $item;
			$attendSum['d1_in'] += $item['d1_in'];
			$attendSum['d1_out'] += $item['d1_out'];
			$attendSum['d2_in'] += $item['d2_in'];
			$attendSum['d2_out'] += $item['d2_out'];
			$attendSum['d3_in'] += $item['d3_in'];
			$attendSum['d3_out'] += $item['d3_out'];
		}
		// gubun1 미선택 / 미정의
		$etcIn = array('d1_in' => 0, 'd1_out' => 0, 'd2_in' => 0, 'd2_out' => 0, 'd3_in' => 0, 'd3_out' => 0);
		$hasEtc = false;
		foreach ($dataByGubun as $gkey => $row) {
			if (isset($gubunList[$gkey])) {
				continue;
			}
			$hasEtc = true;
			$etcIn['d1_in'] += $row['d1_in'];
			$etcIn['d1_out'] += $row['d1_out'];
			$etcIn['d2_in'] += $row['d2_in'];
			$etcIn['d2_out'] += $row['d2_out'];
			$etcIn['d3_in'] += $row['d3_in'];
			$etcIn['d3_out'] += $row['d3_out'];
		}
		if ($hasEtc) {
			$item = array(
				'code' => '',
				'label' => '(미선택)',
				'd1_in' => $etcIn['d1_in'],
				'd1_out' => $etcIn['d1_out'],
				'd2_in' => $etcIn['d2_in'],
				'd2_out' => $etcIn['d2_out'],
				'd3_in' => $etcIn['d3_in'],
				'd3_out' => $etcIn['d3_out']
			);
			$attendRows[] = $item;
			foreach ($etcIn as $k => $v) {
				$attendSum[$k] += $v;
			}
		}
		$stats['by_attend'] = array('rows' => $attendRows, 'sum' => $attendSum);

		// ----- 표3. 금액통계 (DESK1=사전등록1, DESK2=사전등록2, DESK3=현장등록) -----
		$amountRows = array();
		foreach ($deskTypeMap as $dkey => $dlabel) {
			$amountRows[$dkey] = array(
				'desk' => $dkey,
				'label' => $dlabel,
				'd1_CARD' => 0, 'd1_CASH' => 0, 'd1_BANK' => 0,
				'd2_CARD' => 0, 'd2_CASH' => 0, 'd2_BANK' => 0,
				'd3_CARD' => 0, 'd3_CASH' => 0, 'd3_BANK' => 0
			);
		}
		$amountSum = array(
			'd1_CARD' => 0, 'd1_CASH' => 0, 'd1_BANK' => 0,
			'd2_CARD' => 0, 'd2_CASH' => 0, 'd2_BANK' => 0,
			'd3_CARD' => 0, 'd3_CASH' => 0, 'd3_BANK' => 0
		);

		$query = 'SELECT etc_field7, etc_field5'
			. ', SUBSTR(pay_date, 1, 10) AS pay_day'
			. ', SUM(IFNULL(reg_fee, 0)) AS fee_sum'
			. ' FROM registration_tbl'
			. ' WHERE '.$baseWhere
			. ' AND IFNULL(pay_date, \'\') <> \'\''
			. ' AND etc_field7 IN (\'1\', \'2\', \'3\')'
			. ' AND pay_status IN (\'Y\', \'N\')'
			. ' AND IFNULL(free_yn, \'N\') <> \'Y\''
			. ' GROUP BY etc_field7, etc_field5, SUBSTR(pay_date, 1, 10)';
		$result = $conn->query($query, $baseParams);
		if (DB::isError($result)) {
			error_log('[RegStats] by_amount: '.$result->getMessage());
		} else {
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$dkey = (string)$row['etc_field7'];
				if (!isset($amountRows[$dkey])) {
					continue;
				}
				$pm = $row['etc_field5'];
				if ($pm != 'CARD' && $pm != 'CASH' && $pm != 'BANK') {
					continue;
				}
				$dayNum = statsPayDateToDayNum($row['pay_day'], $dayDates);
				if ($dayNum == '') {
					continue;
				}
				$key = 'd'.$dayNum.'_'.$pm;
				$fee = $row['fee_sum'];
				$amountRows[$dkey][$key] += $fee;
				$amountSum[$key] += $fee;
			}
		}

		$outRows = array();
		foreach ($deskTypeMap as $dkey => $dlabel) {
			$outRows[] = $amountRows[$dkey];
		}
		$stats['by_amount'] = array('rows' => $outRows, 'sum' => $amountSum);

		// ----- 표4. 단체등록 — 국내 [5인 이상 단체]Trainee + 같은 Memo 2명 이상 -----
		$korGroupCodes = statsGetGroupFeeCodes(isset($_ONSITE['fee_kor']) ? $_ONSITE['fee_kor'] : array());
		if (count($korGroupCodes) == 0) {
			$korGroupCodes = array('D');
		}

		$allItems = array();
		$params = $baseParams;
		$params[] = 'K';
		$titlePh = array();
		foreach ($korGroupCodes as $code) {
			$titlePh[] = '?';
			$params[] = $code;
		}

		$query = 'SELECT email, classification, etc_field1, country, name_kr, name_eng, etc_field7, reg_fee, memo'
			. ' FROM registration_tbl'
			. ' WHERE '.$baseWhere
			. ' AND IFNULL(TRIM(memo), \'\') <> \'\''
			. ' AND country = ? AND title IN ('.implode(', ', $titlePh).')'
			. ' ORDER BY email ASC, name_kr ASC, sid ASC';
		$result = $conn->query($query, $params);
		if (DB::isError($result)) {
			error_log('[RegStats] by_group: '.$result->getMessage());
		} else {
			while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$allItems[] = $row;
			}
		}

		$items = array();
		foreach ($allItems as $row) {
			$memoKey = statsNormalizeMemo($row['memo']);
			if ($memoKey == '') {
				continue;
			}
			$classKey = $row['classification'];
			$deskKey = (string)$row['etc_field7'];
			$nation = trim($row['etc_field1']);
			if ($nation == '') {
				$nation = isset($_REG['reg_country'][$row['country']]) ? $_REG['reg_country'][$row['country']] : '';
			}
			$fee = (int)$row['reg_fee'];
			$items[] = array(
				'email' => $row['email'],
				'type_label' => isset($_REG['class_kind'][$classKey]) ? $_REG['class_kind'][$classKey] : $classKey,
				'nation' => $nation,
				'name_kr' => $row['name_kr'],
				'name_eng' => $row['name_eng'],
				'desk_label' => isset($_REG['desk'][$deskKey]) ? $_REG['desk'][$deskKey] : '',
				'fee' => $fee,
				'memo' => $memoKey
			);
		}

		$itemCnt = count($items);
		$parent = array();
		for ($i = 0; $i < $itemCnt; $i++) {
			$parent[$i] = $i;
		}
		for ($i = 0; $i < $itemCnt; $i++) {
			for ($j = $i + 1; $j < $itemCnt; $j++) {
				if (statsMemoLike($items[$i]['memo'], $items[$j]['memo'])) {
					statsUnionFindMerge($i, $j, $parent);
				}
			}
		}

		$groupMap = array();
		for ($i = 0; $i < $itemCnt; $i++) {
			$root = statsUnionFindRoot($i, $parent);
			$rk = (string)$root;
			if (!isset($groupMap[$rk])) {
				$groupMap[$rk] = array(
					'memo' => $items[$i]['memo'],
					'memo_label' => $items[$i]['memo'],
					'cnt' => 0,
					'fee' => 0,
					'rows' => array()
				);
			}
			if (strlen($items[$i]['memo']) < strlen($groupMap[$rk]['memo'])) {
				$groupMap[$rk]['memo'] = $items[$i]['memo'];
				$groupMap[$rk]['memo_label'] = $items[$i]['memo'];
			}
			$groupMap[$rk]['rows'][] = $items[$i];
			$groupMap[$rk]['cnt']++;
			$groupMap[$rk]['fee'] += $items[$i]['fee'];
		}

		$groupList = array();
		foreach ($groupMap as $grp) {
			if ($grp['cnt'] < 2) {
				continue;
			}
			$groupList[] = $grp;
		}
		$sortMemos = array();
		foreach ($groupList as $idx => $grp) {
			$sortMemos[$idx] = $grp['memo'];
		}
		if (count($groupList) > 1) {
			array_multisort($sortMemos, SORT_STRING, $groupList);
		}

		$flatRows = array();
		$groupSum = array('fee' => 0, 'cnt' => 0);
		foreach ($groupList as $grp) {
			foreach ($grp['rows'] as $flatRow) {
				$flatRows[] = $flatRow;
			}
			$groupSum['fee'] += $grp['fee'];
			$groupSum['cnt'] += $grp['cnt'];
		}
		$stats['by_group'] = array('groups' => $groupList, 'rows' => $flatRows, 'sum' => $groupSum);

		return $stats;
	}

	function statsPayDateToDayNum($payDay, $dayDates) {
		$payDay = substr(trim($payDay), 0, 10);
		if ($payDay == '' || strlen($payDay) < 10) {
			return '';
		}
		if ($payDay == $dayDates['1']) {
			return '1';
		}
		if ($payDay == $dayDates['2']) {
			return '2';
		}
		if ($payDay == $dayDates['3']) {
			return '3';
		}
		if ($payDay < $dayDates['1']) {
			return '1';
		}
		if ($payDay > $dayDates['3']) {
			return '3';
		}
		return '';
	}

	function statsGetGroupFeeCodes($feeList) {
		$codes = array();
		if (!is_array($feeList)) {
			return $codes;
		}
		foreach ($feeList as $code => $info) {
			$title = '';
			if (is_array($info) && isset($info['title'])) {
				$title = $info['title'];
			}
			if ($title != '' && strpos($title, '5인 이상 단체') !== false) {
				$codes[] = $code;
			}
		}
		return $codes;
	}

	function statsNormalizeMemo($memo) {
		if ($memo == null) {
			$memo = '';
		}
		$memo = str_replace("\r\n", "\n", $memo);
		$memo = str_replace("\r", "\n", $memo);
		return trim($memo);
	}

	/** 한쪽이 다른 쪽을 포함(LIKE)하거나, 앞 12바이트 이상이 같으면 같은 단체 */
	function statsMemoLike($a, $b) {
		if ($a == '' || $b == '') {
			return false;
		}
		if ($a == $b) {
			return true;
		}
		if (strpos($a, $b) !== false) {
			return true;
		}
		if (strpos($b, $a) !== false) {
			return true;
		}
		$minPrefix = 12;
		$max = min(strlen($a), strlen($b));
		if ($max < $minPrefix) {
			return false;
		}
		$same = 0;
		while ($same < $max && $a[$same] == $b[$same]) {
			$same++;
		}
		return ($same >= $minPrefix);
	}

	function statsUnionFindRoot($i, &$parent) {
		while ($parent[$i] != $i) {
			$parent[$i] = $parent[$parent[$i]];
			$i = $parent[$i];
		}
		return $i;
	}

	function statsUnionFindMerge($a, $b, &$parent) {
		$ra = statsUnionFindRoot($a, $parent);
		$rb = statsUnionFindRoot($b, $parent);
		if ($ra != $rb) {
			$parent[$rb] = $ra;
		}
	}
?>
