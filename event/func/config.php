<?
	$_CONFIG['Name'] = "IASGO 2026";
	$_CONFIG['domain'] = $_SERVER["HTTP_HOST"];
	
	$ex_url = explode("/",$_SERVER['PHP_SELF']);
	$class_con = "";
	if($ex_url[1]=="enter" && ($ex_url[2]=="index.php" || $ex_url[1]=="")){
		$main_yn="Y";
		$class_con = "main";
    }
	$num_per_page=$num_per_page?$num_per_page:20;
	$page_per_block=$page_per_block?$page_per_block:10;
	$page=!$_GET['page']?1:$_GET['page'];

	$_Webinar['sdate'] = "2026-09-09"; //행사시작일
	$_Webinar['edate'] = "2026-09-11"; //행사종료일
	
	$master_ip = "218.235.94.219";

	$link_day="1";
	if(date("Y-m-d")=='2026-09-10') $link_day="2";
	if(date("Y-m-d")=='2026-09-11') $link_day="3";

	
	$_Azure['use'] = false;
	$_Azure['link'] = "https://kcr4u-event.ezv.kr/";

	include_once dirname(__FILE__).'/include.master_setting.php';

	// 최고관리자 계정 ID (registration_tbl.id). 비어 있으면 master_ip 접속만 임시 허용.
	$_CONFIG['super_admin_ids'] = array(
		'iasgo'
	);

	// 출결 메뉴 GNB 노출 (true: E-Poster 다음에 표시 / false: URL로만 접근)
	$_CONFIG['show_attendance_menu'] = (isset($_MASTER['attendance_menu']) && $_MASTER['attendance_menu'] == 'Y');

	// 관리자 등록폼 강의장입장(lecture1~4). IASGO 2026 출결/통계는 checkin_tbl 사용. 필요 시 true
	$_CONFIG['show_lecture_attend'] = false;

	// 관리자 등록폼 로그인(login1~5) 체크박스. 출결/통계는 checkin_tbl 기준. 필요 시 true
	$_CONFIG['show_login_attend'] = false;

	$_CONFIG['admin_menu'] = array(
	 	"1"=>"Registration",
//		"5"=>"Sessions",
//		"2"=>"Program at a Glance",
		"3"=>"E-Poster",
	//	"4"=>"E-Booth",
	//	"6"=>"Notice",
	//	"8"=>"Q&A",
	//	"10"=>"Survey",
	//	"9"=>"통계",
		//"7"=>"Survey"
	);
	if ($_CONFIG['show_attendance_menu']) {
		$_CONFIG['admin_menu']['11'] = '출결';
	}

	$_CONFIG['admin_link'] = array(
		"1"=>"/registration/",
		"2"=>"/program/",
		"3"=>"/poster/",
		"4"=>"/booth/",
		"5"=>"/session/",
		"6"=>"/notice/",
		"7"=>"/survey/",
		"8"=>"/question/?ev_date=".$link_day,
		"9"=>"/status/room.php?ev_date=".$link_day,
		"10"=>"/exam/",
		"11"=>"/registration/attendance.php"
	);

	$_CONFIG['admin_sub1_menu'] = array(
		"1"=>"Registration",
		"11"=>"등록통계",
	//	"2"=>"입출기록",
	//	"7"=>"필수평점기록",
	//	"6"=>"미접속인원",
		//"7"=>"감염관리 전담인력 교육 수료증",
		//"9"=>"세미나 의견제출"
		//"3"=>"평의원",
		//"4"=>"수면다윈검사"
	//	"5"=>"Voting",
	//	"10"=>"경품추첨",
		//"4"=>"VOD",
		/*"3"=>"평의원"*/
	);
	if ($_CONFIG['show_attendance_menu']) {
		$_CONFIG['admin_sub1_menu']['12'] = '출결확인';
		$_CONFIG['admin_sub1_menu']['2'] = '입출기록';
		$_CONFIG['admin_sub1_menu']['13'] = '평점/체류';
	}
	$_CONFIG['admin_sub1_link'] = array(
		"1"=>"/registration/",
		"11"=>"/registration/statistics.php",
		"12"=>"/registration/attendance.php",
		"13"=>"/time/index.php?ev_date=".$link_day,
		"2"=>"/registration/index_checkin.php?ev_date=".$link_day,
		"3"=>"/survey/session_survey.php",
		//"4"=>"/registration/vod_list.php",
		"5"=>"/registration/voting_list.php",
		"6"=>"/registration/login_none.php?ev_date=".$link_day,
		"10"=>"/gift/",
		"7"=>"/registration/index_checkin_ind.php?ev_date=".$link_day,
		"9"=>"/registration/opinion.php"
	);

	$_CONFIG['admin_sub2_menu'] = array(
		"1"=>"Program at a Glance",
		"2"=>"Program at a Glance Backup"
	);
	$_CONFIG['admin_sub2_link'] = array(
		"1"=>"/program/",
		"2"=>"/program/index_copy.php"
	);

	$_CONFIG['admin_sub3_menu'] = array(
		"1"=>"E-Poster",
		"2"=>"E-Poster Category",
		//"3"=>"E-Poster 심사"
	);
	$_CONFIG['admin_sub3_link'] = array(
		"1"=>"/poster/",
		"2"=>"/poster/category.php",
		"3"=>"/poster/judge.php"
	);

	$_CONFIG['admin_sub4_menu'] = array(
		"1"=>"E-Booth",
		"2"=>"E-Booth Category"
	);
	$_CONFIG['admin_sub4_link'] = array(
		"1"=>"/booth/",
		"2"=>"/booth/category.php"
	);


	$_CONFIG['admin_sub5_menu'] = array(
		"1"=>"Session",
		"2"=>"Session Room",
		"6"=>"Faculty 정보",
		"4"=>"Faculty 역할",
		"5"=>"Faculty Category"
		//"3"=>"강의평가"
	);
	$_CONFIG['admin_sub5_link'] = array(
		"1"=>"/session/",
		"2"=>"/session/category.php",
		"3"=>"/session/session_survey.php",
		"4"=>"/faculty/faculty_list.php",
		"5"=>"/faculty/faculty_category.php",
		"6"=>"/faculty/faculty.php"
	);

	$_CONFIG['admin_sub8_menu'] = array(
		"1"=>"Q&A",
		"2"=>"기술문의"
	);
	$_CONFIG['admin_sub8_link'] = array(
		"1"=>"/question/?code=&ev_date=".$link_day,
		"2"=>"/question/tech.php"
	);

	$_CONFIG['admin_sub9_menu'] = array(
		"1"=>"통계",
		"2"=>"Voting 설정",
		"3"=>"Voting 관리",
		"9"=>"Streaming",
		"4"=>"통계로그",
		"5"=>"일자별통계"
		//"2"=>"Survey"
	);
	$_CONFIG['admin_sub9_link'] = array(
		"1"=>"/status/room.php?code=&ev_date=".$link_day,
		"2"=>"/voting/",
		"3"=>"/voting/lecture.php",
		"4"=>"/status/auto_record.php?chkday=".$link_day,
		"5"=>"/status/everyday.php",
		"9"=>"/status/streaming.php"
	);

	$_CONFIG['admin_sub10_menu'] = array(
		"1"=>"문제관리",
		"2"=>"시험결과",
		"3"=>"Feedback",
		"4"=>"Voting설정",
		"5"=>"Voting"
	);
	$_CONFIG['admin_sub10_link'] = array(
		"1"=>"/exam/",
		"2"=>"/exam/result.php?chkday=".$link_day,
		"3"=>"/survey/feedback.php",
		"4"=>"/voting/",
		"5"=>"/voting/lecture.php"
	);

	$_CONFIG['menu'] = array(
		"1"=>"Virtual Congress",
		"2"=>"Program",
		"3"=>"E-Poster",
		"4"=>"Exhibition Hall"
	);

	$_CONFIG['link'] = array(
		"1"=>"/conference/",
		"2"=>"/program/",
		"3"=>"/poster/",
		"4"=>"/booth/"
	);

	if($ex_url[1]=="registration"){
		if (isset($ex_url[2]) && $ex_url[2] == 'attendance.php' && !empty($_CONFIG['show_attendance_menu'])) {
			$main_num = '11';
		} else {
			$main_num = '1';
		}
	}else if($ex_url[1]=="program"){
		$main_num="2";
	}else if($ex_url[1]=="poster"){
		$main_num="3";
	}else if($ex_url[1]=="booth"){
		$main_num="4";
	}else if($ex_url[1]=="notice"){
		$main_num="6";
	}else if($ex_url[1]=="session"){
		$main_num="5";
	}else if($ex_url[1]=="survey"){
		$main_num="7";
	}else if($ex_url[1]=="question"){
		$main_num="8";
	}else if($ex_url[1]=="status"){
		$main_num="9";
	}
	

	/*$_REG['regist_fee_Eng'] = array(
		"Registration for Virtual Congress"	=> array("key"=>"A","price"=>"0")
	); 
	
	$_REG['regist_fee_Kor'] = array(
		"전문의/Fellow/군의관 등"			=> array("key"=>"A","price"=>"20000"),
		"전공의/간호사/학생/65세 이상 Senior"	=> array("key"=>"B","price"=>"0")
	);*/
	
	$_CONFIG['YN_color'] = array(
		"Y"=>"blue",
		"N"=>"red"
	);

	


	$_REG['regist_fee_Eng'] = array(
		"A"	=> array("title"=>"Registration for Virtual Congress","price"=>"0")
	);

	$_REG['regist_fee_Kor'] = array(
		"A"	=> array("title"=>"전문의/Fellow/군의관 등","price"=>"20000"),
		"B"	=> array("title"=>"전공의/간호사/학생/65세 이상 Senior","price"=>"0")
	);

	$_REG['pay_method'] = array("C"=>"Credit Card","V"=>"Wire Transfer");
	$_REG['pay_status_txt'] = array("Y"=>"완료","N"=>"현장납부","C"=>"취소");
	$_REG['login_yn'] = array("Y"=>"승인","N"=>"미승인");

	// IASGO 2026 admin
	$_REG['desk'] = array(
		"1"=>"DESK 1",
		"2"=>"DESK 2",
		"3"=>"DESK 3"
	);
	$_REG['vip'] = array(
		"Y"=>"VIP"
	);
	$_REG['reg_source'] = array(
		"ADMIN"=>"관리자",
		"ONSITE"=>"현장등록",
		"PRE"=>"사전등록"
	);

	$_Booth['type'] = array(
		"A"=>"부스형",
		"B"=>"X배너형",
		"C"=>"배너형"
	);

	$_Booth['booth_open_type'] = array(
		"op1"=>"Company",
		"op2"=>"Brochures ",
		"op3"=>"Movie ",
		"op4"=>"Survey ",
		"op5"=>"Guest Book",
		"op6"=>"Stamp Event"
	);

	/*$_Booth['type'] = array(
		"A"=>"330x140",
		"B"=>"310x120",
		"C"=>"224x99",
		"D"=>"200x88"
	);*/
	
	$_Booth['social'] = array(
		"facebook"=>"FaceBook",
		"blog"=>"Blog",
		"linkedin"=>"In",
		"youtube"=>"Youtube",
		"instagram"=>"Instagram"
	);

	$_PROGRAM['lang'] = array(
		"Eng"=>"1",
		"Kor"=>"2"
	);
	$_PROGRAM['lang_session'] = array(
		"Eng"=>"English Session",
		"Kor"=>"Korean Session"
	);
	$_PROGRAM['lang_code'] = array(
		"E"=>"Eng",
		"K"=>"Kor",
		"A"=>"Eng/Kor"
	);

	$_Day['room_key'] = array(
		"1"=>"A",
		"2"=>"B",
		"3"=>"C",
		"4"=>"D",
		"5"=>"E",
		"6"=>"F",
		"7"=>"G",
		"8"=>"H",
		"9"=>"I"
	);

	$_Day['room_title'] = array(
		"1"=>"Grand Ballroom 101, 1F",
		"2"=>"Grand Ballroom 102, 1F",
		"3"=>"Grand Ballroom 103, 1F",
		"4"=>"Grand Ballroom 104, 1F",
		"5"=>"Grand Ballroom 105, 1F",
		"6"=>"201, 2F",
		"7"=>"202, 2F",
		"8"=>"203, 2F",
		"9"=>"Auditorium, 3F"
	);
	
	$_PROGRAM['Month'] = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
	$_PROGRAM['days'] = array("1"=>"Mon","2"=>"Tue","3"=>"Wed","4"=>"Thu","5"=>"Fri","6"=>"Sat","0"=>"Sun");
	
	$_PROGRAM['movie'][1] = "https://live001.enjsoft.net:1935/live/TG6OA0B84L";
	//$_PROGRAM['movie'][2] = "https://ev49.enjsoft.net:1935/live/1BZT2B0BZI";
	$_PROGRAM['movie'][3] = "https://live001.enjsoft.net:1935/live/M0F2K9U7T3";
	//$_PROGRAM['movie'][4] = "https://ev49.enjsoft.net:1935/live/9VXLP7IZ5M";
	$_PROGRAM['movie'][5] = "https://live001.enjsoft.net:1935/live/PRD03CTYWA";
	//$_PROGRAM['movie'][6] = "https://ev49.enjsoft.net:1935/live/7T87S2EQ9J";
	//$_PROGRAM['movie'][7] = "https://ev49.enjsoft.net:1935/live/SR8SVYQP9A";
	//$_PROGRAM['movie'][8] = "https://ev49.enjsoft.net:1935/live/ITP9OOT62U";
	$_PROGRAM['movie'][9] = "https://live001.enjsoft.net:1935/live/Y5N6PMOFRW";
	

	$_NOTICE['use'] = array(
		"Y"=>"사용",
		"N"=>"미사용"
	);
	$_NOTICE['push'] = array(
		"Y"=>"예",
		"N"=>"아니오"
	);
	$_REG['enter'] = array(
		"Y"=>"O",
		""=>"X"
	);
	$_REG['enter_color'] = array(
		"Y"=>"blue",
		""=>"red"
	);
	
	$_REG['reg_kind'] = array(
		"A"=>"Dr.",
		"B"=>"Mr.",
		"C"=>"Ms.",
		"D"=>"Other / Associate Professor",
		"E"=>"Other / Chief Healthcare Officer",
		"F"=>"Other / crc",
		"G"=>"Other / employee",
		"H"=>"Other / Head of technicians",
		"I"=>"Other / Miss",
		"J"=>"Other / Radiologic technologist",
		"K"=>"Other / Radiological Technician",
		"L"=>"Other / Radiological Ttechnologist",
		"M"=>"Other / Research Professor",
		"N"=>"Other / researcher",
		"O"=>"Other / resident",
		"P"=>"Other / student",
		"Q"=>"Professor",
		"Z"=>"기타"
	);

	$_REG['gubun'] = array(
		"A"=>"사전",
		"B"=>"단체",
		"C"=>"당일",
		"D"=>"부스"
	);
	$_REG['gubun1_title'] = "Category";
	$_REG['gubun1'] = array(
		"1"=>"General Doctor (일반의)",
		"2"=>"Corporate Member(기업회원)",
		"3"=>"Fellow(전임의)",
		"4"=>"General Doctor (일반의)",
		"5"=>"Medical Doctor (전문의)",
		"6"=>"Military Medical Officer (군의관)",
		"7"=>"Nurse(간호사)",
		"8"=>"Pharmacist(약사)",
		"9"=>"Professor(교수)",
		"10"=>"Public Health Doctor (공중보건의)",
		"11"=>"Researcher(관련연구자)",
		"12"=>"Researcher(관련연구자)",
		"13"=>"기자",
		"99"=>"Etc(기타)"
	);

	$_REG['gubun2_title'] = "Degree";
	$_REG['gubun2'] = array(
		"1"=>"Ph.D.",
		"2"=>"Ph.D.",
		"3"=>"Ph.D.",
		"4"=>"Ph.D.",
		"5"=>"Ph.D.",
		"6"=>"Ph.D.",
		"9"=>"기타"
	);

	$_REG['class_kind'] = array(
		"A"=>"조기",
		"B"=>"사전",
		"C"=>"현장",
		"P"=>"PDP",
		"U"=>"Only Poster",
		"V"=>"무료등록",
		"W"=>"Press",
		"X"=>"특별명단",
		"Y"=>"부스",
		"Z"=>"임의",
		"M"=>"관계자"
	);

	

	$_REG['reg_country'] = array(
		"K"=>"국내",
		"F"=>"국외"
	);
	$_REG['memberGubun'] = array(
		"2"=>"내과전문의",
		"1"=>"내과전공의", 
		"5"=>"기타(일반의, 타과, 의과대학생 등)"
	);

	$_REG['memberGubun_sub2'] = array(
		"1"=>"대학교수",
		"2"=>"봉직의", 
		"3"=>"개원의", 
		"4"=>"군의관, 공중보건의"
	);
	$_REG['memberGubun_sub5'] = array(
		"5"=>"일반의",
		"6"=>"타과 전공의", 
		"7"=>"타과 전문의", 
		"8"=>"의과대학생"
	);

	$_ABS['pre_type'] = array("포스터구연"=>"포스터구연", "포스터"=>"포스터");

	$_ABS['category'] = array("01"=>"소화기","02"=>"순환기","03"=>"호흡기","04"=>"내분비-대사","05"=>"신장","06"=>"혈액종양","07"=>"감염","08"=>"알레르기","09"=>"류마티스","10"=>"노년내과");

	$_ABS['sub1_cat'] = array("1"=>"위장관","2"=>"간","3"=>"췌담도");
	$_ABS['sub2_cat'] = array("1"=>"혈액","2"=>"종양");

	$_ABS['abs_type'] = array("1"=>"국문","2"=>"영문");
	$_ABS['abs_kind'] = array("1"=>"원저","2"=>"증례");
	$_ABS['final_confirm'] = array("Y"=>"완료","N"=>"미완료");


	$_Log['chk_type'] = array("E"=>"입장","S"=>"체류","O"=>"퇴장");
	$_Log['location_kind'] = array("P"=>"PC","M"=>"Mobile","T"=>"Tablet","A"=>"관리자-수정팝업");
	


	//$day = 1;

	$ing_time = time(); //현재 시간

	$_Event['gift'] = array(
		"1"=>"소장내시경",
		"2"=>"캡슐내시경 2판 ", 
		"3"=>"소화기질환과 장내 미생물 ", 
		"4"=>"임상소화기내시경학", 
		"5"=>"소화기내시경복강경 치료의 길잡이 ", 
		"6"=>"영상 증강 내시경의 올바른 이해와 임상 적용 ", 
		"7"=>"비만과 대사질환의 내시경 치료",
		"99"=>"N"
	);
	$_Event['gift_limit'] = array(
		"1"=>5,
		"2"=>5, 
		"3"=>5, 
		"4"=>20, 
		"5"=>5, 
		"6"=>5, 
		"7"=>5, 
		"99"=>0
	);

	$_CONFIG['room'] = array(
		'1'=>'1',
		'2'=>'2',
		'3'=>'3',
		'4'=>'4',
		'5'=>'5',
		'6'=>'6',
		'7'=>'7',
		'8'=>'8',
		'9'=>'9'
	);


	$_CONFIG['Gkey'] = array(
		// IASGO 2026: 현장 출결은 checkin_tbl / checkin_detail_tbl 단일 사용.
	);
	/*
	$_CONFIG['Gkey'] = array(
		'1'=>'A',
		'2'=>'B',
		'3'=>'C',
		'4'=>'D',
		'5'=>'E',
		'6'=>'F',
		'7'=>'G',
		'8'=>'H',
		'9'=>'I',
		'10'=>'J',
		'11'=>'K',
		'12'=>'L',
		'13'=>'M'
	);
	*/
	$_CONFIG['access_kind'] = array(
		'1'=>'수련책임자 간담회',
		'2'=>'보험정책단 아카데미',
		'4'=>'Hospital Medicine'
	);

	$_CONFIG['link_target'] = array(
		'_blank'=>'새창',
		'_self'=>'현재 페이지'
	);


	$_EXAM['pass'] = array(
		"Y"=>"합격",
		"R"=>"불합격"
	);

	$_EXAM['exam_result'] = array(
		"Y"=>"정답",
		"N"=>"오답",
		"P"=>"시간초과",
		""=>"-"
	);
	$_EXAM['exam_result_color'] = array(
		"Y"=>"blue",
		"N"=>"red",
		"P"=>"gray",
		""=>"-"
	);
	
	$_Activation['category'] = true;
	$_Exam['category'] = array(
		"A"=>"Case of the Day",
		"B"=>"Live Diagnosis Challenge"
	);

	$_SURVEY['job'] = array(
		"1"=>"의사",
		"2"=>"간호사",
		"3"=>"임상병리사",
		"9"=>"기타"
	);

	$_SURVEY['charge'] = array(
		"1"=>"전담",
		"2"=>"겸직"
	);

	$_SURVEY['answer'] = array(
		"1"=>"매우만족",
		"2"=>"만족",
		"3"=>"보통",
		"4"=>"불만족",
		"5"=>"전혀만족못함"
	);


	//객관식
	$_SURVEY['question_m_K'] = array(
		"1"=>"장소 (코엑스 회의장 및 전시장)",
		"2"=>"숙소 (InterContinental Seoul Coex)",
		"3"=>"대회 가방 만족도",
		"4"=>"Media Wall (LED 스크린) 영상 만족도 (콘텐츠, 유익성 등)",
		"5"=>"로비 조성 만족도 (기둥 구조물, ISP Zone, BSA Zone)",
		"6"=>"장소 및 동선 안내 설치물 (위치 및 장소 식별의 용이성)",
		"7"=>"라운지 운영 만족도 (Preview Room & Faculty/Senior Lounge, Young Radiologist Lounge)",
		"8"=>"Registration Desk, Coat Room, Kit Desk, Information Desk 서비스",
		"9"=>"현장 등록 절차 (현장 등록 및 사전 등록자 네임택 수령)",
		"10"=>"발표자 시스템 (태블릿 PC를 통한 PPT 슬라이드 노트 확인)",
		"11"=>"전반적인 대회 운영 만족도",

		"15"=>"프로그램북 최소 수량 제작",
		"16"=>"PVC재질의 X배너를 대체한 허니콤보드(종이)배너 제작",
		"17"=>"허니콤보드(종이) 구조물 운영 만족도 (로비 메인 구조물, 포토존)",
		"18"=>"종이 명찰, 종이 줄(Lanyard) 만족도",


		"19"=>"Opening Session 진행 만족도",
		"20"=>"Welcome Reception 식음료 및 서비스",
		"21"=>"Congress Banquet 식음료 및 서비스",
		"22"=>"Cafeteria 식음료 및 서비스",
		"23"=>"Luncheon Symposia 식음료 및 서비스 (도시락)",

		"24"=>"전시 참여에 대한 유익성",
		"25"=>"전시사의 전시 품목에 대한 만족도",
		"26"=>"전시 참여 업체의 다양성",

		"28"=>"인스타그램 이벤트 만족도",
		"29"=>"전시장 QR Code 이벤트 만족도",
		"30"=>"프로필 사진 촬영 이벤트 만족도",

		"33"=>"온라인 강의실 (Live Sessions) 운영 만족도",
		"34"=>"Invited Guests 기능 및 열람의 편리성",
		"35"=>"Program at a Glance Filtering 기능",
		"36"=>"E-Posters 발표 자료 열람의 편리성",


		"37"=>"Case of the Day 문제 난이도의 적절성",
		"38"=>"Case of the Day 문제 풀이 방식의 만족도",
		"39"=>"Live Diagnosis Challenge의 문제 난이도의 적절성",
		"40"=>"Live Diagnosis Challenge 문제 풀이 방식의 만족도",


		"41"=>"플랫폼 전반적인 운영 만족도 (편리성, 속도 등)",
		"42"=>"Platform 디자인 완성도",
		"43"=>"모바일 플랫폼 이용의 편의성",
		

		"44"=>"KCR 2023 공식 홈페이지의 이용 편리성 및 속도",
		"45"=>"KCR 2023 공식 홈페이지의 디자인 만족도",

	);

	//주관식
	$_SURVEY['question_s_K'] = array(
		"1"=>"현장 학술대회 운영에 대한 기타 의견이 있으실 경우, 말씀해 주시기 바랍니다.",
		"2"=>"온라인 플랫폼 관련 기타 의견이 있으실 경우, 말씀해 주시기 바랍니다.",
		"3"=>"공식 홈페이지 관련 기타 의견이 있으실 경우, 말씀해 주시기 바랍니다.",
		"4"=>"KCR 2023 중 인상 깊었던 점을 말씀해 주시기 바랍니다.",
		"5"=>"조직위원회에 전하고 싶은 의견 (장, 단점)이 있으실 경우, 말씀해 주시기 바랍니다.",


		"6"=>"내년 서울에서 개최할 KCR 2024에 기대되는 점을 말씀해 주시기 바랍니다.",
		"7"=>"KCR 2024에서 운영되었으면 하는 학술 프로그램을 말씀해 주시기 바랍니다.",
		"8"=>"친환경 학회와 관련하여 추천할 항목이나 추가할 내용이 있으시면 말씀해 주시기 바랍니다. ",
		"9"=>"기타 KCR 2024에 바라는 제안 사항이 있다면, 말씀해 주시기 바랍니다. "
	);


	//객관식
	$_SURVEY['question_m_F'] = array(
		"1"=>"Congress venue (Coex session rooms and exhibition hall)",
		"2"=>"Accommodation ",
		"3"=>"Congress Kit",
		"4"=>"Media Wall_LED Screen",
		"5"=>"Grand Ballroom Lobby_Pillar (Today’s Highlights, ISP Zone, BSA Zone, KCR meets Malaysia, and etc.)",
		"6"=>"Signage and banners",
		"7"=>"Management of lounges (Preview Room, Faculty/Senior Lounge, Young Radiologist Lounge)",
		"8"=>"Registration Desk, Coat Room, Kit Desk, Information Desk",
		"9"=>"On-site registration process",
		"10"=>"Management of presentations",
		"11"=>"Overall management of the onsite congress",

		"12"=>"Program Book: minimum quantity of printed hard copies",
		"13"=>"Production of banners: X-banners (PVC material) → honeycomb board (paper) banners",
		"14"=>"Honeycomb board (paper) structures (main lobby, photo zone)",
		"15"=>"Paper nametags, paper lanyards ",

		"16"=>"Opening Session",
		"17"=>"Welcome Reception including food and beverages",
		"18"=>"Congress Banquet including food and beverages",
		"19"=>"Cafeteria in the Exhibition Hall including food and beverages",
		"20"=>"Luncheon Symposia including food and beverages",

		"21"=>"Convenience of viewing/using the Technical Exhibition Hall",
		"22"=>"Interest of the contents of the Exhibition companies",
		"23"=>"Variety of the Exhibition companies",
		
		"24"=>"Live Sessions",
		"25"=>"Invited guests page and screen loading speed",
		"26"=>"Program at a Glance filtering",
		"27"=>"Convenience of viewing e-poster presentation materials",

		"28"=>"Adequacy of the level of difficulty of the Case of the Day questions",
		"29"=>"Case of the Day question solving method",
		"30"=>"Adequacy of the level of difficulty of the Live Diagnosis Challenge quizzes",
		"31"=>"Live Diagnosis Challenge quiz solving method",

		"32"=>"Overall platform operations",
		"33"=>"Congress main hall design",
		"34"=>"Convenience of the mobile web",

		"35"=>"Ease of use and speed of the reorganized website",
		"36"=>"Design of the reorganized website",
		"37"=>"Other suggestions for the website",

	);

	//주관식
	$_SURVEY['question_s_F'] = array(
		"1"=>"Other suggestions for the KCR 2023 onsite congress",
		"2"=>"Other Suggestions for the Virtual Platform.",
		"3"=>"What impressed you during KCR 2023?",
		"4"=>"Comments to the KCR 2023 Organizing Committee (please describe good and bad points of the congress, etc.)",
		"5"=>"What are your expectations for KCR 2024 to be held in Seoul next year?",
		"6"=>"What scientific programs would you like to see offered at KCR 2024?",
		"7"=>"Please write any recommendations or additions for Eco-friendly KCR.",
		"8"=>"Please write any other suggestions you may have for KCR 2024."
	);

	$_SURVEY['ans_m_F'] = array(
		"1" => "Greatly<br>Satisfaction",
		"2" => "Satisfaction",
		"3" => "Moderate",
		"4" => "Dissatisfaction",
		"5" => "Greatly<br>Dissatisfaction",
		"6" => "Undesrved"
	);

	$_SURVEY['ans_m_K'] = array(
		"1" => "매우 만족",
		"2" => "만족",
		"3" => "보통",
		"4" => "불만족",
		"5" => "매우 불만족",
		"6" => "모르겠다"
	);

	$_SURVEY['ans_m2_K'] = array(
		"1" => "옵션1",
		"2" => "옵션2",
		"3" => "옵션3",
		"4" => "옵션4"
	);


	$_Feedback['kind'] = array(
		"A"=>"객관식",
		"B"=>"주관식"
	);

	$_Feedback['que_type'] = array(
		"Z"=>"초기화",
		"A"=>"1:매우만족 , 2:만족 , 3:보통 , 4:불만족 , 5:전현만족못함",
		"B"=>"1:예 , 2:아니오"
	);
		

	$_PROGRAM['difficulty'] = array(
		"All"=>"All",
		"jr"=>"Jun",
		"Jun"=>"Jun",
		"Adv"=>"Adv",
		"Interactive"=>"Interactive"
	);
	$_PROGRAM['difficulty_code'] = array(
		"All"=>"A",
		"jr"=>"C",
		"Jun"=>"C",
		"Adv"=>"D",
		"Interactive"=>"B"
	);

	$_Poster['award'] = array(
		"A"=>"Grand Prix",
		"B"=>"Gold",
		"C"=>"Silver",
		"D"=>"Bronze",
	);


	$_Poster['award_code'] = array(
		"A"=>"grand",
		"B"=>"gold",
		"C"=>"silver",
		"D"=>"bronze",
	);

	$_Login['login_kind'] = array(
		"P"=>"PC",
		"M"=>"Mobile"
	);

	$_Faculty['role'] = array(
		"A"=>"Moderator",
		"B"=>"Speaker",
		"C"=>"Pannel",
		"D"=>"President"
	);
	

	$_Faculty['award'] = array(
		//"A"=>"Academic Grant",
		"D"=>"KASID Best Oral Presentation Award",
		"F"=>"Young Investigator Award",
		"B"=>"Distinguished Investigator Award",
		//"C"=>"E-Travel Grant",
		//"G"=>"Travel Grant",
		"E"=>"KASID Best Poster Award"
	);

	$_Gift['gift_K'] = array(
		"1"=>array(
			"title"=>"다이슨 헤어드라이어",
			"cnt"=>1
		),
		"2"=>array(
			"title"=>"로지텍 블루투스 키보드",
			"cnt"=>5
		),
		"3"=>array(
			"title"=>"프로필 사진 촬영 교환권",
			"cnt"=>20
		),
		"4"=>array(
			"title"=>"여행용 다용도 파우치",
			"cnt"=>100
		),
		"N"=>array(
			"title"=>"꽝",
			"cnt"=>''
		)
	);

	$_Gift['gift_F'] = array(
		"1"=>array(
			"title"=>"Dyson hair dryers",
			"cnt"=>1
		),
		"2"=>array(
			"title"=>"Logitech bluetooth keyboard",
			"cnt"=>5
		),
		"3"=>array(
			"title"=>"Profile photo voucher",
			"cnt"=>20
		),
		"4"=>array(
			"title"=>"Travel pouch",
			"cnt"=>100
		),
		"N"=>array(
			"title"=>"꽝",
			"cnt"=>''
		)
	);

	include_once $_SERVER['DOCUMENT_ROOT'].'/func/config/flag.php';

	// IASGO 현장등록 요금 (webinar onsite config 미러 — Document Root가 event일 때)
	if (is_file($_SERVER['DOCUMENT_ROOT'].'/../webinar/func/config/onsite.php')) {
		include_once $_SERVER['DOCUMENT_ROOT'].'/../webinar/func/config/onsite.php';
	} else if (is_file('/home/virtual/iasgo/webinar/func/config/onsite.php')) {
		include_once '/home/virtual/iasgo/webinar/func/config/onsite.php';
	}
?>