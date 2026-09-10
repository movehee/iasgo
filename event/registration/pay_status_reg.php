<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	$sid = isset($_POST['sid']) ? (int)$_POST['sid'] : 0;
	$chkval = isset($_POST['chkval']) ? trim($_POST['chkval']) : '';

	if ($sid < 1) {
		echo 'N';
		exit;
	}
	if ($chkval != '' && !isset($_REG['pay_status_txt'][$chkval])) {
		echo 'N';
		exit;
	}

	$oldRow = regLogSnapshot($sid, array('pay_status', 'pay_date'));
	$payDate = date('Y-m-d H:i:s');
	$query = "UPDATE registration_tbl SET pay_status=?, pay_date=? WHERE sid=?";
	$result = $conn->query($query, array($chkval, $payDate, $sid));
	if (DB::isError($result)) {
		error_log('[Admin] pay_status_reg error: '.$result->getMessage());
		echo 'N';
		exit;
	}

	$oldPayStatus = isset($oldRow['pay_status']) ? $oldRow['pay_status'] : '';
	$oldPayDate = isset($oldRow['pay_date']) ? $oldRow['pay_date'] : '';
	regLogWrite($sid, 'update', 'pay_status', array(
		'pay_status' => array($oldPayStatus, $chkval),
		'pay_date' => array($oldPayDate, $payDate)
	));

	echo 'Y';
?>
