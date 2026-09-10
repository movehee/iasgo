<?php
	if (!isset($excelBase)) {
		$excelBase = '/registration/statistics_excel.php';
	}
	$dl = isset($stats['day_labels']) ? $stats['day_labels'] : array('1' => 'Day1', '2' => 'Day2', '3' => 'Day3');
?>
<div class="btn btnArea" style="margin-bottom:15px;">
	<input type="button" value="전체 엑셀 다운로드" class="btnGreen2" onclick="location.href='<?=$excelBase?>?section=all'">
</div>

<!-- 표1. 참여국가별 -->
<div class="bp10">
	<div class="btn" style="margin-bottom:8px;">
		<strong style="margin-right:10px;">1. 참여국가별 (입장 기록 있는 국가)</strong>
		<input type="button" value="엑셀" class="btnGreen" onclick="location.href='<?=$excelBase?>?section=by_nation'">
		<p style="margin-top:8px;font-size:12px;color:#666;">* 체크인 = 출결(checkin) 최초입장.</p>
	</div>
	<table class="tblDef inputTbl" style="width:100%;">
		<thead>
			<tr>
				<th>국가명</th>
				<th>Day1 (<?=$dl['1']?>)</th>
				<th>Day2 (<?=$dl['2']?>)</th>
				<th>Day3 (<?=$dl['3']?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($stats['by_nation']['rows'])): ?>
				<?php foreach ($stats['by_nation']['rows'] as $row): ?>
					<tr>
						<th class="al"><?=$row['nation']?></th>
						<td><?=number_format($row['day1'])?></td>
						<td><?=number_format($row['day2'])?></td>
						<td><?=number_format($row['day3'])?></td>
					</tr>
				<?php endforeach; ?>
					<tr>
						<th>합계</th>
						<th><?=number_format($stats['by_nation']['sum']['day1'])?></th>
						<th><?=number_format($stats['by_nation']['sum']['day2'])?></th>
						<th><?=number_format($stats['by_nation']['sum']['day3'])?></th>
					</tr>
			<?php else: ?>
				<tr>
					<td colspan="4">데이터 없음</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- 표2. 입장통계 -->
<div class="bp10" style="margin-top:25px;">
	<div class="btn" style="margin-bottom:8px;">
		<strong style="margin-right:10px;">2. 입장통계 (국내 · 출결기준)</strong>
		<input type="button" value="엑셀" class="btnGreen" onclick="location.href='<?=$excelBase?>?section=by_attend'">
		<p style="margin-top:8px;font-size:12px;color:#666;">* 체크인 = 출결 최초입장 / 체크아웃 = 출결 최종퇴장 또는 관리자 수동 퇴장시각</p>
	</div>
	<table class="tblDef inputTbl" style="width:100%;">
		<thead>
			<tr>
				<th rowspan="2">구분</th>
				<th colspan="2">Day1 (<?=$dl['1']?>)</th>
				<th colspan="2">Day2 (<?=$dl['2']?>)</th>
				<th colspan="2">Day3 (<?=$dl['3']?>)</th>
			</tr>
			<tr>
				<th>체크인</th>
				<th>체크아웃</th>
				<th>체크인</th>
				<th>체크아웃</th>
				<th>체크인</th>
				<th>체크아웃</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($stats['by_attend']['rows'])): ?>
				<?php foreach ($stats['by_attend']['rows'] as $row): ?>
					<tr>
						<th class="al"><?=$row['label']?></th>
						<td><?=number_format($row['d1_in'])?></td>
						<td><?=number_format($row['d1_out'])?></td>
						<td><?=number_format($row['d2_in'])?></td>
						<td><?=number_format($row['d2_out'])?></td>
						<td><?=number_format($row['d3_in'])?></td>
						<td><?=number_format($row['d3_out'])?></td>
					</tr>
				<?php endforeach; ?>
					<tr>
						<th>합계</th>
						<th><?=number_format($stats['by_attend']['sum']['d1_in'])?></th>
						<th><?=number_format($stats['by_attend']['sum']['d1_out'])?></th>
						<th><?=number_format($stats['by_attend']['sum']['d2_in'])?></th>
						<th><?=number_format($stats['by_attend']['sum']['d2_out'])?></th>
						<th><?=number_format($stats['by_attend']['sum']['d3_in'])?></th>
						<th><?=number_format($stats['by_attend']['sum']['d3_out'])?></th>
					</tr>
			<?php else: ?>
				<tr>
					<td colspan="7">데이터 없음</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- 표3. 금액통계 (DESK1=사전등록1, DESK2=사전등록2, DESK3=현장등록) -->
