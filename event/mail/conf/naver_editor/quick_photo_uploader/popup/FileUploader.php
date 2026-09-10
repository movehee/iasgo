<?php
//기본 리다이렉트
echo $_REQUEST["htImageInfo"];

$url = $_REQUEST["callback"] .'?callback_func='. $_REQUEST["callback_func"];

$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);
if (bSuccessUpload) { //성공 시 파일 사이즈와 URL 전송
	
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];
	$new_path = "../../../../upload/naver_editor/".urlencode($_FILES['Filedata']['name']);
	
	if(file_exists($new_path)){
		$filename = $_FILES['Filedata']['name'];
		
		$FileExt = substr(strrchr($filename, "."), 1); // 확장자 추출
		$FileName = substr($filename, 0, strlen($filename) - strlen($FileExt) - 1); // 화일명 추출
		
		$name = "$FileName.$FileExt";
		
		$new_path = "../../../../upload/naver_editor/".urlencode($name);
		$FileCnt = 0;
		
		while(file_exists($new_path)) // 화일명이 중복되지 않을때 까지 반복
		{
			$FileCnt++;
			$name = $FileName."_".$FileCnt.".".$FileExt; // 화일명뒤에 (_1 ~ n)의 값을 붙여서....
			$new_path = "../../../../upload/naver_editor/".urlencode($name);
		}
		
	}	
	
	
	@move_uploaded_file($tmp_name, $new_path);
//	make_thumbnail($new_path, 780, 2000, "");
//	thumnail($new_path, urlencode($name), "../../../../upload/naver_editor/", "780", "780");

/*
	$original_path = $new_path;
	$ori_path = imagecreatefromgif($original_path);
	$new_img = imagecreatetruecolor("780","");
*/
	
	
	$url .= "&bNewLine=true";
	$url .= "&sFileName=".urlencode(urlencode($name));
	//$url .= "&size=". $_FILES['Filedata']['size'];
	//아래 URL을 변경하시면 됩니다.

	$url .= "&sFileURL=http://".$_SERVER['HTTP_HOST']."/upload/naver_editor/".urlencode(urlencode($name));
} else { //실패시 errstr=error 전송
	$url .= '&errstr=error';
}
header('Location: '. $url);
?>