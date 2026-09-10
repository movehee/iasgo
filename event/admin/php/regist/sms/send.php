<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/lib.php";
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/func/class.sms.php";
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/func/class.mms.php";

if(empty($_POST)){
	PutMessageBack("비정상적인 접근입니다.");
}

if($_POST['reg_type'] == "content") {
	
	$query = "update event_tbl set sms_content='".addslashes($_POST['msg'])."' where code='$code'";
	$conn->query($query);
	PutMessageClose("저장되었습니다.");
	exit;
}

$query = "SELECT * FROM session_set_tbl where code='".$code."' ";
$setting_result = $conn->query($query);
$setting_result->fetchInto(&$setting_d, DB_FETCHMODE_ASSOC);


$query = "SELECT * FROM regist_set_tbl where code='".$code."' ";
$reg_set_result = $conn->query($query);
while(is_array($reg_set_d=$reg_set_result->fetchRow(DB_FETCHMODE_ASSOC))){
	$reg_set[$reg_set_d['sid']] = $reg_set_d;
}

$Sms = new Sms('121.254.129.66','sms','kidc','sms',$HTTP_HOST,$e['code']);
$Mms = new Mms($e['code']);

foreach( $chk_sid as $key => $val ){
	
	$query = "select * from regist_tbl where sid='".$val."' and code='".$e['code']."' and del='N'";
	$result = $conn->query($query);
	$result->fetchInto(&$d, DB_FETCHMODE_ASSOC);

	$receive_number = $d[$hp_col];

	$msg = str_replace("{reg_sid}", $d['sid'], $msg);

	if($setting_d['reg_name_en']) {
		$info_field = "info".$reg_set[$setting_d['reg_name_en']]['info_orderby'];
		$msg = str_replace("{reg_name_en}", str_replace("&&", " ", $d[$info_field]), $msg);
	}

	if($setting_d['reg_office']) {
		$info_field = "info".$reg_set[$setting_d['reg_office']]['info_orderby'];
		$msg = str_replace("{reg_office}", $d[$info_field], $msg);
	}

	if($setting_d['reg_license']) {
		$info_field = "info".$reg_set[$setting_d['reg_license']]['info_orderby'];
		$msg = str_replace("{reg_license}", $d[$info_field], $msg);
	}
	
	if(strlen($msg) < 80){
		$Sms->sms_send($receive_number, $msg, $e['sms_number'], $e['code'], "N", "");
	}else{
		$Mms->mms_send($receive_number,  $e['sms_number'], $msg, 'N', 'now()', $e['code']);
	}	
	
}

PutMessageClose("메세지를 성공적으로 전송했습니다.");

?>