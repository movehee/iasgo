<?  @header("Content-Type: text/html; charset=UTF-8");
	session_start();
	if(!$_SESSION['cod']){
		$code = rand(11111,99999); $_SESSION['cod'] = $code; echo $code;
	}


	$user_file = $_SERVER['DOCUMENT_ROOT']."../auth/".$_COOKIE['wmember_sid']."-kcr-"."online_secret".".txt";

	if(is_file($user_file)){
		$fp = fopen($user_file,"r") or die("파일을 열 수 없습니다！");
		$chk_arr = array();
		$chk_arr = array();
		while( !feof($fp) ) {
			//echo fgets($fp);
			$chk_arr = fgets($fp);
		}
		$chk = explode("|:|",$chk_arr);
		
		if($chk[2]!=$_SESSION['cod']  && $chk[0]==$_COOKIE['wmember_sid'] && $chk[3]==$_COOKIE['wmember_name']){
			echo "N";
			exit;
		}else{
			echo "Y";
			exit;
		}

	}else{
		echo "N";
		exit;
	}
?>