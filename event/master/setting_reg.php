<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	if (!isSuperAdminLogined()) {
		PutMessageBack('최고관리자만 이용가능한 페이지 입니다.');
	}

	$badgeReprint = (isset($_POST['badge_reprint']) && $_POST['badge_reprint'] == 'Y') ? 'Y' : 'N';
	$attendanceMenu = (isset($_POST['attendance_menu']) && $_POST['attendance_menu'] == 'Y') ? 'Y' : 'N';
	$tagCheckin = (isset($_POST['tag_checkin']) && $_POST['tag_checkin'] == 'Y') ? 'Y' : 'N';
	$timeClamp = (isset($_POST['time_clamp']) && $_POST['time_clamp'] == 'Y') ? 'Y' : 'N';

	$content = "<?php\n";
	$content .= "\t\$_MASTER['badge_reprint'] = '".$badgeReprint."';\n";
	$content .= "\t\$_MASTER['attendance_menu'] = '".$attendanceMenu."';\n";
	$content .= "\t\$_MASTER['tag_checkin'] = '".$tagCheckin."';\n";
	$content .= "\t\$_MASTER['time_clamp'] = '".$timeClamp."';\n";
	$content .= "?>\n";

	$masterFile = $_SERVER['DOCUMENT_ROOT'].'/func/config_master.php';
	$written = @file_put_contents($masterFile, $content);
	if ($written === false) {
		error_log('[Master] config_master write failed: '.$masterFile.' perms='.@substr(sprintf('%o', @fileperms($masterFile)), -4));
		PutMessageBack('설정 저장에 실패했습니다. 파일 권한을 확인해 주세요.');
	}
	@chmod($masterFile, 0777);

	$actorSid = isset($_COOKIE['wmember_sid']) ? (int)$_COOKIE['wmember_sid'] : 0;
	error_log(
		'[Master] setting saved: badge_reprint='.$badgeReprint
		.' attendance_menu='.$attendanceMenu
		.' tag_checkin='.$tagCheckin
		.' time_clamp='.$timeClamp
		.' by='.$actorSid
	);

	PutMessageLocation('설정이 저장되었습니다.', '/master/');
?>
