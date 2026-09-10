<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

$chking = $conn->getOne("select count(*) from booth_brochures_down where booth_sid='$booth_sid' and bsid='$bsid' and id='".$_COOKIE['wmember_id']."'");
if($chking==0){
	$query = "insert into booth_brochures_down set booth_sid='$booth_sid', bsid='$bsid', id='".$_COOKIE['wmember_id']."', signdate='".time()."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
}
$conn->disconnect();
header('Content-Type: text/html; charset=utf-8');
$path_text = str_replace(" ","+",$path);
$filename_text = str_replace(" ","+",$filename);

if(strstr($_SERVER['HTTP_USER_AGENT'],"MSIE") || eregi('Trident', $_SERVER['HTTP_USER_AGENT'])){
	$path = base64_decode(Trim($path_text));
	$filename = iconv("utf-8","euc-kr",base64_decode($filename_text));
	$filesize = filesize($path);
}else{
	$path = base64_decode(Trim($path_text));
	$filename = base64_decode($filename_text);
	$filesize = filesize($path);
}

/*
if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) {

$fp = @fopen($path,"rb");
Header("Content-type: application/download\r\n");
Header("Content-length: $filesize\r\n");
Header("Content-disposition-type: attachment\r\n");
Header("Content-disposition: filename=$filename");
$result = fpassthru($fp);
exit;
} else {
*/

Header("Content-Type: application/octet-stream");
Header("Content-Length: ".filesize($path));
Header("Content-disposition: attachment; filename=$filename");
ReadFile($path);

//}

?>
