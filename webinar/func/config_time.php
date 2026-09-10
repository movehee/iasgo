<?php
	// event/func/config_time.php 만 수정하면 됨
	$eventConfigTime = dirname(rtrim($_SERVER['DOCUMENT_ROOT'], '/\\')).'/event/func/config_time.php';
	if (!is_file($eventConfigTime)) {
		error_log('[config_time] missing: '.$eventConfigTime);
	} else {
		include_once $eventConfigTime;
	}
?>
