<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$enc_passwd = $passwd;

	$query = "select * from registration_tbl where id='$id' and status='Y' and del='N'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}

	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	if(!$d['sid']){
		PutMessageBack("일치하는 정보가 없습니다.");
		exit;
	}else{
		if($_SERVER['REMOTE_ADDR']!='218.235.94.2220' && $_SERVER['REMOTE_ADDR']!='218.235.94.225' && $_SERVER['REMOTE_ADDR']!='218.235.94.209' ) {
			if($license_number!=$d['passwd']){
				PutMessageBack("면허번호가 일치하지 않습니다.");
				exit;
			}
		}
		
		setcookie('wmember_sid', $d['sid'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_name', $d['name_kr'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_license_number', $d['license_number'], 0, '/',$_CONFIG['domain']);
		setcookie('wmember_level', $d['member_level'], 0, '/',$_CONFIG['domain']);
	
		$conn->disconnect();
		
		PutLocation("/");
	}
?>