<?php
	/*
	 * IASGO 2026 출결·평점 세션 설정 (단일 기준)
	 * - 관리자(event) / 아이패드 태그(webinar) 모두 이 파일을 사용
	 *
	 * 인정 시간만 시간 추가하면 되고, 휴식 or 런천 or 기타 등 제외 시간은 '분'만 작성
	 * 배열: 시작, 종료, 필수세션여부(N/Y), 다음세션까지 제외분(분), 사용(Y/N)
	 * ※ 4번째 값 = 종료~다음 인정세션 시작까지 제외 구간(휴식/런천/기타)
	 *
	 * Day1 2026-09-09
	 *   08:30-10:00 인정 / 10:00-10:20 제외(20)
	 *   10:20-11:50 인정 / 11:50-12:00 제외(10)
	 *   12:00-13:00 제외(60) / 13:00-13:20 제외(20)
	 *   13:20-14:20 인정 / 14:20-14:40 제외(20)
	 *   14:40-16:10 인정 / 16:10-16:20 제외(10)
	 *   16:20-17:50 인정
	 *
	 * Day2 2026-09-10
	 *   08:30-10:00 인정 / 10:00-10:20 제외(20)
	 *   10:20-11:50 인정 / 11:50-12:10 제외(20)
	 *   12:10-13:10 제외(60) / 13:10-13:40 인정
	 *   13:40-14:20 제외(40) / 14:20-14:40 제외(20)
	 *   14:40-16:10 인정 / 16:10-16:20 제외(10)
	 *   16:20-17:50 인정
	 *
	 * Day3 2026-09-11
	 *   08:00-09:00 인정 / 09:00-10:30 인정
	 *   10:30-10:50 제외(20) / 10:50-12:20 인정
	 *   12:20-12:30 제외(10) / 12:30-13:30 제외(60)
	 * 	 13:30-13:40 제외(10) / 13:40-15:40 인정
	 */
	include_once dirname(__FILE__).'/include.master_setting.php';

	$_TIME['score_max_hour'] = 6;

	$session_date1 = '2026-09-09';
	$_TIME['session']['1'] = array(
		'1' => array($session_date1.' 08:30', $session_date1.' 10:00', 'N', '20', 'Y'),
		'2' => array($session_date1.' 10:20', $session_date1.' 11:50', 'N', '90', 'Y'),
		'3' => array($session_date1.' 13:20', $session_date1.' 14:20', 'N', '20', 'Y'),
		'4' => array($session_date1.' 14:40', $session_date1.' 16:10', 'N', '10', 'Y'),
		'5' => array($session_date1.' 16:20', $session_date1.' 17:50', 'N', '0', 'Y')
	);

	$session_date2 = '2026-09-10';
	$_TIME['session']['2'] = array(
		'1' => array($session_date2.' 08:30', $session_date2.' 10:00', 'N', '20', 'Y'),
		'2' => array($session_date2.' 10:20', $session_date2.' 11:50', 'N', '80', 'Y'),
		'3' => array($session_date2.' 13:10', $session_date2.' 13:40', 'N', '60', 'Y'),
		'4' => array($session_date2.' 14:40', $session_date2.' 16:10', 'N', '10', 'Y'),
		'5' => array($session_date2.' 16:20', $session_date2.' 17:50', 'N', '0', 'Y')
	);

	$session_date3 = '2026-09-11';
	$_TIME['session']['3'] = array(
		'1' => array($session_date3.' 08:00', $session_date3.' 09:00', 'N', '0', 'Y'),
		'2' => array($session_date3.' 09:00', $session_date3.' 10:30', 'N', '20', 'Y'),
		'3' => array($session_date3.' 10:50', $session_date3.' 12:20', 'N', '80', 'Y'),
		'4' => array($session_date3.' 13:40', $session_date3.' 15:40', 'N', '0', 'Y')
	);

	// 필수세션 없음
	// $_TIME['session_ind']['1'] = array();

	/**
	 * 출결용 현재시각 (config_time_ing.php 고정시각 지원)
	 * - use=true 이면 파일의 고정 unix time
	 * - 아니면 time()
	 * - config_time_ing.php 는 비관리자 include 시 time()으로 덮으므로 include 하지 않고 파일만 읽는다
	 */
	function getFixedNowTime() {
		$now = time();
		$timeIngFile = '';
		if (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] != '') {
			$timeIngFile = rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/func/config_time_ing.php';
		}
		if ($timeIngFile == '' || !is_file($timeIngFile)) {
			$timeIngFile = dirname(__FILE__).'/config_time_ing.php';
		}
		if (!is_file($timeIngFile)) {
			return $now;
		}
		$timeIngRaw = @file_get_contents($timeIngFile);
		if ($timeIngRaw === false) {
			return $now;
		}
		$timeUseFixed = (strpos($timeIngRaw, "use'] = true") !== false || strpos($timeIngRaw, 'use"] = true') !== false);
		$fixedIng = 0;
		if (preg_match('/ing\'\]\s*=\s*"([0-9]{9,})"/', $timeIngRaw, $timeIngMatch)) {
			$fixedIng = (int)$timeIngMatch[1];
		} else if (preg_match('/ing"\]\s*=\s*"([0-9]{9,})"/', $timeIngRaw, $timeIngMatch)) {
			$fixedIng = (int)$timeIngMatch[1];
		}
		if ($timeUseFixed && $fixedIng > 0) {
			return $fixedIng;
		}
		return $now;
	}

	/**
	 * 해당 일차의 세션 인정 시작~마지막 종료
	 */
	function getEventDayRange($evDate) {
		global $_TIME;
		$evDate = (int)$evDate;
		if (!isset($_TIME['session'][$evDate]) || !is_array($_TIME['session'][$evDate])) {
			return null;
		}
		$start = 0;
		$end = 0;
		foreach ($_TIME['session'][$evDate] as $s => $sess) {
			if (!isset($sess[0]) || !isset($sess[1])) {
				continue;
			}
			$sTs = strtotime($sess[0]);
			$eTs = strtotime($sess[1]);
			if ($sTs < 1 || $eTs < 1) {
				continue;
			}
			if ($start < 1 || $sTs < $start) {
				$start = $sTs;
			}
			if ($eTs > $end) {
				$end = $eTs;
			}
		}
		if ($start < 1 || $end < 1) {
			return null;
		}
		return array('start' => $start, 'end' => $end);
	}

	/**
	 * 시각을 해당 일차 인정시간 범위로 자른다 (분 단위)
	 * - start 이전이면 start
	 * - end 이후이면 end
	 */
	function clampToEventDayRange($ts, $evDate) {
		$ts = (int)$ts;
		if ($ts < 1) {
			return 0;
		}
		// 분 단위로 맞춘다(초 단위 X)
		$ts = $ts - ($ts % 60);
		$range = getEventDayRange($evDate);
		if (!$range) {
			return $ts;
		}
		if ($ts < $range['start']) {
			return (int)$range['start'];
		}
		if ($ts > $range['end']) {
			return (int)$range['end'];
		}
		return $ts;
	}

	/**
	 * 출결 컬럼 목록(최초 / 최종 시간 컬럼)
	 */
	function getDayTimeColumns($evDate) {
		global $_TIME;
		$evDate = (int)$evDate;
		$cols = array('first_date', 'last_date');
		if (!isset($_TIME['session'][$evDate]) || !is_array($_TIME['session'][$evDate])) {
			return $cols;
		}
		foreach ($_TIME['session'][$evDate] as $s => $sess) {
			$s = (int)$s;
			if ($s < 1) {
				continue;
			}
			$cols[] = 's'.$s.'_sdate';
			$cols[] = 's'.$s.'_edate';
		}
		return $cols;
	}

	/**
	 * 하루 최초/최종 시각
	 * - 최초 = first_date 와 세션 In/Out 중 가장 빠른 시각
	 * - 최종 = last_date 와 세션 In/Out 중 가장 늦은 시각 (퇴장 QR 이 없으면 마지막으로 찍은 시각)
	 * - 기록이 없으면 최초는 매우 큰 값, 최종은 0 : 체류분이 0 으로 계산된다
	 * - 분 단위로 맞춘다(초 단위 X)
	 */
	function getDayBoundTimeSql($evDate, $kind) {
		$isFirst = ($kind == 'first');
		$noneValue = $isFirst ? '9999999999' : '0';
		$items = array();
		foreach (getDayTimeColumns($evDate) as $col) {
			$num = '(ifnull('.$col.',0)+0)';
			$items[] = 'if('.$num.'>0,'.$num.','.$noneValue.')';
		}
		$func = $isFirst ? 'least' : 'greatest';
		return 'floor('.$func.'('.implode(',', $items).')/60)*60';
	}

	/**
	 * 최초~최종 구간의 인정 세션 체류분
	 * - 세션별 In/Out 계산이 아니라 하루 최초와 최종 시각으로 계산한다
	 * - 최초~최종 과 세션 인정구간이 겹치는 부분만 합산하므로 휴식·점심은 자동 제외
	 * - 최초가 세션 시작보다 이르면 세션 시작부터, 최종이 세션 종료보다 늦으면 세션 종료까지
	 */
	function getSessionStayTimeSql($evDate) {
		global $_TIME;
		$evDate = (int)$evDate;
		if (!isset($_TIME['session'][$evDate]) || !is_array($_TIME['session'][$evDate])) {
			return '0 as total_time';
		}
		$firstSql = getDayBoundTimeSql($evDate, 'first');
		$lastSql = getDayBoundTimeSql($evDate, 'last');
		$parts = array();
		foreach ($_TIME['session'][$evDate] as $s => $sess) {
			$s = (int)$s;
			if ($s < 1 || !isset($sess[0]) || !isset($sess[1])) {
				continue;
			}
			$sessionStart = strtotime($sess[0]);
			$sessionEnd = strtotime($sess[1]);
			if ($sessionStart < 1 || $sessionEnd < 1) {
				continue;
			}
			$parts[] = 'floor(greatest(0, least('.$lastSql.','.$sessionEnd.')-greatest('.$firstSql.','.$sessionStart.'))/60)';
		}
		if (count($parts) < 1) {
			return '0 as total_time';
		}
		return 'cast('.implode('+', $parts).' as signed) as total_time';
	}

	/**
	 * 출결 1row 의 하루 최초/최종 시각 (getDayBoundTimeSql 과 같은 규칙)
	 */
	function getDayFirstLastTime($evDate, $row) {
		if (!is_array($row)) {
			return null;
		}
		$first = 0;
		$last = 0;
		foreach (getDayTimeColumns($evDate) as $col) {
			$ts = isset($row[$col]) ? (int)$row[$col] : 0;
			if ($ts < 1) {
				continue;
			}
			// 초를 버려 분 단위로 맞춘다
			$ts = $ts - ($ts % 60);
			if ($first < 1 || $ts < $first) {
				$first = $ts;
			}
			if ($ts > $last) {
				$last = $ts;
			}
		}
		if ($first < 1) {
			return null;
		}
		return array('first' => $first, 'last' => $last);
	}

	/**
	 * 최초~최종 구간의 인정 세션 체류분 (getSessionStayTimeSql 과 같은 규칙)
	 */
	function getSessionStayMinutes($evDate, $row) {
		global $_TIME;
		$evDate = (int)$evDate;
		if (!isset($_TIME['session'][$evDate]) || !is_array($_TIME['session'][$evDate])) {
			return 0;
		}
		$span = getDayFirstLastTime($evDate, $row);
		if (!$span) {
			return 0;
		}
		$total = 0;
		foreach ($_TIME['session'][$evDate] as $s => $sess) {
			$s = (int)$s;
			if ($s < 1 || !isset($sess[0]) || !isset($sess[1])) {
				continue;
			}
			$sessionStart = strtotime($sess[0]);
			$sessionEnd = strtotime($sess[1]);
			$in = ($span['first'] > $sessionStart) ? $span['first'] : $sessionStart;
			$out = ($span['last'] < $sessionEnd) ? $span['last'] : $sessionEnd;
			if ($out > $in) {
				$total += (int)(($out - $in) / 60);
			}
		}
		return $total;
	}

	/**
	 * 체류시간 >> 화면용 시:분 / 평점 (1시간 미만 0점, 상한 score_max_hour)
	 */
	function getSessionStayScore($totalMin, $scoreMaxHour) {
		// DB 는 문자열로 넘겨주므로 정수로 고정. 음수/소수는 버림.
		$totalMin = (int)$totalMin;
		$scoreMaxHour = (int)$scoreMaxHour;
		$result = array(
			'stay_hours' => '',
			'stay_min' => '',
			'score' => 0
		);
		if ($totalMin < 1) {
			return $result;
		}
		$hours = (int)($totalMin / 60);
		$mins = $totalMin % 60;
		$result['stay_hours'] = sprintf('%02d', $hours);
		$result['stay_min'] = sprintf('%02d', $mins);
		$result['score'] = ($hours > $scoreMaxHour) ? $scoreMaxHour : $hours;
		return $result;
	}
?>
