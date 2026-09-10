<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/func/class.sms.php";
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/func/class.mms.php";

if(empty($_POST)){
	PutMessageBack("비정상적인 접근입니다.");
}

$Sms = new Sms('121.254.129.66','sms','kidc','sms',$HTTP_HOST,$e['code']);
$Mms = new Mms($e['code']);

foreach( $chk_sid as $key => $val ){
	
	$query = "select ".$hp_col." from regist_tbl where sid='".$val."' and code='".$e['code']."' and del='N'";
	$result=$conn->getOne($query);
	
	if(strlen($msg) < 80){
		$Sms->sms_send($result, $msg, $e['sms_number'], $e['code'], "N", "");
	}else{
		$Mms->mms_send($result,  $e['sms_number'], $msg, 'N', 'now()', $e['code']);
	}	
	
}

PutMessageClose("메세지를 성공적으로 전송했습니다.");

?>