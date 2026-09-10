<?php
	/**
	 * 최고관리자 설정 (URL 전용)
	 * - /master/
	 * - GNB 미노출
	 */
	include $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';

	if (!isSuperAdminLogined()) {
		PutMessageBack('최고관리자만 이용가능한 페이지 입니다.');
	}

	$timeIng = isset($_Time['ing']) ? (int)$_Time['ing'] : time();
	if ($timeIng < 1) {
		$timeIng = time();
	}
	$daySet = date('Y-m-d', $timeIng);
	$timeSet = date('H:i:s', $timeIng);
	$timeUse = (isset($_Time['use']) && $_Time['use'] == true);

	$searchKw = isset($_REQUEST['kw']) ? trim($_REQUEST['kw']) : '';
	$printList = array();
	if ($searchKw != '') {
		$like = '%'.$searchKw.'%';
		$printResult = $conn->query(
			'SELECT sid, id, name_kr, name_eng, license_number, print_date'
			.' FROM registration_tbl'
			.' WHERE del = ? AND print_date > 0'
			.' AND (name_kr LIKE ? OR name_eng LIKE ? OR license_number LIKE ?)'
			.' ORDER BY print_date DESC LIMIT 50',
			array('N', $like, $like, $like)
		);
		if (!DB::isError($printResult)) {
			while (is_array($prow = $printResult->fetchRow(DB_FETCHMODE_ASSOC))) {
				$printList[] = $prow;
			}
			$printResult->free();
		} else {
			error_log('[Master] print search failed: '.$printResult->getMessage());
		}
	}

	$badgeReprint = (isset($_MASTER['badge_reprint']) && $_MASTER['badge_reprint'] == 'Y');
	$attendanceMenu = (isset($_MASTER['attendance_menu']) && $_MASTER['attendance_menu'] == 'Y');
	$tagCheckin = (!isset($_MASTER['tag_checkin']) || $_MASTER['tag_checkin'] == 'Y');
	$timeClamp = (isset($_MASTER['time_clamp']) && $_MASTER['time_clamp'] == 'Y');
