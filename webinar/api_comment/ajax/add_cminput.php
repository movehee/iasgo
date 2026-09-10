<?php 
##이미 입력된 정보에 추가 저장
header("Content-Type: text/html; charset=UTF-8");

$return = true;
$msg = '';
$html = '';

if(is_file($_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php")) include $_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php";
else{
	$return = false;
	$msg = "COMMENT 설정파일이 없습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}
include $DOCUMENT_ROOT . "api_comment/YY.php";

ob_start(); //출력 버퍼링 활성
include $_SERVER['DOCUMENT_ROOT']."api_comment/form/coment.php";
$html .= ob_get_contents(); //파일내용 변수에 저장
ob_end_clean(); //출력 버퍼 지우고 출력 버퍼링 종료

echo json_encode(array('_return' => $return, 'msg' => $msg, 'html'=>$html)); 
