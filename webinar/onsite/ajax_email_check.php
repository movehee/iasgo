<?php
	/**
	 * E-mail 중복체크 (JSON)
	 */
	@error_reporting(E_ALL ^ E_NOTICE);

	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/include.connect.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/include.connect.php';
	}

	header('Content-Type: application/json; charset=UTF-8');

	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$email = preg_replace('/\s+/', '', $email);

	$result = array(
		'ok' => false,
		'dup' => false,
		'msg' => ''
	);

	if ($email == '') {
		$result['msg'] = 'empty';
		echo json_encode($result);
		exit;
	}

	if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email)) {
		$result['msg'] = 'invalid';
		echo json_encode($result);
		exit;
	}

	if (!isset($conn) || !$conn) {
		$result['msg'] = 'error';
		echo json_encode($result);
		exit;
	}

	$dupCnt = $conn->getOne(
		'SELECT COUNT(*) FROM registration_tbl WHERE del = ? AND (id = ? OR email = ?)',
		array('N', $email, $email)
	);
	if (DB::isError($dupCnt)) {
		error_log('[Onsite] email check error: ' . $dupCnt->getMessage());
		$result['msg'] = 'error';
		echo json_encode($result);
		exit;
	}

	$result['ok'] = true;
	$result['dup'] = ((int)$dupCnt > 0);
	$result['msg'] = $result['dup'] ? 'dup' : 'ok';
	echo json_encode($result);
	exit;
?>
