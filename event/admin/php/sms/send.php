<?php
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
//exit;
//$code = "ksic2019s";
$code = "ksic2020";

$query="SELECT * FROM sms_tbl where code='$code' and send_yn='N'";
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

while(is_array($d = mysqli_fetch_assoc($result))){
	
	//$subject = "[KSIC 2020 개최 안내]"; //제목
	$subject = "KSIC Conference APP 설치 안내"; //제목

	$query_sms = "INSERT INTO MMS_MSG 
					(SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1,EXPIRETIME, ETC1, ETC4, ID, ETC2) VALUES
					('$subject','$d[recieve_num]','$d[send_num]','0',now(), '$d[content]',0,null,'43200', 'N', '".time()."', '".$code."', 'ezv.kr');";     
					
	//echo $query_sms."<br/><br/>";
	
	$result2=$conn_sms->query($query_sms);
	if(DB::isError($result2)) {
		die($result2->getMessage(). "<br/>". $query_sms . "<br/>");
	}
	else {
		mysqli_query($conn, "update sms_tbl set send_yn='Y' where sid='$d[sid]'");
	}
}

echo "완료";