<?  @header("Content-Type: text/html; charset=UTF-8");
	session_start();
	if(!$_SESSION['cod']){
		$code = rand(11111,99999); $_SESSION['cod'] = $code;
	}
	
	$user_file = $_SERVER['DOCUMENT_ROOT']."../auth/".$_COOKIE['wmember_sid']."-kcr-"."online_secret".".txt";
	
	if(is_file($user_file)){
		$fp = fopen($user_file,"r") or die("파일을 열 수 없습니다！");
		$chk_arr = array();
		$chk = array();
		while( !feof($fp) ) {
			$chk_arr = fgets($fp);
		}
		$chk = explode("|:|",$chk_arr);
		if($chk[2]!=$_SESSION['cod']  && $chk[0]==$_COOKIE['wmember_sid'] && $chk[3]==$_COOKIE['wmember_name'] && $chk[2]){
			$myfile = fopen($user_file, "w") or die("Unable to open file!");
			$txt = $_COOKIE['wmember_sid']."|:|".$_SERVER['REMOTE_ADDR']."|:|".$_SESSION['cod']."|:|".$_COOKIE['wmember_name'];
			fwrite($myfile, $txt);
			fclose($myfile);
		}		

	}else{
		$myfile = fopen($user_file, "w") or die("Unable to open file!");
		$txt = $_COOKIE['wmember_sid']."|:|".$_SERVER['REMOTE_ADDR']."|:|".$_SESSION['cod']."|:|".$_COOKIE['wmember_name'];
		fwrite($myfile, $txt);
		fclose($myfile);
	}
?>
