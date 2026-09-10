<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$enc_passwd = $passwd;

//	if($passwd=='ssbh'){
//		$chking = $conn->getOne("select sid from registration_tbl where id='$id' and del='N'");
//		if(!$chking){
//			$in_query = "insert into registration_tbl set id='$id',name_kr='ssbh', passwd='$passwd',classification='W', login1='Y', login2='Y', login3='Y'";
//			$in_result = $conn->query($in_query);
//			if(DB::isError($in_result)) {
//				die($in_result->getMessage());
//			}
//		}
//	}
	
	// $query = "select * from registration_tbl where id='$id' and passwd='$passwd' and del='N' and login".$day."='Y'";
	$query = "select * from registration_tbl where id='$id' and passwd='$passwd' and del='N' ";

//	$query = "select * from registration_tbl where id='$id' and passwd='$passwd' and del='N' and login".$day."='Y'"; //and login".$day."='Y' //행사종료 후 모두 들어올 수 있어야 해서 풀어둠.
	$result = $conn->query($query); //and login".$day."='Y'
	
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		//echo $query;
		//exit;
	}


	if(!$d['sid']){
		PutMessageBack("Your ID/PW doesn’t match.\\nPlease contact the secretariat if you don’t know the log-in information.\\nEmail:  kcr@kcr4u.org");
		exit;
	}else{

		if($d['member_level']=='M'){
			include $_SERVER['DOCUMENT_ROOT']."func/config_time_ing.php";
			include $_SERVER['DOCUMENT_ROOT']."func/config.php";
		}
		if($_SERVER['REMOTE_ADDR']!='218.235.94.2220' && $_SERVER['REMOTE_ADDR']!='218.235.94.3225') {}
		
			// if($d['classification']!='M' && $d['classification']!='Y' && $d['classification']!='D'){

				if($d['member_level']!='M'){
					if($d['login'.$day] != 'Y') {
						PutMessageBack("Joint Symposium registrants are only able to access your accounts on the day they complete their registration.");
						exit;
					}else{
						if($d['login1']=='Y' && $d['login2']=='Y' && $d['login3']=='Y' && $d['login4']=='Y'){
						
							if($_Day['enter_date']>time()){
								PutMessageBack("Log-in successful!\\nThe Virtual Platform will be open on September 18, 10:00 A.M. (KST, GMT+9)");
								exit;
							}
								
						}else{
							if($_Day['login_date'][$day]>time()){
								PutMessageBack("Log-in successful!\\nThe Virtual Platform will be open on ".$_Day['login_date'][$day]."");
								exit;
							}
						}
					}
				}
				
				

			 	
			// }
			// if($day!='1'){
			// 	if($d['classification']=='W'){
			// 		PutMessageBack("입장이 제한되었습니다.");
			// 		exit;
			// 	}
			// }


		// if($d['only_pil'] == "Y") {
		// 	if(time() < strtotime("2022-09-24 13:55:00")) {
		// 		PutMessageBack("필수평점세션만 참여 가능합니다. 문의사항은 사무국으로 연락 부탁드립니다\\nkcr@kcr4u.org");
		// 		exit;
		// 	}
		// }


		if($off=='Y'){
			$Tnum = $conn->getOne("select count(*) from exam_tbl where day='".$day."' and category='A' and del='N'"); //총 문제수
			$my_max = $conn->getOne("select count(*) from exam_result_each_tbl where day='".$day."' and usid='".$d['sid']."' and kind='A'"); //내가 푼 마지막 문제번호

			if($Tnum<=$my_max){ //문제 다 푼 상태면...
				//PutMessageBack("Participation in today's case of the day has been completed. Please come back tomorrow");
		 		//exit;
			}

		}

		if(date('Y-m-d') == "2022-09-20") {
			setcookie('start_day_login', "Y", 0, '/',$_CONFIG['domain']);
		}
		
		

		$login_code = $d['sid']."_".GenerateString(10);
		setcookie('wmember_sid', $d['sid'], 0, '/',$_CONFIG['domain']);
		if($d['name_eng']){
			setcookie('wmember_name', $d['name_eng'], 0, '/',$_CONFIG['domain']);
			setcookie('wmember_aff', $d['aff_eng'], 0, '/',$_CONFIG['domain']);
		}else{
			setcookie('wmember_name', $d['name_kr'], 0, '/',$_CONFIG['domain']);
			setcookie('wmember_aff', $d['aff_kor'], 0, '/',$_CONFIG['domain']);
		}

		setcookie('wmember_license_number', $d['license_number'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_level', $d['member_level'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_login_code', $login_code, 0, '/',$_CONFIG['domain']);
		setcookie('wmember_email', $d['email'], 0, '/',$_CONFIG['domain']);

		setcookie('wmember_days', $day, 0, '/',$_CONFIG['domain']);
		setcookie('main_agree', $d['agree'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_reg_kind', $d['reg_kind'], 0, '/',$_CONFIG['domain']);
		if($d['login_day'.$day]){
			setcookie('wmember_logindate', $d['login_day'.$day], 0, '/',$_CONFIG['domain']);
		}else{
			setcookie('wmember_logindate', time(), 0, '/',$_CONFIG['domain']);
		}
		if($d['group_key']){
			setcookie('Gkey', "_".$d['group_key'], 0, '/',$_CONFIG['domain']);
		}else{
			setcookie('Gkey', "", 0, '/',$_CONFIG['domain']);
		}
		setcookie('wmember_class', $d['classification'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_country', $d['country'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_country_name', $d['etc_field1'], 0, '/',$_CONFIG['domain']);


		setcookie('login_yn1', $d['login1'], 0, '/',$_CONFIG['domain']);
		setcookie('login_yn2', $d['login2'], 0, '/',$_CONFIG['domain']);
		setcookie('login_yn3', $d['login3'], 0, '/',$_CONFIG['domain']);
		setcookie('login_yn4', $d['login4'], 0, '/',$_CONFIG['domain']);
		setcookie('login_yn5', $d['login5'], 0, '/',$_CONFIG['domain']);

		setcookie('lecture_yn1', $d['lecture1'], 0, '/',$_CONFIG['domain']);
		setcookie('lecture_yn2', $d['lecture2'], 0, '/',$_CONFIG['domain']);
		setcookie('lecture_yn3', $d['lecture3'], 0, '/',$_CONFIG['domain']);
		setcookie('lecture_yn4', $d['lecture4'], 0, '/',$_CONFIG['domain']);

		if($off=='Y'){
			setcookie('offline', 'Y', 0, '/',$_CONFIG['domain']);
		}
		
		// if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		if(strtotime("2023-09-20 00:00:01")<time()) {
		 	$query = "update registration_tbl set login_day".$day."=if(login_day".$day.">0,login_day".$day.",'".time()."'), last_name='$passwd', last_logindate='".time()."',session_code='$login_code',login_kind='P' where sid='".$d['sid']."'";
		 	$result = $conn->query($query);
		 	if(DB::isError($result)) {
		 		die($result->getMessage());
		 	}
		// }
		}
		
		
		$login_date = date("Y-m-d");
		$loginchk = $conn->getOne("select count(*) from login_view_tbl where usid='".$d['sid']."' and signdate='".$login_date."'");
		if(strtotime("2023-09-20 00:00:01")<time()) {
			if($loginchk==0){
				$query = "insert into login_view_tbl set usid='".$d['sid']."', signdate='".$login_date."'";
				$result = $conn->query($query);
				if(DB::isError($result)) {
					die($result->getMessage());
				}
			}
		}
		
	
		$conn->disconnect();

		if($off=='Y'){
			PutLocation("/case_off/");
		}else{
			if($d['classification']=='U'){
				PutLocation("/poster_off/");
			}else if($d['classification']=='P'){
				PutLocation("/poster/");
			}else{
				PutLocation("/enter/");
				//PutLocation("/load/survey/survey.php?direct=Y");
			}
		}
		/*if($d['classification']=='Y'){
			PutLocation("/mypage/");
		}else if($d['classification']=='U'){
			PutLocation("/e_poster/");
		}else{
			PutLocation("/enter/");
		}*/
		exit;
	}
?>