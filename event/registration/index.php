<?php
	include $_SERVER['DOCUMENT_ROOT']."include.header.php";
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/func/class.Block.php';

	$num_per_page = $li_page ? $li_page : 50;
	$search_type = $search_type ? $search_type : 'and';
	$result_code = $result_code ? $result_code : '1';

	// 정렬 (등록번호·면허번호·DESK는 숫자, 나머지는 문자열 앞글자)
	$sort_sql = ' ORDER BY sid DESC';
	$sort_map = array(
		'etc_field2' => "CAST(SUBSTRING_INDEX(etc_field2, '-', -1) AS UNSIGNED)",
		'classification' => 'classification',
		'id' => 'id',
		'name_kr' => 'name_kr',
		'name_eng' => 'name_eng',
		'license_number' => 'CAST(license_number AS UNSIGNED)',
		'title' => 'title',
		'pay_status' => 'pay_status',
		'aff_kor' => 'aff_kor',
		'etc_field8' => 'etc_field8',
		'etc_field7' => 'CAST(etc_field7 AS UNSIGNED)'
	);
	if ($sort_field && isset($sort_map[$sort_field])) {
		$sort_sql = ' ORDER BY '.$sort_map[$sort_field];
		if ($orderby == 'asc' || $orderby == 'desc') {
			$sort_sql .= ' '.$orderby;
		}
	}

	// 검색 필드(eq: = / like: LIKE)
	$search_fields = array(
		'title' => 'eq',
		'classification' => 'eq',
		'pay_status' => 'eq',
		'etc_field7' => 'eq',
		'etc_field8' => 'eq',
		'id' => 'like',
		'name_kr' => 'like',
		'name_eng' => 'like',
		'license_number' => 'like',
		'aff_kor' => 'like',
		'cell' => 'like',
		'etc_field2' => 'like'
	);

	$search_query = array();
	$search_url = '';

	foreach ($search_fields as $field => $op) {
		$value = isset($_REQUEST[$field]) ? $_REQUEST[$field] : '';
		if ($value == '') {
			continue;
		}

		if ($field == 'aff_kor') {
			$search_query[] = " (aff_kor like '%".$value."%' OR aff_eng like '%".$value."%') ";
		} else if ($op == 'eq') {
			$search_query[] = " ".$field." = '".$value."' ";
		} else {
			$search_query[] = " ".$field." like '%".$value."%' ";
		}
		$search_url .= '&'.$field.'='.$value;
	}

	if ($li_page) {
		$search_url .= '&li_page='.$li_page;
	}
	$search_url .= '&result_code='.$result_code;

	$fsql = " WHERE del='N'";
	if ($search_query) {
		$fsql = ' WHERE '.implode($search_type, $search_query)." AND del='N'";
	}

	// 1일차 이전일 경우 1일 처리 & 최대 5일까지만 처리
	$eventDays = ((strtotime($_Webinar['edate']) - strtotime($_Webinar['sdate'])) / 86400) + 1;
	if ($eventDays < 1) {
		$eventDays = 1;
	} else if ($eventDays > 5) {
		$eventDays = 5;
	}

	$totalRecord = $conn->getOne('SELECT COUNT(*) FROM registration_tbl'.$fsql);
	if (DB::isError($totalRecord)) {
		die($totalRecord->getMessage());
	}

	$pageNav = new Page($page, $totalRecord, $num_per_page);
	$totalPage = $pageNav->getTotalPage();

	$checkinSelect = '';
	for ($di = 1; $di <= $eventDays; $di++) {
		$checkinSelect .= ', (SELECT c.first_date FROM checkin_tbl c'
			. ' WHERE c.usid = registration_tbl.sid AND c.day = '.$di.' LIMIT 1) AS ci_in'.$di
			. ', (SELECT c.last_date FROM checkin_tbl c'
			. ' WHERE c.usid = registration_tbl.sid AND c.day = '.$di.' LIMIT 1) AS ci_out'.$di;
	}
	$query = 'SELECT registration_tbl.*'.$checkinSelect.' FROM registration_tbl'.$fsql.$sort_sql;
	$query .= ' LIMIT '.$pageNav->getFirstRecordInPage().','.$num_per_page;
	master_echo($query);

	$result = $conn->query($query);
	if (DB::isError($result)) {
		die($result->getMessage());
	}

	$virtualRecordNo = $pageNav->getVirtualRecordNoInPage($totalRecord);

	// 페이징 블록
	$blockNav = new Block('', $totalPage, $page_per_block);
	$totalBlock = $blockNav->getTotalBlock();
	$blockNav->setBlock($page);
	$block = $blockNav->getBlock();
	$firstPageInBlock = $blockNav->getFirstPageInBlock();
	$lastPageInBlock = $blockNav->getLastPageInBlock();
	if ($block >= $totalBlock) {
		$lastPageInBlock = $totalPage;
	}

	$printDay1 = $_Webinar['sdate'];
	$printDay2 = date('Y-m-d', strtotime($_Webinar['sdate'].' +1 day'));
	$printDay3 = $_Webinar['edate'];
	$print_cnt = $conn->getOne("SELECT COUNT(*) FROM registration_tbl WHERE print_date>0 AND del='N'");
	$printDay1_cnt = $conn->getOne("SELECT COUNT(*) FROM registration_tbl WHERE DATE(FROM_UNIXTIME(print_date))='".$printDay1."' AND del='N'");
	$printDay2_cnt = $conn->getOne("SELECT COUNT(*) FROM registration_tbl WHERE DATE(FROM_UNIXTIME(print_date))='".$printDay2."' AND del='N'");
	$printDay3_cnt = $conn->getOne("SELECT COUNT(*) FROM registration_tbl WHERE DATE(FROM_UNIXTIME(print_date))='".$printDay3."' AND del='N'");

