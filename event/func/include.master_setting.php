<?php
	/**
	 * 최고관리자 기능 스위치 (단일 기준)
	 * - 데이터: dirname(__FILE__).'/config_master.php'
	 * - event/webinar 모두 이 로더를 통해 같은 값 참조
	 */
	if (!isset($_MASTER) || !is_array($_MASTER)) {
		$_MASTER = array(
			'badge_reprint' => 'N',
			'attendance_menu' => 'N',
			'tag_checkin' => 'Y',
			'time_clamp' => 'N'
		);
		$masterCfgFile = dirname(__FILE__).'/config_master.php';
		if (is_file($masterCfgFile)) {
			include $masterCfgFile;
		}
		if (!isset($_MASTER['badge_reprint']) || ($_MASTER['badge_reprint'] != 'Y' && $_MASTER['badge_reprint'] != 'N')) {
			$_MASTER['badge_reprint'] = 'N';
		}
		if (!isset($_MASTER['attendance_menu']) || ($_MASTER['attendance_menu'] != 'Y' && $_MASTER['attendance_menu'] != 'N')) {
			$_MASTER['attendance_menu'] = 'N';
		}
		if (!isset($_MASTER['tag_checkin']) || ($_MASTER['tag_checkin'] != 'Y' && $_MASTER['tag_checkin'] != 'N')) {
			$_MASTER['tag_checkin'] = 'Y';
		}
		if (!isset($_MASTER['time_clamp']) || ($_MASTER['time_clamp'] != 'Y' && $_MASTER['time_clamp'] != 'N')) {
			$_MASTER['time_clamp'] = 'N';
		}
	}
?>
