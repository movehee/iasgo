<?php
 	$sFileInfo = '';
	$headers = array(); 
	foreach ($_SERVER as $k => $v){   
  	
		if(substr($k, 0, 9) == "HTTP_FILE"){ 
			$k = substr(strtolower($k), 5); 
			$headers[$k] = $v; 
		} 
	}
	
	$file = new stdClass; 
	$file->name = $headers['file_name'];	
	$file->size = $headers['file_size'];
	$file->content = file_get_contents("php://input"); 
	
	$newPath = '../../../../upload/naver_editor/'.urlencode($file->name);

	if(file_exists($newPath)){
		$filename = $file->name;
		
		$FileExt = substr(strrchr($filename, "."), 1); // 확장자 추출
		$FileName = substr($filename, 0, strlen($filename) - strlen($FileExt) - 1); // 화일명 추출
		
		$file->name = "$FileName.$FileExt";
		
		$newPath = "../../../../upload/naver_editor/".urlencode($file->name);
		$FileCnt = 0;
		
		while(file_exists($newPath)) // 화일명이 중복되지 않을때 까지 반복
		{
			$FileCnt++;
			$file->name = $FileName."_".$FileCnt.".".$FileExt; // 화일명뒤에 (_1 ~ n)의 값을 붙여서....
			$newPath = "../../../../upload/naver_editor/".urlencode($file->name);
		}
		
	}		
	
	
	if(file_put_contents($newPath, $file->content)) {
		$sFileInfo .= "&bNewLine=true";
		$sFileInfo .= "&sFileName=".$file->name;
		$sFileInfo .= "&sFileURL=http://".$_SERVER['HTTP_HOST']."/upload/naver_editor/".urlencode(urlencode($file->name));
	}
	echo $sFileInfo;
 ?>
