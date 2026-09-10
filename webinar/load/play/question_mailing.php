<?
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";
	
	$d['session_question'] = $session_question;
	$d['name_kr'] = $_COOKIE['wmember_name'];
	$d['email'] = $_COOKIE['wmember_email'];
	$d['domain'] = $_CONFIG['URL'];
	

	if($ex_fsid[0]){

		include $_SERVER['DOCUMENT_ROOT']."/templates/template.question.php";
		$html = template($d);
	
		$fquery = "select * from faculty_tbl where sid='".$ex_fsid[0]."'";
		$fresult = $conn->query($fquery);
		$fresult->fetchInto(&$f,DB_FETCHMODE_ASSOC);
		$fresult->free();
		
		if(!$f['email']){
			$to_email = "imkasid@innon.co.kr";
			$to_name = "Innon";
		}else{
			$to_email = $f['faculty_email'];
			$to_name = $f['faculty_name'];
		}

		
		$_ecare_no = "66";
		
		$M2mail = new M2mail('wiseU');
		
		$d['from_name'] = $_COOKIE['wmember_name'];
		$d['from_email'] = $_COOKIE['wmember_email'];
		$d['mail_body'] = $html;
		$d['subject'] = '[IMKASID 2022] A question has arrived.';
		$d['ecare_no'] = $_ecare_no;
		$d['to_email'] = $to_email;
		$d['to_name'] = $to_name;
		$M2mail->send($d, 'EUC-KR');
	}
?>