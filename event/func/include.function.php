<?
###### Default Define
define('M2', true);
define('SALT', 'carden');

if(!strcmp(substr($_SERVER['DOCUMENT_ROOT'], -1), '/')){
	define('ROOT', substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT'])-1));
} else {
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
}
header('Content-Type: text/html; charset=utf-8');

###### Variable Arrangements
if(!get_magic_quotes_gpc()){

	if (is_array($_REQUEST))
		foreach($_REQUEST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_REQUEST[$_tmp['k']]))
				foreach($_REQUEST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
					$_REQUEST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_REQUEST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);

	if (is_array($_GET))
		foreach($_GET as $_tmp['k'] => $_tmp['v'])
			if (is_array($_GET[$_tmp['k']]))
				foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
					$_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);

	if (is_array($_POST))
		foreach($_POST as $_tmp['k'] => $_tmp['v'])
			if (is_array($_POST[$_tmp['k']]))
				foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1'])
					$_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
			else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
			
}else {
	if (!ini_get('register_globals')){
		extract($_GET);
		extract($_POST);
	}
}


// 암호화
function Encrypt($val){
	return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $val, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}
//복원
function Decrypt($val){
	return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($val), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}


##패스워드 형식
function pass_encrypy($val){
	$new_val = hash("sha512",MD5($val));

	return $new_val;
}
##패스워드 형식
function encryp($val){
	$new_val = hash("sha512",MD5($val));

	return $new_val;
}


##### 입력한 비밀번호가 암호화된 비밀번호와 일치하는지 검사한다.
function isIdenticalByCryptedPasswd($uncrypted,$crypted)
{
   if(!strcmp(crypt($uncrypted,$crypted),$crypted))
      return TRUE;
   else
      return FALSE;
}

function PutValueParentImage($val,$url,$target1,$target2){
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "$('#" . $target1 . "',parent.document).val('" . $val . "');";
	$print .= "$('#" . $target2 . "',parent.document).css('background','none');";
	$print .= "$('#" . $target2 . "',parent.document).html('<img src=\'" . $url . $val . "\' border=0 width=110>');";
	$print .= "//]]>\n</script>\n";
	print($print);
}

