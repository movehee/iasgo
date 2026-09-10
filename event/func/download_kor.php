<?
header('Content-Type: text/html; charset=utf-8');

$path_text = str_replace(" ","+",$path);
$filename_text = str_replace(" ","+",$filename);






$path = iconv("UTF-8","EUC-KR",base64_decode(Trim($path_text)));
if(!file_exists($path)){
	echo "<script>alert('파일이 존재하지 않습니다.');history.back();</script>";
	exit;
}

$filename = base64_decode($filename_text);
$filesize = filesize($path);

//file_exists(
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
Header("Content-disposition: attachment; filename=".iconv("UTF-8","EUC-KR",$filename));
ReadFile($path);

//}

?>
