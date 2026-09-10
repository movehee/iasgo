<?php
function thumbnail($file, $save_filename,$width='') { 

	$widths=$width?$width:150;

	$img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다 
	
	if($img_info[2]=="1") $src_img = imagecreatefromgif($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="2") $src_img = imagecreatefromjpeg($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="3") $src_img = imagecreatefrompng($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="15") $src_img = imagecreatefromwbmp($file); //JPG파일로부터 이미지를 읽어옵니다 
	else return false;

	$img_width = $img_info[0]; 
	$img_height = $img_info[1]; 
	
	if($img_width>$widths){
		$dst_width = $widths; 
		$dst_height = $img_height * ($widths/$img_width);
	}else{
		$dst_width = $img_width; 
		$dst_height = $img_height;
	}
	$dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다 
	
	
	$white = imagecolorallocate($dst_img, 255, 255, 255);
	imagefill($dst_img, 0, 0, $white);
	 

	ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다 

	ImageInterlace($dst_img); 
	ImageJPEG($dst_img,  $save_filename,100); //실제로 이미지파일을 생성합니다 
	ImageDestroy($dst_img); 
	ImageDestroy($src_img); //메모리상의 이미지를 삭제합니다. 

}


//모바일에서 보기 위해 썸내일 조정.
function mobile_thumbnail($file, $save_filename,$width='') { 

	$widths=$width?$width:500;

	$img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다 
	
	if($img_info[2]=="1") $src_img = imagecreatefromgif($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="2") $src_img = imagecreatefromjpeg($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="3") $src_img = imagecreatefrompng($file); //JPG파일로부터 이미지를 읽어옵니다 
	else if($img_info[2]=="15") $src_img = imagecreatefromwbmp($file); //JPG파일로부터 이미지를 읽어옵니다 
	else return false;

	$img_width = $img_info[0]; 
	$img_height = $img_info[1]; 
	
	if($img_width>$widths){
		$dst_width = $widths; 
		$dst_height = $img_height * ($widths/$img_width);
	}else{
		$dst_width = $img_width; 
		$dst_height = $img_height;
	}
	$dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다 
	$dst_img = imagecolorallocate($dst_img,255,255,255);
	ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다 

	ImageInterlace($dst_img); 
	ImageJPEG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다 
	ImageDestroy($dst_img); 
	ImageDestroy($src_img); //메모리상의 이미지를 삭제합니다. 

}
 
?> 