<div class="bp10" style="margin-top:25px;">
	<div class="btn" style="margin-bottom:8px;">
		<strong style="margin-right:10px;">3. 금액통계</strong>
		<input type="button" value="엑셀" class="btnGreen" onclick="location.href='<?=$excelBase?>?section=by_amount'">
	</div>
	<table class="tblDef inputTbl" style="width:100%;">
		<thead>
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
		</thead>
		<tbody>
			<?php if (!empty($stats['by_amount']['rows'])): ?>
				<?php foreach ($stats['by_amount']['rows'] as $row): ?>
					<tr>
						<th class="al"><?=$row['label']?></th>
						<td><?=number_format($row['d1_CARD'])?></td>
						<td><?=number_format($row['d1_CASH'])?></td>
						<td><?=number_format($row['d1_BANK'])?></td>
						<td><?=number_format($row['d2_CARD'])?></td>
						<td><?=number_format($row['d2_CASH'])?></td>
						<td><?=number_format($row['d2_BANK'])?></td>
						<td><?=number_format($row['d3_CARD'])?></td>
						<td><?=number_format($row['d3_CASH'])?></td>
						<td><?=number_format($row['d3_BANK'])?></td>
					</tr>
				<?php endforeach; ?>
					<tr>
						<th>합계</th>
						<th><?=number_format($stats['by_amount']['sum']['d1_CARD'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d1_CASH'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d1_BANK'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d2_CARD'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d2_CASH'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d2_BANK'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d3_CARD'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d3_CASH'])?></th>
						<th><?=number_format($stats['by_amount']['sum']['d3_BANK'])?></th>
					</tr>
			<?php else: ?>
				<tr>
					<td colspan="10">데이터 없음</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- 표4. 단체등록 -->
<div class="bp10" style="margin-top:25px;">
	<div class="btn" style="margin-bottom:8px;">
		<strong style="margin-right:10px;">4. 단체등록</strong>
		<input type="button" value="엑셀" class="btnGreen" onclick="location.href='<?=$excelBase?>?section=by_group'">
		<p style="margin-top:8px;font-size:12px;color:#666;">* 국내 [5인 이상 단체]Trainee만 표시합니다. 같은 단체 Memo끼리 묶이며, 뒤에 개인 Memo가 있어도 됩니다.</p>
	</div>
	<table class="tblDef inputTbl" style="width:100%;">
		<thead>
			<tr>
				<th>이메일</th>
				<th>등록유형</th>
				<th>국가</th>
				<th>성명(국문)</th>
				<th>성명(영문)</th>
				<th>결제데스크</th>
				<th>금액</th>
				<th>Memo</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($stats['by_group']['rows'])): ?>
				<?php foreach ($stats['by_group']['rows'] as $row): ?>
					<tr>
						<td class="al"><?=$row['email']?></td>
						<td><?=$row['type_label']?></td>
						<td><?=$row['nation']?></td>
						<td><?=$row['name_kr']?></td>
						<td class="al"><?=$row['name_eng']?></td>
						<td><?=$row['desk_label']?></td>
						<td><?=number_format($row['fee'])?></td>
						<td class="al"><?=htmlspecialchars($row['memo'], ENT_QUOTES, 'UTF-8')?></td>
					</tr>
				<?php endforeach; ?>
					<tr>
						<th>합계 (<?=(int)$stats['by_group']['sum']['cnt']?>명)</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th><?=number_format($stats['by_group']['sum']['fee'])?></th>
						<th></th>
					</tr>
			<?php else: ?>
				<tr>
					<td colspan="8">데이터 없음</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>
