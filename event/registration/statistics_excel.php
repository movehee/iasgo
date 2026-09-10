<?php
	if ($_SERVER['REMOTE_ADDR'] != '218.235.94.219') {
		header('Content-Type: text/html; charset=utf-8');
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=Registration_Statistics_'.date('YmdHis').'.xls');
		header('Content-Description: PHP4 Generated Data');
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();

	require_once $_SERVER['DOCUMENT_ROOT'].'/registration/include.statistics.php';

	$section = isset($_REQUEST['section']) ? trim($_REQUEST['section']) : 'all';
	$allowed = array('all', 'by_nation', 'by_attend', 'by_amount', 'by_group');
	if (!in_array($section, $allowed)) {
		$section = 'all';
	}

	$stats = getRegStatistics($conn);
	$showAll = ($section == 'all');
	$dl = isset($stats['day_labels']) ? $stats['day_labels'] : array('1' => 'Day1', '2' => 'Day2', '3' => 'Day3');
?>
<style>
td,th{mso-number-format:\@;}
</style>

<?php if ($showAll || $section == 'by_nation'): ?>
	<h3>1. 참여국가별 (입장 기록 있는 국가)</h3>
	<table border="1">
		<tr>
			<th>국가명</th>
			<th>Day1 (<?=$dl['1']?>)</th>
			<th>Day2 (<?=$dl['2']?>)</th>
			<th>Day3 (<?=$dl['3']?>)</th>
		</tr>
		<?php if (!empty($stats['by_nation']['rows'])): ?>
			<?php foreach ($stats['by_nation']['rows'] as $row): ?>
				<tr>
					<td><?=$row['nation']?></td>
					<td><?=$row['day1']?></td>
					<td><?=$row['day2']?></td>
					<td><?=$row['day3']?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<td>합계</td>
					<td><?=$stats['by_nation']['sum']['day1']?></td>
					<td><?=$stats['by_nation']['sum']['day2']?></td>
					<td><?=$stats['by_nation']['sum']['day3']?></td>
				</tr>
		<?php endif; ?>
	</table><br><br>
<?php endif; ?>

<?php if ($showAll || $section == 'by_attend'): ?>
	<h3>2. 입장통계 (국내 · 출결기준)</h3>
	<table border="1">
		<tr>
			<th rowspan="2">구분</th>
			<th colspan="2">Day1 (<?=$dl['1']?>)</th>
			<th colspan="2">Day2 (<?=$dl['2']?>)</th>
			<th colspan="2">Day3 (<?=$dl['3']?>)</th>
		</tr>
		<tr>
			<th>체크인</th><th>체크아웃</th>
			<th>체크인</th><th>체크아웃</th>
			<th>체크인</th><th>체크아웃</th>
		</tr>
		<?php if (!empty($stats['by_attend']['rows'])): ?>
			<?php foreach ($stats['by_attend']['rows'] as $row): ?>
				<tr>
					<td><?=$row['label']?></td>
					<td><?=$row['d1_in']?></td>
					<td><?=$row['d1_out']?></td>
					<td><?=$row['d2_in']?></td>
					<td><?=$row['d2_out']?></td>
					<td><?=$row['d3_in']?></td>
					<td><?=$row['d3_out']?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<td>합계</td>
					<td><?=$stats['by_attend']['sum']['d1_in']?></td>
					<td><?=$stats['by_attend']['sum']['d1_out']?></td>
					<td><?=$stats['by_attend']['sum']['d2_in']?></td>
					<td><?=$stats['by_attend']['sum']['d2_out']?></td>
					<td><?=$stats['by_attend']['sum']['d3_in']?></td>
					<td><?=$stats['by_attend']['sum']['d3_out']?></td>
				</tr>
		<?php endif; ?>
	</table><br><br>
<?php endif; ?>

<?php if ($showAll || $section == 'by_amount'): ?>
	<h3>3. 금액통계</h3>
	<table border="1">
		<tr>
			<th rowspan="2">구분</th>
			<th colspan="3">Day1 (<?=$dl['1']?>)</th>
			<th colspan="3">Day2 (<?=$dl['2']?>)</th>
			<th colspan="3">Day3 (<?=$dl['3']?>)</th>
		</tr>
		<tr>
			<th>카드</th><th>현금</th><th>계좌이체</th>
			<th>카드</th><th>현금</th><th>계좌이체</th>
			<th>카드</th><th>현금</th><th>계좌이체</th>
		</tr>
		<?php if (!empty($stats['by_amount']['rows'])): ?>
			<?php foreach ($stats['by_amount']['rows'] as $row): ?>
				<tr>
					<td><?=$row['label']?></td>
					<td><?=$row['d1_CARD']?></td>
					<td><?=$row['d1_CASH']?></td>
					<td><?=$row['d1_BANK']?></td>
					<td><?=$row['d2_CARD']?></td>
					<td><?=$row['d2_CASH']?></td>
					<td><?=$row['d2_BANK']?></td>
					<td><?=$row['d3_CARD']?></td>
					<td><?=$row['d3_CASH']?></td>
					<td><?=$row['d3_BANK']?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<td>합계</td>
					<td><?=$stats['by_amount']['sum']['d1_CARD']?></td>
					<td><?=$stats['by_amount']['sum']['d1_CASH']?></td>
					<td><?=$stats['by_amount']['sum']['d1_BANK']?></td>
					<td><?=$stats['by_amount']['sum']['d2_CARD']?></td>
					<td><?=$stats['by_amount']['sum']['d2_CASH']?></td>
					<td><?=$stats['by_amount']['sum']['d2_BANK']?></td>
					<td><?=$stats['by_amount']['sum']['d3_CARD']?></td>
					<td><?=$stats['by_amount']['sum']['d3_CASH']?></td>
					<td><?=$stats['by_amount']['sum']['d3_BANK']?></td>
				</tr>
		<?php endif; ?>
	</table><br><br>
<?php endif; ?>

<?php if ($showAll || $section == 'by_group'): ?>
	<h3>4. 단체등록</h3>
	<table border="1">
		<tr>
			<th>이메일</th>
			<th>등록유형</th>
			<th>국가</th>
			<th>성명(국문)</th>
			<th>성명(영문)</th>
			<th>결제데스크</th>
			<th>금액</th>
			<th>비고</th>
		</tr>
		<?php if (!empty($stats['by_group']['rows'])): ?>
			<?php foreach ($stats['by_group']['rows'] as $row): ?>
				<tr>
					<td><?=$row['email']?></td>
					<td><?=$row['type_label']?></td>
					<td><?=$row['nation']?></td>
					<td><?=$row['name_kr']?></td>
					<td><?=$row['name_eng']?></td>
					<td><?=$row['desk_label']?></td>
					<td><?=$row['fee']?></td>
					<td><?=$row['memo']?></td>
				</tr>
			<?php endforeach; ?>
				<tr>
					<td>합계 (<?=(int)$stats['by_group']['sum']['cnt']?>명)</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?=$stats['by_group']['sum']['fee']?></td>
					<td></td>
				</tr>
		<?php endif; ?>
	</table>
<?php endif; ?>
