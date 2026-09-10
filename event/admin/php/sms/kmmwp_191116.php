<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

$code = "191116";

$query="SELECT * FROM sms_tbl where code='$code' and send_yn='N'";
//echo $query;exit;
//$query .= "and sid=871";
$result = mysqli_query($conn, $query);


$hostName = "121.254.129.66";
$userName = "sms";
$userPassword = "kidc";
$dbName = "sms";

##### including board class files.
include_once "DB.php";

##### 데이터베이스에 연결한다.
$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
$conn_sms = DB::connect($dsn);
if(DB::isError($conn_sms)) {
   die ($conn_sms->getMessage());
}
$conn_sms->query("set names utf8 ");


/*
$subject = "2019 하반기 KMMWP workshop & 임상연구 모임";

$reserve_date = "2019-11-13 09:50:00";

$d[recieve_num] = "01062360556";
$d[send_num] = "01034414427";

$d[content] = "안녕하세요. 다발골수종연구회입니다.

2019년 11월 16일(토)에 진행되는 2019 하반기 KMMWP workshop & 임상연구 모임에 등록을 해주셔서 감사합니다.
아래 URL을 통하여 App.을 설치 하신 후, 당일 보팅과 실시간 질의응답에 활발한 참여를 부탁드립니다.

참여 해 주시는 선생님들께서는 적극적인 활용을 부탁드립니다.

보팅앱 설치방법
http://ezv.kr/191116/

1) 아이폰: 다운로드 버튼을 눌러 앱 설치 후 아래 과정으로 승인을 해주셔야 앱 실행이 가능합니다.
설정 > 일반 > 프로파일 or 기기관리 > m2community > 신뢰함 > 앱실행

2) 안드로이드: 다운로드 버튼을 누르면 구글플레이로 연결됩니다.
";


$query_sms = "INSERT INTO MMS_MSG 
					(SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1,EXPIRETIME, ETC1, ETC4, ID, ETC2) VALUES
					('$subject','$d[recieve_num]','$d[send_num]','0',now(), '$d[content]',0,null,'43200', 'N', '".time()."', '".$code."', 'ezv.kr');";     
					

$result2=$conn_sms->query($query_sms);
if(DB::isError($result2)) {
	die($result2->getMessage(). "<br/>". $query_sms . "<br/>");
}
*/

exit;
$subject = "2019 하반기 KMMWP workshop & 임상연구 모임";
$reserve_date = "2019-11-16 08:30:00";


while(is_array($d = mysqli_fetch_assoc($result))){
	
	

	$query_sms = "INSERT INTO MMS_MSG 
					(SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1,EXPIRETIME, ETC1, ETC4, ID, ETC2) VALUES
					('$subject','$d[recieve_num]','$d[send_num]','0','$reserve_date', '$d[content]',0,null,'43200', 'N', '".time()."', '".$code."', 'ezv.kr');";     
					
	echo $query_sms."<br/><br/>";
	
	$result2=$conn_sms->query($query_sms);
	if(DB::isError($result2)) {
		die($result2->getMessage(). "<br/>". $query_sms . "<br/>");
	}
	else {
		mysqli_query($conn, "update sms_tbl set send_yn='Y' where sid='$d[sid]'");
	}
}


echo "완료";