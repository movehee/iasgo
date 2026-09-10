<?php
	/**
	 * 출결 확인
	 * - URL: /registration/attendance.php
	 * - GNB: config.php 의 $_CONFIG['show_attendance_menu'] (true/false)
	 */
	include $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config_time.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	// 시간설정 사용함이면 고정 시각 기준으로 Day 기본값 선택
	$timeIngFile = $_SERVER['DOCUMENT_ROOT'].'/func/config_time_ing.php';
	if (is_file($timeIngFile)) {
		$timeIngRaw = @file_get_contents($timeIngFile);
		if ($timeIngRaw !== false && strpos($timeIngRaw, "\$_Time['use'] = true") !== false) {
			if (preg_match('/\$_Time\[\'ing\'\]\s*=\s*"([0-9]+)"/', $timeIngRaw, $timeIngMatch)) {
				$fixedIng = (int)$timeIngMatch[1];
				if ($fixedIng > 0) {
					$_Time['ing'] = $fixedIng;
					$_Time['use'] = true;
				}
			}
		}
	}

	$evDateRaw = isset($_REQUEST['ev_date']) ? $_REQUEST['ev_date'] : '';
	$isAllDays = ($evDateRaw === 'all' || $evDateRaw === '0');
	if ($isAllDays) {
		$ev_date = 0;
	} else {
		$ev_date = (int)$evDateRaw;
		if ($ev_date < 1 || !isset($_TIME['session'][$ev_date])) {
			$ev_date = 1;
			if (isset($_Time['ing']) && (int)$_Time['ing'] > 0) {
				$todayChk = date('Y-m-d', (int)$_Time['ing']);
			} else {
				$todayChk = date('Y-m-d');
			}
			if (isset($_TIME['session']) && is_array($_TIME['session'])) {
				foreach ($_TIME['session'] as $dkey => $sessions) {
					if (!isset($sessions['1'][0])) {
						continue;
					}
					if (substr($sessions['1'][0], 0, 10) == $todayChk) {
						$ev_date = (int)$dkey;
						break;
					}
				}
			}
		}
	}

	$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
	if ($page < 1) {
		$page = 1;
	}
	$num_per_page = isset($li_page) && $li_page ? (int)$li_page : 50;
	if (!isset($page_per_block) || !$page_per_block) {
		$page_per_block = 10;
	}

	include $_SERVER['DOCUMENT_ROOT'].'/registration/include.attendance_search.php';

	$countSql = 'SELECT COUNT(*) FROM ('.$listSelect.') Tb';
	$countResult = $listParams ? $conn->getOne($countSql, $listParams) : $conn->getOne($countSql);
	if (DB::isError($countResult)) {
		error_log('[Attendance] count failed: '.$countResult->getMessage());
		$countResult = 0;
	}
	$totalRecord = (int)$countResult;

	$pageNav = new Page($page, $totalRecord, $num_per_page);
	$totalPage = $pageNav->getTotalPage();
	$firstRecord = $pageNav->getFirstRecordInPage();
	$virtualRecordNo = $pageNav->getVirtualRecordNoInPage($totalRecord);

	$listQuery = $listSelect.' ORDER BY t1.first_date DESC, t1.usid DESC LIMIT '.(int)$firstRecord.','.(int)$num_per_page;
	$listResult = $listParams ? $conn->query($listQuery, $listParams) : $conn->query($listQuery);
	if (DB::isError($listResult)) {
		error_log('[Attendance] list failed: '.$listResult->getMessage());
		$listResult = false;
	}

	$detailSql = 'SELECT d.usid, d.day, d.session_in, d.check_in, d.chk_type, d.location_kind, r.classification,'
		.' r.name_kr, r.name_eng, r.id, r.country'
		.' FROM checkin_detail_tbl AS d'
		.' INNER JOIN registration_tbl AS r ON d.usid = r.sid AND r.del = \'N\''
		.' WHERE 1=1'.$detailWhere
		.' ORDER BY d.check_in DESC LIMIT 30';
	$detailResult = $detailParams ? $conn->query($detailSql, $detailParams) : $conn->query($detailSql);
	if (DB::isError($detailResult)) {
		error_log('[Attendance] detail failed: '.$detailResult->getMessage());
		$detailResult = false;
	}

	$chkTypeLabel = array('I' => 'In', 'O' => 'Out', 'E' => 'In', 'S' => 'Stay');
	$locLabel = isset($_Log['location_kind']) ? $_Log['location_kind'] : array('P' => 'PC', 'M' => 'Mobile', 'T' => 'Tablet', 'A' => '관리자-수정팝업');

	$blockNav = new Block('', $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if ($block >= $totalBlock) {
		$lastPageInBlock = $totalPage;
	}

	$showMenu = !empty($_CONFIG['show_attendance_menu']);
	$linkDay = $ev_date > 0 ? (int)$ev_date : 1;
	if ($ev_date > 0) {
		$summaryTitle = (int)$ev_date.'일차 출결 요약';
		if ($dayLabel != '') {
			$summaryTitle .= ' ('.$dayLabel.')';
		}
	} else {
		$summaryTitle = '전체 출결 요약';
	}
?>
<div class="btn bp10" style="float:left;">
	<a href="<?=$PHP_SELF?>?ev_date=all<?=$search_keep?>"<?=$ev_date < 1 ? ' class="btnRed"' : ''?>><i class="far fa-calendar-alt"></i>전체</a>
	<?php foreach ($_TIME['session'] as $dkey => $sessions): ?>
		<?php $dLabel = isset($sessions['1'][0]) ? substr($sessions['1'][0], 0, 10) : ''; ?>
		<a href="<?=$PHP_SELF?>?ev_date=<?=(int)$dkey?><?=$search_keep?>"<?=$ev_date == (int)$dkey ? ' class="btnRed"' : ''?>>
			<i class="far fa-calendar-alt"></i><?=(int)$dkey?>일차
			<?php if ($dLabel != ''): ?>
				<span class="dLabel">(<?=$dLabel?>)</span>
			<?php endif; ?>
		</a>
	<?php endforeach; ?>
</div>
<div class="searchArea" style="clear:both;">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="get">
		<input type="hidden" name="ev_date" value="<?=$ev_date > 0 ? (int)$ev_date : 'all'?>">
		<fieldset>
			<legend>출결 검색<?=$showMenu ? '' : ' (GNB 비노출)'?></legend>
			<table class="tblDef inputTbl">
				<colgroup>
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
					<col style="width: 8%;">
					<col style="width: 12%;">
				</colgroup>
				<tbody>
					<tr>
						<th>ID</th>
						<td class="al">
							<input type="text" name="id" id="id" value="<?=$id?>" style="width:95%;">
						</td>
						<th>성명</th>
						<td class="al">
							<input type="text" name="name_kr" id="name_kr" value="<?=$name_kr?>" style="width:95%;">
						</td>
						<th>성명(영문)</th>
						<td class="al">
							<input type="text" name="name_eng" id="name_eng" value="<?=$name_eng?>" style="width:95%;">
						</td>
						<th>면허번호</th>
						<td class="al">
							<input type="text" name="license_number" id="license_number" value="<?=$license_number?>" style="width:95%;">
						</td>
						<th>소속</th>
						<td class="al">
							<input type="text" name="aff_kor" id="aff_kor" value="<?=$aff_kor?>" style="width:95%;">
						</td>
					</tr>
					<tr>
						<th>등록구분</th>
						<td class="al">
							<select name="classification" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php foreach ($_REG['class_kind'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$classification == $tkey ? 'selected' : ''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th>카테고리</th>
						<td class="al">
							<select name="title" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php if (!empty($_ONSITE['fee_kor'])): ?>
									<optgroup label="국내">
										<?php foreach ($_ONSITE['fee_kor'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title == $tkey ? 'selected' : ''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
								<?php if (!empty($_ONSITE['fee_eng'])): ?>
									<optgroup label="국외">
										<?php foreach ($_ONSITE['fee_eng'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title == $tkey ? 'selected' : ''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
							</select>
						</td>
						<th>sid</th>
						<td class="al">
							<input type="text" name="key" id="key" value="<?=$usidKey > 0 ? (int)$usidKey : ''?>" style="width:95%;">
						</td>
						<th>바로가기</th>
						<td class="al" colspan="3">
							<a href="/registration/index_checkin.php?ev_date=<?=(int)$linkDay?>">입출기록</a>
							&nbsp;|&nbsp;
							<a href="/time/index.php?ev_date=<?=(int)$linkDay?>&include_staff=Y">평점/체류</a>
							&nbsp;|&nbsp;
							<a href="/?kind=time">시간설정</a>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>'">
				<input type="button" value="Excel Backup" class="btnGreen2" onclick="location.href='attendance_excel.php?<?=ltrim($search_url, '&')?>'">
				<input type="button" value="출결 사용안내" class="btnGrey" onclick="window.open('attendance_popup.php','attGuide','width=780,height=720,scrollbars=yes,resizable=yes');">
				<span style="margin-left:12px;color:#666;">총 <?=(int)$totalRecord?>명<?=$dayLabel != '' ? ' · '.$dayLabel : ''?></span>
			</div>
		</fieldset>
	</form>
</div>

<div class="contents">
	<h3 style="margin:0 0 10px;">최근 스캔 로그 (최대 30건)</h3>
	<table class="tblDef">
		<thead>
			<tr>
				<th>시각</th>
				<?php if ($ev_date < 1): ?>
					<th>일차</th>
				<?php endif; ?>
				<th>등록구분</th>
				<th>sid</th>
				<th>이름</th>
				<th>ID</th>
				<th>세션</th>
				<th>In/Out</th>
				<th>기기</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$detailHasRow = false;
				if ($detailResult):
					while (is_array($log = $detailResult->fetchRow(DB_FETCHMODE_ASSOC))):
						$detailHasRow = true;
						$logName = ($log['country'] == 'K' && trim($log['name_kr']) != '') ? $log['name_kr'] : $log['name_eng'];
						if (trim($logName) == '') {
							$logName = $log['name_kr'];
						}
						$chkTxt = isset($chkTypeLabel[$log['chk_type']]) ? $chkTypeLabel[$log['chk_type']] : $log['chk_type'];
						$locTxt = isset($locLabel[$log['location_kind']]) ? $locLabel[$log['location_kind']] : $log['location_kind'];
						$logClass = isset($_REG['class_kind'][$log['classification']]) ? $_REG['class_kind'][$log['classification']] : $log['classification'];
			?>
				<tr>
					<td><?=$log['check_in'] > 0 ? date('Y-m-d H:i:s', (int)$log['check_in']) : ''?></td>
					<?php if ($ev_date < 1): ?>
						<td><?=(int)$log['day']?>일차</td>
					<?php endif; ?>
					<td><?=$logClass?></td>
					<td><?=(int)$log['usid']?></td>
					<td><?=$logName?></td>
					<td><?=$log['id']?></td>
					<td><?=(int)$log['session_in'] > 0 ? 'S'.(int)$log['session_in'] : '-'?></td>
					<td><?=$chkTxt?></td>
					<td><?=$locTxt?></td>
				</tr>
			<?php
					endwhile;
				endif;
				if (!$detailHasRow):
			?>
				<tr>
					<td colspan="<?=$ev_date < 1 ? 9 : 8?>">스캔 로그가 없습니다.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<h3 style="margin:24px 0 10px;"><?=$summaryTitle?></h3>
	<table class="tblDef">
		<thead>
			<tr>
				<th>No</th>
				<?php if ($ev_date < 1): ?>
					<th>일차</th>
				<?php endif; ?>
				<th>sid</th>
				<th>등록구분</th>
				<th>이름</th>
				<th>ID</th>
				<th>최초</th>
				<th>최종</th>
				<?php for ($s = 1; $s <= $sessionCount; $s++): ?>
					<th>S<?=$s?> In</th>
					<th>S<?=$s?> Out</th>
				<?php endfor; ?>
			</tr>
		</thead>
		<tbody>
			<?php
				$listHasRow = false;
				if ($listResult):
					while (is_array($d = $listResult->fetchRow(DB_FETCHMODE_ASSOC))):
						$listHasRow = true;
						$rowName = ($d['country'] == 'K' && trim($d['name_kr']) != '') ? $d['name_kr'] : $d['name_eng'];
						if (trim($rowName) == '') {
							$rowName = $d['name_kr'];
						}
						$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : $d['classification'];
			?>
				<tr>
					<td><?=(int)$virtualRecordNo?></td>
					<?php if ($ev_date < 1): ?>
						<td><?=(int)$d['day']?>일차</td>
					<?php endif; ?>
					<td><?=(int)$d['usid']?></td>
					<td><?=$classLabel?></td>
					<td><?=$rowName?></td>
					<td><?=$d['id']?></td>
					<td><?=$d['first_date'] > 0 ? date('H:i', (int)$d['first_date']) : ''?></td>
					<td><?=$d['last_date'] > 0 ? date('H:i', (int)$d['last_date']) : ''?></td>
					<?php for ($s = 1; $s <= $sessionCount; $s++): ?>
						<?php
							$sc = 's'.$s.'_sdate';
							$ec = 's'.$s.'_edate';
						?>
						<td><?=(isset($d[$sc]) && $d[$sc] > 0) ? date('H:i', (int)$d[$sc]) : ''?></td>
						<td><?=(isset($d[$ec]) && $d[$ec] > 0) ? date('H:i', (int)$d[$ec]) : ''?></td>
					<?php endfor; ?>
				</tr>
			<?php
						$virtualRecordNo--;
					endwhile;
				endif;
				if (!$listHasRow):
					$colspan = 7 + ($sessionCount * 2) + ($ev_date < 1 ? 1 : 0);
			?>
				<tr>
					<td colspan="<?=(int)$colspan?>">출결 데이터가 없습니다.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php include $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/include.page.php'; ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/include.footer.php'; ?>
