<?php
	/**
	 * 등록 변경 이력 조회 (최고관리자 전용)
	 */
	include $_SERVER['DOCUMENT_ROOT'].'include.header.php';

	if (!isSuperAdminLogined()) {
		PutMessageBack('최고관리자만 이용가능한 페이지 입니다.');
	}

	$perPage = 100;
	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	if ($page < 1) {
		$page = 1;
	}

	$sdate = isset($_GET['sdate']) ? trim($_GET['sdate']) : '';
	$edate = isset($_GET['edate']) ? trim($_GET['edate']) : '';
	$kw = isset($_GET['kw']) ? trim($_GET['kw']) : '';
	$adminKw = isset($_GET['admin_kw']) ? trim($_GET['admin_kw']) : '';
	$source = isset($_GET['source']) ? trim($_GET['source']) : '';
	$field = isset($_GET['field']) ? trim($_GET['field']) : '';

	$sourceLabels = array(
		'postform' => '등록팝업',
		'pay_status' => '결제상태',
		'desk' => 'DESK',
		'memo' => '메모',
		'delete' => '삭제',
		'excel' => '엑셀'
	);

	$where = array('1=1');
	$params = array();

	if ($sdate != '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $sdate)) {
		$where[] = 'L.created_at >= ?';
		$params[] = $sdate.' 00:00:00';
	}
	if ($edate != '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $edate)) {
		$where[] = 'L.created_at <= ?';
		$params[] = $edate.' 23:59:59';
	}
	if ($source != '' && isset($sourceLabels[$source])) {
		$where[] = 'L.source = ?';
		$params[] = $source;
	}
	if ($field != '' && preg_match('/^[A-Za-z0-9_()]+$/', $field)) {
		$where[] = 'L.field = ?';
		$params[] = $field;
	}
	if ($adminKw != '') {
		$where[] = '(CAST(L.admin_sid AS CHAR) = ? OR A.id LIKE ?)';
		$params[] = $adminKw;
		$params[] = '%'.$adminKw.'%';
	}
	if ($kw != '') {
		$where[] = '(R.name_kr LIKE ? OR R.name_eng LIKE ? OR R.id LIKE ? OR CAST(L.target_sid AS CHAR) = ?)';
		$like = '%'.$kw.'%';
		$params[] = $like;
		$params[] = $like;
		$params[] = $like;
		$params[] = $kw;
	}

	$whereSql = implode(' AND ', $where);
	$joinSql = ' FROM reg_change_log L'
		.' LEFT JOIN registration_tbl R ON R.sid = L.target_sid'
		.' LEFT JOIN registration_tbl A ON A.sid = L.admin_sid';

	$countSql = 'SELECT COUNT(*)'.$joinSql.' WHERE '.$whereSql;
	$countResult = $conn->getOne($countSql, $params);
	if (DB::isError($countResult)) {
		error_log('[RegLog] count failed: '.$countResult->getMessage());
		$total = 0;
	} else {
		$total = (int)$countResult;
	}

	$totalPage = ($total > 0) ? (int)ceil($total / $perPage) : 1;
	if ($page > $totalPage) {
		$page = $totalPage;
	}
	$offset = ($page - 1) * $perPage;

	$listSql = 'SELECT L.*, R.name_kr, R.name_eng, R.id AS target_id, A.id AS admin_id'
		.$joinSql
		.' WHERE '.$whereSql
		.' ORDER BY L.sid DESC'
		.' LIMIT '.(int)$offset.', '.(int)$perPage;
	$listResult = $conn->query($listSql, $params);
	$list = array();
	if (!DB::isError($listResult)) {
		while (is_array($row = $listResult->fetchRow(DB_FETCHMODE_ASSOC))) {
			$list[] = $row;
		}
		$listResult->free();
	} else {
		error_log('[RegLog] list failed: '.$listResult->getMessage());
	}

	$qs = array();
	if ($sdate != '') { $qs['sdate'] = $sdate; }
	if ($edate != '') { $qs['edate'] = $edate; }
	if ($kw != '') { $qs['kw'] = $kw; }
	if ($adminKw != '') { $qs['admin_kw'] = $adminKw; }
	if ($source != '') { $qs['source'] = $source; }
	if ($field != '') { $qs['field'] = $field; }
	$baseQs = http_build_query($qs);
