<?php
	include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'func/config_time.php';

	$admin_yn = 'Y';
	$sid = isset($sid) ? (int)$sid : 0;
	$eventDays = ((strtotime($_Webinar['edate']) - strtotime($_Webinar['sdate'])) / 86400) + 1;
	if ($eventDays < 1) {
		$eventDays = 1;
	} else if ($eventDays > 5) {
		$eventDays = 5;
	}
	$date_count = $eventDays;
	$ex_sdate = explode('-', $_Webinar['sdate']);

	$d = array();
	if ($sid > 0) {
		$result = $conn->query('SELECT * FROM registration_tbl WHERE sid = ?', array($sid));
		if (DB::isError($result)) {
			error_log('[Registration] select failed: sid='.$sid.' '.$result->getMessage());
			die($result->getMessage());
		}
		$result->fetchInto($d, DB_FETCHMODE_ASSOC);
		$result->free();
	}
	if (!$sid) {
		$d['login1'] = 'Y';
		$d['login2'] = 'Y';
		$d['login3'] = 'Y';
		$d['login4'] = 'Y';
		$d['login5'] = 'Y';
		$d['etc_field9'] = 'ADMIN';
		$d['pay_status'] = 'N';
		$d['classification'] = 'C';
	}

	// 출결 시각: checkin 전체 컬럼(세션 포함) + registration login/logout
	$checkinByDay = array();
	if ($sid > 0) {
		$ciRes = $conn->query(
			'SELECT * FROM checkin_tbl WHERE usid = ?',
			array($sid)
		);
		if (DB::isError($ciRes)) {
			error_log('[Registration] checkin select failed: sid='.$sid.' '.$ciRes->getMessage());
		} else {
			while (is_array($ciRow = $ciRes->fetchRow(DB_FETCHMODE_ASSOC))) {
				$ciDay = (int)$ciRow['day'];
				if ($ciDay >= 1 && $ciDay <= $eventDays) {
					$checkinByDay[$ciDay] = $ciRow;
				}
			}
			$ciRes->free();
		}
	}

	$attendTimes = array();
	for ($date = 1; $date <= $eventDays; $date++) {
		$loginDay = isset($d['login_day'.$date]) ? (int)$d['login_day'.$date] : 0;
		$logoutDay = isset($d['logout_day'.$date]) ? (int)$d['logout_day'.$date] : 0;
		$ciIn = 0;
		$ciOut = 0;
		$spanFirst = 0;
		$spanLast = 0;
		if (isset($checkinByDay[$date])) {
			$ciIn = isset($checkinByDay[$date]['first_date']) ? (int)$checkinByDay[$date]['first_date'] : 0;
			$ciOut = isset($checkinByDay[$date]['last_date']) ? (int)$checkinByDay[$date]['last_date'] : 0;
			$span = getDayFirstLastTime($date, $checkinByDay[$date]);
			if ($span) {
				$spanFirst = (int)$span['first'];
				$spanLast = (int)$span['last'];
			}
		}
		$inTs = $ciIn;
		if ($spanFirst > 0 && ($inTs < 1 || $spanFirst < $inTs)) {
			$inTs = $spanFirst;
		}
		if ($inTs < 1) {
			$inTs = $loginDay;
		}
		$outTs = $ciOut;
		if ($logoutDay > $outTs) {
			$outTs = $logoutDay;
		}
		if ($spanLast > $outTs && $spanLast > $inTs) {
			$outTs = $spanLast;
		}
		if ($inTs > 0 && $outTs > 0) {
			$inMin = $inTs - ($inTs % 60);
			$outMin = $outTs - ($outTs % 60);
			if ($outMin <= $inMin) {
				$outTs = 0;
			}
		}
		$attendTimes[$date] = array(
			'in' => ($inTs > 0) ? date('Y-m-d H:i', $inTs) : '',
			'out' => ($outTs > 0) ? date('Y-m-d H:i', $outTs) : ''
		);
	}

	$payDateVal = isset($d['pay_date']) ? trim($d['pay_date']) : '';
	if ($payDateVal != '') {
		$payTs = strtotime($payDateVal);
		if ($payTs > 0) {
			$payDateVal = date('Y-m-d H:i', $payTs);
		}
	}

	$isDomestic = ($d['country'] == 'K');
	$isOverseas = ($d['country'] == 'F');
	if ($isDomestic) {
		$d['etc_field1'] = 'Korea';
	}

	$groupKeyLabel = isset($d['group_key']) ? $d['group_key'] : '';
	if($groupKeyLabel == 'K') {
		$groupKeyLabel = '국내';
	} else if($groupKeyLabel == 'F') {
		$groupKeyLabel = '국외';
	}
