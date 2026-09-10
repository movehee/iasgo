<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";
	
	
	$cquery = "select * from comment_tbl where sid='$mysid'";
	$cresult = $conn->query($cquery);
	if(DB::isError($cresult)) {
	  die($cresult->getMessage());
	}
	$cresult->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$cresult->free();

	$d['name_kr'] = $_COOKIE['wmember_name'];
	$d['email'] = $_COOKIE['wmember_email'];
	$d['domain'] = $_CONFIG['URL'];

	include $_SERVER['DOCUMENT_ROOT']."/templates/template.poster.php";
	$html = template($d);
	
	$_ecare_no = "66";
	
	$M2mail = new M2mail('wiseU');
	
	$d['from_name'] = $_COOKIE['wmember_name'];
	$d['from_email'] = $_COOKIE['wmember_email'];
	$d['mail_body'] = $html;
	$d['subject'] = '[KCR 2023] The poster has been commented on.';
	$d['ecare_no'] = $_ecare_no;
	//$d['to_email'] = $email;
	$d['to_email'] = $poster_email;
	//$d['to_email'] = "rut12@m2community.co.kr";
	$d['to_name'] = $poster_email;
	$M2mail->send($d, 'EUC-KR');

?>