<?
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

	$subject = "Exelon"; //제목
	$msg = "선생님 안녕하십니까.\n 
	Novartis Exelon team 입니다. \n
	바쁘신 시간에도 저희 심포지엄에 참석해 주신 선생님께 다시 한번 감사의 인사 드립니다. \n
	앞으로도 저희 Exelon 을 통해 좀더 많은 치매 환자분들께서 더 나은 삶을 살아가실 수 있도록 열심히 달리겠습니다. \n
	하반기에도 더 새롭고 풍성한 내용으로 인사 드리겠습니다.
	"; //문자발송 내용

	
	$upload_img_name = "exelon.jpg";
	//$upload_img = "http://ezv.kr/php/mms/image/exelon_190521.gif";
	$upload_img = "http://ezv.kr/php/mms/image/exelon.jpg";
	


	if(!ftp_put($fc, $upload_img_name, $upload_img, FTP_BINARY)){
		echo " 선생님 문자 발송 중 오류가 발생했습니다. 해당 선생님부터 다시 보내주세요..";
		exit;
	}else{
		//echo $_arr1[$i]."<br>";
		//echo "Success";
		
		//$file_path1 = "/home/sms/mmsfile/ezv/exelon_190521.gif";
		$file_path1 ="/home/sms/mmsfile/ezv/exelon.jpg";
		$file_cnt = 1;
	

		$query = "INSERT INTO MMS_MSG 
					(SUBJECT,PHONE,CALLBACK,STATUS,REQDATE,MSG,FILE_CNT,FILE_PATH1,EXPIRETIME, ETC1, ETC4, ID, ETC2, TYPE) VALUES
					('$subject','01055540623','02-2227-8285','0',now(), '$msg',$file_cnt,'$file_path1','43200', 'N', '2147500478', 'ezv', 'ezv.kr', '0');";           
		
		//echo $query."<br/><br/>";
		$result2=$conn->query($query);
		if(DB::isError($result2)) die($result2->getMessage(). "<br/>". $query2 . "<br/>");
		
	}
?>