<?php 
##이미 입력된 정보에 추가 저장
header("Content-Type: text/html; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."func/include.connect.php";

$return = true;
$msg = '';
$row = array();

if(is_file($_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php")) include $_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php";
else{
	$return = false;
	$msg = "COMMENT 설정파일이 없습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}
include $DOCUMENT_ROOT . "api_comment/YY.php";

#임시 입력데이터
$content_arr = array(
	'name'			=> (!empty($_POST['cname'])?trim($_POST['cname']):''),
	'id'			=> (!empty($_POST['cid'])?trim($_POST['cid']):''),
	'content'		=> (!empty($_POST['content'])?$_POST['content']:''),
	'rname'			=> (!empty($_POST['rname'])?trim($_POST['rname']):''),
	'signdate'		=> time(),
	'modifydate'	=> '',
	'op1'			=> (!empty($_POST['cop1'])?$_POST['cop1']:''),
	'op2'			=> (!empty($_POST['cop2'])?$_POST['cop2']:''),
	'op3'			=> (!empty($_POST['cop3'])?$_POST['cop3']:''),
	'poster_sid'			=> (!empty($_POST['poster_sid'])?$_POST['poster_sid']:'')
);

##부적절한 단어가 포홤되어있는지확인.
$Fresult = fuck_match($words, $content_arr['content']); 
if(!empty($Fresult)){##욕을쓸경우 욕쓰지 말라고 메세지띄움
	$return = false;
	$msg = "내용에 부적절한 단어가 포함되어있습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}


$type = "C";
##코멘트의 코멘트일경우
$_csid = "";
if(!empty($_POST['_csid'])){
	$_csid = $_POST['_csid'];
	$type = "CC";
	
	##입력할 타켁코멘트가 있는지 검사
	$date_C = $conn->getOne("select count(*) from comment_tbl where sid='".$_POST['_csid']."'");

	if( $date_C <= 0 ){
		##작성한 코멘트에 대한 타겟 코멘트가 없으면 리턴
		$return = false;
		$msg = "상위 코멘트가 없습니다.";
		echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
		exit;
	}
}

$poster_sid = $_POST['poster_sid'];
if($_POST['poster_sid']){
$poster_email = $conn->getOne("select presenter_email from e_poster where sid='".$_POST['poster_sid']."'");
$poster_subject = $conn->getOne("select subject from e_poster where sid='".$_POST['poster_sid']."'");
}
$query = "insert into comment_tbl set name='".(!empty($_POST['cname'])?trim($_POST['cname']):'')."',
									  id='".(!empty($_POST['cid'])?trim($_POST['cid']):'')."',
									  content='".(!empty($_POST['content'])?addslashes($_POST['content']):'')."',
									  rname='".(!empty($_POST['rname'])?trim($_POST['rname']):'')."',
									  signdate='".time()."',
									  modifydate='',
									  op1='".(!empty($_POST['cop1'])?$_POST['cop1']:'')."',
									  op2='".(!empty($_POST['cop2'])?$_POST['cop2']:'')."',
									  op3='".(!empty($_POST['cop3'])?$_POST['cop3']:'')."',
									  type='".$type."',
									  page_name='".(!empty($_POST['file_name'])?$_POST['file_name']:'')."',
									  number='".(!empty($_POST['_number'])?$_POST['_number']:'')."',
									  csid='".(!empty($_POST['_csid'])?$_POST['_csid']:'')."'";
									  
									  
									  
$result = $conn->query($query);
if(DB::isError($result)) {
   die($result->getMessage());
}
$mysid = mysql_insert_id();


include_once $_SERVER['DOCUMENT_ROOT']."poster/mailing.php";

/*
if($type == 'C' && substr($_POST['_number'], 0, 2) == "b_") {//부스라면
	
	$booth_sid = substr($_POST['_number'], 2);
	
	$booth_query = "select * from booth_company where booth_sid = $booth_sid";
	$booth_result = $conn->query($booth_query);
	$booth_result->fetchInto(&$booth, DB_FETCHMODE_ASSOC);
	

	if($booth['manager_hp']) {

		$hostName = "121.254.129.66";
		$userName = "sms";
		$userPassword = "kidc";
		$dbName = "sms";

		##### 데이터베이스에 연결한다.
		$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
		$conn_sms = DB::connect($dsn);
		if(DB::isError($conn_sms)) {
		   die ($conn_sms->getMessage());
		}
		$conn_sms->query("set names utf8 ");

		if($test_hp) {
			$recieve_num = $test_hp;
		} else {
			$recieve_num = $booth['manager_hp'];
		}
	
		$subject = "KATRDIC 2020 Virtual Conference";
		$content = "KATRDIC 2020 부스에 Q&A가 등록되었습니다.";
		$send_num = "02-2190-7342";
		$sms_code = "webinar.katrdic.org";

		$query_sms = "INSERT INTO MMS_MSG 
					(SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1,EXPIRETIME, ETC1, ETC4, ID, ETC2) VALUES
					('$subject','$recieve_num','$send_num','0',now(), '$content',0,null,'43200', 'N', '".time()."', '".$sms_code."', 'webinar');";

		$conn_sms->query($query_sms);

	}


}
*/
echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
exit;