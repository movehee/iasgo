<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	procAdminLoginChk();

	$evDateRaw = isset($_REQUEST['ev_date']) ? $_REQUEST['ev_date'] : '';
	if ($evDateRaw == 'all' || $evDateRaw == '0') {
		$ev_date = 0;
	} else {
		$ev_date = (int)$evDateRaw;
		if ($ev_date < 1 || !isset($_TIME['session'][$ev_date])) {
			$ev_date = 1;
		}
	}

	include $_SERVER['DOCUMENT_ROOT'].'/registration/include.attendance_search.php';

	$listQuery = $listSelect.' ORDER BY t1.first_date DESC, t1.usid DESC';
	$listResult = $listParams ? $conn->query($listQuery, $listParams) : $conn->query($listQuery);
	if (DB::isError($listResult)) {
		error_log('[AttendanceExcel] list failed: '.$listResult->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	$ex_sdate = explode('-', $_Webinar['sdate']);

	header('Content-Type: application/vnd.ms-excel; charset=utf-8');
	header('Content-Disposition: attachment; filename=attendance_'.date('YmdHis').'.xls');
	header('Content-Description: PHP Generated Data');
?>
<style>
td{mso-number-format:\@;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1">
	<tr>
		<th>No</th>
		<th>행사일</th>
		<th>sid</th>
		<th>등록구분</th>
		<th>ID</th>
		<th>성명</th>
		<th>성명(영문)</th>
		<th>면허번호</th>
		<th>카테고리</th>
		<th>소속</th>
		<th>소속(영문)</th>
		<th>최초입장</th>
		<?php for ($i = 1; $i <= $sessionCount; $i++): ?>
			<th>S<?=$i?>입장</th>
			<th>S<?=$i?>퇴장</th>
		<?php endfor; ?>
		<th>최종퇴장</th>
	</tr>
	<?php
		$n = 1;
		while (is_array($d = $listResult->fetchRow(DB_FETCHMODE_ASSOC))):
			$feeLabel = $d['title'];
			$isDomestic = ($d['country'] == 'K');
			$isOverseas = ($d['country'] == 'F');
			if ($isDomestic && isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if ($isOverseas && isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_kor'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_kor'][$d['title']]['title'];
			} else if (isset($_ONSITE['fee_eng'][$d['title']]['title'])) {
				$feeLabel = $_ONSITE['fee_eng'][$d['title']]['title'];
			}
			$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : $d['classification'];
			$eventDay = date('m.d', mktime(0, 0, 0, $ex_sdate[1], $ex_sdate[2] + ($d['day'] - 1), $ex_sdate[0]));
	?>
		<tr>
			<td><?=(int)$n?></td>
			<td><?=$eventDay?></td>
			<td><?=(int)$d['usid']?></td>
			<td><?=$classLabel?></td>
			<td><?=$d['id']?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['name_eng']?></td>
			<td><?=$d['license_number']?></td>
			<td><?=$feeLabel?></td>
			<td><?=$d['aff_kor']?></td>
			<td><?=$d['aff_eng']?></td>
			<td><?=$d['first_date'] > 0 ? date('H:i', (int)$d['first_date']) : ''?></td>
			<?php 
				for ($s = 1; $s <= $sessionCount; $s++):
					$sc = 's'.$s.'_sdate';
					$ec = 's'.$s.'_edate';
			?>
				<td><?=(isset($d[$sc]) && $d[$sc] > 0) ? date('H:i', (int)$d[$sc]) : ''?></td>
				<td><?=(isset($d[$ec]) && $d[$ec] > 0) ? date('H:i', (int)$d[$ec]) : ''?></td>
			<?php endfor; ?>
			<td><?=$d['last_date'] > 0 ? date('H:i', (int)$d['last_date']) : ''?></td>
		</tr>
	<?php
			$n++;
		endwhile;
	?>
</table>
