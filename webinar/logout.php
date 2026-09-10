<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	/*$query = "update registration_tbl set logout_day".$day."='".time()."',room='', session_code='' where sid='".$_COOKIE['wmember_sid']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}*/

	foreach($_COOKIE as $v=>$val){
		SetCookie($v,'',0,'/',$_CONFIG['domain']);
	}

	if($_COOKIE['offline']=='Y'){
		PutLocation("/off/");
	}else{
		PutLocation("/index.php");
	}
	
?>