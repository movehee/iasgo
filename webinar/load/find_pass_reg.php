<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";
	
	
	$cquery = "select * from registration_tbl where email='$email'";
	$cresult = $conn->query($cquery);
	if(DB::isError($cresult)) {
	  die($cresult->getMessage());
	}
	$cresult->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$cresult->free();

	if(!$d['sid']){
		echo json_encode(array('push'=>"N"));
		exit;
	}
	
	include $_SERVER['DOCUMENT_ROOT']."/templates/template.find_passwd.php";	
	$mail_title = "[KCR 2023] Password information mail";

	$html = template($d);
	
	$_ecare_no = 102;
	
	$M2mail = new M2mail('wiseU');

	$d['from_name'] = "KCR 2023";
	$d['from_email'] = "kcr@kcr4u.org";
	$d['mail_body'] = $html;
	$d['subject'] = $mail_title;
	$d['ecare_no'] = $_ecare_no;
	
	$d['to_email'] = $d['email'];
	//$d['to_email'] = "rut12@m2community.co.kr";
	$d['to_name'] = $d['name_en'] ? $d['name_en'] : $d['name_kr'];
	

	$M2mail->send($d, 'EUC-KR');
	
	
	echo json_encode(array('push'=>"Y"));
	$conn->disconnect();
	exit;
?>