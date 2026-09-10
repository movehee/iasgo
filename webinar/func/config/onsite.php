<?php
	// 국내 등록 설정
	$_ONSITE['fee_kor'] = array(
		'A' => array('title' => 'IASGO / KSGC / KSSO Member', 'price' => 700000),
		'B' => array('title' => 'IASGO Non-Member/ 제약/ 의료기기 회사', 'price' => 1100000),
		'C' => array('title' => 'Trainee (전공의/전임의/수련의/인턴/군의관)', 'price' => 400000),
		'D' => array('title' => '[5인 이상 단체]Trainee (전공의/전임의/수련의/인턴/군의관)', 'price' => 350000),
		'E' => array('title' => '[Full days] 간호사/연구원/기타', 'price' => 140000),
		'F' => array('title' => '[1 day] 간호사/연구원/기타', 'price' => 70000),
		'G' => array('title' => '대학생, 학부생', 'price' => 0)
	);

	// 국외 등록 설정
	$_ONSITE['fee_eng'] = array(
		'A' => array('title' => 'IASGO Member', 'price' => 700),
		'B' => array('title' => 'IASGO Non-Member/ Pharmaceutical/ Medical device Company', 'price' => 1100),
		'C' => array('title' => 'Trainee (Intern/Resident/Fellow)', 'price' => 400),
		'D' => array('title' => '[Full days] Nurse/Technician/Others', 'price' => 140),
		'E' => array('title' => '[1 day] Nurse/Technician/Others', 'price' => 70),
		'F' => array('title' => 'Medical Student', 'price' => 0)
	);

	// gubun1 - 구분 선택 (국내)
	$_ONSITE['gubun1'] = array(
		'1' => '전문의',
		'2' => '봉직의',
		'3' => '전공의',
		'4' => '전임의',
		'5' => '연구원',
		'6' => '개원의',
		'99' => '기타'
	);

	// gubun2 - 소속 선택 (국내) / Specialty (국외)
	$_ONSITE['gubun2_kor'] = array(
		'1' => '외과',
		'2' => '내과',
		'99' => '기타'
	);

	$_ONSITE['gubun2_eng'] = array(
		'1' => 'Surgery',
		'2' => 'Internal Medicine',
		'99' => 'Others'
	);

	// etc_field5 - 결제방법
	$_ONSITE['pay_method_kor'] = array(
		'CARD' => '카드',
		'BANK' => '송금',
		'CASH' => '현금',
	);

	$_ONSITE['pay_method_eng'] = array(
		'CARD' => 'Credit Card',
		'CASH' => 'Cash'
	);

	// 참석 예정 날짜 (login1~login3)
	$_ONSITE['attend_days'] = array(
		'1' => array(
			'date' => '2026-09-09',
			'time' => '08:30 ~ 18:00',
			'place' => 'BEXCO',
			'label_kor' => '9/9(수) 참석',
			'label_eng' => 'Sep 9 (Wed) – Will Attend',
			'price' => 0
		),
		'2' => array(
			'date' => '2026-09-10',
			'time' => '08:30 ~ 18:00',
			'place' => 'BEXCO',
			'label_kor' => '9/10(목) 참석',
			'label_eng' => 'Sep 10 (Thu) – Will Attend',
			'price' => 0
		),
		'3' => array(
			'date' => '2026-09-11',
			'time' => '08:30 ~ 18:00',
			'place' => 'BEXCO',
			'label_kor' => '9/11(금) 참석',
			'label_eng' => 'Sep 11 (Fri) – Will Attend',
			'price' => 0
		)
	);

	// 국내는 +82 prefix 고정
	$_ONSITE['domestic_phone_prefix'] = '+82';
?>
