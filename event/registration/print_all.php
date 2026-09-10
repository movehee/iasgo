<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/script/phpqrcode/qrlib.php';
	procAdminLoginChk();

	function printBadgeText($val) {
		return htmlspecialchars(stripslashes($val), ENT_QUOTES, 'UTF-8');
	}

	function printBadgeBuildQr($qrDir, $rowSid) {
		$qrCode = $rowSid.'A';
		$qrFile = $qrDir.$qrCode.'.png';
		QRcode::png($qrCode, $qrFile, 'L', 4, 2);
		return array(
			'qr_code' => $qrCode,
			'qr_src' => '/upload/qr/'.$qrCode.'.png'
		);
	}

	$qrDir = $_SERVER['DOCUMENT_ROOT'].'/upload/qr/';
	if (!is_dir($qrDir)) {
		@mkdir($qrDir, 0777);
	}

	$badgeList = array();

	$chkNum = isset($_REQUEST['chk_num']) ? $_REQUEST['chk_num'] : array();
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
	if (!$sidList) {
		PutMessageBack('선택된 데이터가 없습니다.');
	}

	$allowBadgeReprint = (isset($_MASTER['badge_reprint']) && $_MASTER['badge_reprint'] == 'Y');
	$isSuperPrint = isSuperAdminLogined();
	$printSkipCount = 0;

	$placeholders = implode(',', array_fill(0, count($sidList), '?'));
	$query = 'SELECT * FROM registration_tbl WHERE sid IN ('.$placeholders.') ORDER BY FIELD(sid, '.$placeholders.')';
	$params = array_merge($sidList, $sidList);
	$resultInfo = $conn->query($query, $params);
	if (DB::isError($resultInfo)) {
		error_log('[Print] select failed: '.$resultInfo->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	$printTime = getFixedNowTime();
	while (is_array($d = $resultInfo->fetchRow(DB_FETCHMODE_ASSOC))) {
		$rowSid = (int)$d['sid'];
		// 중복인쇄 차단: 허용 off + 최고관리자 아님 + 이미 인쇄됨
		if (!$allowBadgeReprint && !$isSuperPrint && isset($d['print_date']) && (int)$d['print_date'] > 0) {
			$printSkipCount++;
			continue;
		}
		$upd = $conn->query(
			'UPDATE registration_tbl SET print_date = ? WHERE sid = ?',
			array($printTime, $rowSid)
		);
		if (DB::isError($upd)) {
			error_log('[Print] update print_date failed: sid='.$rowSid.' '.$upd->getMessage());
			PutMessageBack('시스템 장애입니다.다시시도해주세요');
		}

		$tagName = $d['name_eng'] ? $d['name_eng'] : $d['name_kr'];
		if ($d['aff_eng']) {
			$aff = $d['aff_eng'];
		} else if ($d['etc_field6']) {
			$aff = $d['etc_field6'];
		} else {
			$aff = $d['aff_kor'];
		}

		$countryName = $d['etc_field1'];
		if ($countryName == 'Korea, Republic of' || $d['country'] == 'K') {
			$countryName = 'Korea';
		}

		$isDomestic = ($d['country'] == 'K');
		$qrInfo = printBadgeBuildQr($qrDir, $rowSid);

		$badgeList[] = array(
			'sid' => $rowSid,
			'qr_code' => $qrInfo['qr_code'],
			'qr_src' => $qrInfo['qr_src'],
			'name_kr' => $d['name_kr'],
			'tag_name' => $tagName,
			'aff' => $aff,
			'country_name' => $countryName,
			'price_txt' => $isDomestic ? 'KRW' : 'USD',
			'price' => (int)$d['reg_fee'],
			'name_long' => (strlen($tagName) > 18),
			'lunch' => isset($d['lunch']) ? $d['lunch'] : '',
			'banquet' => isset($d['banquet']) ? $d['banquet'] : ''
		);
	}
	if (!$badgeList) {
		if ($printSkipCount > 0) {
			PutMessageBack('이미 인쇄된 명찰입니다. 중복인쇄가 차단되어 있습니다.');
		}
		PutMessageBack('선택된 데이터가 없습니다.');
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>관리자 | <?=printBadgeText($_CONFIG['Name'])?></title>
<script type="text/javascript" src="/script/jquery.js"></script>
<script type="text/javascript" src="/script/textfill/jquery.textfill.js"></script>
<style>
	@media print {
		@page {
			size: 210mm 297mm;
			margin: 0;
		}
		html, body {
			border: 0;
			margin: 0;
			padding: 0;
		}
	}
	html, body {
		margin: 0;
		padding: 0;
	}
	.page-a4 {
		width: 210mm;
		height: 297mm;
		position: relative;
		overflow: hidden;
	}
	.page-a4 + .page-a4 {
		page-break-before: always;
	}
	.name-kr {
		position: absolute;
		top: 40mm;
		left: 62mm;
		font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
		font-size: 10pt;
		text-align: right;
		width: 35mm;
	}
	.name-en {
		position: absolute;
		top: 60mm;
		left: 10mm;
		width: 85mm;
		height: 14mm;
		font-family: 'Calibri';
		font-size: 30pt;
		font-weight: bold;
		text-align: center;
		overflow: hidden;
		line-height: 1.15;
	}
	.name-en.is-long {
		top: 48mm !important;
		height: 26mm;
	}
	.office-e {
		position: absolute;
		top: 75mm;
		left: 10mm;
		width: 85mm;
		height: 14mm;
		font-family: 'Calibri';
		font-size: 14pt;
		text-align: center;
		overflow: hidden;
		display: flex;
		align-items: center;
		justify-content: center;
		line-height: 1.15;
	}
	.country {
		position: absolute;
		top: 90mm;
		left: 10mm;
		width: 85mm;
		font-family: 'Calibri';
		font-size: 14pt;
		font-weight: bold;
		text-align: center;
	}
	.qr-code {
		position: absolute;
		top: 100mm;
		left: 10mm;
		width: 85mm;
		height: 25mm;
		text-align: center;
	}
	.qr-code img {
		width: 70px;
		height: 70px;
	}
	.receipt-name {
		position: absolute;
		top: 50mm;
		left: 126mm;
		width: 80mm;
		font-family: 'Calibri';
		font-size: 20pt;
	}
	.receipt-office {
		position: absolute;
		top: 69mm;
		left: 129mm;
		width: 66mm;
		height: 2.4em;
		font-family: 'Calibri';
		font-size: 14pt;
		overflow: hidden;
		line-height: 1.2;
		white-space: normal;
		word-wrap: break-word;
		overflow-wrap: break-word;
	}
	.receipt-office.is-single {
		top: 72mm;
	}
	.receipt-office span {
		display: block;
		width: 100%;
		white-space: normal;
		line-height: 1.2;
	}
	.receipt-fee {
		position: absolute;
		top: 91mm;
		left: 137mm;
		font-family: 'Calibri';
		font-size: 14pt;
	}
	.coupon-lunch1 {
		position: absolute;
		top: 155mm;
		left: 98mm;
		font-size: 20pt;
		font-weight: bold;
	}
	.coupon-lunch2 {
		position: absolute;
		top: 185mm;
		left: 98mm;
		font-size: 20pt;
		font-weight: bold;
	}
	.coupon-lunch3 {
		position: absolute;
		top: 217mm;
		left: 98mm;
		font-size: 20pt;
		font-weight: bold;
	}
	.coupon-banquet {
		position: absolute;
		top: 135mm;
		left: 199mm;
		font-size: 20pt;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
	function getLineCount(el) {
		const style = window.getComputedStyle(el);
		const fontSize = parseFloat(style.fontSize);
		let lineHeight = parseFloat(style.lineHeight);
		if (!lineHeight || isNaN(lineHeight)) {
			lineHeight = fontSize * 1.2;
		}
		return Math.round(el.offsetHeight / lineHeight);
	}

	function fitBoxText(selector, maxPx, minPx, maxLines) {
		$(selector).each(function () {
			const box = this;
			const text = $(box).children('span').get(0);
			if (!text) {
				return;
			}
			let size = maxPx;
			text.style.fontSize = size + 'px';
			while (
				size > minPx
				&& (getLineCount(text) > maxLines || text.scrollWidth > box.clientWidth + 1)
			) {
				size -= 1;
				text.style.fontSize = size + 'px';
			}
			if (getLineCount(text) <= 1) {
				$(box).addClass('is-single');
			}
		});
	}

	$(function () {
		$('.name-en').textfill({
			maxFontPixels: 40,
			minFontPixels: 16
		});
		$('.office-e').textfill({
			maxFontPixels: 18,
			minFontPixels: 8
		});
		$('.receipt-name').textfill({
			maxFontPixels: 20,
			minFontPixels: 12,
			widthOnly: true
		});
		fitBoxText('.receipt-office', 18, 8, 2);
		const printSkipCount = <?= (int)$printSkipCount ?>;
		if (printSkipCount > 0) {
			alert('이미 인쇄된 ' + printSkipCount + '명은 중복인쇄 차단으로 제외되었습니다.');
		}
		setTimeout(function () {
			window.print();
		}, 1000);
	});
</script>
</head>
<body>
<?php foreach ($badgeList as $badge): ?>
	<div class="page-a4">
		<div class="name-kr"><?=printBadgeText($badge['name_kr'])?></div>
		<div class="name-en<?=$badge['name_long'] ? ' is-long' : ''?>">
			<span><?=printBadgeText($badge['tag_name'])?></span>
		</div>
		<div class="office-e">
			<span><?=printBadgeText($badge['aff'])?></span>
		</div>
		<div class="country"><?=printBadgeText($badge['country_name'])?></div>
		<div class="qr-code">
			<img src="<?=printBadgeText($badge['qr_src'])?>" alt="QR" width="70" height="70">
		</div>
		<div class="receipt-name">
			<span><?=printBadgeText($badge['tag_name'])?></span>
		</div>
		<div class="receipt-office">
			<span><?=printBadgeText($badge['aff'])?></span>
		</div>
		<div class="receipt-fee">
			<?=printBadgeText($badge['price_txt'])?> <?=number_format($badge['price'])?>
		</div>
		<?php if (strpos($badge['lunch'], 'W') !== false): ?>
			<div class="coupon-lunch1">O</div>
		<?php endif; ?>
		<?php if (strpos($badge['lunch'], 'T') !== false): ?>
			<div class="coupon-lunch2">O</div>
		<?php endif; ?>
		<?php if (strpos($badge['lunch'], 'F') !== false): ?>
			<div class="coupon-lunch3">O</div>
		<?php endif; ?>
		<?php if ($badge['banquet'] == 'Y'): ?>
			<div class="coupon-banquet">O</div>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
</body>
</html>