###### Alert Functions Start
function PutMessageRefreshURL($msg,$url)
{
	print("<script language=\"JavaScript\">
		  <!--
		  alert('$msg');
		  //-->
		  </script>");
	print("<meta http-equiv='Refresh' content='0; url=$url'>");
	exit();
}
function PutParentLocation($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "parent.location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}
function PutMessage($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "//]]>\n</script>\n";
	print($print);
}

function PutMessageBack($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "history.back();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}
function PutMessageMain($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "location.href='/';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}
function PutMessageClose($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\nself.close();";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageCloseOpenerLocation($msg,$url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "opener.location.href='${url}';\n";
	$print .= "self.close();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageCloseOpenerOpenerLocation($msg,$url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "opener.opener.location.href='${url}';\n";
	$print .= "opener.window.close();self.close();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutCloseOpenerLocation($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "opener.location.href='${url}';\n";
	$print .= "self.close();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}



function PutMessageCloseOpenerReload($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "opener.location.reload();\n";
	$print .= "self.close();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageLocation($msg,$url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageTopLocation($msg,$url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "top.location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutLocation($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function OpenerReload() {
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}
function OpenerReload_location($msg,$url) {
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "opener.location.reload();\n";
	$print .= "location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function TargetReload() {
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageOpenerReload($msg) {
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert('" . $msg . "');\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}



function PutMessageParentReload($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert(\"${msg}\");\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

###### Alert Functions End

###### Redirect Functions Start
function RefreshURL($url){ print("<meta http-equiv='Refresh' content='0; url=${url}'>"); exit; }

function redirect($url) {
   $url = urlencode($url);
   echo "<meta http-equiv='Refresh' content='0; URL=/login.php?url=${url}'>";
   exit;
}

function redirect_unmem($url) {
   $url = urlencode($url);
   echo "<meta http-equiv='Refresh' content='0; URL=/member/?url=${url}&order=Y'>";
   exit;
}
function redirectParent($url){
   //$url = urlencode($url);
   echo "<script>
    var category_sid = parent.document.getElementsByName('category_sid')[0].value;
    var product_sid = parent.document.getElementsByName('product_sid')[0].value;
   	parent.location.href='/member/?url='+encodeURIComponent('${url}?category_sid='+category_sid+'&product_sid='+product_sid+'#view_tab_3');
   </script>";
   exit;
}

function LoginedChk(){
   GLOBAL $HTTP_COOKIE_VARS,$REQUEST_URI;
   if(!$HTTP_COOKIE_VARS["member_id"]) {
      PutMessage('로그인 하신 후 이용하실 수 있습니다.');
      redirect($REQUEST_URI);
   } else {
      return TRUE;
   }
}

function already_LoginedChk(){
   GLOBAL $HTTP_COOKIE_VARS,$REQUEST_URI;
   if($HTTP_COOKIE_VARS["member_id"]) {
      PutMessageBack('이미 로그인하셨습니다.');
      exit;
   } else {
      return TRUE;
   }
}

function LoginedChk_membership(){
   GLOBAL $HTTP_COOKIE_VARS,$REQUEST_URI;
   if($HTTP_COOKIE_VARS["member_level"]=="3" || $HTTP_COOKIE_VARS["member_level"]=="4" || $HTTP_COOKIE_VARS["member_level"]=="M") {
      return true;
   } else {
      PutMessageBack('회원공간은 연회원, 평생회원만 이용가능합니다.');
      exit;
   }
}

function redirect_p($url) {
   $url = urlencode($url);
   putMessage("로그인 후 사용해주세요");
   echo "<meta http-equiv='Refresh' content='0; URL=/?url=$url'>";
   exit;
}
###### Redirect Functions End

###### Login Check Functions Start
# 로그인 회원 체크
function isLogined() {
	global $_COOKIE;
	if($_COOKIE['wmember_sid']){
		return true;	
	}else{ 
		
		return false;
	}
	
}

//회원 승인여부를 검사
function isMember_confirm(){
	global $_COOKIE;
	if($_COOKIE['member_confirm'] == 'N'){
		PutMessageBack('회원 승인 후 사용 가능합니다.');
	}
}

//대기, 회원, 관리자 등급중 대기는 접근 불가
function isMember_level(){
	global $_COOKIE;
	if($_COOKIE['member_level'] == 'A'){
		PutMessageBack('회원등급이 아닙니다.');
	}
}



/*척추 신경만 사용*/

##### 현재의 사용자가 정회원,종신회원 인지 조사
function isLogined_23(){
	GLOBAL $_COOKIE;
	if($_COOKIE['member_sid'] != "" && ($_COOKIE['member_level'] == "2" || $_COOKIE['member_level'] == "3"  ) ){
		return true;
	}else{
		return false;
	}
}

##### 현재의 사용자가 준회원,정회원,종신회원 인지 조사
function isLogined_123(){
	GLOBAL $_COOKIE;
	if($_COOKIE['member_sid'] != "" && ($_COOKIE['member_level'] == "1" || $_COOKIE['member_level'] == "2" || $_COOKIE['member_level'] == "3"  ) ){
		return true;
	}else{
		return false;
	}
}



function isDoctorLogined() {
   GLOBAL $_COOKIE;
   if(strcmp($_COOKIE["member_kind"],'D') || !$_COOKIE["member_sid"]) {
      return FALSE;
   } else {
      return TRUE;
   }
}

##### 현재의 사용자가 정회원인지 조사
function isRegularLogined() {
   GLOBAL $_COOKIE;
  if(!$_COOKIE["member_sid"] || ($_COOKIE["member_level"] != "2" && $_COOKIE["member_level"] != "3" && $_COOKIE["member_level"] != "A")) {
      return FALSE;
   } else {
      return TRUE;
   }
}
/*척추 신경만 사용*/


# 증례 회원 체크
function isCaseLogined() {
	global $_COOKIE;
	if($_COOKIE['case_member_id']) return true;
	return false;
}

# 수련병원 로그인 회원 체크
function isLogined_h() {
	global $_COOKIE;
	if($_COOKIE['h_member_id']) return true;
	return false;
}

function isMemLogined() {
	global $_COOKIE;
	if($_COOKIE['member_id']) {
		echo "<script>location.href='/member/modifyform.php';</script>";
	}
}

# 어드민 회원체크
function isAdminLogined() {
	global $_COOKIE, $conn;
	
	if(eregi('M',$_COOKIE['wmember_level'])){
		/* 관리자 쿠키 위변조를 위해 회원테이블 한번더 검색 추가할것*/
		return true;
	}else{
		return false;
	}
}

/**
 * 최고관리자 여부
 * - registration_tbl 재조회 (쿠키만 믿지 않음)
 * - member_level='M' 이고 id 가 $_CONFIG['super_admin_ids'] 에 포함
 * - 목록이 비어 있으면 master_ip 접속만 임시 허용
 */
function isSuperAdminLogined() {
	global $_COOKIE, $_CONFIG, $conn, $master_ip;

	if (!isAdminLogined()) {
		return false;
	}

	$usid = isset($_COOKIE['wmember_sid']) ? (int)$_COOKIE['wmember_sid'] : 0;
	if ($usid < 1 || !is_object($conn)) {
		return false;
	}

	$chk = $conn->query(
		'SELECT sid, id, member_level FROM registration_tbl WHERE sid = ? AND del = ?',
		array($usid, 'N')
	);
	if (DB::isError($chk)) {
		error_log('[SuperAdmin] select failed: '.$chk->getMessage());
		return false;
	}
	$row = $chk->fetchRow(DB_FETCHMODE_ASSOC);
	$chk->free();
	if (!$row || !(int)$row['sid']) {
		return false;
	}
	if (!isset($row['member_level']) || !eregi('M', $row['member_level'])) {
		return false;
	}

	$superIds = array();
	if (isset($_CONFIG['super_admin_ids']) && is_array($_CONFIG['super_admin_ids'])) {
		foreach ($_CONFIG['super_admin_ids'] as $oneId) {
			$oneId = trim((string)$oneId);
			if ($oneId != '') {
				$superIds[] = $oneId;
			}
		}
	}

	$loginId = isset($row['id']) ? trim((string)$row['id']) : '';
	if ($superIds) {
		return in_array($loginId, $superIds);
	}

	$remoteAddr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (isset($master_ip) && $master_ip != '' && $remoteAddr == $master_ip) {
		return true;
	}
	return false;
}

## 관리자 메뉴별 권한 체크
function isMenuLogined(){
	global $_COOKIE, $conn;
	
	$menu_chk_qry = "select menu_level from user_binfo where id='".$_COOKIE['member_id']."' ";
	$menu_level = $conn->getOne($menu_chk_qry);

	if($menu_level == 'all') return false;
	else return true;
}

# 학술대회 어드민 회원체크
function isHakAdminLogined() {
	global $_COOKIE;
   if($_COOKIE['workshop_member_level'] == "H" || $_COOKIE['member_level'] == "M"){
      return TRUE;
   } else {
      return FALSE;
   }
	return false;
}
# 학술대회 출판사 회원체크
function isPrintAdminLogined() {
	global $_COOKIE;
   if($_COOKIE['workshop_member_level'] == "P"){
      return TRUE;
   } else {
      return FALSE;
   }
	return false;
}
# 학술대회 현장등록
function isNowAdminLogined() {
	global $_COOKIE;
   if($_COOKIE['workshop_member_level'] == "U"){
      return TRUE;
   } else {
      return FALSE;
   }
	return false;
}
##### 현재의 사용자가 회원관리자인지 조사
function isAdminLoginedMem() {
   GLOBAL $HTTP_COOKIE_VARS;
   if(($HTTP_COOKIE_VARS[member_level] == "Q") || ($HTTP_COOKIE_VARS[member_level] == "M")){
      return TRUE;
   } else {
      return FALSE;
   }
}

##### 로그인하지 않은 사용자의 경우 로그인페이지로 보낸다.
function redirectadmin($url) {
   echo "<meta http-equiv='Refresh' content='0; URL=/member/index.html?url=" . $url . "'>";
   exit;
}

##### 현재의 사용자가 클럽관리자인지 조사
function isClubAdminLogined() {
   GLOBAL $HTTP_COOKIE_VARS;
    if(($HTTP_COOKIE_VARS[clubuser_level] == "M") || ($HTTP_COOKIE_VARS[member_level] == "M")){
      return TRUE;
   } else {
      return FALSE;
   }
}


# 로그인 체크 후 비로그인시 로그인 페이지로
function procLoginChk() {
	global $_COOKIE,$_SERVER;
	if(isLogined()) return;
	else redirect("${_SERVER[PHP_SELF]}?${_SERVER[QUERY_STRING]}");
}

# 발표자료때문에 따로 생성함.
function procLoginChk2() {
	global $_COOKIE,$_SERVER;
	if(isLogined()) return;
	else PutMessage("회원만 확인 가능합니다."); redirect("${_SERVER[PHP_SELF]}?${_SERVER[QUERY_STRING]}");
}

function procLoginChkParent(){
	global $_COOKIE,$_SERVER;
	if(isLogined()) return;
	else redirectParent("/product/view.php");
}

function procLoginChk_unmem() {
	global $_COOKIE,$_SERVER;
	if(isLogined()) return;
	else redirect_unmem("${_SERVER[PHP_SELF]}?${_SERVER[QUERY_STRING]}");
}

# 관리자 체크 후 경고메세지
function procAdminLoginChk() {
	global $_COOKIE,$_SERVER;
	procLoginChk();
	if(isAdminLogined()) return;
	else PutMessageBack('관리자만 이용가능한 페이지 입니다.');
}

# 관리자 체크 후 경고메세지
function procAdminLoginChk_S() {
	global $_COOKIE,$_SERVER;
	procLoginChk_S();
	if(isAdminLogined()) return;
	else PutMessageBack('관리자만 이용가능한 페이지 입니다.');
}

###### Content Check Functions
# 데이터 존재 확인
function isContentNull($content) {
	if(trim($content)) return true;
	return false;
}
function isContentsNull($content){ return iscontentNull($content); }

##### 입력한 항목의 값이 NULL값인지의 여부를 반환한다.
function isContentsNull2($contents) {
   if(!$contents)
      return TRUE;

   if(!ereg("([^[:space:]]+)", $contents))
      return TRUE;
   else
      return FALSE;
}

# 아이디는 영문자로 시작 되어야 하며 4~16자리이다.
function isCorrectId($id) { return ereg("^[[:alpha:]]+[[:alnum:]+]{4,16}",$id); }

# 비밀번호 기본 조건 6~20개의 영문 혹은 숫자 여야 한다.
function isCorrectPw($passwd) { return ereg("[[:alnum:]+]{6,12}",$passwd); }

# 이메일 체크
function isCorrectEmail($email) {
	return ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email);
}

# 홈페이지 체크
function isCorrectHomepage($homepage) { return ereg("http://([0-9a-zA-Z./@~?&=_]+)", $homepage); }

# 숫자체크
function isCorrectNumber($value) { return is_numeric($value); }

# 쿼리문 정리
function getValueForQuery($value) {
	if(!get_magic_quotes_gpc()) $value = addslashes($value);
	return $value;
}


function UnQuotedStr($buf){ return stripslashes($buf); }

# 문자열 커팅.
function strCut($msg,$cut_size,$dot=true) {
	# UTF 8일 경우...
	return utf8_strcut($msg, $cut_size, $dot);

	if($cut_size > strlen($msg)) return $msg;
	$ishan1=0; $ishan2=0;
	for($i=0;$i<strlen($msg);$i++) {
		if($ishan1==1) $ishan2=1;
		if(ord($msg[$i]) >127 && $ishan1==0)  {$ishan2=0; $ishan1=1;}
		if($ishan2==1) $ishan1=0;
		if (($i+1)==$cut_size) {
			if ($ishan2!=1) break;
			$temp_str.=$msg[$i];
			break;
		}
		$temp_str.=$msg[$i];
	}
	if($dot==true) $temp_str.="...";
	return $temp_str;
}

function str_cut($msg, $cut_size, $dot=true) {
	return strCut($msg, $cut_size, $dot);
}

function cut_str($str,$max_len)
{
 $return_str = mb_substr($str, 0 ,$max_len);
 return (mb_strlen($str)>$max_len)?$return_str."..":$str;
}

function utf8_strcut( $str, $size, $dot=true){
	$substr = substr( $str, 0, $size * 2 );
	$multi_size = preg_match_all( '/[\\x80-\\xff]/', $substr, $multi_chars );

	if ( $multi_size > 0 ) $size = $size + intval( $multi_size / 3 ) - 1;

	if ( strlen( $str ) > $size ) {
		$str = substr( $str, 0, $size );
		$str = preg_replace( '/(([\\x80-\\xff]{3})*?)([\\x80-\\xff]{0,2})$/', '$1', $str );
		if($dot==true) $str .= '...';
	}
	return $str;
}

# 파일 아이콘 정리
function IconType($filename, $iconlocation='', $str) {
	
	if(!is_dir($_SERVER['DOCUMENT_ROOT'].$iconlocation)) $iconlocation='/image/icon/';
	$icon_value=explode(".",$filename);
	$tmp=strtolower(array_pop($icon_value));
	
	switch($tmp){
		case 'avi': case 'doc': case 'docx': case 'ppt': case 'pptx': case 'exe': case 'gif': case 'jpg': case 'hwp':
		case 'pdf':	case 'mp3': case 'wav': case 'xls': case 'xlsx': case 'zip': case 'alz': break;
		default: $icon='etc'; break;
	}
	
	if($str) return printImg("${iconlocation}${str}${tmp}.gif", $filename,false, 'align="middle"');
	else return printImg("${iconlocation}${tmp}.gif", $filename,false, 'align="middle"');
}

function IconType2($filename) {
	$icon_value=explode(".",$filename);
	$num = count($icon_value)-1;
	if((!strcmp($icon_value[$num],"csv")) OR (!strcmp($icon_value[$num],"CSV")))  $img_icon="<img src=\"/image/icon/icon_xls.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"avi")) OR (!strcmp($icon_value[$num],"AVI")))  $img_icon="<img src=\"/image/icon/icon_avi.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"doc")) OR (!strcmp($icon_value[$num],"DOC")))	$img_icon="<img src=\"/image/icon/icon_doc.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"docx")) OR (!strcmp($icon_value[$num],"DOCX")))	$img_icon="<img src=\"/image/icon/icon_docx.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"ppt")) OR (!strcmp($icon_value[$num],"PPT")))	$img_icon="<img src=\"/image/icon/icon_ppt.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"exe")) OR (!strcmp($icon_value[$num],"EXE")))	$img_icon="<img src=\"/image/icon/icon_exe.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"gif")) OR (!strcmp($icon_value[$num],"GIF")))	$img_icon="<img src=\"/image/icon/icon_gif.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"jpg")) OR (!strcmp($icon_value[$num],"JPG")))	$img_icon="<img src=\"/image/icon/icon_jpg.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"hwp")) OR (!strcmp($icon_value[$num],"HWP")))	$img_icon="<img src=\"/image/icon/icon_hwp.gif\" width=13 heigth=14 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"pdf")) OR (!strcmp($icon_value[$num],"PDF")))	$img_icon="<img src=\"/image/icon/icon_pdf.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"mp3")) OR (!strcmp($icon_value[$num],"MP3")))	$img_icon="<img src=\"/image/icon/icon_mp3.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"wav")) OR (!strcmp($icon_value[$num],"WAV")))	$img_icon="<img src=\"/image/icon/icon_wav.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"xls")) OR (!strcmp($icon_value[$num],"XLS")))	$img_icon="<img src=\"/image/icon/icon_xls.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"zip")) OR (!strcmp($icon_value[$num],"ZIP")))  $img_icon="<img src=\"/image/icon/icon_zip.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"ppt")) OR (!strcmp($icon_value[$num],"PPT")))  $img_icon="<img src=\"/image/icon/icon_ppt.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"pptx")) OR (!strcmp($icon_value[$num],"PPTX")))  $img_icon="<img src=\"/image/icon/icon_pptx.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"xlsx")) OR (!strcmp($icon_value[$num],"XLSX")))  $img_icon="<img src=\"/image/icon/icon_xlsx.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if((!strcmp($icon_value[$num],"png")) OR (!strcmp($icon_value[$num],"PNG")))  $img_icon="<img src=\"/image/icon/icon_png.png\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";
	if(!$img_icon) $img_icon="<img src=\"/image/icon/icon_etc.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\" align=\"absmiddle\">";

	return $img_icon;
}


function IconType3($filename) {
	$icon_value=explode(".",$filename);
	$num = count($icon_value)-1;
	if((!strcmp($icon_value[$num],"csv")) OR (!strcmp($icon_value[$num],"CSV")))  $img_icon="/image/icon/icon_xls.gif";
	if((!strcmp($icon_value[$num],"avi")) OR (!strcmp($icon_value[$num],"AVI")))  $img_icon="/image/icon/icon_avi.gif";
	if((!strcmp($icon_value[$num],"doc")) OR (!strcmp($icon_value[$num],"DOC")))	$img_icon="/image/icon/icon_doc.gif";
	if((!strcmp($icon_value[$num],"docx")) OR (!strcmp($icon_value[$num],"DOCX")))	$img_icon="/image/icon/icon_docx.gif";
	if((!strcmp($icon_value[$num],"ppt")) OR (!strcmp($icon_value[$num],"PPT")))	$img_icon="/image/icon/icon_ppt.gif";
	if((!strcmp($icon_value[$num],"exe")) OR (!strcmp($icon_value[$num],"EXE")))	$img_icon="/image/icon/icon_exe.gif";
	if((!strcmp($icon_value[$num],"gif")) OR (!strcmp($icon_value[$num],"GIF")))	$img_icon="/image/icon/icon_gif.gif";
	if((!strcmp($icon_value[$num],"jpg")) OR (!strcmp($icon_value[$num],"JPG")))	$img_icon="/image/icon/icon_jpg.gif";
	if((!strcmp($icon_value[$num],"hwp")) OR (!strcmp($icon_value[$num],"HWP")))	$img_icon="/image/icon/icon_hwp.gif";
	if((!strcmp($icon_value[$num],"pdf")) OR (!strcmp($icon_value[$num],"PDF")))	$img_icon="/image/icon/icon_pdf.gif";
	if((!strcmp($icon_value[$num],"mp3")) OR (!strcmp($icon_value[$num],"MP3")))	$img_icon="/image/icon/icon_mp3.gif";
	if((!strcmp($icon_value[$num],"wav")) OR (!strcmp($icon_value[$num],"WAV")))	$img_icon="/image/icon/icon_wav.gif";
	if((!strcmp($icon_value[$num],"xls")) OR (!strcmp($icon_value[$num],"XLS")))	$img_icon="/image/icon/icon_xls.gif";
	if((!strcmp($icon_value[$num],"zip")) OR (!strcmp($icon_value[$num],"ZIP")))  $img_icon="/image/icon/icon_zip.gif";
	if((!strcmp($icon_value[$num],"ppt")) OR (!strcmp($icon_value[$num],"PPT")))  $img_icon="/image/icon/icon_ppt.gif";
	if((!strcmp($icon_value[$num],"pptx")) OR (!strcmp($icon_value[$num],"PPTX")))  $img_icon="/image/icon/icon_pptx.gif";
	if((!strcmp($icon_value[$num],"xlsx")) OR (!strcmp($icon_value[$num],"XLSX")))  $img_icon="/image/icon/icon_xlsx.gif";
	if((!strcmp($icon_value[$num],"png")) OR (!strcmp($icon_value[$num],"PNG")))  $img_icon="/image/icon/icon_png.png";
	if(!$img_icon) $img_icon="/image/icon/icon_etc.gif";

	return $img_icon;
}

# stripslashes 개량
function _stripslashes(&$var) {
	if(!is_array($var)) { $var=stripslashes($var); }
	else {
		foreach($var as $k => $v){
			if(is_array($v)){ _stripslashes(&$v); }
			else { $var[$k]=stripslashes($v); }
		}
	}
}

# 업로드시 파일네임 리네임
function renameFile($filename, $savedir) {
	$splitname=explode(".",$filename);
	$namesize=sizeof($splitname);
	$extension=$splitname[$namesize-1];

	$i=1;
	while(file_exists($savedir.$filename)){
		if($i==1){
			$fname="";
			if($namesize>2){
				for($j=0; $j<$namesize-1; $j++){
					$fname.=$splitname[$i];
					if($i<$namesize-2)
						$fname.=".";
				}
			} else {
				$fname=$splitname[0];
			}
			$fname.="[${i}].${extension}";
		} else {
			$fname=ereg_replace("\[".($i-1)."\]","[${i}]",$filename);
		}
		$filename=$fname;
		$i++;
	}
	return $filename;
}

# 자동으로 링크 걸기
function autolink($html) {
	if($html && $html != "http://"){
	return preg_replace_callback('~((?:https?|ftps?|ed2k|mmst?)://|//)?((\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|(?:[a-z\d\-\.]+(?:\.(com|net|org|af|al|dz|as|ad|ao|ai|aq|ag|ar|am|aw|au|at|az|bs|bh|bd|bb|by|be|bz|bj|bm|bt|bo|ba|bw|bv|br|io|vg|bn|bg|bf|bi|kh|cm|ca|cv|ky|cf|td|cl|cn|cx|cc|co|km|cd|cg|ck|cr|ci|cu|cy|cz|dk|dj|dm|do|ec|eg|sv|gq|er|ee|et|fo|fk|fj|fi|fr|gf|pf|tf|ga|gm|ge|de|gh|gi|gr|gl|gd|gp|gu|gt|gn|gw|gy|ht|hm|va|hn|hk|hr|hu|is|in|id|ir|iq|ie|il|it|jm|jp|jo|kz|ke|ki|kp|kr|kw|kg|la|lv|lb|ls|lr|ly|li|lt|lu|mo|mk|mg|mw|my|mv|ml|mt|mh|mq|mr|mu|yt|mx|fm|md|mc|mn|ms|ma|mz|mm|na|nr|np|an|nl|nc|nz|ni|ne|ng|nu|nf|mp|no|om|pk|pw|ps|pa|pg|py|pe|ph|pn|pl|pt|pr|qa|re|ro|ru|rw|sh|kn|lc|pm|vc|ws|sm|st|sa|sn|cs|sc|sl|sg|sk|si|sb|so|za|gs|es|lk|sd|sr|sj|sz|se|ch|sy|tw|tj|tz|th|tl|tg|tk|to|tt|tn|tr|tm|tc|tv|vi|ug|ua|ae|gb|um|us|uy|uz|vu|ve|vn|wf|eh|ye|zm|zw))))(:\d+)?(?:([^/\s\)\x80-\xff])|/[^ \)<>\r\n]*)?)~im', 'autolink_callback', $html);
	}

}

//function autolink_callback($matches) {
//	if( isset($matches[6]) ) { if( $matches[6] != '' ) { return $matches[0]; } }
//	$link = '';
//	if( $matches[1] != '' ) { $link .= $matches[1]; } else { $link .= 'http://'; }
//	$link .= $matches[2];
//	$url = $link;
//	$arr = explode('?',$link);
//	if ( isset($arr[1]) ) {
//		$ar = explode('&',$arr[1]);
//		foreach ( $ar as &$v ) {
//			$i = explode('=',$v);
//			$v = $i[0];
//			if ( isset($i[1]) ) {
//				$str = $i[1];
//				if ( preg_match('/[\x80-\xff]+/',$str) ) { $v .= '='.urlencode($i[1]); } else { $v .= '='.$i[1]; }
//			}
//		}
//		$arr[1] = implode('&amp;',$ar);
//		$url = $arr[0].'?'.$arr[1];
//	}
//	$urlHtm = htmlspecialchars($matches[0]);
//	return '<a href="'.$url.'" title="'.$urlHtm.'" onclick="window.open(this.href); return false;">'.$urlHtm.'</a>';
//}

function myEditor($wmode,$editor_Url,$formName,$contentForm,$textWidth,$textHeight,$lang=''){
	global $contents,$upload_image,$upload_media,$msg,$html, $DOCUMENT_ROOT;

	if(empty($wmode)) $wmode = '1';
	if(empty($html)) $html = 'y';
	if(empty($editor_Url)) $editor_Url = '.';
	if(empty($formName)) $formName = 'add_form';
	if(empty($contentForm)) $contentForm = 'contents';
	$textWidth = $textWidth ? $textWidth : '100%';
	$textHeight = $textHeight ? $textHeight : '200';
	$lang = $lang ? $lang : 'euc-kr';
	if($wmode==1){
		@include_once ($DOCUMENT_ROOT . $editor_Url.'/editor.html');
    $html='y';
	}
	else{
    $html='n';
		ECHO "
		<textarea style='width:".$textWidth.";' rows=20 name='".$contentForm."' wrap='physical' style='ime-mode: active' class='input'>".$contents."</textarea>
		";
	}
}



# 이미지 태그 자동 넣기
function printImg($src, $alt='', $type=false, $opt='') {
	if(!$src) return '이미지를 입력해 주세요';
	$root=$_SERVER['DOCUMENT_ROOT'];
	if(!strcmp('/', substr($root, -1))) $root=substr($root, 0, strlen($root)-1);
	$local=$root.$src;
	if(!file_exists($local)) return '';
	$info = getimagesize($local);
	if(!$type){
		return "<img src=\"${src}\" width=\"${info[0]}\" height=\"${info[1]}\" alt=\"${alt}\" ${opt}/>";
	} else {
		return "<input type=\"image\" src=\"${src}\" width=\"${info[0]}\" height=\"${info[1]}\" alt=\"${alt}\" ${opt} border=\"0\" />";
	}
}

# 이미지 태그 자동 넣기
function printImg2($src, $alt='', $type=false, $opt='') {
	if(!$src) return '이미지를 입력해 주세요';
	$root=$_SERVER['DOCUMENT_ROOT'];
	if(!strcmp('/', substr($root, -1))) $root=substr($root, 0, strlen($root)-1);
	$local=$root.$src;
	if(!file_exists($local)) return '';
	$info = getimagesize($local);
	if(!$type){
		return "<img src=\"${src}\" style=\"width:${info[0]}px; height:${info[1]}px\" alt=\"${alt}\" ${opt}/>";
	} else {
		return "<input type=\"image\" src=\"${src}\" style=\"width:${info[0]}px; height:${info[1]}px\"  alt=\"${alt}\" ${opt}  />";
	}
}





# FLASH 태그 넣기... (iPhone 대응)
function swf($swf, $img, $width, $height, $alt='') {
	$dirswf=$_SERVER['DOCUMENT_ROOT'].substr($swf, 1, strlen($swf)-1);
	$dirimg=$_SERVER['DOCUMENT_ROOT'].substr($img, 1, strlen($img)-1);

	if(!$swf || !file_exists($dirswf)){ return 'FLASH FILE IS NULL'; }
	if(!$img || !file_exists($dirimg)){	return 'IMAGE FILE IS NULL'; }
	if(isiPhone()){ # iPhone
		$return = printImg($img, $alt);
	} else { # PC
		$return = "<script type=\"text/javascript\">\n//<![CDATA[\n";
		$return .= "document.write(\"<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'\");\n";
		$return .= "document.write(\"        codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' width='${width}' height='${height}'>\");\n";
		$return .= "document.write(\"<param name='movie' value='${swf}'>\");\n";
		$return .= "document.write(\"<param name='quality' value='high'>\");\n";
		$return .= "document.write(\"<embed src='${swf}' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='${width}' height='${height}'></embed>\");\n";
		$return .= "document.write(\"</object>\");\n";
		$return .= "//]]>\n</script>\n";
	}
	return $return;
}


# 배열을 셀렉트 박스로
# $arr 에는 반드시 셀렉트 박스로 만들 배열입력
# $id 에는 셀렉트 박스의 name, id
# $value 에는 선택될 값
# $option 에는 자바스크립트 이벤트등 입력.
function printSelectBox($arr, $id, $value='', $option='', $f_value = '') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$return="<select name=\"${id}\" id=\"${id}\" ${option} >\n";

	if($f_value){
		$return.="<option value=\"\">".$f_value."</option>\n";
	}

	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey)){
			$return.="<option value=\"${tkey}\" selected=\"selected\">${tval}</option>\n";
		} else {
			$return.="<option value=\"${tkey}\">${tval}</option>\n";
		}
	}
	$return.="</select>";
	return $return;
}

function printSelectBoxEmail($arr, $id, $value='', $option='') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey)){
			$return.="<option value=\"${tkey}\" selected=\"selected\">${tval}</option>\n";
		} else {
			if($value){
				if($tkey != $value){
					$return.="<option value=\"${tkey}\" selected=\"selected\">${tval}</option>\n";
				}else{
					$return.="<option value=\"${tkey}\">${tval}</option>\n";
				}
			}else{
				$return.="<option value=\"${tkey}\">${tval}</option>\n";
			}
		}
	}
	$return.="</select>";
	return $return;
}



# 배열을 셀렉트 박스로
# $arr 에는 반드시 셀렉트 박스로 만들 배열입력
# $id 에는 셀렉트 박스의 name, id
# $value 에는 선택될 값
# $option 에는 자바스크립트 이벤트등 입력.
function printSelectBox2($arr, $id, $value='', $option='') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
	$return.="<option value=\"\" selected=\"selected\">::선택::</option>\n";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey)){
			$return.="<option value=\"${tkey}\" selected=\"selected\">${tval}</option>\n";
		} else {
			$return.="<option value=\"${tkey}\">${tval}</option>\n";
		}
	}
	$return.="</select>";
	return $return;
}

function printSelectBox3($arr, $id, $value='', $option='') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
	$return.="<option value=\"\" selected=\"selected\">::선택::</option>\n";
	foreach($arr as $tval){
		if(!strcmp($value,$tval)){
			$return.="<option value=\"${tval}\" selected=\"selected\">${tval}</option>\n";
		} else {
			$return.="<option value=\"${tval}\">${tval}</option>\n";
		}
	}
	$return.="</select>";
	return $return;
}

function printSelectBox4($arr, $id, $value='', $option='') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
	$return.="<option value=\"\" selected=\"selected\">::선택::</option>\n";
	foreach($arr as $tval){
		if(!strcmp($value,$tval)){
			$return.="<option value=\"${tval}\" selected=\"selected\">${tval}회차 집담회</option>\n";
		} else {
			$return.="<option value=\"${tval}\">${tval}회차 집담회</option>\n";
		}
	}
	$return.="</select>";
	return $return;
}

# 배열을 라디오 박스로
# $arr 에는 반드시 라디오 박스로 만들 배열입력
# $id 에는 라디오 박스의 name, id
# $value 에는 선택될 값
# $option 에는 자바스크립트 이벤트등 입력.
# $br 에는 개행 여부 true, false
function printRadioBox($arr, $id, $value='', $option='', $br=false) {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$i=1;
	$return="";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey)){
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\" checked=\"checked\"/><label for=\"${id}_${i}\" class=\"hand\">${tval}</label>\n";
		} else {
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\"/><label for=\"${id}_${i}\" class=\"hand\">${tval}</label>\n";
		}
		if($br&&$i%$br==0) $return.="<br />";
		$i++;
	}
	return $return;
}