?>
<style>
	.master-box { margin: 20px; padding: 16px; border: 1px solid #ddd; background: #fff; }
	.master-box h3 { margin: 0 0 12px; font-size: 18px; }
	.master-box .warn { color: #c00; font-weight: bold; margin-bottom: 10px; }
	.master-box label { display: inline-block; margin: 6px 12px 6px 0; font-size: 15px; }
	.master-box input[type="checkbox"] { width: 20px; height: 20px; vertical-align: middle; }
</style>

<div class="contents" style="padding:20px;">
	<p style="color:#666;margin-bottom:20px;">URL 전용 페이지입니다. 세션 시간 편집은 포함하지 않습니다.</p>
	<p style="margin-bottom:16px;"><a href="/master/log.php">로그 확인 페이지</a></p>
	<div class="master-box">
		<h3>기능 스위치</h3>
		<form name="masterSetF" id="masterSetF" method="post" action="/master/setting_reg.php">
			<label>
				<input type="checkbox" name="badge_reprint" value="Y" <?=$badgeReprint ? 'checked' : ''?>>
				명찰 중복인쇄 허용
			</label>
			<label>
				<input type="checkbox" name="attendance_menu" value="Y" <?=$attendanceMenu ? 'checked' : ''?>>
				출결 메뉴 GNB 노출
			</label>
			<label>
				<input type="checkbox" name="tag_checkin" value="Y" <?=$tagCheckin ? 'checked' : ''?>>
				아이패드/태그 출결 사용
			</label>
			<div style="margin-top:12px;padding-top:10px;border-top:1px solid #eee;">
				<strong style="display:block;margin-bottom:8px;">출결 시각 표시·저장</strong>
				<label>
					<input type="radio" name="time_clamp" value="N" <?=!$timeClamp ? 'checked' : ''?>>
					현시간 표시·저장
				</label>
				<label>
					<input type="radio" name="time_clamp" value="Y" <?=$timeClamp ? 'checked' : ''?>>
					인정시간 표시·저장
				</label>
			</div>
			<div class="ac tp10">
				<span class="btnAdmin medium lightBlue">
					<button type="submit">스위치 저장</button>
				</span>
			</div>
		</form>
		<p style="margin-top:10px;color:#666;font-size:13px;">
			중복인쇄 허용이 꺼져 있으면 일반 관리자는 이미 인쇄된 명찰을 다시 출력할 수 없습니다. 최고관리자만 우회 가능합니다.<br>
			입장 기록: 명찰 인쇄는 인쇄 기록만 남기고, 입장(최초)과 통계 loginN은 현장 QR을 찍을 때 저장됩니다.<br>
			출결 시각: “현시간”은 찍은 시각 그대로 저장·표시합니다. “인정시간”은 행사 전이면 당일 최초 인정시각, 행사 후면 당일 최종 인정시각으로 저장·표시합니다. QR 상세 로그는 실제 시각을 유지합니다.
		</p>
	</div>

	<div class="master-box">
		<h3>시간 고정 (테스트용)</h3>
		<div class="warn">아래 시간조정을 하시면 현재 시간이 설정한 시간으로 고정됩니다.</div>
		<div class="warn" style="font-size:18px;">실제 서비스를 진행할 경우 "반드시" 사용함 체크를 풀어야 합니다.</div>
		<form name="time_setF" id="time_setF" method="post" action="/base_setting/time_set_reg.php">
			<input type="hidden" name="return_url" value="/master/">
			<div class="tp10 multi">
				일자 : <input type="text" class="date" name="set_day" style="width:100px;" value="<?=htmlspecialchars($daySet, ENT_QUOTES, 'UTF-8')?>">
				시간 : <input type="text" class="timepicker" name="set_time" style="width:80px;" value="<?=htmlspecialchars($timeSet, ENT_QUOTES, 'UTF-8')?>">
				<input type="checkbox" name="time_set_use" value="Y" style="width:22px;height:22px;" <?=$timeUse ? 'checked' : ''?>>사용함
			</div>
			<div class="ac tp10">
				<span class="btnAdmin medium lightBlue">
					<button type="button" onclick="$('#time_setF').submit()">적용하기</button>
				</span>
				<a href="/?kind=time" style="margin-left:12px;">기존 시간설정 페이지</a>
			</div>
		</form>
	</div>

	<div class="master-box">
		<h3>명찰 인쇄기록 리셋</h3>
		<p class="warn">print_date만 초기화합니다. 출결(최초입장/세션 In·Out)은 유지됩니다.</p>
		<form method="get" action="/master/" style="margin-bottom:12px;">
			검색 (이름 / 면허번호):
			<input type="text" name="kw" value="<?=htmlspecialchars($searchKw, ENT_QUOTES, 'UTF-8')?>" style="width:220px;">
			<input type="submit" value="검색" class="btnDef">
		</form>
		<?php if ($searchKw == ''): ?>
			<p style="color:#666;">검색 후 인쇄기록이 있는 인원을 선택해 리셋할 수 있습니다.</p>
		<?php elseif (!$printList): ?>
			<p style="color:#666;">인쇄기록이 있는 검색 결과가 없습니다.</p>
		<?php else: ?>
			<form name="printResetF" id="printResetF" method="post" action="/master/print_reset.php" onsubmit="return confirm('선택한 인원의 인쇄기록을 초기화할까요? (출결은 유지)');">
				<table class="tblDef">
					<thead>
						<tr>
							<th><input type="checkbox" class="allchk" style="width:18px;height:18px;"></th>
							<th>sid</th>
							<th>ID</th>
							<th>이름</th>
							<th>면허번호</th>
							<th>인쇄시각</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($printList as $prow): ?>
							<?php
								$pName = trim($prow['name_kr']) != '' ? $prow['name_kr'] : $prow['name_eng'];
							?>
							<tr>
								<td>
									<input type="checkbox" name="chk_num[]" class="chk_list" value="<?=(int)$prow['sid']?>" style="width:18px;height:18px;">
								</td>
								<td><?=(int)$prow['sid']?></td>
								<td><?=htmlspecialchars($prow['id'], ENT_QUOTES, 'UTF-8')?></td>
								<td><?=htmlspecialchars($pName, ENT_QUOTES, 'UTF-8')?></td>
								<td><?=htmlspecialchars($prow['license_number'], ENT_QUOTES, 'UTF-8')?></td>
								<td><?=(int)$prow['print_date'] > 0 ? date('Y-m-d H:i:s', (int)$prow['print_date']) : ''?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="ac tp10">
					<span class="btnAdmin medium lightBlue">
						<button type="submit">선택 인쇄기록 리셋</button>
					</span>
				</div>
			</form>
			<script>
				$(function () {
					$('.allchk').on('click', function () {
						$('.chk_list').prop('checked', $(this).is(':checked'));
					});
				});
			</script>
		<?php endif; ?>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'include.footer.php'; ?>
