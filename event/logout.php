<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	foreach($_COOKIE as $v=>$val){
		SetCookie($v,'',0,'/',$_CONFIG['domain']);
	}
	PutLocation("/");
?>