function printRadioBox2($arr, $id, $value='', $option='', $br=false) {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$i=1;
	$return="";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey)){
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\" checked=\"checked\"/><label for=\"${id}_${i}\" style=\"cursor:hand;cursor:pointer;\">${tval}</label>\n";
		} else {
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\"/><label for=\"${id}_${i}\" style=\"cursor:hand;cursor:pointer;\">${tval}</label>\n";
		}
		if($br&&$i%$br==0) $return.="<br />";
		$i++;
	}
	return $return;
}

# 배열을 체크박스로
# $arr 에는 반드시 체크박스로 만들 배열입력
# $id 에는 체크박스의 name, id
# $value 에는 선택될 값
# $option 에는 자바스크립트 이벤트등 입력.
# $br 에는 개행 여부 true, false
function printCheckBox($arr, $id, $value='', $option='', $br=false) {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";

	$i=1;
	$return="";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey) || ereg($tkey, $value)){
			$return.="<input type=\"checkbox\" name=\"${id}[]\" id=\"${id}_${i}\" ${option} value=\"${tkey}\" checked=\"checked\"/><label for=\"${id}_${i}\">${tval}</label>\n";
		} else {
			$return.="<input type=\"checkbox\" name=\"${id}[]\" id=\"${id}_${i}\" ${option} value=\"${tkey}\"/><label for=\"${id}_${i}\">${tval}</label>\n";
		}
		if($br&&$i%$br==0) $return.="<br />";
		$i++;
	}
	return $return;
}

function printCheckOne($arr, $id, $value='', $option='', $br=false) {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tkey) || ereg($tkey, $value)){
			$return.="<input type=\"checkbox\" name=\"${id}\" id=\"${id}\" ${option} value=\"${tkey}\" checked=\"checked\"/><label for=\"${id}\">${tval}</label>\n";
		} else {
			$return.="<input type=\"checkbox\" name=\"${id}\" id=\"${id}\" ${option} value=\"${tkey}\"/><label for=\"${id}\">${tval}</label>\n";
		}
	}
	return $return;
}


# 날짜 선택 셀렉트 박스
# $setDate 에는 선택될 날짜 입력 '2009-01-01' 형식
# $id 에는 year, month, day의 id, name값 입력 배열로.. 기본('year', 'month', 'day')
# $option 에는 자바스크립트 등의 이벤트. 배열시 각 배열로, 하나 입력시 전체 적용
# $startDate 에는 시작일 (최근) '2009-01-01' 형식 기본값, 지금날짜.
# $endDate 에는 종료일 (최후)  '2009-01-01' 형식 기본값, '1930-01-01'
function printSelectBoxForDate($setDate='',$id='', $option='', $startDate='',$endDate='') {

	if(!$setDate) $setDate=date("Y-m-d");
	if(!$startDate) $startDate=date("Y-m-d");
	if(!$endDate) $endDate="1930-01-01";
	if(!$id) $id=array("year","month","day");


	$setArr=explode("-",$setDate);
	$startArr=explode("-",$startDate);
	$endArr=explode("-",$endDate);

	if(is_array($option)){
		foreach($option as $tkey => $tval) { $op[$tkey]=$tval; }
	} else {
		$op[0]=$option; $op[1]=$option; $op[2]=$option;
	}

	# 연도 출력
	$return="<select name=\"${id[0]}\" id=\"${id[0]}\" ${op[0]}>\n";
	for($i=$startArr[0];$i>=$endArr[0];$i--){
		if($i==$setArr[0]) $return.="<option value=\"${i}\" selected>${i}</option>\n";
		else $return.="<option value=\"${i}\">${i}</option>\n";
	}
	$return.="</select> 년 \n";

	# 월 출력
	$return.="<select name=\"${id[1]}\" id=\"${id[1]}\" ${op[1]}>\n";
	for($i=1;$i<=12;$i++){
		if($i==$setArr[1]) $return.="<option value=\"${i}\" selected>${i}</option>\n";
		else $return.="<option value=\"${i}\">${i}</option>\n";
	}
	$return.="</select> 월 \n";

	# 일 출력
	$return.="<select name=\"${id[2]}\" id=\"${id[2]}\" ${op[2]}>\n";
	for($i=1;$i<=31;$i++){
		if($i==$setArr[2]) $return.="<option value=\"${i}\" selected>${i}</option>\n";
		else $return.="<option value=\"${i}\">${i}</option>\n";
	}
	$return.="</select> 일 \n";
	return $return;
}


//function thumbForSize($file, $save_file, $img_size, $outlinecolor){//고정사이즈로 섬네일을 추출하고 비율에 따라 축소
//	/*
//	$img_size 는 배열로 받아온다.
//	$img_size[0],$img_size[1] 은 가로가 큰 이미지일때의 고정 시킬 width, height
//	$img_size[2],$img_size[3] 은 세로가 큰 이미지일때의 고정 시킬 width, height
//	$outlinecolor 는 배열로 받아온다.
//	$outlinecolor[0] = Red
//	$outlinecolor[1] = Green
//	$outlinecolor[2] = Blue
//	*/
//
//	$img_info = getImageSize($file);
//	if($img_info[0] > 2000 || $img_info[1] > 2000) return 0;
//	if($img_info[2] == 1){ $src_img = ImageCreateFromGif($file);
//	}elseif($img_info[2] == 2){ $src_img = ImageCreateFromJPEG($file);
//	}elseif($img_info[2] == 3){ $src_img = ImageCreateFromPNG($file);
//	}else{ return 0; }
//	$img_width = $img_info[0];
//	$img_height = $img_info[1];
//
//	if($img_width > $img_height){ #가로가 큰 이미지
//		$max_width=$img_size[0]; $max_height=$img_size[1];
//		$dst_width = $max_width;
//		$dst_height = ceil(($max_width / $img_width) * $img_height);
//		if($dst_height > $max_height) $dst_height = $max_height;
//
//	} elseif($img_width > $img_height) { # 세로가 큰 이미지
//		$max_width=$img_size[2]; $max_height=$img_size[3];
//
//		$dst_height = $max_height;
//		$dst_width = ceil(($max_height / $img_height) * $img_width);
//		if($dst_width > $max_width) $dst_width = $max_width;
//
//	} else { # 정사각형 이미지
//		$max_width=$img_size[0]; $max_height=$img_size[1];
//		$dst_width = $max_height;
//		$dst_height = $max_height;
//	}
//
//	# 여백과 라인을 위해 상하좌우 각각 4픽셀씩 줄인다.
//	$dst_width-=8;
//	$dst_height-=8;
//
//	if($img_info[2] == 1){ $dst_img = imagecreate($max_width, $max_height);
//	}else{ $dst_img = imagecreatetruecolor($max_width, $max_height); }
//
//	# 입력한 색상으로 전체 이미지를 칠한다.
//	$bgc = ImageColorAllocate($dst_img, $outlinecolor[0], $outlinecolor[1], $outlinecolor[2]);
//	ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc);
//	# 백색으로 외관 1픽셀을 제외하고 칠한다.
//	$bgc = ImageColorAllocate($dst_img, 255, 255, 255);
//	ImageFilledRectangle($dst_img, 1, 1, $max_width-2, $max_height-2, $bgc);
//
//	if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 2;
//    if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 2;
//
//	ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));
//
//	if($img_info[2] == 1)
//	{
//		ImageInterlace($dst_img);
//		ImageGIF($dst_img, $save_file);
//	}elseif($img_info[2] == 2){
//		ImageInterlace($dst_img);
//		ImageJPEG($dst_img, $save_file,85);
//	}elseif($img_info[2] == 3){
//		ImagePNG($dst_img, $save_file);
//	}
//	ImageDestroy($dst_img);
//	ImageDestroy($src_img);
//}

function thumbForSize($file, $save_file, $img_size, $outlinecolor='') {
	/*
	$img_size 는 배열로 받아온다.
	$img_size[0],$img_size[1] 은 가로가 큰 이미지일때의 고정 시킬 width, height
	$img_size[2],$img_size[3] 은 세로가 큰 이미지일때의 고정 시킬 width, height
	$outlinecolor 는 배열로 받아온다.
	$outlinecolor[0] = Red
	$outlinecolor[1] = Green
	$outlinecolor[2] = Blue
	*/

	$img_info = getImageSize($file);
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){ #가로가 큰 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_width;
		$dst_height = ceil(($max_width / $img_width) * $img_height);
		if($dst_height > $max_height) $dst_height = $max_height;

	} elseif($img_width > $img_height) { # 세로가 큰 이미지
		$max_width=$img_size[2]; $max_height=$img_size[3];

		$dst_height = $max_height;
		$dst_width = ceil(($max_height / $img_height) * $img_width);
		if($dst_width > $max_width) $dst_width = $max_width;

	} else { # 정사각형 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_height;
		$dst_height = $max_height;
	}

	exec("convert -resize ${dst_width}x${dst_height} $file $save_file");
}


function thumbForSize2($file, $save_file, $img_size, $thumb_dir, $outlinecolor='') {
	/*
	$img_size 는 배열로 받아온다.
	$img_size[0],$img_size[1] 은 가로가 큰 이미지일때의 고정 시킬 width, height
	$img_size[2],$img_size[3] 은 세로가 큰 이미지일때의 고정 시킬 width, height
	$outlinecolor 는 배열로 받아온다.
	$outlinecolor[0] = Red
	$outlinecolor[1] = Green
	$outlinecolor[2] = Blue
	*/

    if(!filetype($thumb_dir)) {
        if(!@mkdir($thumb_dir,0777)) {
            echo "Unable to create $thumb_dir dir - check permissions<br>\n";
            return;
        }
    }

	$img_info = getImageSize($file);
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){ #가로가 큰 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_width;
		$dst_height = ceil(($max_width / $img_width) * $img_height);
		if($dst_height > $max_height) $dst_height = $max_height;

	} elseif($img_width > $img_height) { # 세로가 큰 이미지
		$max_width=$img_size[2]; $max_height=$img_size[3];

		$dst_height = $max_height;
		$dst_width = ceil(($max_height / $img_height) * $img_width);
		if($dst_width > $max_width) $dst_width = $max_width;

	} else { # 정사각형 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_height;
		$dst_height = $max_height;
	}

	exec("convert -resize ${dst_width}x${dst_height} $file $save_file");
	move_uploaded_file($file, $save_file);

}



function thumbForLogo($file, $save_file, $img_size){//고정사이즈로 섬네일을 추출하고 비율에 따라 축소
	/*
	$img_size 는 배열로 받아온다.
	$img_size[0],$img_size[1] 은 가로가 큰 이미지일때의 고정 시킬 width, height
	$img_size[2],$img_size[3] 은 세로가 큰 이미지일때의 고정 시킬 width, height
	$outlinecolor 는 배열로 받아온다.
	$outlinecolor[0] = Red
	$outlinecolor[1] = Green
	$outlinecolor[2] = Blue
	*/

	$img_info = getImageSize($file);
	if($img_info[0] > 2000 || $img_info[1] > 2000) return 0;
	if($img_info[2] == 1){ $src_img = ImageCreateFromGif($file);
	}elseif($img_info[2] == 2){ $src_img = ImageCreateFromJPEG($file);
	}elseif($img_info[2] == 3){ $src_img = ImageCreateFromPNG($file);
	}else{ return 0; }
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if($img_width > $img_height){ #가로가 큰 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_width;
		$dst_height = ceil(($max_width / $img_width) * $img_height);
		if($dst_height > $max_height) $dst_height = $max_height;

	} elseif($img_width > $img_height) { # 세로가 큰 이미지
		$max_width=$img_size[2]; $max_height=$img_size[3];

		$dst_height = $max_height;
		$dst_width = ceil(($max_height / $img_height) * $img_width);
		if($dst_width > $max_width) $dst_width = $max_width;

	} else { # 정사각형 이미지
		$max_width=$img_size[0]; $max_height=$img_size[1];
		$dst_width = $max_height;
		$dst_height = $max_height;
	}


	if($img_info[2] == 1){ $dst_img = imagecreate($max_width, $max_height);
	}else{ $dst_img = imagecreatetruecolor($max_width, $max_height); }

	# 백색으로 외관 1픽셀을 제외하고 칠한다.
	$bgc = ImageColorAllocate($dst_img, 255, 255, 255);
	ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc);

	if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
    if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

	ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

	if($img_info[2] == 1)
	{
		ImageInterlace($dst_img);
		ImageGIF($dst_img, $save_file);
	}elseif($img_info[2] == 2){
		ImageInterlace($dst_img);
		ImageJPEG($dst_img, $save_file,85);
	}elseif($img_info[2] == 3){
		ImagePNG($dst_img, $save_file);
	}
	ImageDestroy($dst_img);
	ImageDestroy($src_img);

	return true;
}

# 이하 주민번호 체크 (정통부 공식)
function isCorrectJuminNumber($juminno) {
	$juminno=ereg_replace('-', '', $juminno);
	if(!$juminno || strlen($juminno)!=13) return false;
	$jumin1=substr($juminno, 0, 6);
	$jumin2=substr($juminno, 6, 7);
	$yy=substr($jumin1, 0, 2);
	$mm=substr($jumin1, 2, 2);
	$dd=substr($jumin1, 4, 2);
	$genda=substr($jumin2, 0, 1);

	if(!is_numeric($jumin1)) return false;
	if(strlen($jumin1)!=6) return false;
	if($yy < '00' || $yy > '99' || $mm < '01' || $mm > '12' || $dd < '01' || $dd > '31') return false;
	if ($yy < '00' || $yy > '99' || $mm < '01' || $mm > '12' || $dd < '01' || $dd > '31') return false;
	if (!is_numeric($jumin2)) return false;
	if (strlen($jumin2) != 7) return false;
	if ($genda < '1' || $genda > '4') return false;
	$cc = ($genda == '1' || $genda == '2') ? '19' : '20';
	if (isYYYYMMDD($cc.$yy, $mm, $dd) == false) return false;
	if (!isSSN($jumin1, $jumin2)) return false;
	return true;
}


function isYYYYMMDD($y, $m, $d) {
	switch ($m) {
	case 2: // 2월의 경우
		if ($d > 29) return false;
		if ($d == 29) {	// 2월 29의 경우 당해가 윤년인지를 확인
			if (($y % 4 != 0) || ($y % 100 == 0) && ($y % 400 != 0))
				return false;
		}
		break;
	case 4:        // 작은 달의 경우
	case 6:
	case 9:
	case 11:
		if ($d == 31) return false;
	}
	// 큰 달의 경우
	return true;
}

function isNumeric($s) { return is_numeric($s); }

function isSSN($s1, $s2) {
	$n = 2;
	$sum = 0;
	for ($i=0; $i<strlen($s1); $i++) $sum += substr($s1, $i, 1) * $n++;
	for ($i=0; $i<strlen($s2)-1; $i++) {
		$sum += substr($s2, $i, 1) * $n++;
		if ($n == 10) $n = 2;
	}
	$c = 11 - $sum % 11;
	if ($c == 11) $c = 1;
	if ($c == 10) $c = 0;
	if ($c != substr($s2, 6, 1)) return false;
	else return true;
}

###### BBS Functions Start
function isBBSAdmin() { # 게시판별 관리자인지 확인
	global $_COOKIE, $_permit;
	if(!$_COOKIE['wmember_sid']) return false;
	if(isAdminLogined()) return true;
	return ereg($_COOKIE['wmember_sid'], $_permit['bbsAdmin']);
}

function isBBSPermit($act='list') { # 해당 액션의 권한이 있는지 확인 (등급)
	global $_COOKIE, $_permit;
	if(isBBSAdmin()) return true;
	if(!$_COOKIE['member_level']) return false;
	return ereg(trim($_COOKIE['member_level']), $_permit[$act]);
}

function procBBSPopup($code, $width=417, $height=500, $scroll='yes', $table='bbs_tbl') {
	global $conn, $_COOKIE;
	$query="SELECT sid FROM $table WHERE code='$code' AND popup='Y' AND del='N'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		if(!$_COOKIE["popup${code}${d[sid]}"]){
			$print.= "window.open('/popup/bbs_popup.html?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${width},height=${height},scrollbars=${scroll},status=no,directories=no,menubar=no,resizable=no');\n";
			//$print .= "alert(\"${msg}\");\n";
		}
	}
	$print .= "//]]>\n</script>\n";
	print($print);
}
function getBBSPush($code, $limit=5, $select=array('sid', 'code', 'subject', 'signdate'), $table='bbs_tbl') {
	global $conn;
	$query='SELECT '.implode(',', $select)." FROM $table WHERE code='$code' AND push='Y' AND del='N' AND hide='N' ORDER BY sid DESC LIMIT $limit";


 // echo $query;
  $result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	if(!$result->numRows()) return;
	$i=0;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

    //$return[$i]="<img src='/image/main/dot.gif' border='0' align='absmiddle'> ".$d['subject'];
    echo $return[$i];
		$i++;
	}
	return $return;
}
function getBBSNewArticles($code='', $limit=5, $select=array('sid', 'code', 'subject', 'signdate'), $table='bbs_tbl') {
	global $conn;
	$query='SELECT '.implode(',', $select)." FROM $table WHERE ";
	if($code) $query.=" code='$code' AND ";
	$query.=" del='N' AND hide='N' ORDER BY sid DESC LIMIT $limit";
  $result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	if(!$result->numRows()) return;
	$i=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$return[$i]=$d;
		$i++;
	}
	return $return;
}

