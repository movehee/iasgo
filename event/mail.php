<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.Template.php";
	require_once $_SERVER['DOCUMENT_ROOT'] ."func/class.mailsend.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/script/phpqrcode/qrlib.php";
	
	ob_start("colback");
	$debugLog = ob_get_contents();
	ob_end_clean(); 

	$query = "select * from registration_tbl where del='N' and country!='' and country='$country' and ifnull(email,'')!='' and ifnull(qr_number,'')!='' order by sid desc";
	if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
		
	}
//	$query .= " limit 300,300";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	
	$M2mail = new M2mail('wiseU');

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
		$qr_number = $d['qr_number'];
		if($d['qr_number']){
			QRcode::png($qr_number,$_SERVER['DOCUMENT_ROOT']."/upload/qr/".$qr_number.".png",0,5,1);
		}
		//include_once $_SERVER['DOCUMENT_ROOT']."/qr.php";
		unset($html);
		if($d['country']=='K'){
			include_once $_SERVER['DOCUMENT_ROOT']."/templates/template.info_k.php";
			$html = template_k($d);
		}else if($d['country']=='F'){
			include_once $_SERVER['DOCUMENT_ROOT']."/templates/template.info_f.php";
			$html = template_f($d);
		}
		echo "발송대상 : ".$d['name_kr']."/".$d['email']."<br>";
		//echo $html;
		
		$_ecare_no = "66";
		
		$d['from_name'] = "KCR 2023";
		$d['from_email'] = "register@kcr4u.org";
		$d['mail_body'] = $html;
		if($d['country']=='K'){
			$d['subject'] = '[KCR 2023] 학술대회 현장 및 Virtual Platform 안내의 건 ';	
		}else{
			$d['subject'] = '[KCR 2023] Registration QR code and Virtual Platform Information to pre-registrants';
		}
		
		$d['ecare_no'] = $_ecare_no;
		$d['to_name'] = $d['name_kr'];
		

		/*실발송*/
		//$d['to_email'] = $d['email'];
		//$M2mail->send($d, 'EUC-KR'); //이거 풀면 발송
		/*실발송*/

	//$d['to_email'] = "emily@insession.co.kr";
	//$M2mail->send($d, 'EUC-KR'); //이거 풀면 발송

	//$d['to_email'] = "parkjin@m2community.co.kr";
	//$M2mail->send($d, 'EUC-KR'); //이거 풀면 발송
	}



	echo "END";

?>