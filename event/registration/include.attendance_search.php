<?php
	/**
	 * 출결 검색 조건 (attendance.php / attendance_excel.php 공용)
	 */
	$id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
	$name_kr = isset($_REQUEST['name_kr']) ? trim($_REQUEST['name_kr']) : '';
	$name_eng = isset($_REQUEST['name_eng']) ? trim($_REQUEST['name_eng']) : '';
	$license_number = isset($_REQUEST['license_number']) ? trim($_REQUEST['license_number']) : '';
	$aff_kor = isset($_REQUEST['aff_kor']) ? trim($_REQUEST['aff_kor']) : '';
	$classification = isset($_REQUEST['classification']) ? trim($_REQUEST['classification']) : '';
	$title = isset($_REQUEST['title']) ? trim($_REQUEST['title']) : '';
	$usidKey = isset($_REQUEST['key']) ? (int)$_REQUEST['key'] : 0;

	$sessionCount = 0;
	if ($ev_date > 0 && isset($_TIME['session'][$ev_date]) && is_array($_TIME['session'][$ev_date])) {
		$sessionCount = count($_TIME['session'][$ev_date]);
	} else if ($ev_date < 1 && isset($_TIME['session']) && is_array($_TIME['session'])) {
		foreach ($_TIME['session'] as $sessions) {
			if (!is_array($sessions)) {
				continue;
			}
			$daySessionCount = count($sessions);
			if ($daySessionCount > $sessionCount) {
				$sessionCount = $daySessionCount;
			}
		}
	}

	$sessionCols = array();
	for ($s = 1; $s <= $sessionCount; $s++) {
		$sessionCols[] = 's'.$s.'_sdate';
		$sessionCols[] = 's'.$s.'_edate';
	}
	$sessionSelect = $sessionCols ? implode(',', $sessionCols).',' : '';

	$listWhere = '';
	$listParams = array();
	$detailWhere = '';
	$detailParams = array();
	if ($ev_date > 0) {
		$listWhere .= ' AND t1.day = ?';
		$listParams[] = $ev_date;
		$detailWhere .= ' AND d.day = ?';
		$detailParams[] = $ev_date;
	}

	if ($id != '') {
		$listWhere .= ' AND t2.id LIKE ?';
		$listParams[] = '%'.$id.'%';
		$detailWhere .= ' AND r.id LIKE ?';
		$detailParams[] = '%'.$id.'%';
	}
	if ($name_kr != '') {
		$listWhere .= ' AND t2.name_kr LIKE ?';
		$listParams[] = '%'.$name_kr.'%';
		$detailWhere .= ' AND r.name_kr LIKE ?';
		$detailParams[] = '%'.$name_kr.'%';
	}
	if ($name_eng != '') {
		$listWhere .= ' AND t2.name_eng LIKE ?';
		$listParams[] = '%'.$name_eng.'%';
		$detailWhere .= ' AND r.name_eng LIKE ?';
		$detailParams[] = '%'.$name_eng.'%';
	}
	if ($license_number != '') {
		$listWhere .= ' AND t2.license_number LIKE ?';
		$listParams[] = '%'.$license_number.'%';
		$detailWhere .= ' AND r.license_number LIKE ?';
		$detailParams[] = '%'.$license_number.'%';
	}
	if ($aff_kor != '') {
		$listWhere .= ' AND (t2.aff_kor LIKE ? OR t2.aff_eng LIKE ?)';
		$listParams[] = '%'.$aff_kor.'%';
		$listParams[] = '%'.$aff_kor.'%';
		$detailWhere .= ' AND (r.aff_kor LIKE ? OR r.aff_eng LIKE ?)';
		$detailParams[] = '%'.$aff_kor.'%';
		$detailParams[] = '%'.$aff_kor.'%';
	}
	if ($classification != '') {
		$listWhere .= ' AND t2.classification = ?';
		$listParams[] = $classification;
		$detailWhere .= ' AND r.classification = ?';
		$detailParams[] = $classification;
	}
	if ($title != '') {
		$listWhere .= ' AND t2.title = ?';
		$listParams[] = $title;
		$detailWhere .= ' AND r.title = ?';
		$detailParams[] = $title;
	}
	if ($usidKey > 0) {
		$listWhere .= ' AND t1.usid = ?';
		$listParams[] = $usidKey;
		$detailWhere .= ' AND d.usid = ?';
		$detailParams[] = $usidKey;
	}

	$search_keep = '';
	if ($id != '') $search_keep .= '&id='.rawurlencode($id);
	if ($name_kr != '') $search_keep .= '&name_kr='.rawurlencode($name_kr);
	if ($name_eng != '') $search_keep .= '&name_eng='.rawurlencode($name_eng);
	if ($license_number != '') $search_keep .= '&license_number='.rawurlencode($license_number);
	if ($aff_kor != '') $search_keep .= '&aff_kor='.rawurlencode($aff_kor);
	if ($classification != '') $search_keep .= '&classification='.rawurlencode($classification);
	if ($title != '') $search_keep .= '&title='.rawurlencode($title);
	if ($usidKey > 0) $search_keep .= '&key='.$usidKey;
	$evDateParam = $ev_date > 0 ? (int)$ev_date : 'all';
	$search_url = '&ev_date='.$evDateParam.$search_keep;

	$dayLabel = '전체';
	if ($ev_date > 0 && isset($_TIME['session'][$ev_date]['1'][0])) {
		$dayLabel = substr($_TIME['session'][$ev_date]['1'][0], 0, 10);
	} else if ($ev_date > 0) {
		$dayLabel = (int)$ev_date.'일차';
	}

	$listSelect = 'SELECT '.$sessionSelect
		.' t1.usid, t1.day, t1.first_date, t1.last_date, t2.group_key, t2.name_kr, t2.name_eng, t2.id, t2.aff_kor, t2.aff_eng, t2.country, t2.license_number, t2.classification, t2.title'
		.' FROM checkin_tbl AS t1'
		.' INNER JOIN registration_tbl AS t2 ON t1.usid = t2.sid'
		.' WHERE t2.del = \'N\''.$listWhere;