function isWindowsUpload() {
	global $_SERVER;
	if((eregi('MSIE|Windows', $_SERVER['HTTP_USER_AGENT']) || eregi('Safari', $_SERVER['HTTP_USER_AGENT']) || eregi('Chrome', $_SERVER['HTTP_USER_AGENT'])) && !eregi('Firefox', $_SERVER['HTTP_USER_AGENT']) && !eregi('iPhone|iPod|iPad', $_SERVER['HTTP_USER_AGENT']))
		return true;
	return false;
}

function isiPhone() {
	global $_SERVER;
	return eregi('iPhone|iPod|iPad', $_SERVER['HTTP_USER_AGENT']);
}

###### BBS Functions End

/** #### FOR COUNTER START ####**/
function getOsName($agent){
	global $OsSet1;
	$i = 0;
	foreach($OsSet1 as $o){
		$i++;
		if(strstr($agent,$o)) return $i-1;
	}
	return 0;
}
function getBrowserName($agent){
	global $BrSet1;
	$i = 0;
	foreach($BrSet1 as $b){
		$i++;
		if (strstr($agent,$b)) return $i-1;
	}
	return 0;
}
function getDomain($url){
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = count($ENSET);
	for ($i = 1; $i < $eng_num; $i++){
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (strstr($url_exp[2] , $ser_exp[0])) return $i;
	}
	return 0;
}
function getDomain1($url){
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = count($ENSET);
	for ($i = 1; $i < $eng_num; $i++){
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (strstr($url_exp[2] , $ser_exp[0])) return $eng_exp[1];
	}
	return '';
}
function getLanguage($lang){
	if(stristr($lang,'ko')) return 0;
	if(stristr($lang,'en')) return 1;
	if(stristr($lang,'ja')) return 2;
	if(stristr($lang,'zh')) return 3;
	if(stristr($lang,'fr')) return 4;
	if(stristr($lang,'de')) return 5;
	if(stristr($lang,'es')) return 6;
	if(stristr($lang,'it')) return 7;
	return 8;
}
function getKeyword($url , $engine){
	global $ENSET;
	$this_Que= explode(',' , $ENSET[$engine]);
	$url_exp = explode($this_Que[2].'=' , $url);
	$key_exp = explode('&' , $url_exp[1]);
	$this_Kwd = urldecode($key_exp[0]);

	if (!$engine||($engine&&!$this_Kwd)){
		$url_exp = explode('?' , urldecode($url));
		if (!trim($url_exp[1])) return '';
		$que_exp = explode('&' , $url_exp[1]);
		$que_num = count($que_exp);
		for ($i = 0; $i < $que_num; $i++){
			$val_exp = explode('=' , $que_exp[$i]);
			if ($val_exp[1] > "z") return $val_exp[1];
		}
		return '';
	}

	$this_Que= explode(',' , $ENSET[$engine]);
	$url_exp = explode($this_Que[2].'=' , $url);
	$key_exp = explode('&' , $url_exp[1]);

	return urldecode($key_exp[0]);
}
function getMonth($n){
	$set = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	return $set[$n];
}
function getWeekday($n){
	$return=array('0' => '일', '1' => '월', '2' => '화', '3' => '수', '4' => '목', '5' => '금', '6' => '토');
	return $return[$n];
}
function getGrpSize($this,$total,$max,$width){
	//현재수,전체수,가장큰수,원하는길이
	$per = @intval($this/$total*100);
	if (!$width) return $per;
	if ($this) return $this == $max ? $width : @intval($this/$max*$width);
	else return 0;
}
function getPercent($a,$b,$flag){
	return @round($a / $b * 100 , $flag);
}
/** #### FOR COUNTER END ####**/

