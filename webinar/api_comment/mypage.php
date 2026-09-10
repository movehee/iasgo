<?php
##이미 입력된 정보에 추가 저장
if(!headers_sent()) header("Content-Type: text/html; charset=UTF-8");
if(is_file($_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php")) include $_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php";
else{
	echo 'COMMENT 설정파일이 없습니다.';
	exit;
}

if(is_file($_SERVER['DOCUMENT_ROOT'].'/api_comment/css/style.css')){
	##css필요 없을경우 해당css 삭제해주세요.
	echo '<link type="text/css" rel="stylesheet" href="/api_comment/css/style.css">';
}

if(is_file($_SERVER['DOCUMENT_ROOT'].'/api_comment/script/comment.js')){
	##필수로 연결 필요합니다.
	echo '<script type="text/javascript" src="/api_comment/script/jquery-ui.min.js"></script>';
	echo '<script type="text/javascript" src="/api_comment/script/autolink.js"></script>';
	echo '<script type="text/javascript" src="/api_comment/script/comment.js"></script>';
}

##필요한 부분은 list(이외 페이지 필여하지 않아보임)
##화면에 보이는 부분이 수정이 필요할경우 list페이지에서만 수정

include $_SERVER['DOCUMENT_ROOT'] . "api_comment/".(!empty($_COMMENTCNF['page_mode'])?$_COMMENTCNF['page_mode']:'list_mypage').".php";