<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	if (!isSuperAdminLogined()) {
		PutMessageBack('최고관리자만 이용가능한 페이지 입니다.');
	}

	$chkNum = isset($_POST['chk_num']) ? $_POST['chk_num'] : array();
	if (!is_array($chkNum)) {
		$chkNum = array($chkNum);
	}

	$sidList = array();
	foreach ($chkNum as $oneSid) {
		$oneSid = (int)$oneSid;
		if ($oneSid > 0) {
			$sidList[] = $oneSid;
		}
	}
	$sidList = array_values(array_unique($sidList));
	if (!$sidList) {
		PutMessageBack('선택된 데이터가 없습니다.');
	}

	$placeholders = implode(',', array_fill(0, count($sidList), '?'));
	$upd = $conn->query(
		'UPDATE registration_tbl SET print_date = 0 WHERE sid IN ('.$placeholders.') AND del = ?',
		array_merge($sidList, array('N'))
	);
	if (DB::isError($upd)) {
		error_log('[Master] print_reset failed: '.$upd->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	$actorSid = isset($_COOKIE['wmember_sid']) ? (int)$_COOKIE['wmember_sid'] : 0;
	error_log('[Master] print_reset: sids='.implode(',', $sidList).' by='.$actorSid);

	PutMessageLocation('선택한 인원의 인쇄기록을 초기화했습니다. (출결 유지)', '/master/');
?>