?>
<div class="searchArea">
	<form id="searchF" name="searchF" action="<?=$PHP_SELF?>" method="post">
		<input type="hidden" name="result_code" value="<?=$result_code?>">
		<fieldset>
			<legend>상세 검색</legend>
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
						<th>연락처</th>
						<td class="al">
							<input type="text" name="cell" id="cell" value="<?=$cell?>" style="width:95%;">
						</td>
						<th>카테고리</th>
						<td class="al">
							<select name="title" style="height:30px;width:95%;">
								<option value="">선택</option>
								<?php if ($_ONSITE['fee_kor']): ?>
									<optgroup label="국내">
										<?php foreach ($_ONSITE['fee_kor'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title==$tkey?'selected':''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
								<?php if ($_ONSITE['fee_eng']): ?>
									<optgroup label="국외">
										<?php foreach ($_ONSITE['fee_eng'] as $tkey => $tval): ?>
											<option value="<?=$tkey?>" <?=$title==$tkey?'selected':''?>><?=$tval['title']?></option>
										<?php endforeach; ?>
									</optgroup>
								<?php endif; ?>
							</select>
						</td>
						<th>등록구분</th>
						<td class="al">
							<select name="classification" style="height:30px;width:80%;">
								<option value="">선택</option>
								<?php foreach ($_REG['class_kind'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$classification==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th>결제상태</th>
						<td class="al">
							<select name="pay_status" style="height:30px;width:80%;">
								<option value="">선택</option>
								<?php foreach ($_REG['pay_status_txt'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$pay_status==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th>VIP</th>
						<td class="al">
							<select name="etc_field8" style="height:30px;width:80%;">
								<option value="">선택</option>
								<?php foreach ($_REG['vip'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$etc_field8==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<th>DESK</th>
						<td class="al">
							<select name="etc_field7" style="height:30px;width:80%;">
								<option value="">선택</option>
								<?php foreach ($_REG['desk'] as $tkey => $tval): ?>
									<option value="<?=$tkey?>" <?=$etc_field7==$tkey?'selected':''?>><?=$tval?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<th>등록번호</th>
						<td class="al">
							<input type="text" name="etc_field2" id="etc_field2" value="<?=$etc_field2?>" style="width:95%;">
						</td>
						<td colspan="6"></td>
					</tr>
				</tbody>
			</table>
			<div class="btn btnArea">
				<input type="submit" value="검색" class="btnDef">
				<input type="button" value="검색초기화" class="btnGrey" onclick="location.href='<?=$PHP_SELF?>?result_code=<?=$result_code?>'">
				<input type="button" value="Excel Backup" onclick="location.href='excel.php?<?=$search_url?>'" class="btnGreen2 initialism fade_open btn btn-success ex_btn">
				<input type="button" value="통계" onclick="popup_call('registration/statistics','')" class="btnYellow">
			</div>
		</fieldset>
	</form>
</div>
<!-- <div style="font-size:19px;font-weight:bold;margin-left:20px;">&nbsp;&nbsp;&nbsp;PRINT : <?=$print_cnt?> (Day1 : <?=$printDay1_cnt?> / Day2 : <?=$printDay2_cnt?> / Day3 : <?=$printDay3_cnt?>)</div> -->
<style>
	.reg-list-tbl {table-layout:fixed;width:100%;}
	table.tblDef.reg-list-tbl > * > tr > th,
	table.tblDef.reg-list-tbl > * > tr > td {
		word-break:break-all;
		overflow:visible;
	}
	.reg-list-tbl select {max-width:100%;box-sizing:border-box;}
</style>
<div class="contents" style="overflow-x:auto;">
	<div class="btn bp5" style="text-align:right;">
		<a href="javascript:popup_call('registration/postform','')" class="btnGrey withIcon"><i class="fas fa-edit"></i>임의 등록</a>
		<a href="javascript:popup_call('excel/upload','kind=registration')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Excel Upload</a>
		<a href="javaScript:check_print();" class="btnGreen2 withIcon"><i class="fas fa-download" style="font-size:15px;padding-top:0px;"></i>선택 출력</a>
	</div>
	<table class="tblDef reg-list-tbl">
		<colgroup>
			<col style="width: 3%;">
			<col style="width: 5%;">
			<col style="width: 4%;">
			<col class="col-id" style="width: 10%;">
			<col style="width: 5%;">
			<col style="width: 5.5%;">
			<col style="width: 5%;">
			<col style="width: 7%;">
			<col style="width: 6%;">
			<col class="col-aff" style="width: 10%;">
			<col style="width: 5%;">
			<col style="width: 3%;">
			<col style="width: 5.5%;">
			<?php for ($di = 1; $di <= $eventDays; $di++): ?>
				<col style="width: 4%;">
			<?php endfor; ?>
			<col style="width: 4%;">
			<col style="width: 3%;">
			<col style="width: 3%;">
			<col style="width: 3%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th><?=admin_orderby("등록번호","etc_field2",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("등록구분","classification",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("ID","id",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("성명","name_kr",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("성명(영문)","name_eng",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("면허번호","license_number",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("카테고리","title",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("결제상태","pay_status",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("소속","aff_kor",$sort_field,$orderby,$search_url)?></th>
				<th>연락처</th>
				<th><?=admin_orderby("VIP","etc_field8",$sort_field,$orderby,$search_url)?></th>
				<th><?=admin_orderby("DESK","etc_field7",$sort_field,$orderby,$search_url)?></th>
				<?php for ($di = 1; $di <= $eventDays; $di++): ?>
					<th><?=$di?>일차 입/퇴</th>
				<?php endfor; ?>
				<th>관리</th>
				<th>Memo</th>
				<th>Print</th>
				<th>
					<input type="checkbox" class="allchk2" style="margin:0px;width:20px;height:20px;">
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				while (is_array($d = $result->fetchRow(DB_FETCHMODE_ASSOC))):
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

					$classLabel = isset($_REG['class_kind'][$d['classification']]) ? $_REG['class_kind'][$d['classification']] : '';
					$vipLabel = ($d['etc_field8'] == 'Y') ? $_REG['vip']['Y'] : '';
					$memoStyle = $d['memo'] ? 'color:red;' : '';
					$affLabel = $isOverseas ? $d['aff_eng'] : $d['aff_kor'];

					$dayTimes = array();
					for ($di = 1; $di <= $eventDays; $di++) {
						$inTs = isset($d['ci_in'.$di]) ? (int)$d['ci_in'.$di] : 0;
						$ciOut = isset($d['ci_out'.$di]) ? (int)$d['ci_out'.$di] : 0;
						$manualOut = isset($d['logout_day'.$di]) ? (int)$d['logout_day'.$di] : 0;
						$outTs = ($ciOut > $manualOut) ? $ciOut : $manualOut;
						if ($inTs <= 0 && $outTs <= 0) {
							$dayTimes[$di] = '';
							continue;
						}
						$inTxt = ($inTs > 0) ? date('H:i', $inTs) : '-';
						$outTxt = ($outTs > 0) ? date('H:i', $outTs) : '-';
						$dayTimes[$di] = $inTxt.' / '.$outTxt;
					}
			?>
				<tr>
					<td><?=$virtualRecordNo?></td>
					<td><?=$d['etc_field2']?></td>
					<td><?=$classLabel?></td>
					<td class="col-id"><?=$d['id']?></td>
					<td><?=$d['name_kr']?></td>
					<td><?=$d['name_eng']?></td>
					<td><?=$d['license_number']?></td>
					<td><?=$feeLabel?></td>
					<td>
						<select onchange="status_change(<?=(int)$d['sid']?>,this.value)">
							<option value="" <?=$d['pay_status']==''?'selected':''?>>선택</option>
							<?php foreach ($_REG['pay_status_txt'] as $pkey => $pval): ?>
								<option value="<?=$pkey?>" <?=$d['pay_status']==$pkey?'selected':''?>><?=$pval?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<td class="col-aff"><?=$affLabel?></td>
					<td><?=$d['cell']?></td>
					<td><?=$vipLabel?></td>
					<td>
						<select onchange="desk_change(<?=(int)$d['sid']?>,this.value)">
							<option value="">선택</option>
							<?php foreach ($_REG['desk'] as $dkey => $dval): ?>
								<option value="<?=$dkey?>" <?=$d['etc_field7']==$dkey?'selected':''?>><?=$dval?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<?php for ($di = 1; $di <= $eventDays; $di++): ?>
						<td><?=$dayTimes[$di]?></td>
					<?php endfor; ?>
					<td>
						<img src="/image/icon_modify.png" alt="수정" class="hand" onclick="popup_call('registration/postform','sid=<?=(int)$d['sid']?>')">
						<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=(int)$d['sid']?>','registration')">
					</td>
					<td>
						<i class="far fa-sticky-note" style="font-size:18px;<?=$memoStyle?>" onclick="popup_call('registration/memo','sid=<?=(int)$d['sid']?>')"></i>
					</td>
					<td>
						<i class="far fa-address-card" style="font-size:22px;" onclick="window.open('print_all.php?chk_num[]=<?=(int)$d['sid']?>','','width=1024,height=1500')"></i>
						<?php if($d['print_date']>0): ?>
							<div><?=date("H:i",$d['print_date'])?></div>
						<?php endif;?>
					</td>
					<td>
						<input type="checkbox" name="chk_num[]" class="chk_list" value="<?=(int)$d['sid']?>" style="margin:0px;width:20px;height:20px;">
					</td>
				</tr>
			<?php
					$virtualRecordNo--;
				endwhile;
			?>
		</tbody>
	</table>
	<?php
		if ($add_search2) {
			$search_url .= $add_search2;
		}
		if ($sort_field) {
			$search_url .= '&sort_field='.$sort_field;
		}
		if ($orderby) {
			$search_url .= '&orderby='.$orderby;
		}
		$excel_kind = 'exam_result';
	?>
	<div class="btnArea posRel">
		<?php include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.page.php"; ?>
	</div>
</div>
<script>
	$(function(){
		$('.allchk2').on('click',function(){
			if($(this).is(':checked')==true){
				$('.chk_list').prop('checked',true);
			}else{
				$('.chk_list').prop('checked',false);
			}
		});
	});
	function status_change(sid, val) {
		$.ajax({
			type: 'POST',
			url: '/registration/pay_status_reg.php',
			data: 'sid=' + sid + '&chkval=' + val,
			async: false,
			success: function (msg) {
				if (msg != 'Y') {
					alert('통신에 실패하였습니다.');
				}
			}
		});
	}
	function desk_change(sid, val) {
		$.ajax({
			type: 'POST',
			url: '/registration/desk_reg.php',
			data: 'sid=' + sid + '&chkval=' + val,
			async: false,
			success: function (msg) {
				if (msg != 'Y') {
					alert('통신에 실패하였습니다.');
				}
			}
		});
	}
	function check_print(){
		if( $("input:checkbox[name='chk_num[]']").is(":checked") == false ){
			alert("선택된 데이터가 없습니다.");
			return false;
		}else{
			var get_text = "";
			$("input:checkbox[name='chk_num[]']:checked").each(function(){
				get_text += "&chk_num[]="+$(this).val();
			});
			
			window.open("print_all.php?"+get_text,"","width=1024,height=1500");
		}
	}
</script>
<?php include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"; ?>
