<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";
	
	$query = "update question_tbl set answer='$answer' where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	include $_SERVER['DOCUMENT_ROOT']."/templates/template.question_answer.php";
	
	
	
	$cquery = "select name,if(t1.email,t1.email,t2.email) as email,answer from question_tbl as t1 left join registration_tbl as t2 on t1.usid=t2.sid where t1.sid='$sid'";
	$cresult = $conn->query($cquery);
	if(DB::isError($cresult)) {
	  die($cresult->getMessage());
	}
	$cresult->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$cresult->free();
	
	$html = template($d);
	
	$_ecare_no = "66";
	
	$M2mail = new M2mail('wiseU');
	if(!$_COOKIE['wmember_name']) $_COOKIE['wmember_name'] = "imkasid@innon.co.kr";
	if(!$_COOKIE['wmember_email']) $_COOKIE['wmember_email'] = "imkasid@innon.co.kr";

	$d['from_name'] = $_COOKIE['wmember_name'];
	$d['from_email'] = $_COOKIE['wmember_email'];
	$d['mail_body'] = $html;
	$d['subject'] = '['.$_CONFIG['Name'].'] This is the answer to your question.';
	$d['ecare_no'] = $_ecare_no;
	//$d['to_email'] = $email;
	$d['to_email'] = $d['email'];
	$d['to_name'] = $d['name'];
	$M2mail->send($d, 'EUC-KR');


	$conn->disconnect();


	PutMessageOpenerReload("Answer has been sent.");
?>