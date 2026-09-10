<?php
	/**
	 * 현장등록 전용 초기화
	 * - lib.php의 모바일 e-poster 리다이렉트를 쓰지 않음
	 * - 모바일은 허용, Microsoft Edge만 차단
	 */
	header('Content-Type: text/html; charset=UTF-8');
	@error_reporting(E_ALL ^ E_NOTICE);

	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/include.function.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/include.function.php';
	}
	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/include.connect.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/include.connect.php';
	}
	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/config.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/config.php';
	}
	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/config/flag.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/config/flag.php';
	}
	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/func/config/onsite.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'] . '/func/config/onsite.php';
	}

	if (!isset($pageType) || ($pageType != 'intro' && $pageType != 'sub')) {
		$pageType = 'sub';
	}

	$_CONFIG['Name'] = 'IASGO 2026';

	$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	$isEdge = (stripos($userAgent, 'Edg/') !== false || stripos($userAgent, 'Edge/') !== false);
	if ($isEdge) {
		PutMessageMain('엣지 브라우저로는 접속할 수 없습니다. Chrome 등 브라우저로 접속해 주세요.');
	}
?>
