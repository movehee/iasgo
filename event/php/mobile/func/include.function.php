<?

###### Default Define
define('M2', true);

if(!strcmp(substr($_SERVER['DOCUMENT_ROOT'], -1), '/')){
	define('ROOT', substr($_SERVER['DOCUMENT_ROOT'], 0, strlen($_SERVER['DOCUMENT_ROOT'])-1));
} else {
	define('ROOT', $_SERVER['DOCUMENT_ROOT']);
}
###### Variable Arrangements

if($_COOKIE['member_level']=="M" || $_COOKIE['member_level']=="Z"){
	@logchk();
}

if(!get_magic_quotes_gpc()){
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

function PutMessageOpenerReload($msg) {
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert('" . $msg . "');\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutParentReload(){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutParentLocation($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "parent.location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageParentLocation($msg,$url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert('" . $msg . "');\n";
	$print .= "parent.location.href='${url}';\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutMessageParentReload($msg){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "alert('" . $msg . "');\n";
	$print .= "parent.location.reload();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutOpenerParentLocationClose($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "opener.parent.location.href='${url}';\n";
	$print .= "window.close();";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutConfirmLocation($msg,$url1,$url2){
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "if(confirm('" . $msg . "')){";
	$print .= "location.href = '" . $url1 . "';";
	$print .= "}else{";
	$print .= "location.href = '" . $url2 . "';";
	$print .= "}";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function PutValueParent($val,$target){
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "$('#" . $target . "',parent.document).val('" . $val . "');";
	$print .= "//]]>\n</script>\n";
	print($print);
}

function PutValueParentImage($val,$url,$target1,$target2){
	$print = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "$('#" . $target1 . "',parent.document).val('" . $val . "');";
	$print .= "$('#" . $target2 . "',parent.document).css('background','none');";
	$print .= "$('#" . $target2 . "',parent.document).html('<img src=\'" . $url . $val . "\' border=0 width=110>');";
	$print .= "//]]>\n</script>\n";
	print($print);
}

function PutCloseOpenerLocation($url){
	$print  = "<script type=\"text/javascript\">\n//<![CDATA[\n";
	$print .= "opener.location.href='${url}';\n";
	$print .= "self.close();\n";
	$print .= "//]]>\n</script>\n";
	print($print);
	exit;
}

function NoDirect($referer,$get=''){
	if(!$referer && $get) PutMessageLocation("잘못된 경로로 접근하셨습니다.","/");
}

###### Alert Functions End

###### Redirect Functions Start
function RefreshURL($url){ print("<meta http-equiv='Refresh' content='0; url=${url}'>"); exit; }

function redirect($url) {
   $url = urlencode($url);
   echo "<meta http-equiv='Refresh' content='0; URL=/join/?url=${url}'>";
   exit;
}



function redirect_p($url) {
   $url = urlencode($url);
   putMessage("로그인 후 사용해주세요");
   echo "<meta http-equiv='Refresh' content='0; URL=/join/?url=$url'>";
   exit;
}
###### Redirect Functions End

###### Login Check Functions Start
# 로그인 회원 체크
function isLogined() {
	global $_COOKIE;
	if($_COOKIE['member_id']) return true;
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
	global $_COOKIE;
	if(!strcasecmp($_COOKIE['member_level'], 'M') || !strcasecmp($_COOKIE['member_level'], 'Z')) return true;
	return false;
}

function AdminChk(){
	global $_COOKIE;
	if($_COOKIE['member_level']!="M" || $_COOKIE['member_level']!="Z"){
		PutMessageLocation("관리자로 로그인해주시기 바랍니다.","/");
	}
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
   echo "<meta http-equiv='Refresh' content='0; URL=/join/?url=" . $url . "'>";
   exit;
}

function LevelCheck($level_group){
	global $_COOKIE;

	if(strstr($level_group,$_COOKIE['member_level'])) return true;
	else return false;
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

function procLoginChk_S() {
	global $_COOKIE,$_SERVER;
	if(isLogined()) return;
	else redirect_p("${_SERVER[PHP_SELF]}?${_SERVER[QUERY_STRING]}");
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
	if($dot==true) $temp_str.="..";
	return $temp_str;
}

function str_cut($msg, $cut_size, $dot=true) {
	return strCut($msg, $cut_size, $dot);
}

function utf8_strcut( $str, $size, $dot=true){
	$substr = substr( $str, 0, $size * 2 );
	$multi_size = preg_match_all( '/[\\x80-\\xff]/', $substr, $multi_chars );

	if ( $multi_size > 0 ) $size = $size + intval( $multi_size / 3 ) - 1;

	if ( strlen( $str ) > $size ) {
		$str = substr( $str, 0, $size );
		$str = preg_replace( '/(([\\x80-\\xff]{3})*?)([\\x80-\\xff]{0,2})$/', '$1', $str );
		if($dot==true) $str .= '..';
	}
	return $str;
}

# 파일 아이콘 정리
function IconType($filename, $iconlocation='/icon/', $str='') {
	$icon_value=explode(".",$filename,"2");
	$tmp=strtolower($icon_value[1]);
	switch($tmp){
		case 'avi': case 'doc':case 'docx': case 'ppt': case 'pptx': case 'exe': case 'gif': case 'jpg': case 'hwp':
		case 'pdf':	case 'mp3': case 'wav': case 'xls': case 'xlsx': case 'zip': case 'alz': break;
		default: $tmp='file'; break;
	}
	if($str) return printImg("${iconlocation}${str}${tmp}.gif", $filename, false);
	else return printImg("${iconlocation}${tmp}.gif", $filename, 'align="middle"');
}

function IconType2($filename) {
	$icon_value=explode(".",$filename,"2");
	if((!strcmp($icon_value[1],"avi")) OR (!strcmp($icon_value[1],"AVI")))  $img_icon="<img src=\"/image/icon/avi.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"doc")) OR (!strcmp($icon_value[1],"DOC")))	$img_icon="<img src=\"/image/icon/doc.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"ppt")) OR (!strcmp($icon_value[1],"PPT")))	$img_icon="<img src=\"/image/icon/ppt.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"exe")) OR (!strcmp($icon_value[1],"EXE")))	$img_icon="<img src=\"/image/icon/exe.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"gif")) OR (!strcmp($icon_value[1],"GIF")))	$img_icon="<img src=\"/image/icon/gif.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"jpg")) OR (!strcmp($icon_value[1],"JPG")))	$img_icon="<img src=\"/image/icon/jpg.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"hwp")) OR (!strcmp($icon_value[1],"HWP")))	$img_icon="<img src=\"/image/icon/hwp.gif\" width=13 heigth=14 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"pdf")) OR (!strcmp($icon_value[1],"PDF")))	$img_icon="<img src=\"/image/icon/pdf.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"mp3")) OR (!strcmp($icon_value[1],"MP3")))	$img_icon="<img src=\"/image/icon/mp3.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"wav")) OR (!strcmp($icon_value[1],"WAV")))	$img_icon="<img src=\"/image/icon/wav.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"xls")) OR (!strcmp($icon_value[1],"XLS")))	$img_icon="<img src=\"/image/icon/xls.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if((!strcmp($icon_value[1],"zip")) OR (!strcmp($icon_value[1],"ZIP")))  $img_icon="<img src=\"/image/icon/zip.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";
	if(!$img_icon) $img_icon="<img src=\"/image/icon/etc.gif\" width=16 heigth=16 border=0 alt=\"" . $filename . "\">";

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
/*function autolink($html) {
	if($html && $html != "http://"){
	return preg_replace_callback('~((?:https?|ftps?|ed2k|mmst?)://|//)?((\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|(?:[a-z\d\-\.]+(?:\.(com|net|org|af|al|dz|as|ad|ao|ai|aq|ag|ar|am|aw|au|at|az|bs|bh|bd|bb|by|be|bz|bj|bm|bt|bo|ba|bw|bv|br|io|vg|bn|bg|bf|bi|kh|cm|ca|cv|ky|cf|td|cl|cn|cx|cc|co|km|cd|cg|ck|cr|ci|cu|cy|cz|dk|dj|dm|do|ec|eg|sv|gq|er|ee|et|fo|fk|fj|fi|fr|gf|pf|tf|ga|gm|ge|de|gh|gi|gr|gl|gd|gp|gu|gt|gn|gw|gy|ht|hm|va|hn|hk|hr|hu|is|in|id|ir|iq|ie|il|it|jm|jp|jo|kz|ke|ki|kp|kr|kw|kg|la|lv|lb|ls|lr|ly|li|lt|lu|mo|mk|mg|mw|my|mv|ml|mt|mh|mq|mr|mu|yt|mx|fm|md|mc|mn|ms|ma|mz|mm|na|nr|np|an|nl|nc|nz|ni|ne|ng|nu|nf|mp|no|om|pk|pw|ps|pa|pg|py|pe|ph|pn|pl|pt|pr|qa|re|ro|ru|rw|sh|kn|lc|pm|vc|ws|sm|st|sa|sn|cs|sc|sl|sg|sk|si|sb|so|za|gs|es|lk|sd|sr|sj|sz|se|ch|sy|tw|tj|tz|th|tl|tg|tk|to|tt|tn|tr|tm|tc|tv|vi|ug|ua|ae|gb|um|us|uy|uz|vu|ve|vn|wf|eh|ye|zm|zw))))(:\d+)?(?:([^/\s\)\x80-\xff])|/[^ \)<>\r\n]*)?)~im', 'autolink_callback', $html);
	}

}*/

function autolink($contents) {
       $pattern = "/(http|https|ftp|mms):\/\/[0-9a-z-]+(\.[_0-9a-z-]+)+(:[0-9]{2,4})?\/?";
       $pattern .= "([\.~_0-9a-z-]+\/?)*";
       $pattern .= "(\S+\.[_0-9a-z]+)?";
       $pattern .= "(\?[_0-9a-z#%&=\-\+]+)*/i";
       $replacement = "<a href=\"\\0\" target=\"_blank\">\\0</a>";
       return preg_replace($pattern, $replacement, $contents, -1);
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
	$lang = $lang ? $lang : 'utf-8';
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
			//$print.= "window.open('/popup2.html?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${width},height=${height},scrollbars=${scroll},resizable=${resizable},status=no,directories=no,menubar=no');\n";
			$print.= "window.open('/popup2.html?code=${code}&tbl=${table}&number=${d[sid]}', 'popup${code}${d[sid]}', 'width=${d[width]},height=${d[height]},left=${d[position_x]},top=${d[position_y]},scrollbars=${scroll},resizable=${resizable},status=no,directories=no,menubar=no');\n";
			//$print .= "alert(\"${msg}\");\n";
}
}
$print .= "//]]>\n</script>\n";
print($print);
}}

# 이미지 태그 자동 넣기
function printImg($src, $alt='', $type=false, $opt='') {
	if(!$src) return '이미지를 입력해 주세요';
	$root=$_SERVER['DOCUMENT_ROOT'];
	if(!strcmp('/', substr($root, -1))) $root=substr($root, 0, strlen($root)-1);
	$local=$root.$src;
	if(!file_exists($local)) return '';
	$info = getimagesize($local);
	if(!$type){
		return "<img src=\"${src}\" width=\"${info[0]}\" height=\"${info[1]}\" alt=\"${alt}\" ${opt} style=\"cursor:hand\"/>";
	} else {
		return "<input type=\"image\" src=\"${src}\" width=\"${info[0]}\" height=\"${info[1]}\" alt=\"${alt}\" ${opt} style=\"cursor:hand\" border=\"0\" />";
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

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
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

function printSelectBox_new($arr, $id, $value='', $option='', $f_value = '') {
	if(!is_array($arr)) return "Is Not Array.";
	if(!$id) return "ID is null";
	if($value) $value = in_array($value,$arr) ? $value : "직접선택";

	$return="<select name=\"${id}\" id=\"${id}\" ${option}>\n";
  if($f_value){
	  $return.="<option value=\"\">".$f_value."</option>\n";
  }
	foreach($arr as $tkey => $tval){
		if(!strcmp($value,$tval)){
			$return.="<option value=\"${tval}\" selected=\"selected\">${tval}</option>\n";
		} else {
			$return.="<option value=\"${tval}\">${tval}</option>\n";
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
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\" checked=\"checked\"/><label for=\"${id}_${i}\">${tval}</label>\n";
		} else {
			$return.="<input type=\"radio\" name=\"${id}\" id=\"${id}_${i}\" ${option} value=\"${tkey}\"/><label for=\"${id}_${i}\">${tval}</label>\n";
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
	if(!$_COOKIE['member_id']) return false;
	if(isAdminLogined()) return true;
	return ereg($_COOKIE['member_id'], $_permit['bbsAdmin']);
}

function isBBSPermit($act='list') { # 해당 액션의 권한이 있는지 확인 (등급)
	global $_COOKIE, $_permit;
	if(isBBSAdmin()) return true;
	if(!$_COOKIE['member_level']) return false;
	if(!$_permit[$act]) return true;
	return ereg($_COOKIE['member_level'], $_permit[$act]);
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
	if(eregi('MSIE|Windows', $_SERVER['HTTP_USER_AGENT']) && !eregi('Firefox', $_SERVER['HTTP_USER_AGENT']))
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

##### 현재의 사용자가 상담의사인지 조사
function isDoctorLogined() {
	GLOBAL $HTTP_COOKIE_VARS;
 if($HTTP_COOKIE_VARS["member_sid"] && ($HTTP_COOKIE_VARS["doctor_level"] == "Y")) {
	 return TRUE;
 } else {
	 return FALSE;
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

## $field값을 제외한 $query_string값 리턴
function GET_field($query_string,$field=''){
	$STRING = explode("&",$query_string);
	$f = explode("|",$field);

	foreach($STRING as $v=>$val){
		if($field){
			$tg_field = explode("=",$val);
			if(!in_array($tg_field[0],$f)){
				$newString[] = $val;
				//array_splice($STRING,$v,1);
			}
		}
	}
	return implode("&",$newString);
}

function function_use(){
	return true;
}

## 제목에 정렬기준 정할때...
function TBL_subject($arr,$string,$folder,$field,$value='',$color=''){
	$subject = array();
	foreach($arr as $v=>$val){$i++;
		$list_title . $i = "<a href='" . $folder . "?" . $string . "&" . $field . "=" . $v . " ASC' style='color:" . $color . "'>" . $val . "</a>";

		if(strstr($value,$v)){
			if(strstr($value,"ASC")) $list_title . $i = "<a href='" . $folder . "?" . $string . "&" . $field . "=" . $v . " DESC' class='active' style='color:" . $color . "'>" . str_replace("↑","<span class='red'>↑</span>",$val) . "</a>";
			else $list_title . $i = "<a href='" . $folder . "?" . $string . "&" . $field . "=" . $v . " ASC' class='active' style='color:" . $color . "'>" . str_replace("↓","<span class='red'>↓</span>",$val) . "</a>";
		}
		$subject[] = $list_title . $i;
	}
	return $subject;
}

## post로 받은값들 전달
function SubmitPost($url,$post){
	$html = "<form id='SubmitPost' method='post' action='" . $url . "'>";
	foreach($post as $v=>$val){
		if(is_array($val)){
			foreach($val as $t=>$tval){
				$html .= "<input type='hidden' name='" . $v . "[]' value='" . $tval . "'>";
			}
		}else{
			$html .= "<input type='hidden' name='" . $v . "' value='" . $val . "'>";
		}
	}
	$html .=  "</form>";
	$html .= "<script>";
	$html .= "document.getElementById('SubmitPost').submit();";
	$html .= "</script>";

	print $html;
}

##
function list_tbl($table,$code,$len,$cat='',$push='',$category='',$orderby=''){
	GLOBAL $conn; $loop = array();
	@include $_SERVER['DOCUMENT_ROOT'] . "/bbs/config." . $code . ".php";

	if($cat){
		$WHERE .= " AND cat='" . $cat . "' AND  UNIX_TIMESTAMP(stime)>=" . time();
		$ORDER = " ORDER BY stime ASC";
	}else{
		if($orderby) $ORDER = " ORDER BY " . $orderby . " DESC";
		else $ORDER = " ORDER BY signdate DESC";
	}
	if($push) $WHERE .= " AND push='Y' ";
	if($category) $WHERE .= " AND category='" . $category . "' ";

	$c = explode("|",$code);
	foreach($c as $v=>$val){
		$f[] = " code='" . $val . "' ";
	}
	$code_field = "(" . @implode($f," OR ") . ")";
	$query = "SELECT * FROM " . $table . " WHERE " . $code_field . " AND push='Y' AND del='N' " . $WHERE . $ORDER . " LIMIT " . $len;

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){$ii++;
		$d['day_time'] = $_new_day_time ? $_new_day_time : time()-(60*60*24*3);
		$d['thumbdir'] = $_SERVER['DOCUMENT_ROOT']."/upload/" . $code . "/thumbnails/";
		$d['thumburl'] = "http://${_SERVER[HTTP_HOST]}/upload/" . $code . "/thumbnails";
		if($d['etc1']) {
			$sname = mysql_fetch_assoc(mysql_query("SELECT sname FROM society_list WHERE society_name='{$d['etc1']}'"));
			$d['subject'] = "[".$sname["sname"]."] ".$d['subject'];
		}
		foreach($d as $v=>$val){
			$loop[$ii][$v] = $val;
		}
	}
	return $loop;
}

function list_tbl_rand($table,$code,$len){
	GLOBAL $conn; $loop = array();

	if($cat){
		$WHERE .= " AND cat='" . $cat . "' AND  UNIX_TIMESTAMP(stime)>=" . time();
		$ORDER = " ORDER BY stime ASC";
	}else{
		if($orderby) $ORDER = " ORDER BY " . $orderby . " DESC";
		else $ORDER = " ORDER BY RAND() ";
	}
	if($push) $WHERE .= " AND push='Y' ";
	if($category) $WHERE .= " AND category='" . $category . "' ";

	$c = explode("|",$code);
	foreach($c as $v=>$val){
		$f[] = " code='" . $val . "' ";
	}
	$code_field = "(" . @implode($f," OR ") . ")";
	$query = "SELECT * FROM " . $table . " WHERE " . $code_field . " AND del='N' " . $WHERE . $ORDER . " LIMIT " . $len;

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){$ii++;
		$d['day_time'] = $_new_day_time ? $_new_day_time : time()-(60*60*24*3);
		$d['thumbdir'] = $_SERVER['DOCUMENT_ROOT']."/upload/" . $code . "/thumbnails/";
		$d['thumburl'] = "http://${_SERVER[HTTP_HOST]}/upload/" . $code . "/thumbnails";
		foreach($d as $v=>$val){
			$loop[$ii][$v] = $val;
		}
	}
	return $loop;
}

##
function photo_tbl($table,$code,$bbs_tbl){
	GLOBAL $conn;

	$query = "SELECT * FROM " . $table . " a, " . $bbs_tbl . " b WHERE a.bsid=b.sid AND a.code='" . $code . "' AND push='Y' GROUP BY a.bsid ORDER BY a.sid LIMIT 1";

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	$result->fetchInto(&$d, DB_FETCHMODE_ASSOC);
	$d['subject'] = $conn->getOne("SELECT subject FROM " . $bbs_tbl . " WHERE sid='" . $d['bsid'] . "'");


	return $d;
}

function GetSubject($code,$number){
	GLOBAL $conn;

	switch($code){
		case "gallery":
			$table = "board_tbl";
		break;
		case "schedule":
			$table = "schedule";
		break;
		case "society":
			$table = "schedule";
		break;
		default:
			$table = "bbs_tbl";
		break;
	}

	$subject = $conn->getOne("SELECT subject FROM " . $table . " WHERE code='" . $code . "' AND sid='" . $number . "'");

	if($subject) return $subject;
}

function getRand($couponLength, $couponString=""){

    $defaultString = "ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789";
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

##패스워드 형식
function encryp($val){
	GLOBAL $conn;
	$new_val = hash("sha512",MD5($conn->getOne("SELECT password('" . $val . "')")));

	return $new_val;
}
function encryp2($val){
	GLOBAL $conn;
	$new_val = hash("sha512",MD5($val));

	return $new_val;
}

##
function is_Direct(){
	GLOBAL $_SERVER;

	if(!$_SERVER['HTTP_REFERER']){
		PutLocation("/");
	}
}

function to_enc($val,$code){
	GLOBAL $conn;

	$value = $conn->getOne("SELECT HEX(AES_ENCRYPT('" . $val . "','" . MD5($code) . "'))");
	return $value;
}

function to_dec($val,$code){
	GLOBAL $conn;

	$value = $conn->getOne("SELECT AES_DECRYPT(UNHEX('" . $val . "'), '" . MD5($code) . "')");
	return $value;
}

function print_htmltag_yesno(){

}

function new_btn($target,$url){
	GLOBAL $conn;
	$u = explode("=",$url);
	$u = explode("&",$u[1]);

	if($u[0]){
		include $_SERVER['DOCUMENT_ROOT'] . "/bbs/config." . $u[0] . ".php";
		$cnt = $conn->getOne("SELECT COUNT(sid) FROM " . $target . "_tbl WHERE 1 AND code='" . $u[0] . "' AND signdate>'" . $_new_day_time . "' AND del='N'");
		if($cnt>0) echo " <img src='/bbs/skin/notice/icon/new.gif' border='0' alt=''>";
	}
}

function make_timeArr($stime,$etime,$type){
	$arr = array();
	switch($type){
		case "1":
			for($i=$stime;$i<=$etime;$i++){
				$text_time = $i<=12 ? "AM " . $i : "PM " . ($i-12);
				$arr[$i] = $text_time;
			}
		break;

		case "2":
			for($i=$stime;$i<=$etime;$i++){
				$arr[] = sprintf("%02d",$i);
			}
		break;

		case "3":
			for($i=$stime;$i<=$etime;$i++){
				$arr[] = $i;
			}
		break;
	}

	return $arr;
}

function checkLimit($dt1,$dt2){
	$t1 = mktime(23,59,59,$dt1[1],$dt1[2],$dt1[0]);
	$t2 = mktime(23,59,59,$dt2[1],$dt2[2],$dt2[0]);
	$t = time();

	if($t1>=$t) return 1;
	else if($t1<$t && $t2>=$t) return 2;
	else if($t>$t2) return 0;
}

function deadline_check($arr){

	$deadline = mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]);
	if($deadline>=time()){
		return 0;
	}else{
		return 1;
	}
}

function modline_check($arr){

	$deadline = mktime(0,0,0,$arr[1],$arr[2]+1,$arr[0]);
	if($deadline>=time()){
		return 0;
	}else{
		return 1;
	}
}

function file_up($org_file, $file_name, $file_real_name, $save_path){
	$flag = 0;	// 오류검출 플래그
  # 이동
  if(!move_uploaded_file($org_file, $save_path . $file_real_name)){
    putMessageBack("Error~~");
  }else{
    $flag = 1;
  }

  return $flag;		// 업로드된 파일명 리턴
}

function bbs_title($code,$bbs_tbl='',$number=''){
	GLOBAL $conn,$_cfg;

	if($number){
		$title = $conn->getOne("SELECT subject FROM ".$bbs_tbl." WHERE sid='".$number."'");
	}else{
		$url = "/bbs/index.html?code=" . $code;
		$rev_code = $_cfg['code'][$code];
		$ref_number = $_cfg['menu']['ref_url'][$rev_code][$url];

		$title = $_cfg['menu']['navi'][$rev_code][$ref_number];
	}
	return $title;
}

function bbs_content($code,$bbs_tbl='',$number=''){
	GLOBAL $conn,$_cfg;

	if($number){
		$content = $conn->getOne("SELECT content FROM ".$bbs_tbl." WHERE sid='".$number."'");
		$content = strip_tags($content);
	}else{
		$url = "/bbs/index.html?code=" . $code;
		$rev_code = $_cfg['code'][$code];
		$ref_number = $_cfg['menu']['ref_url'][$rev_code][$url];

		$content = $_cfg['menu']['navi'][$rev_code][$ref_number];
	}
	return str_cut($content,50);
}

function display($a) {
	$c = Count($a);
	if($c>0){
		for ($i = 0, Reset($a); $i < $c; $i++, Next($a)) {
		$k = Key($a); $v = $a[$k];
		if($i==0){
			$go_con = "?";
		}else{
			$go_con = "&";
		}
		$parm .= "$go_con$k=".htmlspecialchars($v);
		}
	}else{
		$parm = "";
	}
	return $parm;
}


function logchk(){
	GLOBAL $menu_urlArr;
	$urlArr = explode("/",$_SERVER['PHP_SELF']);
	if(in_array("admin",$urlArr)){
		$hostName3 = "localhost";
		$userName3 = "new_koms";
		$userPassword3 = "koms1@#4";
		$dbName3 = "new_koms";

		if(!class_exists("DB")) {
		  include_once "DB.php";
		}

		##### 데이터베이스에 연결한다.
		$dsn3 = "mysql://$userName3:$userPassword3@$hostName3/$dbName3";
		$conn3 = DB::connect($dsn3);
		if(DB::isError($conn3)) {
		   die ($conn3->getMessage());
		}
		$conn3->query("set names utf8 ");

		$post_value = display($_POST);
		$pv = explode("&x=",$post_value);

		$log_url = str_replace("'","",$_SERVER['REQUEST_URI'].$pv[0]);
		$log_id = $_COOKIE['member_id'];
		$log_ip = $_SERVER['REMOTE_ADDR'];
		$log_date = date("Y-m-d");
		$log_date2 = date("H:i:s");
		$log_query = "select count(sid) from koms_logtable where id='$log_id' and ip='$log_ip' and url='$log_url' and logdate='$log_date'";
		$log_cnt = $conn3->getOne($log_query);

		if($log_cnt==0){
			$log_query2 = "insert into koms_logtable (id,level,ip,url,logdate,logdate2) values ('$log_id','" . $_COOKIE['member_level'] . "','$log_ip','$log_url','$log_date','$log_date2')";
			$log_result = $conn3->query($log_query2);
			if(DB::isError($log_result)) {
			   die($log_result->getMessage());
			}
		}

		$conn3->disconnect();
	}
}

function convetEncoding(&$d, $charset="UTF-8") {

    $d['mail_body']	=	$this->uni2html($d);

  }

function uni2html($str) {
    $result = "";
    $len = strLen($str);
    for($i = 0; $i < $len; $i++) {
      $temp = $c = subStr($str, $i, 1);
      $h = ord($c{0});
      if (strlen($c) > 1) {
        if ($h <= 0xDF)
          $temp = ($h & 0x1F) << 6 | (ord($c{1}) & 0x3F);
        else if ($h <= 0xEF)
          $temp = ($h & 0x0F) << 12 | (ord($c{1}) & 0x3F) << 6 | (ord($c{2}) & 0x3F);
        else if ($h <= 0xF4)
          $temp = ($h & 0x0F) << 18 | (ord($c{1}) & 0x3F) << 12 | (ord($c{2}) & 0x3F) << 6 | (ord($c{3}) & 0x3F);

        $temp = "&#$temp;";
      }
      $result .= $temp;
    }
    return $result;
  }

//두날짜사이에 날짜를 배열로 반환
function createDateRangeArray($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function createbarcodetime($info){
	global $conn;
	
	$oquery= "select * from conference_barcode_option where cid='".$info['cid']."' and event_date='".$info['event_date']."'";
	$oresult= $conn->query($oquery);
	$oresult->fetchInto(&$o,DB_FETCHMODE_ASSOC);
	$oresult->free();
	
	$view_start_time = $info['check_in'];
	$view_end_time = $info['check_out'];
	$baseStartTime = strtotime($o['barcode_sdate']);
	$baseEndTime = strtotime($o['barcode_edate']);
	
	$break_stime = explode("||",$o['break_stime']);
	$break_etime = explode("||",$o['break_etime']);
	
	$break_array = array();		
	
	foreach( $break_stime as $key => $val ){
		array_push($break_array, array( strtotime($val),strtotime($break_etime[$key])));
	}
	
	// 출결 시작시간보다 먼저찍었다면 시작시간으로 출력
	if( $info['check_in'] < $baseStartTime ) {
		$info['check_in'] = $baseStartTime;
	} 
	// 출결 마감시간 넘어서 찍어도 최대 마감시간으로 출력
	if ( $info['check_out'] > $baseEndTime )  {
		$info['check_out'] = $baseEndTime;
	}
	
	$someTime = $info['check_out']-$info['check_in'];
	
	foreach($break_array as $key=>$val){
		if($info['check_in'] < $val[0]){
			if($info['check_out'] > $val[1]) {
				$someTime += $val[0]-$val[1];
			} else if($info['check_out'] < $val[0]) {

			} else {
				$someTime += $val[0]-$info['check_out'];
			}
		}else if($info['check_in'] < $val[1]) {
			if($info['check_out'] > $val[1]) {
				$someTime += $info['check_in']-$val[1];
			} else if($info['check_out'] < $val[0]) {

			} else {
				$someTime += $info['check_in']-$info['check_out'];
			}
		}
	}
	
	$aReturnValue['H'] = sprintf("%02d", ($someTime/60/60)%24); //시간
	$aReturnValue['i'] = sprintf("%02d", ($someTime/60)%60); //분
	$aReturnValue['s'] = sprintf("%02d", ($someTime%60)); //초
	
	$info_ment = "";
	if($aReturnValue['H']>0){
		$info_ment .= $aReturnValue['H']."시간 "; 
	}
	if($aReturnValue['i']>0){
		$info_ment .= $aReturnValue['i']."분 "; 
	}
	
	echo $info_ment;
	
}

function createbarcodetime2($info){
	global $conn;
	
	$oquery= "select * from conference_barcode_option where cid='".$info['cid']."' and event_date='".$info['event_date']."'";
	$oresult= $conn->query($oquery);
	$oresult->fetchInto(&$o,DB_FETCHMODE_ASSOC);
	$oresult->free();
	
	$view_start_time = $info['check_in'];
	$view_end_time = $info['check_out'];
	$baseStartTime = strtotime($o['barcode_sdate']);
	$baseEndTime = strtotime($o['barcode_edate']);
	
	$break_stime = explode("||",$o['break_stime']);
	$break_etime = explode("||",$o['break_etime']);
	
	$break_array = array();		
	
	foreach( $break_stime as $key => $val ){
		array_push($break_array, array( strtotime($val),strtotime($break_etime[$key])));
	}
	
	// 출결 시작시간보다 먼저찍었다면 시작시간으로 출력
	if( $info['check_in'] < $baseStartTime ) {
		$info['check_in'] = $baseStartTime;
	} 
	// 출결 마감시간 넘어서 찍어도 최대 마감시간으로 출력
	if ( $info['check_out'] > $baseEndTime )  {
		$info['check_out'] = $baseEndTime;
	}
	
	$someTime = $info['check_out']-$info['check_in'];
	
	foreach($break_array as $key=>$val){
		if($info['check_in'] < $val[0]){
			if($info['check_out'] > $val[1]) {
				$someTime += $val[0]-$val[1];
			} else if($info['check_out'] < $val[0]) {

			} else {
				$someTime += $val[0]-$info['check_out'];
			}
		}else if($info['check_in'] < $val[1]) {
			if($info['check_out'] > $val[1]) {
				$someTime += $info['check_in']-$val[1];
			} else if($info['check_out'] < $val[0]) {

			} else {
				$someTime += $info['check_in']-$info['check_out'];
			}
		}
	}
	
	return ($someTime/60/60)%24;
}

?>
