<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';

	$usid = isset($_POST['usid']) ? (int)$_POST['usid'] : 0;
	$day = isset($_POST['day']) ? (int)$_POST['day'] : 0;
	$groupKey = isset($_POST['group_key']) ? trim($_POST['group_key']) : '';
	$room = isset($_POST['room']) ? (int)$_POST['room'] : 0;
	$session = isset($_POST['session']) ? (int)$_POST['session'] : 0;
	$inout = isset($_POST['inout']) ? trim($_POST['inout']) : '';
	$tagTime = isset($_POST['tag_time']) ? (int)$_POST['tag_time'] : 0;

	if ($room < 1 || $room > 99) {
		if (isset($_COOKIE['tag_room'])) {
			$room = (int)$_COOKIE['tag_room'];
		}
	}
	if ($room < 1 || $room > 99) {
		$room = 1;
	}
	$indexUrl = 'index.php?room='.$room;

	if ($usid < 1 || $day < 1) {
		PutMessageLocation('정상적인 접근이 아닙니다.', $indexUrl);
		exit;
	}

	$checkinTbl = 'checkin_tbl';
	$sCol = 's'.$session.'_sdate';
	$eCol = 's'.$session.'_edate';

	$query = 'SELECT t1.*, t2.name_kr, t2.name_eng, t2.aff_kor, t2.aff_eng, t2.country, t2.license_number'
		.' FROM '.$checkinTbl.' AS t1'
		.' INNER JOIN registration_tbl AS t2 ON t1.usid = t2.sid'
		.' WHERE t1.usid = ? AND t1.day = ?';
	$result = $conn->query($query, array($usid, $day));
	if (DB::isError($result)) {
		error_log('[TagResult] select failed: '.$result->getMessage());
		PutMessageLocation('시스템 장애입니다.다시시도해주세요', $indexUrl);
		exit;
	}
	$d = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$result->free();

	if (!$d || !(int)$d['usid']) {
		PutMessageLocation('출결 정보를 찾을 수 없습니다.', $indexUrl);
		exit;
	}

	$tagName = $d['name_eng'];
	$tagAff = $d['aff_eng'];
	if ($d['country'] == 'K') {
		if (trim($d['name_kr']) != '') {
			$tagName = $d['name_kr'];
		}
		if (trim($d['aff_kor']) != '') {
			$tagAff = $d['aff_kor'];
		}
	}

	$entryTime = 0;
	$exitTime = 0;
	if ($session > 0) {
		if (isset($d[$sCol]) && $d[$sCol] > 0) {
			$entryTime = (int)$d[$sCol];
		}
		if (isset($d[$eCol]) && $d[$eCol] > 0) {
			$exitTime = (int)$d[$eCol];
		}
	}
	if ($inout == 'In' && $tagTime > 0) {
		$entryTime = $tagTime;
	}
	if ($inout == 'Out' && $tagTime > 0) {
		$exitTime = $tagTime;
	}

	$stayTimes = '';
	if ($entryTime > 0 && $exitTime > 0 && $exitTime >= $entryTime) {
		$someTime = $exitTime - $entryTime;
		$hh = sprintf('%02d', floor($someTime / 3600));
		$mm = sprintf('%02d', floor(($someTime % 3600) / 60));
		$ss = sprintf('%02d', $someTime % 60);
		$stayTimes = $hh.':'.$mm.':'.$ss;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IASGO 2026</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/flatly/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="./countdown/dist/css/autorefresher.min.css">
<style>
body { overflow: hidden; height: 100vh; background: #fafafa; }
h1 { margin-bottom: 50px; font-family: 'Quicksand'; }
.container { margin: 150px auto; }
</style>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	$('#tag_number').focus();
});
//]]>
</script>
</head>
<body onclick="$('#tag_number').focus();">
<div class="wrapper attendance">
	<div class="auto-refresher mt-auto mb-auto"></div>
	<div class="sub-visual">
		서브비쥬얼
	</div>
	<div class="contents">
		<div id="container">
			<div class="contents">
				<div class="table-wrap">
					<table class="cst-table type2">
						<caption class="hide">IASGO 2026 Attendance</caption>
						<colgroup>
							<col style="width: 40%;">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th>Name</th>
								<td><?=htmlspecialchars($tagName, ENT_QUOTES, 'UTF-8')?></td>
							</tr>
							<tr>
								<th>Affiliation</th>
								<td><?=htmlspecialchars($tagAff, ENT_QUOTES, 'UTF-8')?></td>
							</tr>
							<tr>
								<th>License Number</th>
								<td><?=htmlspecialchars($d['license_number'], ENT_QUOTES, 'UTF-8')?></td>
							</tr>
							<tr>
								<th>Session</th>
								<td>S<?=(int)$session?> / <?=$inout == 'Out' ? 'Exit' : 'Entry'?></td>
							</tr>
							<tr>
								<th>Entry Time</th>
								<td><?if ($entryTime > 0) {?><?=date('H : i', $entryTime)?><?}?></td>
							</tr>
							<?php if ($exitTime > 0) { ?>
							<tr>
								<th>Exit Time</th>
								<td><?=date('H : i', $exitTime)?></td>
							</tr>
							<tr>
								<th>Total Duration of Stay</th>
								<td><?=htmlspecialchars($stayTimes, ENT_QUOTES, 'UTF-8')?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div style="position:absolute;top:0px;z-index:-1;">
		<form id="tagF" name="tagF" action="tag_reg.php" method="post" autocomplete="off">
			<input type="hidden" name="room" value="<?=(int)$room?>">
			<input type="text" name="tag_number" id="tag_number" value="">
		</form>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="./countdown/dist/js/autorefresher.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.auto-refresher').autoRefresher({
			seconds: 3,
			callback: function () {
				location.href = '<?=$indexUrl?>';
			},
			progressBarHeight: '0px',
			showControls: false
		});
	});
</script>
</body>
</html>
