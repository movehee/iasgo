<?
$_Reg_Field['Field'] = array(
'country'=>array('title'=>'국내/외', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>'N'),
'country_name'=>array('title'=>'국가명', 'required'=>'N', 'kind'=>'I', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'classification'=>array('title'=>'등록구분', 'required'=>'Y', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'original_sid'=>array('title'=>'접수번호', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'N', 'Modify'=>''),
'gubun4'=>array('title'=>'등록구분(3)', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'title'=>array('title'=>'직위', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'name_kr'=>array('title'=>'성명', 'required'=>'Y', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'N', 'Modify'=>''),
'name_eng'=>array('title'=>'성명(영문)', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'N', 'Modify'=>''),
'aff_kor'=>array('title'=>'소속', 'required'=>'Y', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'aff_eng'=>array('title'=>'소속(영문)', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'N', 'Modify'=>''),
'email'=>array('title'=>'이메일', 'required'=>'Y', 'kind'=>'I', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'cell'=>array('title'=>'연락처', 'required'=>'Y', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'license_number'=>array('title'=>'면허번호', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'N', 'Modify'=>''),
'etc_field4'=>array('title'=>'전공과목', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'gubun1'=>array('title'=>'카테고리', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'gubun2'=>array('title'=>'학회회원', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'etc_field1'=>array('title'=>'소속학회', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'price'=>array('title'=>'금액', 'required'=>'N', 'kind'=>'I', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'etc_field2'=>array('title'=>'결제수단', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>'Y'),
'etc_field3'=>array('title'=>'DESK', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>'N'),
'pay_status'=>array('title'=>'입금여부', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>'Y'),
'etc_field6'=>array('title'=>'출력소속', 'required'=>'N', 'kind'=>'I', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'score_chk'=>array('title'=>'평점여부', 'required'=>'Y', 'kind'=>'R', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'id'=>array('title'=>'ID', 'required'=>'Y', 'kind'=>'I', 'List'=>'N', 'Batch'=>'N', 'Modify'=>''),
'passwd'=>array('title'=>'비밀번호', 'required'=>'Y', 'kind'=>'I', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'gubun3'=>array('title'=>'부스', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'etc_field5'=>array('title'=>'갈라디너 참여', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>'Y'),
'event_chk'=>array('title'=>'럭키드로우', 'required'=>'N', 'kind'=>'R', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>''),
'etc_field10'=>array('title'=>'아이디', 'required'=>'N', 'kind'=>'I', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'etc_field11'=>array('title'=>'갈라디너 대상', 'required'=>'N', 'kind'=>'S', 'List'=>'Y', 'Batch'=>'Y', 'Modify'=>'Y'),
'etc_field20'=>array('title'=>'등록구분(2)', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
'etc_field21'=>array('title'=>'등록카테고리', 'required'=>'N', 'kind'=>'S', 'List'=>'N', 'Batch'=>'Y', 'Modify'=>''),
);

$_Reg_Field['gubun4'] = array(
'114'=>'1_Faculty',
'115'=>'2_PPTC Registrants',
'121'=>'3_Military Program',
'133'=>'4_Military EMT',
'134'=>'5_Military Nurse',
);

$_Reg_Field['etc_field4'] = array(
'88'=>'정형외과',
'89'=>'신경외과',
'90'=>'흉부외과',
'91'=>'성형외과',
'92'=>'마취통증의학과',
'93'=>'응급의학과',
'94'=>'내과',
'95'=>'소아청소년과',
'96'=>'산부인과',
'97'=>'정신건강의학과',
'98'=>'안과',
'99'=>'이비인후과',
'100'=>'피부과',
'101'=>'비뇨기과',
'102'=>'영상의학과',
'103'=>'방사선종양학과',
'104'=>'신경과',
'105'=>'재활의학과',
'106'=>'진단검사의학과',
'107'=>'병리과',
'108'=>'예방의학과',
'109'=>'가정의학과',
'110'=>'직업환경의학과',
'111'=>'핵의학과',
'112'=>'외과',
'180'=>'기타',
);

$_Reg_Field['gubun1'] = array(
'128'=>'간호사',
'135'=>'교수',
'136'=>'군간호사',
'137'=>'군응급구조사',
'138'=>'군의관',
'139'=>'그외 군 관련',
'140'=>'기타',
'141'=>'방사선사',
'142'=>'응급구조사',
'143'=>'전공의',
'144'=>'전문의',
'145'=>'초청연자',
'146'=>'초청좌장',
'147'=>'패컬티',
'148'=>'학생',
'149'=>'후원사',
'150'=>'기타',
'181'=>'-',
);

$_Reg_Field['gubun2'] = array(
'12'=>'회원',
'113'=>'비회원',
'131'=>'-',
);

$_Reg_Field['etc_field1'] = array(
'37'=>'대한외상학회',
'38'=>'대한두개안면성형외과학회',
'39'=>'대한성형외과학회',
'40'=>'대한신경손상학회',
'41'=>'대한신경중환자의학회',
'42'=>'대한외과학회',
'43'=>'대한외상간호사회',
'44'=>'대한외상중환자외과학회',
'45'=>'대한응급의학회',
'46'=>'대한인터벤션영상의학회',
'47'=>'대한정형외상학회',
'48'=>'대한창상학회',
'49'=>'대한환자혈액관리학회',
'50'=>'외상술기교육연구학회',
'51'=>'응급중환자영상학회',
'52'=>'한국트라우마스트레스학회',
'132'=>'기타',
);

$_Reg_Field['etc_field2'] = array(
'59'=>'Credit Card(On-site)',
'60'=>'계좌이체',
'120'=>'Cash',
);

$_Reg_Field['etc_field3'] = array(
'61'=>'DESK 1',
'62'=>'DESK 2',
'63'=>'DESK 3',
'122'=>'DESK 4',
'123'=>'DESK 5',
'124'=>'DESK 6',
);

$_Reg_Field['gubun3'] = array(
'29'=>'참여',
'30'=>'미참여',
'125'=>'해당없음',
);

$_Reg_Field['etc_field5'] = array(
'117'=>'참여',
'118'=>'미참여',
);

$_Reg_Field['etc_field11'] = array(
'126'=>'대상',
'127'=>'미대상',
);

$_Reg_Field['etc_field20'] = array(
'151'=>'PCO 등록',
'152'=>'PCO 직접 등록',
'153'=>'홈페이지',
);

$_Reg_Field['etc_field21'] = array(
'167'=>'EMT (응급구조사)',
'168'=>'Etc (기타)',
'169'=>'Fellow (전임의)',
'170'=>'Military MD (군의관)',
'171'=>'Military Nurse, Military EMT, Other Military (군간호사, 군응급구조사, 그 외 군 관련)',
'172'=>'Nurse (간호사)',
'173'=>'Overseas Registrant',
'174'=>'PPTC Faculty',
'175'=>'Professor (교수,전문의)',
'176'=>'Resident (전공의)',
'177'=>'RT (방사선사)',
'178'=>'Student (학생)',
'179'=>'-',
);

$_Reg_Field['Search'] = array(
'name_kr'=>array('title'=>'성명', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'name_eng'=>array('title'=>'성명(영문)', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'aff_kor'=>array('title'=>'소속', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'aff_eng'=>array('title'=>'소속(영문)', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'license_number'=>array('title'=>'면허번호', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'cell'=>array('title'=>'연락처', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'email'=>array('title'=>'이메일', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'classification'=>array('title'=>'등록구분', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'pay_status'=>array('title'=>'입금여부', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'Y'),
'gubun1'=>array('title'=>'카테고리', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'country'=>array('title'=>'국내/외', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'N'),
'country_name'=>array('title'=>'국가명', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'gubun2'=>array('title'=>'학회회원', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'etc_field1'=>array('title'=>'소속학회', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'etc_field2'=>array('title'=>'결제수단', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'Y'),
'etc_field3'=>array('title'=>'DESK', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'N'),
'etc_field4'=>array('title'=>'전공과목', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'title'=>array('title'=>'직위', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'original_sid'=>array('title'=>'접수번호', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'event_chk'=>array('title'=>'럭키드로우', 'kind'=>'R', 'Search'=>'Y', 'list_modify'=>''),
'gubun3'=>array('title'=>'부스', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'gubun4'=>array('title'=>'등록구분(3)', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'etc_field5'=>array('title'=>'갈라디너 참여', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'Y'),
'etc_field10'=>array('title'=>'아이디', 'kind'=>'I', 'Search'=>'Y', 'list_modify'=>''),
'etc_field11'=>array('title'=>'갈라디너 대상', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>'Y'),
'etc_field20'=>array('title'=>'등록구분(2)', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
'etc_field21'=>array('title'=>'등록카테고리', 'kind'=>'S', 'Search'=>'Y', 'list_modify'=>''),
);

?>