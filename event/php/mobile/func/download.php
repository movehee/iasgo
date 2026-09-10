<?
header('Content-Type: text/html; charset=utf-8');

$path_text = str_replace(" ","+",$path);
$filename_text = str_replace(" ","+",$filename);

//if(strstr($_SERVER['HTTP_USER_AGENT'],"MSIE")){
	$path = iconv("utf-8","euc-kr",base64_decode(Trim($path_text)));
	$filename = iconv("utf-8","euc-kr",base64_decode($filename_text));
	$filesize = filesize($path);
/*}else{
	$path = base64_decode(Trim($path_text));
	$filename = base64_decode($filename_text);
	$filesize = filesize($path);
}*/



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
