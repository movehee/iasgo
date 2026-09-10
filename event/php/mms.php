<?
	//include_once $_SERVER['DOCUMENT_ROOT'] . "/php/func/include.function.php";
	//include_once $_SERVER['DOCUMENT_ROOT'] . "/php/func/include.connect.php";

	$send_id = "Novartis Exelon";
	$send_number = "010-5229-3790";


	$server_host = "121.254.129.66";  //-->원격서버의 ip주소 
	$server_port = "21000";    //-->원격서버의 port 
	$server_id= "sms";    //-->원격서버의 서버id 
	$server_pw = "sms1234";    //-->원격서버의 서버password 

	//원격서버에 연결한다. 
	if(!($fc = ftp_connect($server_host, $server_port))) 
		die("$server_host : $server_post - connect failed"); 

	//원격서버에 로그인한다. 
	if(!ftp_login($fc, $server_id, $server_pw)) 
		die("$server_id - login failed"); 

	//업로드할 폴더로 이동한다. 
	$server_dir = "mmsfile/ezv"; 
	ftp_chdir($fc, $server_dir); 
	

	

	$hostName = "121.254.129.66";
	$userName = "sms";
	$userPassword = "kidc";
	$dbName = "sms";

	##### including board class files.
	include_once "DB.php";

	##### 데이터베이스에 연결한다.
	$dsn = "mysql://$userName:$userPassword@$hostName/$dbName";
	$conn = DB::connect($dsn);
	if(DB::isError($conn)) {
	   die ($conn->getMessage());
	}
	$conn->query("set names utf8 ");

	//$subject = utf8_strcut($content,10); //제목
	$subject = "TEST"; //제목
	$msg = $content; //문자발송 내용
?>