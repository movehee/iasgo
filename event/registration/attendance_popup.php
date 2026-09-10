<?php
	/**
	 * 출결·평점 사용안내 팝업
	 */
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	procAdminLoginChk();

	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;
	$guideDayList = array();
	if (isset($_TIME['session']) && is_array($_TIME['session'])) {
		foreach ($_TIME['session'] as $gDay => $gSessions) {
			$gDay = (int)$gDay;
			if ($gDay < 1 || !is_array($gSessions)) {
				continue;
			}
			$dayDate = '';
			$sessionLines = array();
			$dayMaxMin = 0;
			$range = function_exists('getEventDayRange') ? getEventDayRange($gDay) : null;
			foreach ($gSessions as $gSessKey => $gSess) {
				if (!isset($gSess[0]) || !isset($gSess[1])) {
					continue;
				}
				if ($dayDate == '') {
					$dayDate = substr($gSess[0], 0, 10);
				}
				$sessionLines[] = 'S'.(int)$gSessKey.' '.date('H:i', strtotime($gSess[0])).'~'.date('H:i', strtotime($gSess[1]));
				$dayMaxMin += (int)((strtotime($gSess[1]) - strtotime($gSess[0])) / 60);
			}
			$rangeText = '';
			if ($range && isset($range['start']) && isset($range['end'])) {
				$rangeText = date('H:i', (int)$range['start']).'~'.date('H:i', (int)$range['end']);
			}
			// 그 일차에 처음부터 끝까지 있었을 때 받을 수 있는 최대 평점
			$dayMaxInfo = getSessionStayScore($dayMaxMin, $scoreMaxHour);
			$guideDayList[] = array(
				'day' => $gDay,
				'date' => $dayDate,
				'range' => $rangeText,
				'sessions' => $sessionLines,
				'max_min' => $dayMaxMin,
				'max_score' => $dayMaxInfo['score']
			);
		}
	}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>IASGO 2026 출결·평점 사용안내</title>
<style>
	html, body {
		margin: 0;
		padding: 0;
		background: #fff;
		font-family: 'Malgun Gothic', '맑은 고딕', sans-serif;
		color: #333;
	}
	.att-guide-wrap {
		padding: 0;
	}
	.att-guide-head {
		padding: 14px 18px;
		border-bottom: 1px solid #e5e5e5;
		background: #f7f9fb;
	}
	.att-guide-head h1 {
		margin: 0;
		font-size: 18px;
		line-height: 1.3;
	}
	.att-guide-body {
		padding: 16px 18px 20px;
		font-size: 13px;
		line-height: 1.55;
	}
	.att-guide-summary {
		margin: 0 0 14px;
		padding: 10px 12px;
		background: #eef6ff;
		border: 1px solid #cfe3f8;
		border-radius: 4px;
	}
	.att-guide-summary li {
		margin: 0 0 4px;
	}
	.att-guide-section {
		margin: 0 0 16px;
	}
	.att-guide-section h2 {
		margin: 0 0 8px;
		font-size: 15px;
		color: #1f4e79;
	}
	.att-guide-section ul {
		margin: 0;
		padding-left: 18px;
	}
	.att-guide-section li {
		margin: 0 0 4px;
	}
	.att-guide-day {
		margin: 0 0 8px;
		padding: 8px 10px;
		background: #fafafa;
		border: 1px solid #eee;
		border-radius: 4px;
	}
	.att-guide-day strong {
		display: block;
		margin-bottom: 4px;
	}
	.att-guide-foot {
		margin-top: 8px;
		padding: 10px 12px;
		background: #fff8e8;
		border: 1px solid #f0e0b0;
		border-radius: 4px;
	}
	.att-guide-actions {
		padding: 10px 18px 18px;
		text-align: right;
	}
	.att-guide-actions button {
		min-width: 72px;
		height: 32px;
		padding: 0 14px;
		border: 1px solid #bbb;
		border-radius: 3px;
		background: #f3f3f3;
		cursor: pointer;
	}
