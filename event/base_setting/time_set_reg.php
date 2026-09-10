<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	$setDay = isset($_POST['set_day']) ? trim($_POST['set_day']) : '';
	$setTime = isset($_POST['set_time']) ? trim($_POST['set_time']) : '';
	$timeSetUse = (isset($_POST['time_set_use']) && $_POST['time_set_use'] == 'Y') ? 'Y' : 'N';

	if ($timeSetUse == 'Y') {
		if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $setDay)) {
			PutMessageBack('일자 형식이 올바르지 않습니다.');
		}
		if (!preg_match('/^([01][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $setTime)) {
			PutMessageBack('시간 형식이 올바르지 않습니다.');
		}
	}

	$content = "<?\n";
	if ($timeSetUse == 'Y') {
		$content .= "\$_Time['use'] = true;\n";
		$setUnix = strtotime($setDay.' '.$setTime);
		if ($setUnix < 1) {
			PutMessageBack('시간 형식이 올바르지 않습니다.');
		}
		$content .= "\$_Time['ing'] = \"".$setUnix."\";\n";
	} else {
		$content .= "\$_Time['use'] = false;\n";
		$content .= "\$_Time['ing'] = time();\n";
	}

	$content .= "if(\$_COOKIE['wmember_level']!='M' && \$d['member_level']!='M'){\n";
	$content .= "\$_Time['ing'] = time();\n";
	$content .= "}\n";
	$content .= "?>";

	$paths = array(
		$_SERVER['DOCUMENT_ROOT'].'/../webinar/func/config_time_ing.php',
		$_SERVER['DOCUMENT_ROOT'].'/../mobile/func/config_time_ing.php',
		$_SERVER['DOCUMENT_ROOT'].'/func/config_time_ing.php'
	);

	$writeOk = false;
	foreach ($paths as $onePath) {
		$dirName = dirname($onePath);
		if (!is_dir($dirName)) {
			continue;
		}
		$fp = @fopen($onePath, 'w');
		if (!$fp) {
			error_log('[TimeSet] open failed: '.$onePath);
			continue;
		}
		fwrite($fp, $content);
		fclose($fp);
		$writeOk = true;
	}
	if (!$writeOk) {
		error_log('[TimeSet] all writes failed');
		PutMessageBack('시간설정 저장에 실패했습니다.');
	}

	$returnUrl = isset($_POST['return_url']) ? trim($_POST['return_url']) : '';
	$allowedReturn = array(
		'/master/' => true,
		'/master/index.php' => true,
		'/?kind=time' => true
	);
	if ($returnUrl == '' || !isset($allowedReturn[$returnUrl])) {
		$returnUrl = '/?kind=time';
	}
?>
<script>location.href="<?=htmlspecialchars($returnUrl, ENT_QUOTES, 'UTF-8')?>";</script>
