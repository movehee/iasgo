<?
	$_CONFIG['Name'] = "KSERS 2026";
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
	
	$_Webinar['sdate'] = "2026-04-23"; //행사시작일
	$_Webinar['edate'] = "2026-04-25"; //행사종료일


	$HTTP = "http";
	if($_SERVER['HTTPS']=="on"){
		$HTTP = "https";
	}
	$_CONFIG['URL'] = $HTTP.'://'.$_SERVER["HTTP_HOST"];


	$master_ip = "218.235.94.220";
	
	$_CONFIG['Admin_link'] = "https://ifaa2024.org-event.ezv.kr/";

	$_Azure['use'] = true;
	//$_Azure['link'] = "https://webinar2cdnstorage.blob.core.windows.net/cdn/kcr/";
	$_Azure['link'] = "https://ifaa2024.org-event.ezv.kr/";
	$_Azure['link_layout'] = "/";
	
	$_Azure['link_cdn'] = "";

	
	$_REG['gubun'] = array(
		"A"=>"사전",
		"B"=>"현장",
		"C"=>"임의",
		"D"=>"부스"
	);

	$_REG['regist_fee_Eng'] = array(
		"A"	=> array("title"=>"Registration for Virtual Congress","price"=>"0")
	);

	$_REG['regist_fee_Kor'] = array(
		"A"	=> array("title"=>"전문의/Fellow/군의관 등","price"=>"20000"),
		"B"	=> array("title"=>"전공의/간호사/학생/65세 이상 Senior","price"=>"0")
	);

	$_REG['pay_method'] = array("C"=>"Credit Card","V"=>"Wire Transfer");
	$_REG['pay_status_txt'] = array("Y"=>"Completed","N"=>"Needed","C"=>"Cancel");
	$_REG['login_yn'] = array("Y"=>"승인","N"=>"미승인");

	

	$_PROGRAM['lang'] = array(
		"Eng"=>"1",
		"Kor"=>"2"
	
	);
	$_PROGRAM['lang_session'] = array(
		"Eng"=>"English Session",
		"Kor"=>"Korean Session"
	);
	$_PROGRAM['lang_code'] = array(
		"E"=>"ENG",
		"K"=>"KOR",
		"A"=>"ENG/KOR"
	);

	$_PROGRAM['lang_code_l'] = array(
		"E"=>"ENG",
		"K"=>"KOR",
		"A"=>"ENG/KOR"
	);

	$_PROGRAM['lang_class'] = array(
		"E"=>"eng",
		"K"=>"kor",
		"A"=>"all"
	);
	
	$_PROGRAM['Month_kor'] = array("01"=>"1월","02"=>"2월","03"=>"3월","04"=>"4월","05"=>"5월","06"=>"6월","07"=>"7월","08"=>"8월","09"=>"9월","10"=>"10월","11"=>"11월","12"=>"12월");
	$_PROGRAM['days_kor'] = array("1"=>"월","2"=>"화","3"=>"수","4"=>"목","5"=>"금","6"=>"토","0"=>"일");

	$_PROGRAM['Month_eng'] = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
	$_PROGRAM['days_eng'] = array("1"=>"Mon","2"=>"Tue","3"=>"Wed","4"=>"Thu","5"=>"Fri","6"=>"Sat","0"=>"Sun");
	

	//https://player.vimeo.com/external/439972761.hd.mp4?s=5338532c9335b1eb1118bb3b16e3c0afe73c1937&profile_id=174

	$_PROGRAM['movie'][1] = "https://live001.enjsoft.net:1935/live/TG6OA0B84L";
	//$_PROGRAM['movie'][2] = "https://ev49.enjsoft.net:1935/live/1BZT2B0BZI";
	$_PROGRAM['movie'][3] = "https://live001.enjsoft.net:1935/live/M0F2K9U7T3";
	//$_PROGRAM['movie'][4] = "https://ev49.enjsoft.net:1935/live/9VXLP7IZ5M";
	$_PROGRAM['movie'][5] = "https://live001.enjsoft.net:1935/live/PRD03CTYWA";
	//$_PROGRAM['movie'][6] = "https://ev49.enjsoft.net:1935/live/7T87S2EQ9J";
	//$_PROGRAM['movie'][7] = "https://ev49.enjsoft.net:1935/live/SR8SVYQP9A";
	//$_PROGRAM['movie'][8] = "https://ev49.enjsoft.net:1935/live/ITP9OOT62U";
	$_PROGRAM['movie'][9] = "https://live001.enjsoft.net:1935/live/Y5N6PMOFRW";


	$_PROGRAM['lecture_file_total'][1] = "https://webinar3cdnstorage.blob.core.windows.net/cdn/koshic/book.pdf"; //일자별 대표파일
	$_PROGRAM['lecture_file_room'][1][1] = "https://webinar3cdnstorage.blob.core.windows.net/cdn/koshic/book.pdf";


	$_PROGRAM['lecture_file_total'][2] = "https://webinar3cdnstorage.blob.core.windows.net/cdn/koshic/book.pdf"; //일자별 대표파일
	$_PROGRAM['lecture_file_room'][2][1] = "https://webinar3cdnstorage.blob.core.windows.net/cdn/koshic/book.pdf";
	$_PROGRAM['lecture_file_room'][2][2] = "https://kaimcdnstorage.blob.core.windows.net/cdn/room2.pdf";
	$_PROGRAM['lecture_file_room'][2][3] = "https://kaimcdnstorage.blob.core.windows.net/cdn/room3.pdf";
	$_PROGRAM['lecture_file_room'][2][4] = "https://kaimcdnstorage.blob.core.windows.net/cdn/room4.pdf";
	$_PROGRAM['lecture_file_room'][2][5] = "https://kaimcdnstorage.blob.core.windows.net/cdn/room5.pdf";
	$_PROGRAM['lecture_file_room'][2][6] = "https://kaimcdnstorage.blob.core.windows.net/cdn/room6.pdf";



	$_PROGRAM['Abs_down'] = array( //방별 초록 집 다운로드
		"1"=>"#",
		"2"=>"#",
		"3"=>"#",
		"4"=>"#",
		"5"=>"#"
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

	$_NOTICE['use'] = array(
		"Y"=>"사용",
		"N"=>"미사용"
	);
	$_NOTICE['push'] = array(
		"Y"=>"예",
		"N"=>"아니오"
	);



	$_ABS['pre_type'] = array("포스터구연"=>"포스터구연", "포스터"=>"포스터");

	$_ABS['category'] = array("01"=>"소화기","02"=>"순환기","03"=>"호흡기","04"=>"내분비-대사","05"=>"신장","06"=>"혈액종양","07"=>"감염","08"=>"알레르기","09"=>"류마티스","10"=>"노년내과");

	$_ABS['sub1_cat'] = array("1"=>"위장관","2"=>"간","3"=>"췌담도");
	$_ABS['sub2_cat'] = array("1"=>"혈액","2"=>"종양");

	$_ABS['abs_type'] = array("1"=>"국문","2"=>"영문");
	$_ABS['abs_kind'] = array("1"=>"원저","2"=>"증례");


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

	$_Day['room_subtitle'] = array(
		"1"=>"101호",
		"2"=>"102호",
		"3"=>"103호",
		"4"=>"104호",
		"5"=>"105호",
		"6"=>"201호",
		"7"=>"202호",
		"8"=>"203호",
		"9"=>"Auditorium"
	);

	$_PROGRAM['difficulty'] = array(
		"All"=>"All",
		"jr"=>"Jun",
		"Jun"=>"Jun",
		"Adv"=>"Adv",
		"Basic"=>"Basic",
		"Interactive"=>"Interactive"
	);

	$_PROGRAM['difficulty_code'] = array(
		"All"=>"all",
		"jr"=>"jr",
		"Jun"=>"jun",
		"Adv"=>"adv",
		"Basic"=>"basic",
		"Interactive"=>"interc"
	);


	$_PROGRAM['gubun_code'] = array(
		"AB"=>"Abdomen",
		"BR"=>"Breast",
		"CH"=>"Chest",
		"CV"=>"Cardiovascular",
		"ER"=>"Emergency",
		"GU"=>"Genitourinary",
		"IR"=>"Intervention",
		"ITA"=>"Image-guided tumor ablation",
		"MS"=>"Musculoskeletal",
		"MS(SP)"=>"Spine",
		"NR"=>"Neuroradiology",
		"NR(HN)"=>"Head and Neck",
		"NR(NI)"=>"Neurointervention",
		"OT"=>"Others",
		"PD"=>"Pediatric",
		"TH"=>"Thyroid"
	);

	/*$_PROGRAM['code_title'] = array(
		"LS" => "Luncheon Symposium",
		"AI SS" => "AI Scientific Session",
		"NR" => "KCR Meets India",
		"CBR" => "Case-based Review",
		"CL" => "Congress Lecture",
		"IIS" => "Image Interpretation Session",
		"ISP" => "Informal Scientific Presentation", 
		"JS" => "Joint Symposium",
		"KMM" => "KCR Meets Malaysia",
		"MC" => "Multisession Course", 
		"MDT" => "Multidisciplinary Team Sessions",
		"OS" => "Opening Session",
		"PL" => "Plenary Lecture",
		"RANK" => "RANK-QS",
		"RC" => "Refresher Course",
		"RIAI" => "RINK-CR (AI)",
		"RINK" => "RINK-CR",
		"SE" => "Scientific Exhibition",  
		"SF" => "Special Focus Session",
		"SS" => "Scientific Session",
		"VES" => "Visionary Education Session",
		"WN" => "What's New Session"
	);*/

	$_PROGRAM['code_title'] = array(
		"1"=>"Special Focus Session",
		"2"=>"Refresher Course",
		"3"=>"Scientific Session",
		"4"=>"Case-based Review",
		"5"=>"RANK-QS",
		"6"=>"KCR Meets India",
		"7"=>"Multidisciplinary Team Session",
		"8"=>"Opening Session",
		"9"=>"Congress Lecutre",
		"10"=>"Luncheon Symposium",
		"11"=>"KSR-NECA Joint Session (RINK-CR)",
		"12"=>"Image Interpretation Session",
		"13"=>"Joint Symposium with SFR",
		"14"=>"영상의학과 의사의 소통",
		"15"=>"AI Scientific Session",
		"16"=>"대학(병원) 영상의학의 위기",
		"17"=>"Plenary Lecture",
		"18"=>"Editorial Luncheon",
		"19"=>"Joint Symposium with ICIS",
		"20"=>"Joint Symposium with RSNA",
		"21"=>"Joint Symposium with KOSRO",
		"22"=>"영상의학과 의사의 관점에서 보는 데이터 표준화와 전망",
		"23"=>"Joint Symposium with KSMRM",
		"24"=>"영상의학과 정책현안",
		"25"=>"Joint Symposium with Spain",
		"26"=>"Joint Symposium with KOSAIM",
		"27"=>"Visionary Education Session",
		"28"=>"Joint Symposium with KSIIM",
		"29"=>"Joint Symposium with ESR",
		"30"=>"What's New Session",
		"31"=>"특수의료장비 품질관리교육",
		"32"=>"Joint Symposium with KARP",
		"33"=>"Asbestos Related Pleuropulmonary Diseases",
		"34"=>"Member-initiated Session",
		"35"=>"필수평점교육"
	);


	
	$_Poster['award'] = array(
		"A"=>"Grand",
		"B"=>"Gold",
		"C"=>"Silver",
		"D"=>"Bronze",
		"E"=>"Invitation to JKSR",
	);


	$_Poster['award_code'] = array(
		"A"=>"grand",
		"B"=>"gold",
		"C"=>"silver",
		"D"=>"bronze",
		"E"=>"jksr"
	);
	
	$_Faculty['role'] = array(
		"A"=>"Moderator",
		"B"=>"Speaker",
		"C"=>"Pannel",
		"D"=>"President"
	);

	$_Faculty['award'] = array(
		//"A"=>"Academic Grant",
		"D"=>"4 KASID Best Oral Presentation Award",
		"F"=>"16 Young Investigator Award",
		"B"=>"7 Distinguished Investigator Award",
		//"C"=>"E-Travel Grant",
		//"G"=>"Travel Grant",
		"E"=>"10 KASID Best Poster Award"
		
	);


	$_No_eval = array(4,5,19,29,37,38,39,47,50,51,56,57,65,66,67,68,69,70,79,80,81,90,93,98,104,109,110,111,112,117,118,119,120,121,122,133,134,136,142,143,144,145);	

	$_VOTING['date1'] = array(
		/* room */
		'1' => array("stime"=>"08:00", "etime"=>"09:20"),
		'2' => array("stime"=>"14:10", "etime"=>"15:40"),
		'3' => array("stime"=>"09:30", "etime"=>"10:50"),
		'5' => array("stime"=>"14:10", "etime"=>"15:40"),
		'8' => array("stime"=>"08:00", "etime"=>"09:10")
	);

	$_VOTING['date3'] = array(
		/* room */
		'2' => array("stime"=>"08:00", "etime"=>"09:30"),
		'4' => array("stime"=>"08:00", "etime"=>"09:20"),
		'9' => array("stime"=>"14:10", "etime"=>"15:40")
	);

	$_VOTING['date_room1'] = array(
		/* room */
		'1' => array("name"=>"GBR 101 (Room 1)", "session"=>"CBR 01-TH"),
		'2' => array("name"=>"GBR 102 (Room 2)", "session"=>"CBR 03-BR"),
		'3' => array("name"=>"GBR 103 (Room 3)", "session"=>"CBR 02-AB"),
		'5' => array("name"=>"GBR 105 (Room 5)", "session"=>"CBR 04-NR"),
		'8' => array("name"=>"GBR 203 (Room 8)", "session"=>"JS 01- BR")
	);

	$_VOTING['date_room3'] = array(
		/* room */
		'2' => array("name"=>"GBR 102 (Room 2)", "session"=>"CBR 05-PD"),
		'4' => array("name"=>"GBR 104 (Room 4)", "session"=>"MDT 03-AB"),
		'9' => array("name"=>"Auditorium", "session"=>"Image Interpretation Session")
	);

	
	if(!$_Time['ing']){
		$_Time['ing']=time();
	}
	
	
	$day="1";	
	if(date("Y-m-d",$_Time['ing'])=='2023-09-21') $day="2";
	else if(date("Y-m-d",$_Time['ing'])=='2023-09-22') $day="3";
	else if(date("Y-m-d",$_Time['ing'])=='2023-09-23') $day="4";
	
	$_Day['enter_date'] = strtotime("2023-09-18 10:00:00");
	

	$_Day['login_date'][1] = strtotime("2023-09-20 00:00:00");
	$_Day['login_date'][2] = strtotime("2023-09-21 00:00:00");
	$_Day['login_date'][3] = strtotime("2023-09-22 00:00:00");
	$_Day['login_date'][3] = strtotime("2023-09-23 00:00:00");

	$_Day['room_start'][1] = strtotime("2023-09-20 07:30:00");
	$_Day['room_start'][2] = strtotime("2023-09-21 07:30:00");
	$_Day['room_start'][3] = strtotime("2023-09-22 07:30:00");
	$_Day['room_start'][4] = strtotime("2023-09-23 07:30:00");
	$_Day['room_start'][5] = strtotime("2023-09-24 07:30:00");
	
	$_REG['reg_kind'] = array(
		"A"=>"Professor.",
		"B"=>"Dr.",
		"C"=>"Mr.",
		"D"=>"Ms.",
		"Z"=>"Other"
	);	
	$_REG['gubun1'] = array(
		"1"=>"Physician",
		"2"=>"Trainee, Student",
		"3"=>"Nurse, Coordinator, etc.",
		"9"=>"Other"
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
			"cnt"=>10
		),
		"4"=>array(
			"title"=>"여행용 다용도 파우치",
			"cnt"=>100
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
			"cnt"=>10
		),
		"4"=>array(
			"title"=>"Travel pouch",
			"cnt"=>100
		)
	);


	include_once $_SERVER['DOCUMENT_ROOT'].'func/config/menu.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'func/config/navi.php';

	include_once $_SERVER['DOCUMENT_ROOT'].'func/config/booth.php';
?>