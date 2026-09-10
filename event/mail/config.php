<?
###########################
## 아래 내용을 꼭 맞춰주세요.(권한 707)
##
## 주소록 엑셀 경로 : /upload/excel/
## 메일 발송 첨부 파일 경로 : /upload/group_mail/
## 네이버에디터 업로드경로 : /upload/naver_editor/ 
##
## 주소록 DB : tp_addgrcode, tp_addgrinfo
##
##
##
##
###########################




######## 홈페이지별 function 파일
require_once $DOCUMENT_ROOT . "func/include.function.php";

######## 홈페이지별 config 파일
require_once $DOCUMENT_ROOT . "func/config.php";

######## 홈페이지별 db connection 파일
require_once $DOCUMENT_ROOT . "func/include.connect.php";

######## 한 페이지당 출력할 게시물의 수
$num_per_page = 15;

######## 게시물목록 하단에 링크를 걸 페이지의 개수
$page_per_block = 15;

//$receiv_arr = array('ALL'=>'전체회원',"A"=>"정회원", "R"=>"준회원",'NOT'=>'미납회원','YES'=>'완납회원');
######## 템플릿 설정
$template_arr = array('1'=>'템플릿 1', '2'=>'템플릿 1', '8'=>'템플릿 없음');


######## 템플릿 버튼 설정
$btn_arr = array('1'=>'자세히 보기','2'=>'바로가기','N'=>'사용안함',);

######## 메일 발송 테이블
$mail_tbl = "send_email";

######## 발송 대상 테이블
$mail_list_tbl = "mail_list_tbl";

######## 발송 대상
$_MAIL['to_name_group'] = array('1'=>'회원발송','3'=>'주소록발송','4'=>'테스트발송','9'=>'직접발송');


######## 회원 권한별 - 회원 발송 대상시 사용
$_MEMBER_LEVEL = $_CONFIG['member_gubun1'];

######## 이케어넘버
$_ECARE_NO = "224";

$society_name = "대한신경외과학회";
$adminEmail = "kns61@neurosurgery.or.kr";

######## 메뉴번호
$split_url = explode('/',$PHP_SELF);
if($split_url[3] == 'list.php'){
	## 메일 관리 메뉴번호
	$main_num=11;
	$sub_num=1;
}else{
	## 주소록 메뉴번호
	$main_num=11;
	$sub_num=2;
}

$_SEARCH['field9'] = array('c_name'=>'성명','c_email'=>'이메일');
$_SEARCH['field8'] = array('c_grname'=>'주소록명');

$_MEMBER['field1'] = array('name_kr'=>'성명','email'=>'이메일','id'=>'아이디');
//$society_name = $society_name;


######## 홈페이지별 관리자 헤더,푸터 파일
$_header_file = $DOCUMENT_ROOT . "admin/include.header.php";
$_footer_file = $DOCUMENT_ROOT . "admin/include.footer.php";

######## 스타일 및 js 파일 경로

$_js_css = '
<link type="text/css" rel="stylesheet" href="/css/neurosurgery.css" />
<link type="text/css" rel="stylesheet" href="/css/neurosurgery_sub.css" />
<link type="text/css" rel="stylesheet" href="/admin/mail/admin.css" />
<!--[if lt IE 8]>
<script type="text/javascript">
//<![CDATA[
	var IE7_PNG_SUFFIX = ".png";
//]]>
</script>
<script type="text/javascript" src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->
<script type="text/javascript" src="/script/jquery.min.1.7.1.js"></script>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
';


?>