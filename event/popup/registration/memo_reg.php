<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();

	$sid = isset($_POST['sid']) ? (int)$_POST['sid'] : (isset($sid) ? (int)$sid : 0);
	$memo = isset($_POST['memo']) ? $_POST['memo'] : (isset($memo) ? $memo : '');

	if ($sid < 1) {
		PutMessageBack('잘못된 요청입니다.');
	}

	$oldRow = regLogSnapshot($sid, array('memo'));
	$query = 'UPDATE registration_tbl SET memo = ? WHERE sid = ?';
	$result = $conn->query($query, array($memo, $sid));
	if (DB::isError($result)) {
		error_log('[Admin] memo_reg error: '.$result->getMessage());
		die($result->getMessage());
	}

	$oldMemo = isset($oldRow['memo']) ? $oldRow['memo'] : '';
	regLogWrite($sid, 'update', 'memo', array(
		'memo' => array($oldMemo, $memo)
	));

	$conn->disconnect();
	PutMessageCloseOpenerReload("저장되었습니다.");
?>