?>
<style>
	.master-box { margin: 20px; padding: 16px; border: 1px solid #ddd; background: #fff; }
	.master-box h3 { margin: 0 0 12px; font-size: 18px; }
	.reg-log-filter label { display: inline-block; margin: 4px 10px 4px 0; }
	.reg-log-filter input[type="text"] { width: 120px; }
	.reg-log-tbl td { word-break: break-all; vertical-align: top; }
	.reg-log-arrow { color: #666; margin: 0 4px; }
	.reg-log-pager { margin-top: 12px; text-align: center; }
	.reg-log-pager a { margin: 0 4px; }
</style>

<div class="contents" style="padding:20px;">
	<div class="master-box">
		<h3>등록 변경 이력</h3>
		<p style="margin-bottom:12px;"><a href="/master/">&laquo; 최고관리자 설정으로</a></p>

		<form method="get" action="/master/log.php" class="reg-log-filter" style="margin-bottom:16px;">
			<label>기간
				<input type="text" name="sdate" class="date" value="<?=$sdate?>" placeholder="시작일">
				~
				<input type="text" name="edate" class="date" value="<?=$edate?>" placeholder="종료일">
			</label>
			<label>대상자
				<input type="text" name="kw" value="<?=$kw?>" placeholder="이름/ID/sid" style="width:140px;">
			</label>
			<label>변경주체
				<input type="text" name="admin_kw" value="<?=$adminKw?>" placeholder="ID/sid" style="width:120px;">
			</label>
			<label>화면
				<select name="source">
					<option value="">전체</option>
					<?php foreach ($sourceLabels as $sk => $sv): ?>
						<option value="<?=$sk?>" <?=$source == $sk ? 'selected' : ''?>><?=$sv?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>항목
				<input type="text" name="field" value="<?=$field?>" placeholder="pay_status 등" style="width:110px;">
			</label>
			<input type="submit" value="검색" class="btnDef">
		</form>

		<p style="color:#666;margin-bottom:8px;">총 <?=(int)$total?>건 / <?=(int)$page?> / <?=(int)$totalPage?> 페이지</p>

		<table class="tblDef reg-log-tbl">
			<thead>
				<tr>
					<th style="width:8%;">일시</th>
					<th style="width:10%;">관리자</th>
					<th style="width:8%;">화면</th>
					<th style="width:6%;">액션</th>
					<th style="width:14%;">대상자</th>
					<th style="width:10%;">항목</th>
					<th style="width:22%;">변경 전</th>
					<th style="width:22%;">변경 후</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!$list): ?>
					<tr><td colspan="8">이력이 없습니다.</td></tr>
				<?php else: ?>
					<?php foreach ($list as $row): ?>
						<?php
							$targetName = trim($row['name_kr']) != '' ? $row['name_kr'] : $row['name_eng'];
							if ($targetName == '') {
								$targetName = '-';
							}
							$srcLabel = isset($sourceLabels[$row['source']]) ? $sourceLabels[$row['source']] : $row['source'];
							$adminLabel = '-';
							if ((int)$row['admin_sid'] > 0) {
								$adminId = isset($row['admin_id']) ? trim($row['admin_id']) : '';
								$adminLabel = ($adminId != '') ? $adminId : '-';
								$adminLabel .= ' (#'.(int)$row['admin_sid'].')';
							}
						?>
						<tr>
							<td><?=$row['created_at']?></td>
							<td><?=$adminLabel?></td>
							<td><?=$srcLabel?></td>
							<td><?=$row['action']?></td>
							<td>
								#<?=(int)$row['target_sid']?><br>
								<?=$targetName?><br>
								<?=$row['target_id']?>
							</td>
							<td><?=$row['field']?></td>
							<td><?=$row['old_val']?></td>
							<td><?=$row['new_val']?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<?php if ($totalPage > 1): ?>
			<div class="reg-log-pager">
				<?php
					$prev = $page - 1;
					$next = $page + 1;
					$linkBase = '/master/log.php?'.($baseQs != '' ? $baseQs.'&' : '');
				?>
				<?php if ($page > 1): ?>
					<a href="<?=$linkBase?>page=1">처음</a>
					<a href="<?=$linkBase?>page=<?=$prev?>">이전</a>
				<?php endif; ?>
				<span><?=(int)$page?> / <?=(int)$totalPage?></span>
				<?php if ($page < $totalPage): ?>
					<a href="<?=$linkBase?>page=<?=$next?>">다음</a>
					<a href="<?=$linkBase?>page=<?=(int)$totalPage?>">끝</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'include.footer.php'; ?>