##### 오류상황에 따른 메시지를 전달하여 팝업창을 띄운다.
function error($errcode) {

   switch ($errcode) {
      case ("NOT_FOUND_CONFIG_FILE") :
         PutMessageBack("환경설정 파일을 찾을 수 없습니다.\\n\\n스크립트 실행권한이 없습니다.");
         break;

      case ("NOT_ALLOWED_ZIPKEY") :
         PutMessageBack("검색어는 최소한 두 글자 이상이어야 합니다.");
         break;

      case ("NOT_ALLOWED_NAME") :
         PutMessageBack("입력하신 이름은 허용되지 않는 값입니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_ID") :
         PutMessageBack("입력하신 아이디는 허용되지 않는 값입니다.\\n\\n아이디는 4~10자리의 영문소문자나 숫자 또는 조합된 문자열이여야 하니다.");
         break;

      case ("NOT_ALLOWED_PASSWD") :
         PutMessageBack("입력하신 비밀번호는 허용되지 않는 문자열입니다.\\n\\n비밀번호는 4 ~ 8자의 영문소문자나 숫자 또는 조합된 문자열이어야 합니다.");
         break;

      case ("DIFFERENT_PASSWD") :
         PutMessageBack("입력하신 비밀번호가 일치하지 않습니다.\\n\\n확인 후 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_JUMIN_NUMBER") :
         PutMessageBack("입력하신 주민등록번호가 올바르지 않습니다.\\n\\n확인 후 다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_EMAIL") :
         PutMessageBack("입력하신 전자우편주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_HOMEPAGE") :
         PutMessageBack("입력하신 홈페이지 주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_DUPLICATE_ID") :
         PutMessageBack("신청하신 아이디(ID)는 이미 등록되어 있습니다. \\n\\n다른 아이디로 신청하여 주십시오.");
         break;

      case ("NOT_ALLOWED_DUPLICATE_JUMIN_NUMBER") :
         PutMessageBack("입력하신 주민등록번호는 이미 등록되어 있습니다. \\n\\n사용하실 수 없습니다.");
         break;

      case ("NOT_ALLOWED_LICENSE_NUMBER") :
         PutMessageBack("입력하신 의사면허번호가 올바르지 않습니다.\\n\\n다시 확인 후 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_DUPLICATE_LICENSE_NUMBER") :
         PutMessageBack("입력하신 의사면허번호는 이미 등록되어 있습니다.\\n\\n사용하실 수 없습니다.");
         break;

      case ("NOT_ALLOWED_MODE") :
         PutMessageBack("부적절한 실행옵션으로 인해 실행이 거부되었습니다.\\n\\n관리자에게 문의하여 주십시오.");
         break;

      case ("LOGIN_ID_NOT_FOUND") :
         PutMessageBack("입력하신 아이디(ID)는 등록되어 있지 않습니다. \\n\\n다시한번 확인하시고 입력하여 주십시오.");
         break;

      case ("LOGIN_INVALID_PW") :
         PutMessageBack("회원님이 입력하신 비밀번호가 맞지 않습니다. \\n\\n다시한번 확인하시고 입력하여 주십시오.");
         break;


	  case ("SEARCHID_NAME_NOT_FOUND") :
         PutMessageBack("입력하신 성명은 등록되어 있지 않습니다. \\n\\n다시한번 확인하시고 입력하여 주십시오.");
         break;

	  case ("SEARCHID_EMAIL_NOT_FOUND") :
         PutMessageBack("입력하신 성명과 전자우편 주소가 일치하지 않습니다. \\n\\n다시한번 확인하시고 입력하여 주십시오.");
         break;


      case ("HTTP_HEADERS_SENT") :
         PutMessageBack("프로그램 오류가 발생하였습니다.\\n\\n관리자에게 문의하시기 바랍니다.");
         break;

	  case ("NOT_FOUND_JUDGE") :
         PutMessageBack("관련 논문에 심사위원이 없습니다.\\n\\n먼저 심사위원을 위촉하십시요.");
         break;

	  case ("NOT_FOUNDUSER_JUDGE") :
         PutMessageBack("관련 논문에 심사위원이 없습니다.\\n\\n심사위원이 배정된 논문만 열람이 가능합니다.");
         break;

	  case ("NOT START_DATE") :
         PutMessageBack("행사마지막 날이 행사 시작하는 날보다 작습니다.\\n\\n정확하게 입력하여 주십시요");
         break;

#################################################
################ 회의관리


	  case ("NOT_FOUND_CONFIG_FILE") :
         PutMessageBack("환경설정 파일을 찾을 수 없습니다.\\n\\n스크립트 실행권한이 없습니다.");
         break;

      case ("INVALID_NAME") :
         PutMessageBack("입력하신 성명으로 회원을 찾을수가 없습니다. \\n\\n다시한번 확인하시고 입력하여 주십시오.");
         break;


      case ("ACCESS_DENIED_DB_CONNECTION") :
         PutMessageBack("데이터베이스 연결에 실패하였습니다.\\n\\n연결하고자 하는 서버명과 사용자명, 비밀번호를 확인하시기 바랍니다.");
         break;

      case ("FAILED_TO_SELECT_DB") :
         PutMessageBack("지정한 데이터베이스를 작업대상 데이터베이스로 할 수 없습니다.\\n\\n지정한 데이터베이스를 확인하시기 바랍니다.");
         break;

       case ("QUERY_ERROR") :
         $err_no = mysql_errno();
         $err_msg = mysql_error();
         $error_msg = "ERROR CODE " . $err_no . " : " . $err_msg;
         $error_msg = addslashes($error_msg);
         PutMessageBack($error_msg);
         break;

      case ("NOT_ALLOWED_NAME") :
         PutMessageBack("입력하신 이름은 허용되지 않는 값입니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_EMAIL") :
         PutMessageBack("입력하신 전자우편주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_SUBJECT") :
         PutMessageBack("입력하신 제목은 허용되지 않는 값입니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_CONTENT") :
         PutMessageBack("본문을 입력하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_HOMEPAGE") :
         PutMessageBack("입력하신 홈페이지 주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

	  case ("NOT_GROUP_CHECK") :
         PutMessageBack("해당되는 회원 그룹을 체크해 주십시오.");
         break;

      case ("ACCESS_DENIED_TO_CREATE_DIR") :
         PutMessageBack("첨부한 파일을 저장할 디렉토리를 생성할 수 없습니다.\\n\\n지정한 디렉토리의 퍼미션을 확인하시기 바랍니다.");
         break;

      case ("NOT_ALLOWED_FILE") :
         PutMessageBack("해당파일은 자료실 운영지침에 따라 업로드가 허용되지 않는 파일입니다.\\n\\n가능하면 압축파일의 형태로 등록하여 주십시오.");
         break;

	  case ("NOT_SEAL_FILE") :
         PutMessageBack("사용하실 직인파일을 첨부하시고 등록하십시오.");
         break;

	  case ("NOT_ALLOWED_FILE") :
         PutMessageBack("직인파일로 사용하실 파일은 이미지 파일이어야 합니다.\\n\\n이미지 파일로 업로드 하시기 바랍니다.");
         break;


      case ("ACCESS_DENIED_TO_UPLOAD_DUPLICATE_FILE") :
         PutMessageBack("동일한 이름의 파일이 이미 등록되어 있습니다. \\n\\n다른 이름으로 업로드하여 주십시오.");
         break;

      case ("ACCESS_DENIED_TO_COPY_FILE") :
         PutMessageBack("업로드 과정중 오류가 발생하였습니다.\\n\\n파일이 저장될 디렉토리가 없거나 디렉토리의 퍼미션 제한으로 인한 오류일 가능성이 있습니다.");
         break;

      case ("NOT_SUPPORTED_ORDERING") :
         PutMessageBack("지정한 정렬기준이 잘못되었습니다.\\n\\n지원하지 않는 정렬방식입니다.");
         break;

      case ("NOT_SUPPORTED_LISTTYPE") :
         PutMessageBack("지정한 게시물 출력양식이 잘못되었습니다.\\n\\n지원하지 않는 출력양식입니다.");
         break;

      case ("ACCESS_DENIED_TO_EXECUTE_SCRIPT") :
         PutMessageBack("스크립트 실행권한이 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY") :
         PutMessageBack("권한이 없습니다.\\n\\n해당 게시물을 수정하실 수 없습니다.");
         break;


      case ("NO_ACCESS_DELETE_THREAD") :
         PutMessageBack("답변이 있는 글은 삭제하실 수 없습니다. \\n\\n답변글을 모두 삭제하신 후 삭제하십시오.");
         break;

      case ("FILE_DELETE_FAILURE") :
         PutMessageBack("파일이 삭제되지 않았습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;

      case ("NO_ACCESS_DELETE") :
         PutMessageBack("권한이 없습니다.\\n\\n해당 게시물을 삭제하실 수 없습니다.");
         break;

	  case ("NOT_GROUP_CHECK") :
         PutMessageBack("원하시는 그룹을 체크해주십시오.");
         break;

      case ("ALREADY_ADMIN") :
         PutMessageBack("이미 관리자로 로그인하셨습니다.");
         break;

      case ("NEED_LOGIN") :
         PutMessageBack("관리자로 로그인하셔야 실행가능합니다.");
         break;

	  case ("NOT_MEETING_ATTENDANCE") :
         PutMessageBack("회의 참석 여부를 이미 등록하셨습니다.");
         break;

	  case ("SEARCH_NAME_NOT_FOUND") :
         PutMessageBack("입력하신 회원이 검색되지 않았습니다.\\n\\n회원유무를 확인하시고 다시 검색바랍니다.");
         break;

	  case ("NOT_MEETING_ATTENDANCE") :
         PutMessageBack("회의 참석 여부를 이미 등록하셨습니다.");
         break;

	  case ("SEARCH_NAME_NOT_FOUND") :
         PutMessageBack("입력하신 회원이 검색되지 않았습니다.\\n\\n회원유무를 확인하시고 다시 검색바랍니다.");
         break;


      case ("NOT_ALLOWED_MODE") :
         PutMessageBack("부적절한 실행옵션으로 인해 실행이 거부되었습니다.\\n\\n관리자에게 문의하여 주십시오.");
         break;

################# 공문발송 (정리필요)

 case ("NOT_ALLOWED_NAME") :
         PutMessageBack("입력하신 이름은 허용되지 않는 값입니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_EMAIL") :
         PutMessageBack("입력하신 전자우편주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_SUBJECT") :
         PutMessageBack("입력하신 제목은 허용되지 않는 값입니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_CONTENT") :
         PutMessageBack("본문을 입력하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_HOMEPAGE") :
         PutMessageBack("입력하신 홈페이지 주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

	  case ("NOT_GROUP_CHECK") :
         PutMessageBack("해당되는 회원 그룹을 체크해 주십시오.");
         break;

      case ("ACCESS_DENIED_TO_CREATE_DIR") :
         PutMessageBack("첨부한 파일을 저장할 디렉토리를 생성할 수 없습니다.\\n\\n지정한 디렉토리의 퍼미션을 확인하시기 바랍니다.");
         break;

      case ("NOT_ALLOWED_FILE") :
         PutMessageBack("해당파일은 자료실 운영지침에 따라 업로드가 허용되지 않는 파일입니다.\\n\\n가능하면 압축파일의 형태로 등록하여 주십시오.");
         break;

	  case ("NOT_SEAL_FILE") :
         PutMessageBack("사용하실 직인파일을 첨부하시고 등록하십시오.");
         break;

	  case ("NOT_ALLOWED_FILE") :
         PutMessageBack("직인파일로 사용하실 파일은 이미지 파일이어야 합니다.\\n\\n이미지 파일로 업로드 하시기 바랍니다.");
         break;


      case ("ACCESS_DENIED_TO_UPLOAD_DUPLICATE_FILE") :
         PutMessageBack("동일한 이름의 파일이 이미 등록되어 있습니다. \\n\\n다른 이름으로 업로드하여 주십시오.");
         break;

      case ("ACCESS_DENIED_TO_COPY_FILE") :
         PutMessageBack("업로드 과정중 오류가 발생하였습니다.\\n\\n파일이 저장될 디렉토리가 없거나 디렉토리의 퍼미션 제한으로 인한 오류일 가능성이 있습니다.");
         break;

      case ("NOT_SUPPORTED_ORDERING") :
         PutMessageBack("지정한 정렬기준이 잘못되었습니다.\\n\\n지원하지 않는 정렬방식입니다.");
         break;

      case ("NOT_SUPPORTED_LISTTYPE") :
         PutMessageBack("지정한 게시물 출력양식이 잘못되었습니다.\\n\\n지원하지 않는 출력양식입니다.");
         break;

      case ("ACCESS_DENIED_TO_EXECUTE_SCRIPT") :
         PutMessageBack("스크립트 실행권한이 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY") :
         PutMessageBack("권한이 없습니다.\\n\\n해당 게시물을 수정하실 수 없습니다.");
         break;


      case ("NO_ACCESS_DELETE_THREAD") :
         PutMessageBack("답변이 있는 글은 삭제하실 수 없습니다. \\n\\n답변글을 모두 삭제하신 후 삭제하십시오.");
         break;

      case ("FILE_DELETE_FAILURE") :
         PutMessageBack("파일이 삭제되지 않았습니다. \\n\\n관리자에게 문의하여 주십시오.");
         break;

      case ("NO_ACCESS_DELETE") :
         PutMessageBack("권한이 없습니다.\\n\\n해당 게시물을 삭제하실 수 없습니다.");
         break;



############################
#######################

  ##### 행사일정관리
      case ("INVALID_ENG_WORD") :
         PutMessageBack("입력하신 영문용어는 허용되지 않는 문자열입니다.\\n\\다시한번 확인하시기 바랍니다.");
         break;

      case ("NOT_GROUP_CHECK") :
         PutMessageBack("등록시킬 학과는 하나이상 선택하셔야 합니다.");
         break;



      case ("NOT_ALLOWED_CATEGORY") :
         PutMessageBack("행사의 코드분류를 선택하지 않으셨습니다.\\n\\n확인하여 주시기 바랍니다.");
         break;

      case ("NOT_ALLOWED_TITLE") :
         PutMessageBack("행사명을 입력하지 않으셨습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_PLACE") :
         PutMessageBack("행사장소를 입력하지 않으셨습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_TIME") :
         PutMessageBack("입력하신 행사일자가 타당하지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_SPONSOR") :
         PutMessageBack("행사주최 항목을 입력하지 않으셨습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_FEE") :
         PutMessageBack("참가비 항목을 입력하지 않으셨습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_INQUIRY") :
         PutMessageBack("문의처 항목을 입력하지 않으셨습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_CONTENT") :
         PutMessageBack("본문을 입력하지 않으셨습니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_HOMEPAGE") :
         PutMessageBack("입력하신 홈페이지 주소의 형식이 올바르지 않습니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("NOT_ALLOWED_PASSWD") :
         PutMessageBack("암호는 최소 4자이상의 영문자 또는 숫자여야 합니다. \\n\\n다시입력하여 주십시오.");
         break;

      case ("NO_ACCESS_USER_MODIFY") :
         PutMessageBack("게시물에 대한 수정권한이 없습니다.\\n\\n해당 게시물은 해당회원만 수정가능합니다..");
         break;

      case ("NO_ACCESS_USER_DELETE") :
         PutMessageBack("게시물에 대한 삭제권한이 없습니다.\\n\\n해당 게시물은 해당회원만 삭제가능합니다..");
         break;



     case ("INVALID_OFFICE_NAME") :
         PutMessageBack("입력하신 상호명은 허용되지 않는 문자열입니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_JOBTITLE") :
         PutMessageBack("입력하신 제목은 허용되지 않는 문자열입니다. \\n\\n올바른 제목을 입력하여 주십시오.");
         break;

      case ("INVALID_CH_GRANT") :
         PutMessageBack("입력하신 응시자격은 허용되지 않는 문자열입니다. \\n\\n올바른 응시자격 입력하여 주십시오.");
         break;

      case ("INVALID_PRESENT") :
         PutMessageBack("입력하신 제출서류는 허용되지 않는 문자열입니다. \\n\\n올바른 제출서류를 입력하여 주십시오.");
         break;

      case ("INVALID_OTHER") :
         PutMessageBack("입력하신 기타내용은 허용되지 않는 문자열입니다. \\n\\n올바른 내용을 입력하여 주십시오.");
         break;

      case ("INVALID_BACKGROUND") :
         PutMessageBack("이력사항을 입력하지 않으셨습니다. \\n\\n다시입력하여 주십시오.");
         break;

      case ("INVALID_INTRODUCE") :
         PutMessageBack("소개글을 입력하지 않으셨습니다. \\n\\n다시입력하여 주십시오.");
         break;

      case ("USER_LEVEL_IS_WATING") :
         PutMessageBack("현재 승인대기중입니다.\\n\\n승인메세지가 온 이후 다시한번 로그인을 해주십시오.");
         break;

      case ("INVALID_POLL_NAME") :
         PutMessageBack("입력하신 이름은 허용되지 않는 문자열입니다.\\n\\n올바른 이름을 입력하여 주십시오.");
         break;

      case ("INVALID_POLL_EMAIL") :
         PutMessageBack("입력하신 주소는 올바른 전자우편주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_POLL_SUBJECT") :
         PutMessageBack("입력하신 설문주제는 허용되지 않는 문자열입니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_SDATE") :
         PutMessageBack("선택하신 설문시작일은 유효하지 않은 날짜입니다.\\n\\n다시 선택하여 주십시오.");
         break;

      case ("INVALID_EDATE") :
         PutMessageBack("선택하신 설문종료일은 유효하지 않은 날짜입니다.\\n\\n다시 선택하여 주십시오.");
         break;

      case ("INVALID_DATEDIFF") :
         PutMessageBack("설문종료일이 시작일보다 이전 날짜입니다.");
         break;

      case ("INVALID_POLL_ITEM") :
         PutMessageBack("선택항목에 입력하신 내용은 허용되지 않는 문자열입니다.");
         break;

      case ("DENIED_SCRIPT_EXECUTION") :
         PutMessageBack("스크립트 실행권한이 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY_FOR_ON") :
         PutMessageBack("현재 시행중인 설문조사의 내용은 변경하실 수 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY_FOR_OFF") :
         PutMessageBack("시행종료된 설문조사의 내용은 변경하실 수 없습니다.");
         break;

      case ("NO_ACCESS_DELETE_FOR_ON") :
         PutMessageBack("현재 시행중인 설문조사의 내용은 삭제하실 수 없습니다.");
         break;

      case ("NO_ACCESS_DELETE_FOR_OFF") :
         PutMessageBack("시행종료된 설문조사의 내용은 삭제하실 수 없습니다.");
         break;

      case ("PERMISSION_ERROR_IN_FILE") :
         PutMessageBack("파일을 작성할 수 없습니다.\\n\\n해당 디렉토리의 퍼미션을 살펴보시기 바랍니다.");
         break;

      case ("NO_EXECUTE_POLL_SCRIPT") :
         PutMessageBack("이 설문조사는 시행예정 또는 이미 종료되었거나 관리자에 의해 시행이 유보되어 있습니다.\\n\\n따라서 투표하실 수 없습니다.");
         break;

      case ("NO_EXECUTE_POLL_OUTPUT_SCRIPT") :
         PutMessageBack("이 설문조사는 시행예정이거나 관리자에 의해 시행이 유보되어 있습니다.\\n\\n따라서 결과를 보실 수 없습니다.");
         break;

      case ("COPY_FAILURE") :
         PutMessageBack("PUSH파일을 복사하지 못했습니다.");
         break;

      case ("USER_POLL_EXECUTE") :
         PutMessageBack("이미 설문조사에 응답하셨습니다.\\n\\n다음 설문조사를 이용하시기 바랍니다.");
         break;

      case ("QUERY_ERROR") :
         PutMessageBack("데이타 베이스 질의에 실패하였습니다.\\n\\n 잠시후 다시한번 시도하십시오.");
         break;

      case ("NOT_ADMIN_EXECUTION") :
         PutMessageBack("설문조사관리는 관리자만 실행가능합니다.");
         break;

      case ("NO_ACCESS_STEP_ON") :
         PutMessageBack("설문조사 등록시 등록문항보다 더이상은 등록을 할수 없습니다.");
         break;

      case ("NOT_VOTE_CHECK") :
         PutMessageBack("설문항목을 선택하시기 바랍니다.");
         break;

      case ("NOT_SEX_CHECK") :
         PutMessageBack("설문시 성별을 선택하셔야 합니다.");
         break;

      case ("NOT_AGE_CHECK") :
         PutMessageBack("설문시 연령대를 선택하셔야 합니다.");
         break;

      case ("NO_EXECUTE_POLL_VIEW") :
         PutMessageBack("이 설문조사는 설문종료시까지 결과를 볼 수 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY_STATUS") :
         PutMessageBack("등록한 설문 문항수와 현재 등록된 설문문항수가 맞지 않습니다.\\n\\n설문 문항을 모두 등록하신후에야 시행하시거나 수정할 수 있습니다.");
         break;

      case ("NOT_RECORD_EXECUTION") :
         PutMessageBack("현재 투표한 결과가 없습니다. 투표를 하신후에 결과를 확인하시기 바랍니다.");
         break;

      case ("NOT_RESULT_VIEW") :
         PutMessageBack("이 설문은 투표가 종료된후에만 결과를 확인하실 수 있습니다.");
         break;

	######## 이미 등록된 병력사항이 있을경우
	  case ("ALREADY_INSERT_SEIZURE") :
		 PutMessageBack("이미 등록된 병력정보가 있습니다.");
		 break;

   // 퀴즈 메시지 추가


      case ("NOT_EXISTED_CFG_FILE") :
         PutMessageBack("환경설정 파일을 찾을 수 없습니다.\\n\\n스크립트 실행권한이 없습니다.");
         break;

      case ("INVALID_quiz_NAME") :
         PutMessageBack("입력하신 이름은 허용되지 않는 문자열입니다.\\n\\n올바른 이름을 입력하여 주십시오.");
         break;

      case ("INVALID_quiz_EMAIL") :
         PutMessageBack("입력하신 주소는 올바른 전자우편주소가 아닙니다. \\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_quiz_SUBJECT") :
         PutMessageBack("입력하신 퀴즈문제는 허용되지 않는 문자열입니다.\\n\\n다시 입력하여 주십시오.");
         break;

      case ("INVALID_SDATE") :
         PutMessageBack("선택하신 퀴즈시작일은 유효하지 않은 날짜입니다.\\n\\n다시 선택하여 주십시오.");
         break;

      case ("INVALID_EDATE") :
         PutMessageBack("선택하신 퀴즈종료일은 유효하지 않은 날짜입니다.\\n\\n다시 선택하여 주십시오.");
         break;

      case ("INVALID_DATEDIFF") :
         PutMessageBack("퀴즈종료일이 시작일보다 이전 날짜입니다.");
         break;

      case ("INVALID_quiz_ITEM") :
         PutMessageBack("선택항목에 입력하신 내용은 허용되지 않는 문자열입니다.");
         break;

      case ("DENIED_SCRIPT_EXECUTION") :
         PutMessageBack("스크립트 실행권한이 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY_FOR_ON") :
         PutMessageBack("현재 시행중인 퀴즈의 내용은 변경하실 수 없습니다.");
         break;

      case ("NO_ACCESS_MODIFY_FOR_OFF") :
         PutMessageBack("시행종료된 퀴즈의 내용은 변경하실 수 없습니다.");
         break;

      case ("NO_ACCESS_DELETE_FOR_ON") :
         PutMessageBack("현재 시행중인 퀴즈의 내용은 삭제하실 수 없습니다.");
         break;

      case ("NO_ACCESS_DELETE_FOR_OFF") :
         PutMessageBack("시행종료된 퀴즈의 내용은 삭제하실 수 없습니다.");
         break;

      case ("PERMISSION_ERROR_IN_FILE") :
         PutMessageBack("파일을 작성할 수 없습니다.\\n\\n해당 디렉토리의 퍼미션을 살펴보시기 바랍니다.");
         break;

      case ("NO_EXECUTE_quiz_SCRIPT") :
         PutMessageBack("이 퀴즈는 시행예정 또는 이미 종료되었거나 관리자에 의해 시행이 유보되어 있습니다.\\n\\n따라서 응모하실 수 없습니다.");
         break;

      case ("NO_EXECUTE_quiz_OUTPUT_SCRIPT") :
         PutMessageBack("이 퀴즈는 시행예정이거나 관리자에 의해 시행이 유보되어 있습니다.\\n\\n따라서 결과를 보실 수 없습니다.");
         break;

      case ("COPY_FAILURE") :
         PutMessageBack("PUSH파일을 복사하지 못했습니다.");
         break;

      case ("USER_quiz_EXECUTE") :
         PutMessageBack("이미 퀴즈에 응답하셨습니다.\\n\\n다음 퀴즈조사를 이용하시기 바랍니다.");
         break;

      case ("QUERY_ERROR") :
         PutMessageBack("데이타 베이스 질의에 실패하였습니다.\\n\\n 잠시후 다시한번 시도하십시오.");
         break;



############################################

      default :
   }
}


##### 관리자 회원검색
function user_search($type='',$which='',$input_arr,$column){

   ##### 검색유형 : 전체 회원을 대상으로 검색할 경우
   if(!strcmp($type,"1")) {
      if(!is_array($column) || count($column) < 1) {
         $query = "select * from user_binfo";
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM user_binfo WHERE sid is not null ";
      }
   } else {
      ##### 연관 배열로 넘어온 값을 잘라낸다
      while(list($field_name,$field_value) = each($input_arr)) {
         if($field_value || $field_value != "") {
            $qlike_str = $field_name . " LIKE '%" . $field_value . "%' ";
            if(!$like_query) {
               $like_query = " AND " . $qlike_str;
            } else {
               $like_query .= " " . $which . " " . $qlike_str;
            }
         }
      }

      if(!is_array($column) || count($column) < 1) {
         $query = "select * from user_binfo WHERE sid is not null " . $like_query;
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM user_binfo WHERE sid is not null " . $like_query;
      }
   }

   return $query;
}

##### 회비관리 검색
function pay_search($type='',$which='',$input_arr,$column){

   ##### 검색유형 : 전체 회비관리 대상으로 검색할 경우
   if(!strcmp($type,"1")) {
      if(!is_array($column) || count($column) < 1) {
         $query = "select * from pay_tbl";
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM pay_tbl WHERE sid is not null ";
      }
   } else {
      ##### 연관 배열로 넘어온 값을 잘라낸다
      while(list($field_name,$field_value) = each($input_arr)) {
         if($field_value || $field_value != "") {
            $qlike_str = $field_name . " LIKE '%" . $field_value . "%' ";
            if(!$like_query) {
               $like_query = " AND " . $qlike_str;
            } else {
               $like_query .= " " . $which . " " . $qlike_str;
            }
         }
      }

      if(!is_array($column) || count($column) < 1) {
         $query = "select * from pay_tbl WHERE sid is not null " . $like_query;
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM pay_tbl WHERE sid is not null " . $like_query;
      }
   }

   return $query;
}

##### 후원내역 검색
function pay_sp_search($type='',$which='',$input_arr,$column){

   ##### 검색유형 : 전체 회비관리 대상으로 검색할 경우
   if(!strcmp($type,"1")) {
      if(!is_array($column) || count($column) < 1) {
         $query = "select * from pay_sp_tbl";
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM pay_sp_tbl WHERE sid is not null ";
      }
   } else {
      ##### 연관 배열로 넘어온 값을 잘라낸다
      while(list($field_name,$field_value) = each($input_arr)) {
         if($field_value || $field_value != "") {
            $qlike_str = $field_name . " LIKE '%" . $field_value . "%' ";
            if(!$like_query) {
               $like_query = " AND " . $qlike_str;
            } else {
               $like_query .= " " . $which . " " . $qlike_str;
            }
         }
      }

      if(!is_array($column) || count($column) < 1) {
         $query = "select * from pay_sp_tbl WHERE sid is not null " . $like_query;
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM pay_sp_tbl WHERE sid is not null " . $like_query;
      }
   }

   return $query;
}

##### 리스트 출력함수
function selectList($array_value,$name_value,$member_ec,$first_value){
	$selectList="<select name=\"" . $name_value . "\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}

##### 리스트 출력함수
function selectList2($array_value,$name_value,$member_ec,$first_value, $option = NULL){
	$selectList="<select name=\"" . $name_value . "\" id=\"" . $name_value . "\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}

##### 리스트 출력함수
function selectList3($array_value,$name_value,$member_ec,$first_value, $option = NULL){
	$selectList="<select name=\"" . $name_value . "\" id=\"" . $name_value . "\">";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}
##### 리스트 출력함수
function selectList4($array_value,$name_value,$member_ec){
	$first_value="선택하세요";
	$selectList="<select name=\"" . $name_value . "\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}
##### 리스트 출력함수v2 새창 사이트 이동
function selectList_Link($array_value,$name_value,$member_ec,$first_value){
	$selectList="<select name=\"" . $name_value . "\" onChange=\"link_fun(this.value);\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}

function no_cache_header() {
    if (headers_sent()) return FALSE;
    header("Expires: Sat, 1 Apr 2000 00:00:00 GMT\r\n");
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    switch ($_SERVER['SERVER_PROTOCOL']) {
        case 'HTTP/1.1' :
            header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
            header('Cache-Control: post-check=0, pre-check=0', false);
            break;
        case 'HTTP/1.0' :
            header('Pragma: no-cache'); // HTTP/1.0
            break;
        default : // unknown - both versions of headers should be transmitted
            header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache'); // HTTP/1.0
    }
}

##연도 생성함수
function make_year($start_y,$end_y,$name_value,$sel_value){
  echo "<select name=\"$name_value\">\n";
  echo "<option value=\"\">Select</option>\n";
  for($i=$start_y;$i<=$end_y;$i++){
    $sel = $i == $sel_value ? 'selected' : '';
    echo "<option value=\"".$i."\" ".$sel.">".$i."</option>\n";
  }
  echo "</select>\n";
}

##월,일 생성함수
function make_md($start_m,$end_m,$name_value,$sel_value){
  echo "<select name=\"$name_value\">\n";
  echo "<option value=\"\">Select</option>\n";
  for($i=$start_m;$i<=$end_m;$i++){
    $imsi = sprintf("%02d",$i);
    $sel = $imsi == $sel_value ? 'selected' : '';
    echo "<option value=\"".$imsi."\" ".$sel.">".$imsi."</option>\n";
  }
  echo "</select>\n";
}

##연도 생성함수
function make_year1($start_y,$end_y,$name_value,$sel_value){
  echo "<select name=\"$name_value\">\n";
  echo "<option value=\"\">=선택=</option>\n";
  for($i=$start_y;$i<=$end_y;$i++){
    $sel = $i == $sel_value ? 'selected' : '';
    echo "<option value=\"".$i."\" ".$sel.">".$i."</option>\n";
  }
  echo "</select>\n";
}

##월,일 생성함수
function make_md1($start_m,$end_m,$name_value,$sel_value,$opt_text){
  echo "<select name=\"$name_value\">\n";
  echo "<option value=\"\">=선택=</option>\n";
  for($i=$start_m;$i<=$end_m;$i++){
    $imsi = sprintf("%02d",$i);
    $sel = $imsi == $sel_value ? 'selected' : '';
    echo "<option value=\"".$imsi."\" ".$sel.">".$imsi."</option>\n";
  }
  echo "</select>\n";
}

function make_hm($start_m,$end_m,$name_value,$step_value,$sel_value){
  echo "<select name=\"$name_value\">\n";
  echo "<option value=\"\">Select</option>\n";
  for($i=$start_m;$i<=$end_m;$i=$i+$step_value){
    $imsi = sprintf("%02d",$i);
    $sel = $imsi == $sel_value ? 'selected' : '';
    echo "<option value=\"".$imsi."\" ".$sel.">".$imsi."</option>\n";
  }
  echo "</select>\n";
}

function local_compile($local){
	if ($local=="서울"){
	   $local="01";
	}else if ($local=="부산"){
	   $local="02";
	}else if ($local=="대구"){
	   $local="03";
	}else if ($local=="인천"){
	   $local="04";
	}else if ($local=="광주"){
	   $local="05";
	}else if ($local=="대전"){
	   $local="06";
	}else if ($local=="울산"){
	   $local="07";
	}else if ($local=="강원"){
	   $local="08";
	}else if ($local=="경기"){
	   $local="09";
	}else if ($local=="경남"){
	   $local="10";
	}else if ($local=="경북"){
	   $local="11";
	}else if ($local=="전남"){
	   $local="12";
	}else if ($local=="전북"){
	   $local="13";
	}else if ($local=="제주"){
	   $local="14";
	}else if ($local=="충남"){
	   $local="15";
	}else if ($local=="충북"){
	   $local="16";
	}else{
	   $local="17";
	}

	return $local;
}

function MessageCount($member_id){
	global $conn;

	$query = "SELECT count(sid) FROM messenger WHERE user_id='" . $member_id . "' and receivestatus='Y' and send_signdate <= 0";
	$m_count = $conn->getOne($query);

	return $m_count;
}

##### 회원검색
function member_search($type='',$which='',$input_arr,$column){

   ##### 검색유형 : 전체 회원을 대상으로 검색할 경우
   if(!strcmp($type,"1")) {
      if(!is_array($column) || count($column) < 1) {
         $query = "select * from user_binfo";
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM user_binfo";
      }
   } else {

      ##### 연관 배열로 넘어온 값을 잘라낸다
      while(list($field_name,$field_value) = each($input_arr)) {
         if($field_value) {
            $qlike_str = $field_name . " LIKE '%" . $field_value . "%' ";
            if(!$like_query) {
               $like_query = " WHERE " . $qlike_str;
            } else {
               $like_query .= " " . $which . " " . $qlike_str;
            }
         }
      }

      if(!is_array($column) || count($column) < 1) {
         $query = "select * from user_binfo" . $like_query;
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM user_binfo " . $like_query;
      }
   }
   return $query;
}

//2008-08-28 나태호 추가
function NewMessage($conn,$member_id){
	$query = "select count(*) from messenger where send_signdate=0 and user_id='$member_id'";
  //echo $query;
	$message_number = $conn->getOne($query);
  //if(DB::isError($message_number)) die($message_number->getMessage());
	$msg="<a href=\"/member/messenger/list.php\"><B>새쪽지(<font color=\"red\">$message_number</font>)</B></a>";
	if($message_number>0)
		$msg.="<embed src='/media/memo_on.wav' hidden='true'>";
	return $msg;
}
function getMessengerId($receive,$name)
{
	$url = "/member/messenger/postform1.php?returnv=no&send_id=$receive&send_name=$name";
	if($receive){

		$messenger = "<a href=\"JavaScript:void(0)\" onmouseOver=\"status='$name 회원님에게 쪽지를 보냅니다.';return true;\" onmouseOver=\"status='';return true;\"onClick=window.open('$url','mes','width=700,height=500,status=no,menu=no')>".$name."</a>";
	}else{

		$messenger = "<a href=\"JavaScript:void(0)\" onmouseOver=\"status='$name 회원님에게 쪽지를 보냅니다.';return true;\" onmouseOver=\"status='';return true;\"onClick=window.open('$url','mes','width=700,height=500,status=no,menu=no')>".$name."</a>";
	}
		return $messenger;
}

function ClubUserID($member_id,$club_id){
	global $conn;

	$query = "select user_id from club_uinfo where club_id='${club_id}' and user_id='${member_id}'";
	$clubuser_id = $conn->getOne($query);

	return $clubuser_id;
}

##### carePart 출력함수
function carePart($array_value,$name_value,$member_ec){
	$first_value="주진료분야 선택";
	$selectList="<select name=\"" . $name_value . "\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}

##### 회비검색
function fee_search($type='',$which='',$input_arr,$column){
	$which = "AND";
   ##### 검색유형 : 전체 회원을 대상으로 검색할 경우
   if(!strcmp($type,"1")) {
      if(!is_array($column) || count($column) < 1) {
         $query = "select * FROM newfeelist f,user_binfo u";
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM newfeelist f,user_binfo u";
      }
   } else {

      ##### 연관 배열로 넘어온 값을 잘라낸다
      while(list($field_name,$field_value) = each($input_arr)) {
         if($field_value) {
            $qlike_str = $field_name . " LIKE '%" . $field_value . "%' ";
            if(!$like_query) {
               $like_query = " WHERE " . $qlike_str;
            } else {
               $like_query .= " " . $which . " " . $qlike_str;
            }
         }
      }

      if(!is_array($column) || count($column) < 1) {
         $query = "select * FROM newfeelist f,user_binfo u" . $like_query;
      } else {
//         $columns = implode(",",$column);
         $query = "SELECT " . implode(",",$column) . " FROM newfeelist f,user_binfo u " . $like_query;
      }
   }

   if(stristr($query,"WHERE")){
	   return $query . " AND f.id = u.id";

   }else{
	   return $query . " WHERE f.id = u.id";
   }
}

##### 리스트 출력함수
function selectListFvalue($array_value,$name_value,$member_ec,$first_value){
	//분$first_value="-";
	$selectList="<select name=\"" . $name_value . "\">";
	$selectList.="<option value=\"\">" . $first_value . "</option>";
	while(list($textList, $textValue)=each($array_value)){
		$selectList.="<option value=" . $textList;
		if($textList=="$member_ec") $selectList.=" selected";
		$selectList.=">" . $textValue . "</option>";
	}
	$selectList.="</select>";
	return $selectList;
}

function utf8String2Array($str){
    $re_arr = array();    $re_icount = 0;
    for($i=0,$m=strlen($str);$i<$m;$i++){
        $ch = ord($str{$i});
        if($ch<128){$re_arr[$re_icount++]=substr($str,$i,1);}
        else if($ch<224){$re_arr[$re_icount++]=substr($str,$i,2);$i+=1;}
        else if($ch<240){$re_arr[$re_icount++]=substr($str,$i,3);$i+=2;}
        else if($ch<248){$re_arr[$re_icount++]=substr($str,$i,4);$i+=3;}
    }
    return $re_arr;
}

function parent_html($target,$val){
	$msg = "회원님의 아이디는 <b>" . $val . "</b>입니다.";

	$html = "<script type='text/javascript'>";
	$html .= "parent.document.getElementById('" . $target . "').innerHTML = '" . $msg . "';";
	$html .= "</script>";

	echo $html;
}

function addPoint($act='login') {
	global $conn, $_GET, $_POST, $_COOKIE, $_pointsize_arr, $_point_arr, $sid;
	$now=time();
	$date=date('Y-m-d', $now);
	$yesterday=$now-(60*60*24);
	$lastedyear=$now-(60*60*24*365);
//	$query="DELETE FROM point_tbl WHERE signdate < $lastedyear";
//	$result=$conn->query($query);
//	if(DB::isError($result)) die($result->getMessage());

	switch($act) {
	case 'login':
		{
		// 2010-09-27
		return;
			$query="SELECT count(sid) FROM point_tbl WHERE id='$_POST[id]' AND act='$act' AND signdate > $yesterday";
			$check=$conn->getOne($query);
			if(DB::isError($check)) die($check->getMessage());
			if(!$check){
				$query="INSERT INTO point_tbl SET id='$_POST[id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', memo='$date $_point_arr[$act]'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
			}
		}
		break;
	case 'post':
		{
			$query="INSERT INTO point_tbl SET id='$_COOKIE[member_id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', code='$_GET[code]', memo='$date $_point_arr[$act]', bsid='$sid'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
		}
		break;
	case 'reply':
		{
			$query="INSERT INTO point_tbl SET id='$_COOKIE[member_id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', code='$_GET[code]', memo='$date $_point_arr[$act]', bsid='$sid'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
		}
		break;
	case 'view':
		{
		// 2010-09-27
		return;
			$query="SELECT count(sid) FROM point_tbl WHERE id='$_COOKIE[member_id]' AND act='$act' AND code='$_GET[code]' AND bsid='$_GET[number]'";
			$check=$conn->getOne($query);
			if(DB::isError($check)) die($check->getMessage());
			if(!$check){
				$query="INSERT INTO point_tbl SET id='$_COOKIE[member_id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', code='$_GET[code]', bsid='$_GET[number]', memo='$date $_point_arr[$act]'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
			}
		}
		break;
	case 'commentpost':
		{
			$query="SELECT count(sid) FROM point_tbl WHERE id='$_COOKIE[member_id]' AND act='$act' AND code='$_GET[code]' AND bsid='$_GET[number]'";
			$check=$conn->getOne($query);
			if(DB::isError($check)) die($check->getMessage());
			if(!$check){
				$query="INSERT INTO point_tbl SET id='$_COOKIE[member_id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', code='$_GET[code]', bsid='$_GET[number]', memo='$date $_point_arr[$act]'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
			}
		}
		break;
	case 'delete':
		{
			$query="DELETE FROM point_tbl WHERE id='$_COOKIE[member_id]' AND (act='post' OR act='reply') AND code='$_GET[code]' AND bsid='$_GET[number]'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
		}
		break;
	case 'commentdelete':
		{
			$query="DELETE FROM point_tbl WHERE id='$_COOKIE[member_id]' AND act='commentpost' AND code='$_GET[code]' AND bsid='$_GET[number]'";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());
		}
		break;
	case 'poll':
		{
			$query="SELECT count(sid) FROM point_tbl WHERE id='$_COOKIE[member_id]' AND act='$act' AND bsid='$_GET[number]'";
			$check=$conn->getOne($query);
			if(DB::isError($check)) die($check->getMessage());
			if(!$check){
				$query="INSERT INTO point_tbl SET id='$_COOKIE[member_id]', point='$_pointsize_arr[$act]', signdate='$now', act='$act', bsid='$_GET[number]', memo='$date $_point_arr[$act]'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
			}
		}
		break;

	}

	$query="UPDATE user_binfo SET point=(SELECT sum(point) FROM point_tbl WHERE id='$_COOKIE[member_id]') WHERE id='$_COOKIE[member_id]'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
}

function fromDb($arr) {
  if(is_array($arr)){
    foreach($arr as $key => $val){
      $arr[$key] = htmlspecialchars($val);
    }
  }
  return $arr;
}


function make_email($email, $conn, $Table_name, $sel_sid) {
  Global  $tbl_name, $tbl_name , $hospital_tbl, $society_tbl, $specialty_tbl, $officer_tbl, $service_tbl, $send_chk;
  $sel_sid_e = '';
  $kk = 0 ;

  $sel_sid_arr = explode('||', $sel_sid);
  while(list($s_key, $s_val)=each($sel_sid_arr)){
    $s_val = trim($s_val);
    if($s_val){
      if($send_chk == 'officer'){
        //$query = "select $email from $tbl_name as t1, $society_tbl as t2, $officer_tbl as t3  where  t1.sid = t3.user_sid and  t2.sid = t3.society_sid and  t2.soc_num = t3.soc_num and (".$email." > '!' or ".$email2." > '!') and t3.sid = '".$s_val."' ";
          $email = 'email';
      }elseif($send_chk == 'service'){
        //$query = "select $email from $officer_tbl as t3, $tbl_name as t1  left join  service_tbl as t2 on t1.sid = t2.user_sid where t1.sid = t3.user_sid    and t3.society_sid = 1 and (".$email." > '!' or ".$email2." > '!') and t1.sid = '".$s_val."'  ";
          $email = 'email';
      }else{
        $query = "select $email from $Table_name where sid = '".$s_val."' and (".$email." > '!') ";
      }
      echo $query . '<br>';

      $result = $conn->query($query);
      if(DB::isError($result)) {
         die($result->getMessage());
      }
      $result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
      $col[$email] = trim($col[$email]);
      if($col[$email]){
        $sel_sid_e[$kk] = $col[$email];
        $kk++;
      }

    /*************************
    개인DB, 임원DB, 근무처DB, 의학회봉사 : 첫번째 메일주소로만 발송
    학회DB : 모든 메일주소(2개)로 발송
    *************************/
    if($Table_name == $society_tbl){
      $col[$email2] = trim($col[$email2]);
      if($col[$email2]){
        $sel_sid_e[$kk] = $col[$email2];
        $kk++;
      }
    }

    }
  }//end while
  $sel_sid_text = implode(',', $sel_sid_e);
  return $sel_sid_text ;
}//end fun

//// 검색 조건
function make_email02($email, $conn, $Table_name, $sel_sid) {
  Global  $tbl_name, $tbl_name , $hospital_tbl, $society_tbl, $specialty_tbl, $officer_tbl, $service_tbl, $send_chk;
  $sel_sid_e = '';
  $kk = 0 ;

  $sel_sid = base64_decode($sel_sid);
  if($send_chk == 'officerList'){
    $query = "
      select $email from $tbl_name as t1, $society_tbl as t2, $officer_tbl as t3  where  t1.sid = t3.user_sid and  t2.sid = t3.society_sid and  t2.soc_num = t3.soc_num and (".$email." > '!') " . $sel_sid;
      $email = 'email';
  }elseif($send_chk == 'serviceList'){
    $query = "
      select $email from $officer_tbl as t3, $tbl_name as t1  left join  service_tbl as t2 on t1.sid = t2.user_sid where t1.sid = t3.user_sid    and t3.society_sid = 1 and (".$email." > '!') " . $sel_sid;
      $email = 'email';
  }else{
    $query = "select $email from $Table_name where (".$email." > '!') " . $sel_sid;
  }
  //echo $query;
  $result = $conn->query($query);
  if(DB::isError($result)) {
     die($result->getMessage());
  }
  while(is_array($col = $result->fetchRow(DB_FETCHMODE_ASSOC))) {

    $col[$email] = trim($col[$email]);
    if($col[$email]){
      $sel_sid_e[$kk] = $col[$email];
      $kk++;
    }

  }//end while
  $sel_sid_text = implode(',', $sel_sid_e);
  return $sel_sid_text ;
}//end fun

if($sel_sid){
  include $DOCUMENT_ROOT . "func/include.connect.php";
  if($send_chk == 'mem'){  //회원 선택
    $mem_email = make_email('email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'memList'){
    $mem_email = make_email02('email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'hosList'){
    $mem_email = make_email02('hos_email', $conn, $hospital_tbl, $sel_sid);
  }elseif($send_chk == 'hos'){
    $mem_email = make_email('hos_email', $conn, $hospital_tbl, $sel_sid);
  }elseif($send_chk == 'socList'){
    $mem_email = make_email02('soc_email', $conn, $society_tbl, $sel_sid);
  }elseif($send_chk == 'soc'){
    $mem_email = make_email('soc_email', $conn, $society_tbl, $sel_sid);
  }elseif($send_chk == 'officerList'){
    $mem_email = make_email02('t1.email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'officer'){
    $mem_email = make_email('t1.email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'serviceList'){
    $mem_email = make_email02('t1.email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'service'){
    $mem_email = make_email('t1.email', $conn, $tbl_name, $sel_sid);
  }elseif($send_chk == 'serviceList'){
    $mem_email = make_email02('t1.email', $conn, $tbl_name, $sel_sid);
  }

  $conn->disconnect();
}

function doc_pay($year){
	if($year <= 2005){
		return number_format(50000);
	}else{
		return number_format(100000);
	}
}
##### 출신대학 선택양식을 출력한다.
function getBachelorUnivCode($conn,$item='') {
   GLOBAL $conn;
   $HTML = "";

   $query = "SELECT code,value FROM cat_univ ORDER BY value";
   $result = $conn->query($query);
   if(DB::isError($result)) {
      die($result->getMessage());
   }

   $HTML = "<select name=\"bachelor_univ\">\n";
   while(is_array($row = $result->fetchRow())) {
      if($item && !strcmp($item,$row[0])) {
         $HTML .= "<option value=\"$row[0]\" SELECTED>$row[1]\n";
      } else {
         $HTML .= "<option value=\"$row[0]\">$row[1]\n";
      }
   }
   $HTML .= "</select>\n";

   return $HTML;
}

##### 출신대학 선택양식을 출력한다.
function getBachelorUnivCode_search($conn,$item='') {
   GLOBAL $conn;
   $HTML = "";

   $query = "SELECT code,value FROM cat_univ where code != 'UNIV99' ORDER BY value";
   $result = $conn->query($query);
   if(DB::isError($result)) {
      die($result->getMessage());
   }

   $HTML = "<select name=\"bachelor_univ_db\" id=\"bachelor_univ_db\">\n";
   $HTML .= "<option value=''>-</option>";
   while(is_array($row = $result->fetchRow())) {
      if($item && !strcmp($item,$row[0])) {
         $HTML .= "<option value=\"$row[0]\" SELECTED>$row[1]\n";
      } else {
         $HTML .= "<option value=\"$row[0]\">$row[1]\n";
      }
   }
   $HTML .= "</select>\n";

   return $HTML;
}

##### 직업구분 선택양식을 출력한다.
function getJob($conn,$item='') {
   GLOBAL $conn;
   $HTML = "";

   $query = "SELECT code,value FROM cat_job ORDER BY value";
   $result = $conn->query($query);
   if(DB::isError($result)) {
      die($result->getMessage());
   }

   $HTML = "<select name=\"job\" id=\"job\">\n";
   while(is_array($row = $result->fetchRow())) {
      if($item && !strcmp($item,$row[0])) {
         $HTML .= "<option value=\"$row[0]\" SELECTED>$row[1]\n";
      } else {
         $HTML .= "<option value=\"$row[0]\">$row[1]\n";
      }
   }
   $HTML .= "</select>\n";

   return $HTML;
}
function getJob_search($conn,$item='') {
   GLOBAL $conn;
   $HTML = "";

   $query = "SELECT code,value FROM cat_job ORDER BY value";
   $result = $conn->query($query);
   if(DB::isError($result)) {
      die($result->getMessage());
   }

   $HTML = "<select name=\"job_db\" id=\"job_db\">\n";
   $HTML .= "<option value=''>-</option>";
   while(is_array($row = $result->fetchRow())) {
      if($item && !strcmp($item,$row[0])) {
         $HTML .= "<option value=\"$row[0]\" SELECTED>$row[1]\n";
      } else {
         $HTML .= "<option value=\"$row[0]\">$row[1]\n";
      }
   }
   $HTML .= "</select>\n";

   return $HTML;
}


function getTitleName($main_num, $sub_num, $depth_num, $bbs_sid, $title_gubun=false, $tab_num=0, $sub_tabnum=0,$code=null){

	GLOBAL $conn, $society_name, $_CONFIG, $summary;

	if($main_num && $sub_num){
		$subject = "";
		$title = "";

		if($bbs_sid && $title_gubun){
			if($code == 'schedule'){
				if(!$subject) $subject =  $conn->getOne("select subject from event where sid='${bbs_sid}'");
			}else if($code=='sym'){
				if(!$subject) $subject =  $conn->getOne("select subject from schedule_tbl where sid='${bbs_sid}'");
			}else if($code=='book'){
				if(!$subject) $subject =  $conn->getOne("select subject from book_tbl where sid='${bbs_sid}'");
			}else{
				$subject = $conn->getOne("select subject from bbs_tbl where sid='${bbs_sid}'");
			}

			$title = " > ".$summary." > ".$subject;
		}else{
			if($title_gubun){
				$title .= " > ";
			}
			$title .= str_replace("<br/>"," ",$_CONFIG["menu"][$main_num]);

			if($_CONFIG["menu"][$main_num] != $_CONFIG["sub_menu${main_num}"][$sub_num]){
				$title .= " > ".str_replace("<br/>","&nbsp;",$_CONFIG["sub_menu${main_num}"][$sub_num]);
			}
			if($depth_num){
				if($_CONFIG["sub_menu${main_num}"][$sub_num] != $_CONFIG["sub_menu${main_num}_depth${sub_num}"][$depth_num]){
					$title .= " > ".str_replace("<br/>","&nbsp;",$_CONFIG["sub_menu${main_num}_depth${sub_num}"][$depth_num]);
				}
			}

			if($tab_num){
				if($_CONFIG["sub_menu${main_num}_tab_menu${sub_num}"]){
					$title .= " > ".$_CONFIG["sub_menu${main_num}_tab_menu${sub_num}"][$tab_num];
				}
				if($_CONFIG["sub_menu${main_num}_tab_menu${sub_num}_depth${depth_num}"]){
					$title .= " > ".$_CONFIG["sub_menu${main_num}_tab_menu${sub_num}_depth${depth_num}"][$tab_num];
				}
			}

			if($sub_tabnum){
				$title .= " > ".$_CONFIG["sub_menu${main_num}_tab_menu${sub_num}_sub${tab_num}"][$sub_tabnum];
			}
		}
		return $title;
	}else{
		return "";
	}
}

function getSexType($id){
	GLOBAL $conn;

	if($id){
		$query = "select sex from user_binfo where id='${id}'";
		$sex = $conn->getOne($query);
		if($sex == 'M'){
			echo "남";
		}else if($sex=='W'){
			echo "여";
		}
	}else{
		return "";
	}
}
function display($a) {
	$c = Count($a);
	for ($i = 0, Reset($a); $i < $c; $i++, Next($a)) {
		$k = Key($a);
		$v = $a[$k];
		if($i==0){
			$go_con = "?";
		}else{
			$go_con = "&";
		}
		if(!is_array($v)){
			$parm .= "$go_con$k=".htmlspecialchars($v);
		}
	}
	return $parm;
}
if(!function_exists("procBBSPopup2")) {
function procBBSPopup2($code, $table='bbs_tbl', $table2='bbs_popup') {
	global $conn, $_COOKIE;

	//$query="SELECT sid FROM $table WHERE code='$code' AND popup='Y' AND del='N'";
	$query="select b.sid, p.width, p.height, p.position_x, p.position_y, p.popup_close, p.popup_scroll, p.popup_resize, p.startdate, p.enddate";
	$query.=" from $table b join $table2 p on b.sid= p.bsid where b.code='$code' and b.popup='Y' and b.del='N'";
	$query .= "and ( (p.startdate = '0000-00-00' and p.enddate = '0000-00-00')"; // 기간설정이 안되어 있는 경우
	$query .= " or(p.startdate <= DATE_FORMAT(now(), '%Y-%m-%d') and p.enddate >= DATE_FORMAT(now(), '%Y-%m-%d'))"; // 시작일, 마감일 설정되어 있는 경우
	$query .= " or (p.startdate = '0000-00-00' and p.enddate >= DATE_FORMAT(now(), '%Y-%m-%d'))"; // 마감일만 설정되어 있는 경우
	$query .= " or (p.startdate <= DATE_FORMAT(now(), '%Y-%m-%d') and p.enddate = '0000-00-00') )"; // 시작일만 설정되어 있는 경우
	$result=$conn->query($query);
//	echo $query;

	if("112.76.194.13" == $_SERVER['REMOTE_ADDR'])
	{
		//echo $query."<br/>";
	}

	if(DB::isError($result)) die($result->getMessage());
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		if(!$_COOKIE["popup${code}${d[sid]}"]){
			$scroll='no';
			if($d['popup_scroll']=='Y'){
				$scroll='yes';
			}
			$resizable='no';
			if($d['popup_resize']=='Y'){
				$resizable='yes';
			}
			//$print.= "window.open('/popup2.php?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${width},height=${height},scrollbars=${scroll},resizable=${resizable},status=no,directories=no,menubar=no');\n";
			$print.= "window.open('/popup2.php?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${d[width]},height=${d[height]},left=${d[position_x]},top=${d[position_y]},scrollbars=yes,resizable=${resizable},status=no,directories=no,menubar=no');\n";
			//$print .= "alert(\"${msg}\");\n";
		}
	}
	$print .= "//]]>\n</script>\n";
	print($print);
}
}
function to_dec($val,$code='#vkzlstms!2#'){
	GLOBAL $conn;
	if($val){
		$value = $conn->getOne("SELECT AES_DECRYPT(UNHEX('" . $val . "'), '" . $code . "')");
		return $value;
	}
}

$admin_url = explode('/',$PHP_SELF);
if($admin_url[1] == 'admin'){

	if(!$conn) require_once("${DOCUMENT_ROOT}func/include.connect.php");
	//require_once "${DOCUMENT_ROOT}admin/page_log.php";

}

function getYearFee($m_level,$year){
	GLOBAL $conn;

	if($m_level == 'M') $m_level='1';

	$query_c="SELECT cost FROM feelist_item WHERE gubun='Y' AND year='".$year."' AND member_level='$m_level'";
	$cost=$conn->getOne($query_c);
	if(DB::isError($cost)) die($cost->getMessage());

	return $cost;
}

function getJoinFee($m_level,$year){
	GLOBAL $conn;

	if($m_level == 'M') $m_level='1';

	$query_c="SELECT cost FROM feelist_item WHERE gubun='R'";
	$cost=$conn->getOne($query_c);
	if(DB::isError($cost)) die($cost->getMessage());

	return $cost;
}

function getForeverFee($m_level,$year){
	GLOBAL $conn;

	if($m_level == 'M') $m_level='1';

	$query_c="SELECT cost FROM feelist_item WHERE gubun='F'";
	$cost=$conn->getOne($query_c);
	if(DB::isError($cost)) die($cost->getMessage());

	return $cost;
}
function getBbsContent($sid){
	GLOBAL $conn;
	if($sid){
		$content = $conn->getOne("select content from bbs_tbl where sid='${sid}'");
		if($content){

		}else{
			$content = $conn->getOne("select content from schedule_tbl where sid='${sid}'");
		}
		$content = strip_tags($content);
		return str_cut($content,"100");
	}else{
		return "대한심장학회 심부전연구회";
	}
}


## $field값을 제외한 $query_string값 리턴(자기공명)
function GET_field($query_string,$field=''){
	$STRING = explode("&",$query_string);
	foreach($STRING as $v=>$val){
		if($field){
			$tg_field = explode("=",$val);
			if(!strcmp($tg_field[0],$field)) array_splice($STRING,$v,1);
		}
	}
	return implode("&",$STRING);
}
function PutValueParent($val,$target){
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "$('#" . $target . "',parent.document).val('" . $val . "');";
	$print .= "//]]>\n</script>\n";
	print($print);
}

function TBL_subject($arr,$string,$folder,$field,$value='',$color=''){
	$subject = array();
	foreach($arr as $v=>$val){$i++;
		$list_title . $i = "<a href='" . $folder . "?" . $string . "&" . $field . "=" . $v . " ASC' style='color:" . $color . "'>" . $val . "</a>";

		if(strstr($value,$v)){
			if(strstr($value,"ASC")) $list_title . $i = "<a href='" . $folder . "/?" . $string . "&" . $field . "=" . $v . " DESC' class='active' style='color:" . $color . "'>" . str_replace("↑","<span class='red'>↑</span>",$val) . "</a>";
			else $list_title . $i = "<a href='" . $folder . "?" . $string . "&" . $field . "=" . $v . " ASC' class='active' style='color:" . $color . "'>" . str_replace("↓","<span class='red'>↓</span>",$val) . "</a>";
		}
		$subject[] = $list_title . $i;
	}
	return $subject;
}
##### [등록] 사전등록마감 시한이 지났는지의 여부를 반환
function checkDeadLiner($month,$day,$year, $hour = 23, $min = 59, $sec = 59) {
  if(!checkdate($month,$day,$year)) {
    return FALSE;
  }

  if(time() > mktime($hour,$min,$sec,$month,$day,$year)) {
    return FALSE;
  } else {
    return TRUE;
  }
}

##### [등록] 등록마감 시한이 지났는지의 여부를 반환
function checkDeadLine($month,$day,$year) {
   if(!checkdate($month,$day,$year)) {
      return FALSE;
   }

   if(time() > mktime(23,59,59,$month,$day,$year)) {
      return FALSE;
   } else {
      return TRUE;
   }
}
function to_enc($val,$code='#vkzlstms!2#'){
	GLOBAL $conn;
	if($val){
		$value = $conn->getOne("SELECT HEX(AES_ENCRYPT('" . trim($val) . "','" . $code . "'))");
		return $value;
	}
}
function id_masking($_id){
	$_id_len = strlen($_id);
	$id_cut_len = ceil($_id_len/2);
	$id_per_len = floor($_id_len/2);

	$_id_val = substr($_id,0,$id_cut_len);

	for($i=1;$i<=$id_per_len;$i++){
		$_id_val.="*";
	}

	return $_id_val;
}

function getRand($couponLength, $couponString=""){

    $defaultString = "0123456789abcdefghijklmnopqrstuvwxyz";
    srand((double)microtime()*1000000);

    if ( $couponString == "" ){ //$couponString의 값이 정해지지 않았다면 $defaultString 값으로 사용
           $couponString = $defaultString;
    }

   $length = strlen($couponString);

   for($i=0;$i<$couponLength;$i++)
  {
     $couponStr = rand(0,$length-1); //0에서 $defaultString또는 $couponString의 길이사이의 난수를 구한다
     $resultStr .= substr( $couponString, $couponStr, 1 );
   }

  return $resultStr;
}


//교육 시간 string 만들어주기
function getEduStr($edu_sdate, $edu_edate){
	
	$week = array('일', '월', '화', '수', '목', '금', '토');
	$date_str = "";
	$date_str .= 	date("Y년 m월 d일 ",$edu_sdate) ."(".$week[date("w",$edu_sdate)].") ". date("H:i", $edu_sdate). " ~ ";

	if( date("Y",$edu_sdate) != date("Y",$edu_edate) ) { $date_str .= date("Y년",$edu_edate); }
	if( date("m",$edu_sdate) != date("m",$edu_edate) ) { $date_str .= " ".date("m월",$edu_edate); }
	if( date("d",$edu_sdate) != date("d",$edu_edate) ) { $date_str .= " ".date("d일",$edu_edate); }
	if( date("w",$edu_sdate) != date("w",$edu_edate) ) { $date_str .= " (".$week[date("w",$edu_edate)].") "; }
	$date_str.= " ".date("H:i", $edu_edate);									
	
	return $date_str;

}

//마감 여부 체크 return -> 시작일과 종료일 사이면 TRUE
function checkEduTime($sdate,$edate) {
	if(time() > $sdate && time() < $edate) {
		return TRUE;
	}else{
		return FALSE;
	}
}

function makeLog($qry=""){
	global $conn, $_GET, $_POST, $_COOKIE;
	
	$cookie = "";
	$request = "";
	foreach ($_COOKIE as $k=>$v)
		$cookie .="COOKIE[$k=$v]##";
	foreach ($_GET as $k=>$v)
		$request.="GET[$k=$v]##";
	foreach ($_POST as $k=>$v)
		$request.="POST[$k=$v]##";
		
	$cookie = addslashes($cookie);
	$request = addslashes($request);
	$qry = addslashes($qry);
	
	$query = "insert into event_log set ip='".$_SERVER['REMOTE_ADDR']."', action='".$_SERVER['PHP_SELF']."', cookie='$cookie', request='$request',query='$qry', signdate=now() ";		
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
}


function mms_log($text=""){
	global $conn, $_GET, $_POST, $_COOKIE;
	
	foreach ($_GET as $k=>$v)
		$request.="GET[$k=$v]##";
	foreach ($_POST as $k=>$v)
		$request.="POST[$k=$v]##";
			
	$text = addslashes($text);
	
	$query = "insert into mms_log_tbl set ip='".$_SERVER['REMOTE_ADDR']."', text='$text', request='$request', signdate=now() ";		
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
}




//메일 로그 기록
function makeEmailLog($to_name,$to_email,$subject,$mail_body){
	global $conn, $_GET, $_POST, $_COOKIE;
	
	$to_name = addslashes($to_name);	
	$to_email = addslashes($to_email);	
	$subject = addslashes($subject);	
	$mail_body = addslashes($mail_body);	
		
	$query = "insert into event_maillog set to_name='$to_name', to_email='$to_email', subject='$subject', mail_body='$mail_body', action='".$_SERVER['PHP_SELF']."', signdate=now() ";		
	$result = $conn->query($query);
	if(DB::isError($result)) {
	   die($result->getMessage());
	}	
}

//unixtime 으로 변경후 가공
function make_mktime($sdate,$stime){
	$week = array('일', '월', '화', '수', '목', '금', '토');
	
	$return_str = "";

	$sdate_arr= explode("-",$sdate);
	$stime_arr = explode(":",$stime);
		
	if($stime == ""){
		$stime_arr = array("0","0");
	}
						 
	$unixtime  = mktime($stime_arr[0], $stime_arr[1] ,0, $sdate_arr[1],$sdate_arr[2],$sdate_arr[0]);
	$return_str .= date("Y년 m월 d일",$unixtime);
	$return_str .= " (". $week[date("w",$unixtime)]. ") ";
	
	if($stime != ""){
		$return_str .= date("H시 i분",$unixtime);	
	}
	
	
	return $return_str;
}


### 주어진 GET변수들을 링크로 만들어주되 특정 정해진 변수만을 제외한후 제작
function get_objlink($continue){
	$get_link_arr = array();
	$get_link="";
	$continue_arr=explode(',',$continue);
	foreach($_GET as $Gkey=>$Gval){
		if(empty($Gval)) continue;
		if(in_array($Gkey,$continue_arr)) continue;
		$get_link_arr[] = $Gkey.'='.$Gval;
	}
	$get_link = '?'.implode('&',$get_link_arr);
	return $get_link;
}

function get_objlink2($continue,$arr,$st){
	$get_link_arr = array();
	$get_link="";
	$continue_arr=explode(',',$continue);
	foreach($arr as $Gkey=>$Gval){
		if(empty($Gval)) continue;
		if(in_array($Gkey,$continue_arr)) continue;
		$get_link_arr[] = $Gkey.'='.$Gval;
	}
	$get_link = $st.implode('&',$get_link_arr);
	return $get_link;
}

function get_objinput($continue){
	$get_input_arr = array();
	$get_input="";
	$continue_arr=explode(',',$continue);
	foreach($_GET as $Gkey=>$Gval){
		if(empty($Gval)) continue;
		if(in_array($Gkey,$continue_arr)) continue;
		$get_input_arr[] = '<input type="hidden" name="'.$Gkey.'" value="'.$Gval.'">';
	}
	$get_input = implode(' ',$get_input_arr);
	return $get_input;
}

# 팝업 합수를 추가함

function procBBSPopupMain($code, $table='bbs_tbl', $table2='bbs_popup') {
	global $conn, $_COOKIE;

	//$query="SELECT sid FROM $table WHERE code='$code' AND popup='Y' AND del='N'";
	$query="select b.sid, p.width, p.height, p.position_x, p.position_y, p.popup_close, p.popup_scroll, p.popup_resize, p.startdate, p.enddate";
	$query.=" from $table b join $table2 p on b.sid= p.bsid where b.code='$code' and b.popup='Y' and b.del='N'";
	$query .= "and ( (p.startdate = '0000-00-00' and p.enddate = '0000-00-00')"; // 기간설정이 안되어 있는 경우
	$query .= " or(p.startdate <= DATE_FORMAT(now(), '%Y-%m-%d') and p.enddate >= DATE_FORMAT(now(), '%Y-%m-%d'))"; // 시작일, 마감일 설정되어 있는 경우
	$query .= " or (p.startdate = '0000-00-00' and p.enddate >= DATE_FORMAT(now(), '%Y-%m-%d'))"; // 마감일만 설정되어 있는 경우
	$query .= " or (p.startdate <= DATE_FORMAT(now(), '%Y-%m-%d') and p.enddate = '0000-00-00') )"; // 시작일만 설정되어 있는 경우
	//echo $query;
	$result=$conn->query($query);
//	echo $query;
	if(DB::isError($result)) die($result->getMessage());
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		if(!$_COOKIE["popup${code}${d[sid]}"]){
			$scroll='yes';
			if($d['popup_scroll']=='Y'){
				$scroll='yes';
			}
			$resizable='no';
			if($d['popup_resize']=='Y'){
				$resizable='yes';
			}
			//$print.= "window.open('/popup2.html?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${width},height=${height},scrollbars=${scroll},resizable=${resizable},status=no,directories=no,menubar=no');\n";
			$print.= "window.open('/popup2.php?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${d[width]},height=${d[height]},left=${d[position_x]},top=${d[position_y]},scrollbars=${scroll},resizable=${resizable},status=no,directories=no,menubar=no');\n";
			//$print .= "alert(\"${msg}\");\n";
}
}
$print .= "//]]>\n</script>\n";
print($print);
}


class StringFunction {
	function imgResize($img,$limit_w,$limit_h){
		$file_img = StringFunction::imgIncode($img);
		$size = getImagesize($img);

		$tmp = 1;
		if ($size[0] > $limit_w) {
			$tmp = $limit_w / $size[0];
			if($size[1] * $tmp > $limit_h) $tmp = $tmp * ($limit_h / ($size[1]*$tmp));
		} else if ( $size[1] > $limit_h ) $tmp = $limit_h / $size[1];

		 $x_size = $size[0] * $tmp;
		 $y_size = $size[1] * $tmp;
		//return '<a href="'.$file_img.'" target="_blank"><img src="'.$file_img.'" width="'.$x_size.'" height="'.$y_size.'"></a>';
		if($x_size>0 && $y_size>0){
			return '<img src="'.$file_img.'" width="'.$x_size.'" height="'.$y_size.'" border=0>';
		}
	}

	function imgIncode($str){
		if($str){
			$str = str_replace("%3A",":",str_replace("%2F","/",rawurlencode($str)));
		}
		return $str;
	}
}

##### 동일한 의사면허 번호가 존재하는지 검사한다.
function isDuplicateLicense(&$conn,$license_number) {
   $rows = $conn->getOne("SELECT count(*) FROM user_binfo WHERE license_number = '" . $license_number. "'");
   if(DB::isError($rows)) {
      die($rows->getMessage());
   }

   if($rows > 0) {
      return TRUE;
   } else {
      return FALSE;
   }
}

function explode_arr($field,$num,$gubun){
	$ex_f = explode($gubun,$field);
	return $ex_f[$num];
}


function master_echo($qry){
	global $master_ip;
	if(eregi($_SERVER['REMOTE_ADDR'],$master_ip)){
		echo $qry."<BR>";
	}
}



function change_replace($string,$s) { //배열치환
	$ex = explode(",",$s);
	for($i=0;$i<count($ex);$i++){
		$ex2 = explode("=>",$ex[$i]);
		
		$patterns[] = "/".$ex2[0]."/";
		$replacements[] = $ex2[1];
	}
	
	return preg_replace($patterns, $replacements, $string);
}


function makeBarcode($text,$abyear,$group = false){
	
	//바코드에 접두어를 붙여서 구분 해준다.
	if($group){
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/group/";		
		$filename = $save_dir.$text.".png";
		$text = $text;
	}else{
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/";	
		$filename = $save_dir.$text.".png";
		$text = $text;
	}
	
	// Loading Font
	$font = new BCGFontFile($_SERVER['DOCUMENT_ROOT'].'barcode/font/Arial.ttf', 10);
		
	// The arguments are R, G, B for color.
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);
	
	$drawException = null;
	try {
	    $code = new BCGcode39();
	    $code->setScale(2); // Resolution
	    $code->setThickness(30); // Thickness
	    $code->setForegroundColor($color_black); // Color of bars
	    $code->setBackgroundColor($color_white); // Color of spaces
	    $code->setFont($font); // Font (or 0)
	    $code->parse($text); // Text
	} catch(Exception $exception) {
	    $drawException = $exception;
	}
	
	if(!is_dir($save_dir)){ @mkdir($save_dir, 0777); }
	
	
	$drawing = new BCGDrawing($filename, $color_white);
	if($drawException) {
	    $drawing->drawException($drawException);
	} else {
	    $drawing->setBarcode($code);
	    $drawing->draw();
	}
	// Draw (or save) the image into PNG format.
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	
}


function makeBarcode_jpg($text,$abyear,$group = false){
	
	//바코드에 접두어를 붙여서 구분 해준다.
	if($group){
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/group/";		
		$filename = $save_dir.$text.".jpg";
		$text = $text;
	}else{
		$save_dir = $_SERVER['DOCUMENT_ROOT']."barcode/$abyear/";	
		$filename = $save_dir.$text.".jpg";
		$text = $text;
	}
	
	// Loading Font
	$font = new BCGFontFile($_SERVER['DOCUMENT_ROOT'].'barcode/font/Arial.ttf', 10);
		
	// The arguments are R, G, B for color.
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);
	
	$drawException = null;
	try {
	    $code = new BCGcode39();
		$code->setScale(4); // Resolution
	    $code->setThickness(30); // Thickness
	    $code->setForegroundColor($color_black); // Color of bars
	    $code->setBackgroundColor($color_white); // Color of spaces
	    $code->setFont($font); // Font (or 0)
	    $code->parse($text); // Text
	} catch(Exception $exception) {
	    $drawException = $exception;
	}
	
	if(!is_dir($save_dir)){ @mkdir($save_dir, 0777); }
	
	
	$drawing = new BCGDrawing($filename, $color_white);
	if($drawException) {
	    $drawing->drawException($drawException);
	} else {
	    $drawing->setBarcode($code);
	    $drawing->draw();
	}
	// Draw (or save) the image into PNG format.
	$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
	
}

function getRefererUrl($url){
	if(!trim($url)) return '';
	$url_exp = explode('/' , $url);
	return strCut(str_replace('www.','',$url_exp[2]),30);
}

function format_phone($phone){
    $phone = preg_replace("/[^0-9]/", "", $phone);
    $length = strlen($phone);

    switch($length){
      case 11 :
          return preg_replace("/([0-9]{3})([0-9]{4})([0-9]{4})/", "$1-$2-$3", $phone);
          break;
      case 10:
          return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $phone);
          break;
      default :
          return $phone;
          break;
    }
}

function masking($_type, $_data){
        $_data = str_replace('-','',$_data);
        $strlen = mb_strlen($_data, 'utf-8');
        $maskingValue = "";
         
        $useHyphen = "-";
 
        if($_type == 'N'){
            switch($strlen){
                case 2:
                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'*';
                    break;
                case 3:
                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'*'.mb_strcut($_data, 8, 11, "UTF-8");
                    break;
                case 4:
                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
                    break;
                default:
                    $maskingValue = mb_strcut($_data, 0, 3, "UTF-8").'**'.mb_strcut($_data, 12, 15, "UTF-8");
                    break;
            }
        }else if($_type == 'P'){
            switch($strlen){
                case 10:
                    $maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}***{$useHyphen}".mb_substr($_data, 6, 4);
                    break;
                case 11:
                    $maskingValue = mb_substr($_data, 0, 3)."{$useHyphen}****{$useHyphen}".mb_substr($_data, 7, 4);
                    break;
                default:
                    trigger_error('Not a known format parametter in function', E_USER_NOTICE);
                    break;
            }
        }else{
            trigger_error('Masking Function Parameter Error', E_USER_NOTICE);
        }
        return $maskingValue;
}

function order_sort($PHP_SELF,$search_url,$field){
	$sort_chk = ($_GET['order']==$field) ? 'fcRed' : '';
	if (($_GET['order'] == $field && $_GET['stand'] == "asc") || $_GET['order']!=$field) $order_sort = '<a href="'.$PHP_SELF.'?'.$search_url.'&order='.$field.'&stand=desc" class="'. $sort_chk .'" >↑</a>';
	if ($_GET['order'] == $field && $_GET['stand'] == "desc") $order_sort = '<a href="'.$PHP_SELF.'?'.$search_url.'&order='.$field.'&stand=asc" class="'. $sort_chk .'" >↓</a>';
	return $order_sort;
}

function make_residence_time($hour_one,$hour_two){
	
	if( stristr( $hour_one, "-" ) !== false ){ $hour_one = "00:00:00";}
	if( stristr( $hour_two, "-" ) !== false ){ $hour_two = "00:00:00";}
	
	$h =  strtotime($hour_one);
	$h2 = strtotime($hour_two);
	
	$minute = date("i", $h2);
	$second = date("s", $h2);
	$hour = date("H", $h2);
	
	$convert = strtotime("+$minute minutes", $h);
	$convert = strtotime("+$second seconds", $convert);
	$convert = strtotime("+$hour hours", $convert);
	$new_time = date('H:i:s', $convert);
	
	return $new_time;
	
}

function None_REFERER_new($msg='The wrong approach.'){
	$useragent = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
	if (preg_match('~MSIE|Internet Explorer~i', $useragent ) || (strpos($useragent , 'Trident/7.0; rv:11.0') !== false)) {
		ob_start();
		?>
		<script type="text/javascript">
		//<![CDATA[
		if(opener) {
			if(!window.opener.document.URL){
				alert("<?=$msg?>");
				self.close();
			}
		}else{
			if(!document.referrer){
				alert("<?=$msg?>");
				location.href='/';
			}
		}
		//]]>
		</script>
		<?
		$print .= ob_get_contents();
		ob_end_clean();
	}else{
		if(strpos($_SERVER["HTTP_REFERER"], str_replace("www.","",$_SERVER['SERVER_NAME'])) !== false){  
		}else{
			ob_start();
			?>
			<script type="text/javascript">
			//<![CDATA[
			if(opener) {
				if(!window.opener.document.URL){
					alert("<?=$msg?>");
					self.close();
				}
			}else{
				if(!document.referrer){
					alert("<?=$msg?>");
					location.href='/';
				}
			}
			//]]>
			</script>
			<?
			$print .= ob_get_contents();
			ob_end_clean();
		}
	}
	print($print);
}


function admin_orderby($naming,$field,$sort_field,$orderby,$search_url){
	if($field==$sort_field) $color="color:red;";
	if($orderby=="" || $orderby=="desc" || $field!=$sort_field){
		echo "<a href='".$PHP_SELF."?sort_field=".$field."&orderby=asc".$search_url."' style='text-decoration:none;".$color."'>".$naming."↓</a>";
	}else{
		echo "<a href='".$PHP_SELF."?sort_field=".$field."&orderby=desc".$search_url."' style='text-decoration:none;".$color."'>".$naming."↑</a>";
	}
}

function author_replace($content){
	$replace_search = array("1","2","3","4","5","6","7","8","9","10","*","–","-","‑"," – ","—");
	$replace_target = array("<sup>1</sup>", "<sup>2</sup>", "<sup>3</sup>", "<sup>4</sup>", "<sup>5</sup>", "<sup>6</sup>", "<sup>7</sup>", "<sup>8</sup>", "<sup>9</sup>", "<sup>10</sup>", "<sup>*</sup>","-","-","-","-","-");
	return str_replace($replace_search, $replace_target, $content);
}

function imgResize($img,$limit_w,$limit_h){
	$size = getImagesize($_SERVER['DOCUMENT_ROOT'].$img);
	
	$tmp = 1;
	if ($size[0] > $limit_w) {
		$tmp = $limit_w / $size[0];
		if($size[1] * $tmp > $limit_h) $tmp = $tmp * ($limit_h / ($size[1]*$tmp));
	} else if ( $size[1] > $limit_h ) $tmp = $limit_h / $size[1];

	 $x_size = $size[0] * $tmp;
	 $y_size = $size[1] * $tmp;
	//return '<a href="'.$file_img.'" target="_blank"><img src="'.$file_img.'" width="'.$x_size.'" height="'.$y_size.'"></a>';
	if($x_size>0 && $y_size>0){
		return '<img src="'.$img.'" width="'.$x_size.'" height="'.$y_size.'" style="border:0px;">';
	}
}
function GenerateString($length) {
    $characters = "0123456789";
    $characters .= "abcdefghijklmnopqrstuvwxyz";
    $characters .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string_generated = "";
    $nmr_loops = $length;
    while ($nmr_loops--) {
        $string_generated .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string_generated;
}

/**
 * registration_tbl 지정 컬럼 스냅샷
 * @param int $targetSid
 * @param array $cols 컬럼명 목록 (영문/숫자/_ 만 허용)
 * @return array 없으면 빈 배열
 */
function regLogSnapshot($targetSid, $cols) {
	global $conn;

	$targetSid = (int)$targetSid;
	if ($targetSid < 1 || !is_array($cols) || !$cols || !is_object($conn)) {
		return array();
	}

	$safeCols = array();
	foreach ($cols as $col) {
		$col = trim((string)$col);
		if ($col != '' && preg_match('/^[A-Za-z0-9_]+$/', $col)) {
			$safeCols[] = $col;
		}
	}
	if (!$safeCols) {
		return array();
	}

	$query = 'SELECT '.implode(', ', $safeCols).' FROM registration_tbl WHERE sid = ?';
	$result = $conn->query($query, array($targetSid));
	if (DB::isError($result)) {
		error_log('[RegLog] snapshot failed: sid='.$targetSid.' '.$result->getMessage());
		return array();
	}
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	$result->free();
	if (!$row || !is_array($row)) {
		return array();
	}
	return $row;
}

/**
 * old/new 값 길이 상한 (로그 TEXT 비대화 방지)
 */
function regLogTruncateVal($val) {
	$val = (string)$val;
	if (strlen($val) > 500) {
		return substr($val, 0, 500).'...';
	}
	return $val;
}

/**
 * registration 변경 이력 기록
 * $changes = array('field' => array($old, $new), ...)
 * old == new 항목은 skip. 로그 실패는 본 작업에 영향 없음.
 *
 * @param int $targetSid
 * @param string $action insert|update|delete
 * @param string $source postform|pay_status|desk|memo|delete|excel
 * @param array $changes
 */
function regLogWrite($targetSid, $action, $source, $changes) {
	global $conn, $_COOKIE;

	$targetSid = (int)$targetSid;
	$action = trim((string)$action);
	$source = trim((string)$source);
	if ($targetSid < 1 || $action == '' || $source == '' || !is_array($changes) || !is_object($conn)) {
		return;
	}

	$adminSid = isset($_COOKIE['wmember_sid']) ? (int)$_COOKIE['wmember_sid'] : 0;
	$ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '';
	if (strlen($ip) > 45) {
		$ip = substr($ip, 0, 45);
	}
	$createdAt = date('Y-m-d H:i:s');

	foreach ($changes as $field => $pair) {
		$field = trim((string)$field);
		if ($field == '' || !is_array($pair) || count($pair) < 2) {
			continue;
		}
		$oldVal = isset($pair[0]) ? (string)$pair[0] : '';
		$newVal = isset($pair[1]) ? (string)$pair[1] : '';
		if ($oldVal === $newVal) {
			continue;
		}
		if (strlen($field) > 40) {
			$field = substr($field, 0, 40);
		}
		$oldVal = regLogTruncateVal($oldVal);
		$newVal = regLogTruncateVal($newVal);

		$ins = $conn->query(
			'INSERT INTO reg_change_log SET target_sid = ?, action = ?, source = ?, field = ?, old_val = ?, new_val = ?, admin_sid = ?, ip = ?, created_at = ?',
			array($targetSid, $action, $source, $field, $oldVal, $newVal, $adminSid, $ip, $createdAt)
		);
		if (DB::isError($ins)) {
			error_log('[RegLog] write failed: target='.$targetSid.' field='.$field.' '.$ins->getMessage());
		}
	}
}

/**
 * 스냅샷과 신규값 배열을 changes 형식으로 변환
 * @param array $oldRow
 * @param array $newVals field => new value
 * @return array
 */
function regLogBuildChanges($oldRow, $newVals) {
	$changes = array();
	if (!is_array($newVals)) {
		return $changes;
	}
	if (!is_array($oldRow)) {
		$oldRow = array();
	}
	foreach ($newVals as $field => $newVal) {
		$oldVal = isset($oldRow[$field]) ? $oldRow[$field] : '';
		if ((string)$oldVal === (string)$newVal) {
			continue;
		}
		$changes[$field] = array($oldVal, $newVal);
	}
	return $changes;
}

?>