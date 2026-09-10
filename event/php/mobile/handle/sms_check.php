<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/func/class.sms.php";


$query = "select ".$hp_col." from regist_tbl where ".$name_col."='".$name."' and ".$license_col."='".$license."' and code='".$e['code']."' and pay_chk='Y' and del='N'";

$result=$conn->getOne($query);
if($result){
	$Sms = new Sms('121.254.129.66','sms','kidc','sms',$HTTP_HOST,$e['code']);
	$sms_code = rand(1111,9999);
	$str = "회원님의 인증번호는 ${sms_code} 입니다 -".$e['name']."-";
	$reserve_date = '0000-00-00 00:00:00';
	$Sms->sms_send($result, $str, $e['sms_number'], $e['code'], "N", "");
	
	echo $sms_code;
}else{
	echo "false";
}

	

?>