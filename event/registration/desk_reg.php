<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	$sid = isset($_POST['sid']) ? (int)$_POST['sid'] : 0;
	$chkval = isset($_POST['chkval']) ? trim($_POST['chkval']) : '';

	if ($sid < 1) {
		echo 'N';
		exit;
	}

	// DESK 1~3만 허용, 빈값(선택)도 허용
	if ($chkval != '' && !isset($_REG['desk'][$chkval])) {
		echo 'N';
		exit;
	}

	$oldRow = regLogSnapshot($sid, array('etc_field7'));
	$query = "UPDATE registration_tbl SET etc_field7=? WHERE sid=?";
	$result = $conn->query($query, array($chkval, $sid));
	if (DB::isError($result)) {
		error_log('[Admin] desk_reg error: '.$result->getMessage());
		echo 'N';
		exit;
	}

	$oldDesk = isset($oldRow['etc_field7']) ? $oldRow['etc_field7'] : '';
	regLogWrite($sid, 'update', 'desk', array(
		'etc_field7' => array($oldDesk, $chkval)
	));

	echo 'Y';
?>