?>
<link rel="stylesheet" href="/css/pickout.css">
<style>
	.pk-field{width:300px !important;border-color:red;}	
	.pk-search{width:90%;}
	.pk-modal{padding:0; margin:0;width:30%;}
	ul  {list-style: disc; font-size: 14px;    padding: 5px 15px 5px 25px; border: 1px solid #c1c1c1;background: #e5e5e5;}
	li{    line-height: 22px;}
	[type=checkbox], label {cursor: pointer;}
	td {height:30px;}
</style>
<link rel="stylesheet" href="/script/flatpickr/flatpickr.min.css">
<script src="/script/flatpickr/flatpickr.min.js"></script>
<script src="/script/flatpickr/l10n/ko.js"></script>
<div class="popupCon" id="" style="width:920px;padding:20px;background:#ffffff;">
	<form method="post" name="postForm" id="postForm" action="post.php" enctype="multipart/form-data">
		<input type="hidden" name="sid" id="sid" value="<?=(int)$sid?>">
		<table class="tblDef inputTbl" style="width:100%;">
			<colgroup>
				<col style="width: 5%;">
				<col style="width: 40%;">
				<col style="width:5%;">
				<col style="width: 40%;">
			</colgroup>
			<tbody>
				<tr>
					<th>관리자</th>
					<td colspan='3' class="al">
						<input type="checkbox" name="member_level" id="member_level" value="M" <?=$d['member_level']=='M' ? 'checked' : ''?>>
						<label for="member_level">관리자일 경우에만 선택해주세요</label>
					</td>
				</tr>
				<tr>
					<th>등록구분</th>
					<td class="al">
						<select name="classification" id="classification" >
							<option value="">선택</option>
							<?php foreach($_REG['class_kind'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['classification'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						Group : <?=$groupKeyLabel?>
					</td>
					<th>Title</th>
					<td class="al">
						<select name="reg_kind" id="reg_kind" >
							<option value="">선택</option>
							<?php foreach($_REG['reg_kind'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['reg_kind'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>참가구분(카테고리)</th>
					<td class="al">
						<select id="titleKor" style="<?=$isOverseas ? 'display:none;' : ''?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['fee_kor'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['title'] ? 'selected' : ''?>><?=$tval['title']?></option>
							<?php endforeach; ?>
						</select>
						<select id="titleEng" style="<?=$isOverseas ? '' : 'display:none;'?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['fee_eng'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['title'] ? 'selected' : ''?>><?=$tval['title']?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="title" id="title" value="<?=$d['title']?>">
					</td>
					<th>결제상태</th>
					<td class="al">
						<select name="pay_status" id="pay_status">
							<option value="">선택</option>
							<?php foreach($_REG['pay_status_txt'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['pay_status'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th>무료</th>
					<td class="al">
						<input type="checkbox" name="free_yn" id="free_yn" value="Y" <?=$d['free_yn']=='Y' ? 'checked' : ''?>>
						<label for="free_yn">무료</label>
					</td>
					<th>등록비 금액</th>
					<td class="al">
						<input type="text" id="reg_fee" name="reg_fee" value="<?=$d['reg_fee']?>" style="width:100%;">
					</td>
				</tr>
				<tr>
					<th>결제일자</th>
					<td class="al">
						<input type="text" id="pay_date" name="pay_date" class="js-pay-date" value="<?=$payDateVal?>" style="width:100%;" readonly>
					</td>
					<th>결제방법</th>
					<td class="al">
						<select id="payKor" style="<?=$isOverseas ? 'display:none;' : ''?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['pay_method_kor'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['etc_field5'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						<select id="payEng" style="<?=$isOverseas ? '' : 'display:none;'?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['pay_method_eng'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['etc_field5'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="etc_field5" id="etc_field5" value="<?=$d['etc_field5']?>">
					</td>
				</tr>
				<tr>
					<th>등록경로</th>
					<td class="al">
						<select name="etc_field9" id="etc_field9">
							<option value="">선택</option>
							<?php foreach($_REG['reg_source'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['etc_field9'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<th>VIP</th>
					<td class="al">
						<input type="checkbox" name="etc_field8" id="etc_field8" value="Y" <?=$d['etc_field8']=='Y' ? 'checked' : ''?>>
						<label for="etc_field8">VIP</label>
					</td>
				</tr>
				<tr>
					<th>국내/외</th>
					<td class="al">
						<select name="country" id="country">
							<option value="">선택</option>
							<?php foreach($_REG['reg_country'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['country'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
					</td>
					<th>국가</th>
					<td class="al">
						<input type="text" id="nationKorea" value="Korea" readonly style="width:100%;<?=$isDomestic ? '' : 'display:none;'?>">
						<select id="nationSelect" style="width:100%;<?=$isOverseas ? '' : 'display:none;'?>">
							<option value="">선택</option>
							<?php foreach ($_Flag['country'] as $iso => $cinfo): ?>
								<?php if ($iso == 'KR' || $cinfo['cn'] == '') continue; ?>
								<option value="<?=htmlspecialchars($cinfo['cn'], ENT_QUOTES, 'UTF-8')?>" <?=$d['etc_field1']==$cinfo['cn'] ? 'selected' : ''?>><?=htmlspecialchars($cinfo['cn'], ENT_QUOTES, 'UTF-8')?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="etc_field1" id="etc_field1" value="<?=htmlspecialchars($d['etc_field1'], ENT_QUOTES, 'UTF-8')?>">
					</td>
				</tr>
				<tr>
					<th>ID</th>
					<td class="al">
						<input type="text" id="id" name="id" value="<?=$d['id']?>" style="width:100%;" >
					</td>
					<th>비밀번호</th>
					<td class="al">
						<input type="text" id="passwd" name="passwd" value="<?=$d['passwd']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>성명</th>
					<td class="al">
						<input type="text" id="name_kr" name="name_kr" value="<?=$d['name_kr']?>" style="width:100%;" >
					</td>
					<th>성명(영문)</th>
					<td class="al">
						<input type="text" id="name_eng" name="name_eng" value="<?=$d['name_eng']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>First Name</th>
					<td class="al">
						<input type="text" id="first_name" name="first_name" value="<?=$d['first_name']?>" style="width:100%;" >
					</td>
					<th>Last Name</th>
					<td class="al">
						<input type="text" id="last_name" name="last_name" value="<?=$d['last_name']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>등록번호</th>
					<td class="al">
						<input type="text" id="etc_field2" name="etc_field2" value="<?=$d['etc_field2']?>" style="width:100%;" >
					</td>
					<th>면허번호</th>
					<td class="al">
						<input type="text" id="license_number" name="license_number" value="<?=$d['license_number']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>소속</th>
					<td class="al">
						<input type="text" id="aff_kor" name="aff_kor" value="<?=$d['aff_kor']?>" style="width:100%;" >
					</td>
					<th>소속(영문)</th>
					<td class="al">
						<input type="text" id="aff_eng" name="aff_eng" value="<?=$d['aff_eng']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>부서(국문)</th>
					<td class="al">
						<input type="text" id="depart_kor" name="depart_kor" value="<?=$d['depart_kor']?>" style="width:100%;" >
					</td>
					<th>부서(영문)</th>
					<td class="al">
						<input type="text" id="depart_eng" name="depart_eng" value="<?=$d['depart_eng']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>구분 선택<br>(국내등록)</th>
					<td class="al">
						<select name="gubun1" id="gubun1">
							<option value="">선택</option>
							<?php foreach($_ONSITE['gubun1'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['gubun1'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						<input type="text" id="etc_field3" name="etc_field3" value="<?=$d['etc_field3']?>" style="width:40%;" placeholder="기타">
					</td>
					<th>Specialty<br>(국외등록)</th>
					<td class="al">
						<select id="gubun2Kor" style="<?=$isOverseas ? 'display:none;' : ''?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['gubun2_kor'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['gubun2'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						<select id="gubun2Eng" style="<?=$isOverseas ? '' : 'display:none;'?>">
							<option value="">선택</option>
							<?php foreach ($_ONSITE['gubun2_eng'] as $tkey => $tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['gubun2'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" name="gubun2" id="gubun2" value="<?=$d['gubun2']?>">
					</td>
				</tr>
				<tr>
					<th>E-mail</th>
					<td class="al">
						<input type="text" id="email" name="email" value="<?=$d['email']?>" style="width:100%;" >
					</td>
					<th>연락처</th>
					<td class="al">
						<input type="text" id="cell" name="cell" value="<?=$d['cell']?>" style="width:100%;" >
					</td>
				</tr>
				<tr>
					<th>Ribbon Information</th>
					<td class="al">
						<input type="text" id="etc_field6" name="etc_field6" value="<?=$d['etc_field6']?>" style="width:100%;" >
						<div style="margin-top:4px;font-size:12px;color:#666;line-height:1.4;">소속(영문)이 없을 때 명찰에 표시됩니다.</div>
					</td>
					<th>DESK</th>
					<td class="al">
						<select name="etc_field7" id="etc_field7">
							<option value="">선택</option>
							<?php foreach($_REG['desk'] as $tkey=>$tval): ?>
								<option value="<?=$tkey?>" <?=$tkey==$d['etc_field7'] ? 'selected' : ''?>><?=$tval?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<?php
					$showLectureAttend = (isset($_CONFIG['show_lecture_attend']) && $_CONFIG['show_lecture_attend']);
					$showLoginAttend = (isset($_CONFIG['show_login_attend']) && $_CONFIG['show_login_attend']);
				?>
				<?php if ($showLoginAttend || $showLectureAttend): ?>
					<?php for($date=1;$date<=$date_count;$date++): ?>
						<tr>
							<?php if ($showLoginAttend): ?>
								<th >로그인 <?=date("m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></th>
								<td class="al"<?=$showLectureAttend ? '' : ' colspan="3"'?>>
									<input type="checkbox" name="login<?=$date?>" id="login<?=$date?>" value="Y" <?=$d['login'.$date]=='Y' ? 'checked' : ''?>>
									<label for="login<?=$date?>">입장</label>
								</td>
							<?php endif; ?>
							<?php if ($showLectureAttend): ?>
								<th >강의장입장 <?=date("m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></th>
								<td class="al"<?=$showLoginAttend ? '' : ' colspan="3"'?>>
									<input type="checkbox" name="lecture<?=$date?>" id="lecture<?=$date?>" value="Y" <?=$d['lecture'.$date]=='Y' ? 'checked' : ''?>>
									<label for="lecture<?=$date?>">입장</label>
								</td>
							<?php endif; ?>
						</tr>
					<?php endfor; ?>
				<?php endif; ?>
				<?php for ($date = 1; $date <= $eventDays; $date++): ?>
					<tr>
						<th><?=$date?>일차 입장</th>
						<td class="al">
							<input type="text" name="login_day<?=$date?>" id="login_day<?=$date?>" class="js-attend-time" value="<?=$attendTimes[$date]['in']?>" style="width:100%;" autocomplete="off">
						</td>
						<th><?=$date?>일차 퇴장</th>
						<td class="al">
							<input type="text" name="logout_day<?=$date?>" id="logout_day<?=$date?>" class="js-attend-time" value="<?=$attendTimes[$date]['out']?>" style="width:100%;" autocomplete="off">
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
		<div class="btnArea btn">
			<input type="submit" value="<?=$sid ? '수정' : '저장'?>" class="btnPoint btnBig">
			<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
		</div>
	</form>
</div>
<script>
	$(function(){
		$('#Popup_Title').html('Registration');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,1200);

		function syncCountryFields() {
			const country = $('#country').val();
			if (country == 'K') {
				$('#nationKorea').show();
				$('#nationSelect').hide();
				$('#etc_field1').val('Korea');
				$('#titleKor, #gubun2Kor, #payKor').show();
				$('#titleEng, #gubun2Eng, #payEng').hide();
				$('#title').val($('#titleKor').val());
				$('#gubun2').val($('#gubun2Kor').val());
				$('#etc_field5').val($('#payKor').val());
			} else if (country == 'F') {
				$('#nationKorea').hide();
				$('#nationSelect').show();
				$('#etc_field1').val($('#nationSelect').val());
				$('#titleKor, #gubun2Kor, #payKor').hide();
				$('#titleEng, #gubun2Eng, #payEng').show();
				$('#title').val($('#titleEng').val());
				$('#gubun2').val($('#gubun2Eng').val());
				$('#etc_field5').val($('#payEng').val());
			} else {
				$('#nationKorea, #nationSelect').hide();
				$('#etc_field1').val('');
			}
		}

		$('#country').on('change', syncCountryFields);
		$('#nationSelect').on('change', function(){
			$('#etc_field1').val($(this).val());
		});
		$('#titleKor, #titleEng').on('change', function(){
			const key = $(this).val();
			$('#title').val(key);
			$('.title_sub_area').load('/registration/change_title.php?key='+key);
		});
		$('#gubun2Kor, #gubun2Eng').on('change', function(){
			$('#gubun2').val($(this).val());
		});
		$('#payKor, #payEng').on('change', function(){
			$('#etc_field5').val($(this).val());
		});

		flatpickr('.js-attend-time', {
			enableTime: true,
			time_24hr: true,
			dateFormat: 'Y-m-d H:i',
			allowInput: true,
			locale: 'ko'
		});
		flatpickr('.js-pay-date', {
			enableTime: true,
			time_24hr: true,
			dateFormat: 'Y-m-d H:i',
			allowInput: true,
			locale: 'ko'
		});
	});
</script>