</style>
</head>
<body>
<div class="att-guide-wrap">
	<div class="att-guide-head">
		<h1>IASGO 2026 출결·평점 사용안내</h1>
	</div>
	<div class="att-guide-body">
		<ul class="att-guide-summary">
			<li>평점은 <strong>하루의 최초 기록과 최종 기록</strong>만으로 계산합니다. 세션별 In/Out 한 쌍은 필요 없습니다.</li>
			<li>휴식·점심 등 <strong>세션 사이 공백 시간은 체류·평점에서 제외</strong>됩니다.</li>
			<li>평점은 <strong>인정 체류 1시간당 1점</strong>이며, 하루 최대 <strong><?=(int)$scoreMaxHour?>점</strong>입니다. (1시간 미만은 0점)</li>
			<li>명찰 인쇄만으로는 입장이 저장되지 않습니다. <strong>입실 QR과 이후 QR을 각각 찍어야</strong> 평점이 계산됩니다.</li>
			<li>입실 QR만 있고 <strong>이후 기록이 없으면 체류시간이 0</strong>이 되어 0점입니다.</li>
		</ul>

		<div class="att-guide-section">
			<h2>1. 출결 기능 개요</h2>
			<ul>
				<li>출결 확인 화면은 선택한 일차의 최근 QR 로그와 참가자별 세션 In/Out을 확인하는 관리자 화면입니다.</li>
				<li>명찰 인쇄는 인쇄 기록만 남깁니다. 입장(최초)은 <strong>현장 QR을 찍어야</strong> 저장됩니다.</li>
				<li>대한의사협회 평점은 <strong>1일 2회(입실, 퇴실) QR 태그</strong> 후, 실제 교육 참여시간에 따라 인정됩니다.</li>
				<li><strong>최초/최종</strong> = 평점 계산의 기준이 되는 하루 첫 기록·마지막 기록 / <strong>S1~Sn In/Out</strong> = 참고용 세션별 기록입니다.</li>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>2. 현장 QR 사용 순서</h2>
			<ul>
				<li>각 세션에서 첫 QR은 In, 같은 세션의 다음 QR은 Out으로 처리됩니다.</li>
				<li>하루 최초 In만 있고 Out이 없으면 아이패드에 “나가실 때 QR을 찍어주세요” 안내가 표시됩니다.</li>
				<li>최초 입장 이후에 찍은 QR은 <strong>세션·시각과 무관하게 그때마다 최종시간으로 갱신</strong>됩니다. 세션 중간에 나가도 그 시각이 최종시간이 됩니다.</li>
				<li>중간 세션을 찍지 않아도 됩니다. <strong>들어올 때와 나갈 때</strong> QR을 찍으면 그 사이 인정시간이 모두 반영됩니다.</li>
				<li>입실 QR만 찍고 한 번도 더 찍지 않으면 최초와 최종이 같아 체류시간이 0입니다. 나갈 때 QR을 찍어야 평점이 발생합니다.</li>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>3. 일차별 인정시간</h2>
			<?php if ($guideDayList): ?>
				<?php foreach ($guideDayList as $gDayRow): ?>
					<div class="att-guide-day">
						<strong>
							DAY<?=(int)$gDayRow['day']?>
							<?php if ($gDayRow['date'] != ''): ?>(<?=htmlspecialchars($gDayRow['date'], ENT_QUOTES, 'UTF-8')?>)<?php endif; ?>
							<?php if ($gDayRow['range'] != ''): ?> · 표시 범위 <?=htmlspecialchars($gDayRow['range'], ENT_QUOTES, 'UTF-8')?><?php endif; ?>
							· 인정 합계 <?=(int)($gDayRow['max_min'] / 60)?>시간 <?=(int)$gDayRow['max_min'] % 60?>분 · <strong>최대 <?=(int)$gDayRow['max_score']?>점</strong>
						</strong>
						<?=htmlspecialchars(implode(' / ', $gDayRow['sessions']), ENT_QUOTES, 'UTF-8')?>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p>세션 설정이 없습니다. 시간설정을 확인해 주세요.</p>
			<?php endif; ?>
			<ul>
				<li>위 구간만 인정되며, 휴식·점심 등 세션 사이 공백은 체류시간과 평점에서 제외됩니다.</li>
				<li>하루 종일 참석해도 그 일차의 <strong>인정 합계를 넘는 점수는 나오지 않습니다.</strong> 인정 합계가 <?=(int)$scoreMaxHour?>시간 미만인 일차는 만점이 불가능합니다.</li>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>4. 체류시간·평점 계산법</h2>
			<ul>
				<li><strong>최초</strong> = 그날 찍힌 기록(최초입장·세션 In/Out) 중 가장 이른 시각입니다.</li>
				<li><strong>최종</strong> = 그날 찍힌 기록 중 가장 늦은 시각입니다. 퇴장 QR이 없으면 마지막으로 찍은 입장 시각이 최종이 됩니다.</li>
				<li>인정 체류분 = <strong>최초~최종 구간과 인정 세션이 겹치는 시간</strong>의 합입니다. 세션별 In/Out 쌍은 보지 않습니다.</li>
				<li>최초가 세션 시작보다 이르면 세션 시작시각부터, 최종이 세션 종료보다 늦으면 세션 종료시각까지만 인정합니다.</li>
				<li>초 단위는 버리고 분 단위로 계산합니다.</li>
				<li>평점 = (총 인정 체류분 ÷ 60)의 정수 부분. 1시간 미만은 0점, 하루 최대 <?=(int)$scoreMaxHour?>점입니다.</li>
				<?php if (isset($guideDayList[0])): ?>
					<li>
						예시: DAY<?=(int)$guideDayList[0]['day']?> <?=htmlspecialchars($guideDayList[0]['range'], ENT_QUOTES, 'UTF-8')?>
						내내 있었고 중간 세션 기록이 하나도 없어도
						→ <?=(int)$guideDayList[0]['max_min']?>분 → <?=(int)$guideDayList[0]['max_score']?>점
					</li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>5. 평점이 빠지거나 0점인 주요 이유</h2>
			<ul>
				<li>명찰만 인쇄하고 QR을 안 찍음 → 입장 기록이 없어 0점</li>
				<li>입실 QR만 찍고 이후 기록이 없음 → 최초와 최종이 같아 0분</li>
				<li>나갈 때 QR을 찍지 않음 → 최종이 마지막으로 찍은 시각에서 멈춰 이후 시간이 인정 안 됨</li>
				<li>휴식·점심시간에만 기록이 있음 → 인정시간이 아니므로 0분</li>
				<li>총 인정시간이 60분 미만 → 체류시간은 있어도 평점 0점</li>
				<li>그 일차의 인정 합계가 <?=(int)$scoreMaxHour?>시간 미만 → 종일 참석해도 만점은 나오지 않음 (위 3번 표 참고)</li>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>6. 인정시간 밖 QR 처리</h2>
			<ul>
				<li>행사일이 아닌 날짜의 QR은 “행사일이 아닙니다”로 거절됩니다.</li>
				<li>일차 시작 전에 찍은 기록은 일차 시작시각부터, 일차 종료 후에 찍은 기록은 종료시각까지만 인정됩니다.</li>
				<li>휴식·점심시간에 찍은 QR도 최초/최종 판단에는 쓰이지만, 휴식 구간 자체는 체류시간에서 빠집니다.</li>
				<li>체류시간·평점은 최초~최종과 인정 세션이 겹치는 분만 합산하므로, 휴식·점심 구간은 어느 쪽이든 제외됩니다.</li>
			</ul>
		</div>

		<div class="att-guide-section">
			<h2>7. 화면 확인 및 수정 순서</h2>
			<ul>
				<li><strong>최근 스캔 로그</strong>: 실제 QR 순서, In/Out, 기기 확인</li>
				<li><strong>일차 출결 요약</strong>: 최초/최종과 세션별 누락 확인</li>
				<li><strong>입출기록</strong>: 해당 일차 전체 현황 및 엑셀 확인</li>
				<li><strong>평점/체류</strong>: 최종 인정 체류시간·평점 및 시간 보정</li>
			</ul>
			<div class="att-guide-foot">
				점수가 이상하면 <strong>최근 로그 → 세션 In/Out 누락 → 평점/체류</strong> 순서로 확인하세요.
			</div>
		</div>
	</div>
	<div class="att-guide-actions">
		<button type="button" onclick="window.close();">닫기</button>
	</div>
</div>
</body>
</html>
