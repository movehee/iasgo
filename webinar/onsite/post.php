<?php
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		PutMessageLocation('잘못된 접근입니다.', '/');
	}

	$regType = isset($_POST['reg_type']) ? trim($_POST['reg_type']) : '';
	if ($regType != 'K' && $regType != 'F') {
		PutMessageBack('등록 구분이 올바르지 않습니다.');
	}

	// 국내 K / 국외 F
	$isDomestic = ($regType == 'K');

	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$email = preg_replace('/\s+/', '', $email);
	$nationCode = isset($_POST['nation_code']) ? trim($_POST['nation_code']) : '';
	$firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
	$firstName = str_replace(array("\xE2\x80\x98", "\xE2\x80\x99", "\xCA\xBC"), "'", $firstName);
	$firstName = str_replace(array("\xE2\x80\x93", "\xE2\x80\x94"), '-', $firstName);
	$firstName = preg_replace('/\s+/', ' ', $firstName);
	$lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
	$lastName = str_replace(array("\xE2\x80\x98", "\xE2\x80\x99", "\xCA\xBC"), "'", $lastName);
	$lastName = str_replace(array("\xE2\x80\x93", "\xE2\x80\x94"), '-', $lastName);
	$lastName = preg_replace('/\s+/', ' ', $lastName);
	$nameKr = isset($_POST['name_kr']) ? trim($_POST['name_kr']) : '';
	$nameKr = preg_replace('/\s+/', '', $nameKr);
	$affKor = isset($_POST['aff_kor']) ? trim($_POST['aff_kor']) : '';
	$affEng = isset($_POST['aff_eng']) ? trim($_POST['aff_eng']) : '';
	$departKor = isset($_POST['depart_kor']) ? trim($_POST['depart_kor']) : '';
	$departEng = isset($_POST['depart_eng']) ? trim($_POST['depart_eng']) : '';
	$cellRaw = isset($_POST['cell']) ? preg_replace('/[^0-9]/', '', $_POST['cell']) : '';
	$licenseNumber = isset($_POST['license_number']) ? preg_replace('/[^0-9]/', '', $_POST['license_number']) : '';
	$gubun1 = isset($_POST['gubun1']) ? trim($_POST['gubun1']) : '';
	$gubun1Etc = isset($_POST['gubun1_etc']) ? trim($_POST['gubun1_etc']) : '';
	$gubun2 = isset($_POST['gubun2']) ? trim($_POST['gubun2']) : '';
	$gubun2Etc = isset($_POST['gubun2_etc']) ? trim($_POST['gubun2_etc']) : '';
	$feeCode = isset($_POST['fee_code']) ? trim($_POST['fee_code']) : '';
	$payMethod = isset($_POST['pay_method']) ? trim($_POST['pay_method']) : '';
	$phonePrefix = isset($_POST['phone_prefix']) ? trim($_POST['phone_prefix']) : '';

	// 참석일은 관리자에서 설정 >> 현장등록에서는 저장 X
	$login1 = '';
	$login2 = '';
	$login3 = '';

	if ($email == '') {
		PutMessageBack($isDomestic ? 'E-mail을 입력해 주세요.' : 'Please enter your E-mail.');
	}
	if (!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email)) {
		PutMessageBack($isDomestic ? '올바른 E-mail 형식이 아닙니다.' : 'Please enter a valid E-mail address.');
	}
	$engNamePattern = '/^[A-Za-z]+([\'-][A-Za-z]+)*( [A-Za-z]+([\'-][A-Za-z]+)*)*$/';
	if (!preg_match($engNamePattern, $firstName) || !preg_match($engNamePattern, $lastName)) {
		PutMessageBack($isDomestic ? '영문 성명은 영문만 입력해 주세요. (띄어쓰기, \', - 허용)' : 'Name must be English letters only (spaces, apostrophe, and hyphen allowed).');
	}

	$countryName = '';

	if ($isDomestic) {
		$nationCode = 'KR';
		$countryName = 'Korea';
		if ($nameKr == '' || !preg_match('/^[가-힣]+$/u', $nameKr)) {
			PutMessageBack('성명(국문)은 한글만, 공백 없이 입력해 주세요.');
		}
		if ($affKor == '') {
			PutMessageBack('소속 기관(국문)을 입력해 주세요.');
		}
		if ($affEng == '') {
			PutMessageBack('소속 기관(영문)을 입력해 주세요.');
		}
		if ($cellRaw == '') {
			PutMessageBack('핸드폰 번호를 입력해 주세요.');
		}
		if ($licenseNumber == '' || !preg_match('/^[0-9]+$/', $licenseNumber)) {
			PutMessageBack('의사면허 번호는 숫자만 입력해 주세요.');
		}
		if ($gubun1 == '' || !isset($_ONSITE['gubun1'][$gubun1])) {
			PutMessageBack('구분 선택을 해 주세요.');
		}
		if ($gubun1 == '99' && $gubun1Etc == '') {
			PutMessageBack('구분 기타 내용을 입력해 주세요.');
		}
		if ($gubun2 == '' || !isset($_ONSITE['gubun2_kor'][$gubun2])) {
			PutMessageBack('소속 선택을 해 주세요.');
		}
		if ($gubun2 == '99' && $gubun2Etc == '') {
			PutMessageBack('소속 기타 내용을 입력해 주세요.');
		}
		if ($feeCode == '' || !isset($_ONSITE['fee_kor'][$feeCode])) {
			PutMessageBack('등록비 카테고리를 선택해 주세요.');
		}
		if ($payMethod == '' || !isset($_ONSITE['pay_method_kor'][$payMethod])) {
			PutMessageBack('결제방법을 선택해 주세요.');
		}
		$cell = '+82-' . $cellRaw;
		$departEng = '';
	} else {
		if ($nationCode == '' || $nationCode == 'KR' || !isset($_Flag['country'][$nationCode])) {
			PutMessageBack('Please select your Country.');
		}
		$countryName = isset($_Flag['country'][$nationCode]['cn']) ? $_Flag['country'][$nationCode]['cn'] : $nationCode;
		if ($affEng == '') {
			PutMessageBack('Please enter your Affiliation.');
		}
		if ($phonePrefix == '') {
			$cnum = isset($_Flag['country'][$nationCode]['cnum']) ? $_Flag['country'][$nationCode]['cnum'] : '';
			if ($cnum != '') {
				$phonePrefix = '+' . $cnum;
			}
		}
		if ($cellRaw == '') {
			PutMessageBack('Please enter your Phone Number.');
		}
		if ($gubun2 != '' && !isset($_ONSITE['gubun2_eng'][$gubun2])) {
			PutMessageBack('Please select a valid Specialty.');
		}
		if ($feeCode == '' || !isset($_ONSITE['fee_eng'][$feeCode])) {
			PutMessageBack('Please select a Registration Fee category.');
		}
		if ($payMethod == '' || !isset($_ONSITE['pay_method_eng'][$payMethod])) {
			PutMessageBack('Please select a Payment Method.');
		}
		// cnum 없는 국가는 prefix X >> 번호만 저장
		if ($phonePrefix != '') {
			$cell = $phonePrefix . '-' . $cellRaw;
		} else {
			$cell = $cellRaw;
		}
		$nameKr = '';
		$affKor = '';
		$departKor = '';
		$licenseNumber = '';
		$gubun1 = '';
		$gubun1Etc = '';
		$gubun2Etc = '';
	}

	$id = $email;
	$nameEng = trim($firstName . ' ' . $lastName);
	$country = $isDomestic ? 'K' : 'F';
	$groupKey = $country;
	$classification = 'C';
	$payStatus = 'N';
	$del = 'N';
	$status = 'Y';
	$passwd = '';
	// 관리자 기준 매핑
	// etc_field1: 국가명 / etc_field2: 접수번호(관리자용, 비움)
	// etc_field3: 구분 기타 / etc_field4: 국가 / etc_field5: 결제수단
	// etc_field8: VIP / etc_field9: 등록경로(ONSITE)
	// title: 등록비 코드
	$etcField1 = $countryName;
	$etcField2 = '';
	$etcField3 = ($gubun1 == '99') ? $gubun1Etc : '';
	$etcField4 = $nationCode;
	$etcField5 = $payMethod;
	$etcField8 = '';
	$etcField9 = 'ONSITE';
	$title = $feeCode;
	$titleSub = ($gubun2 == '99') ? $gubun2Etc : '';
	// Title(reg_kind)은 현장등록에서 받지 않음 — DB 기본값 A(Dr.) 방지
	$regKind = '';
	// 등록비 금액 / 무료 여부 (국내=원, 국외=USD — country로 구분)
	if ($isDomestic) {
		$regFee = isset($_ONSITE['fee_kor'][$feeCode]['price']) ? $_ONSITE['fee_kor'][$feeCode]['price'] : 0;
	} else {
		$regFee = isset($_ONSITE['fee_eng'][$feeCode]['price']) ? $_ONSITE['fee_eng'][$feeCode]['price'] : 0;
	}
	$freeYn = ($regFee == 0) ? 'Y' : 'N';
	$payDate = '';

	// 이미 등록된 이메일 중복 체크
	$dupCnt = $conn->getOne(
		'SELECT COUNT(*) FROM registration_tbl WHERE del = ? AND (id = ? OR email = ?)',
		array($del, $id, $email)
	);
	if (DB::isError($dupCnt)) {
		error_log('[Onsite] duplicate check error: ' . $dupCnt->getMessage());
		PutMessageBack($isDomestic ? '등록 처리 중 오류가 발생했습니다.' : 'An error occurred during registration.');
	}
	if ($dupCnt > 0) {
		PutMessageBack($isDomestic ? '이미 등록된 E-mail입니다.' : 'This E-mail is already registered.');
	}

	// 국내등록 시 의사면허번호 중복 체크 (0000 제외)
	if ($isDomestic && $licenseNumber != '' && $licenseNumber != '0000') {
		$dupLicenseCnt = $conn->getOne(
			'SELECT COUNT(*) FROM registration_tbl WHERE del = ? AND license_number = ?',
			array($del, $licenseNumber)
		);
		if (DB::isError($dupLicenseCnt)) {
			error_log('[Onsite] license duplicate check error: ' . $dupLicenseCnt->getMessage());
			PutMessageBack('등록 처리 중 오류가 발생했습니다.');
		}
		if ($dupLicenseCnt > 0) {
			PutMessageBack('이미 등록된 의사면허 번호입니다.');
		}
	}

	$query = 'INSERT INTO registration_tbl SET'
		. ' id = ?'
		. ', email = ?'
		. ', passwd = ?'
		. ', first_name = ?'
		. ', last_name = ?'
		. ', name_kr = ?'
		. ', name_eng = ?'
		. ', aff_kor = ?'
		. ', aff_eng = ?'
		. ', depart_kor = ?'
		. ', depart_eng = ?'
		. ', cell = ?'
		. ', license_number = ?'
		. ', gubun1 = ?'
		. ', gubun2 = ?'
		. ', title = ?'
		. ', free_yn = ?'
		. ', reg_fee = ?'
		. ', title_sub = ?'
		. ', country = ?'
		. ', group_key = ?'
		. ', classification = ?'
		. ', reg_kind = ?'
		. ', pay_status = ?'
		. ', pay_date = ?'
		. ', del = ?'
		. ', status = ?'
		. ', etc_field1 = ?'
		. ', etc_field2 = ?'
		. ', etc_field3 = ?'
		. ', etc_field4 = ?'
		. ', etc_field5 = ?'
		. ', etc_field8 = ?'
		. ', etc_field9 = ?'
		. ', login1 = ?'
		. ', login2 = ?'
		. ', login3 = ?';

	$params = array(
		$id,
		$email,
		$passwd,
		$firstName,
		$lastName,
		$nameKr,
		$nameEng,
		$affKor,
		$affEng,
		$departKor,
		$departEng,
		$cell,
		$licenseNumber,
		$gubun1,
		$gubun2,
		$title,
		$freeYn,
		$regFee,
		$titleSub,
		$country,
		$groupKey,
		$classification,
		$regKind,
		$payStatus,
		$payDate,
		$del,
		$status,
		$etcField1,
		$etcField2,
		$etcField3,
		$etcField4,
		$etcField5,
		$etcField8,
		$etcField9,
		$login1,
		$login2,
		$login3
	);

	$result = $conn->query($query, $params);
	if (DB::isError($result)) {
		error_log('[Onsite] insert error: ' . $result->getMessage());
		PutMessageBack($isDomestic ? '등록 처리 중 오류가 발생했습니다.' : 'An error occurred during registration.');
	}

	$completeUrl = $isDomestic ? '/onsite/complete_domestic.php' : '/onsite/complete_overseas.php';
	$msg = $isDomestic ? '등록이 완료되었습니다.' : 'Your registration is complete.';
	PutMessageLocation($msg, $completeUrl);
?>
