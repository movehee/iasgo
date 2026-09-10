<?
	header("Content-Type: text/html; charset=UTF-8");
	@error_reporting(E_ALL ^ E_NOTICE);
	@extract($HTTP_GET_VARS);
	@extract($HTTP_POST_VARS);
	@extract($HTTP_SERVER_VARS);
	@extract($HTTP_ENV_VARS);
	$HTTP_SESSION_VARS = $_SESSION;
	@extract($HTTP_SESSION_VARS);
	@extract($_FILES);

	if(is_file($_SERVER['DOCUMENT_ROOT'] . "func/include.function.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "func/include.function.php";
	if(is_file($_SERVER['DOCUMENT_ROOT'] . "func/include.connect.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "func/include.connect.php";
	if(is_file($_SERVER['DOCUMENT_ROOT'] . "func/config_time_ing.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "func/config_time_ing.php";
	if(is_file($_SERVER['DOCUMENT_ROOT'] . "func/config.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "func/config.php";
	
	
	if(is_file("config.php")) include_once "config.php";

	//Check Mobile
	$mAgent = array("iPhone","iPod","Android","Blackberry", 
		"Opera Mini", "Windows ce", "Nokia", "sony", "Edge" );
	$chkMobile = false;
	$edge_check = false;
	for($i=0; $i<sizeof($mAgent); $i++){
		if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
			$chkMobile = true;
			if( $mAgent[$i] == "Edge" ){ $edge_check = true; }
			break;
		}
	}
	

	if($chkMobile && $mode != "file_down"){
		if( $edge_check ){
			PutMessageBack("엣지 브라우저로는 접속 할 수 없습니다. 익스플로러나 크롬브라우저로 접속 해 주세요.");
		}else{
//			RefreshURL("https://eposter.aofog2024.org/poster");
			RefreshURL("https://eposter.iasgo.ezv.kr/did/list.php");
		}
	}
	
?>