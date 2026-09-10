<?

	//*
/*

	// APNS 테스트!! Start  ------
$deviceToken = '8F49249BD270C06BC56073B6E9BCC158CE965A7902CBDD635812BDC3EB6BF656'; // 디바이스토큰ID
$message = '새글이 등록되었습니다.'; // 전송할 메시지
 
// 개발용

//$apnsHost = 'gateway.sandbox.push.apple.com';
//$apnsCert = 'dev_kapard_apns.pem';

 
// 실서비스용
$apnsHost = 'gateway.push.apple.com';
$apnsCert = 'ns_apns.pem';
 
$apnsPort = 2195;
 
$payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default'),'code'=>123,'sid'=>11,'url'=>'/app/php/about/message.php');
$payload = json_encode($payload);
 
$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
 
$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
 
if($apns)
{
	echo "ok..";
  $apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload;
  fwrite($apns, $apnsMessage);
  fclose($apns);
} else {
	echo "error";
}
*/

	// APNS 테스트!! END -- ------
/*
	
	final class MMLibApns {
	
   static private $headers = array(
    'Authorization: key=AAAAvDSopW4:APA91bFtnXTQG3bqCG2APmqppueeT0cmUh5Zv0WN3sGGLcZNS76-hCsuld9GQ49fMePVy5hY4itPOvnRtD5T-gP2bptf8Gj_Y1qoXM7S3BXrJgXWawBp9bTkzdzOCPUwkpeX2MJtry0v',
    'Content-Type: application/json'
  );
  	static private $url = 'http://fcm.googleapis.com/fcm/send';
   
	static function send($uuids, $title, $linkurl, $body,$sid){
		
	    //title과 contents의 길이가 0이면 return 처리
	   // if(strlen($title) == 0 || strlen($contents) == 1) return NULL;

	    $fields = array(
			'registration_ids' => is_array($uuids) ? $uuids : array($uuids),
			'content_available'  => true,
			'priority' => 'high',
			'notification' => array("linkurl"=>$linkurl, "title"=>$title, "body"=>$body,"sound"=>"default"),
			'data'=>array("sid"=>$sid),
			
	    );

	    // Open connection
	    $ch = curl_init();
	   
	    // Set the URL, number of POST vars, POST data
	    curl_setopt($ch, CURLOPT_URL, self::$url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, self::$headers);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	   
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    // curl_setopt($ch, CURLOPT_POST, true);
	    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $data = json_encode($fields);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    // Execute post
	    $result = curl_exec($ch);
	    // Close connection
	    curl_close($ch);
	    echo $result; //INVALID_REGISTRATION
	  }
}

	
*/

final class MMLibApns {
	
   static private $headers = array(
    'Authorization: key=AIzaSyAXNp3SS5wqjNyzNTQDmPLR8YXjpeve12Y',
    'Content-Type: application/json'
  );
  	static private $url = 'http://fcm.googleapis.com/fcm/send';
   
	static function send($uuids, $title, $linkurl, $body,$dd,$sid){
	    //title과 contents의 길이가 0이면 return 처리
	   // if(strlen($title) == 0 || strlen($contents) == 1) return NULL;
	   
	  // for ( $i = 0, $j = count($uuids); $i < $j ; $i++  ) {

			    $fields = array(
				'registration_ids' => is_array($uuids) ? $uuids: array($uuids),
				'content_available'  => true,
				'priority' => 'high',
				'notification' => array("linkurl"=>$linkurl, "title"=>$title, "body"=>$body,"sound"=>"default"),
				'data'=>array("sid"=>$sid,"message"=>$title,"url"=>'/workshop/2019Spring/app/php/bbs/view.php',"code"=>"2"),
		    );
	
		    // Open connection
		    $ch = curl_init();
		   
		    // Set the URL, number of POST vars, POST data
		    curl_setopt($ch, CURLOPT_URL, self::$url);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, self::$headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		   
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    // curl_setopt($ch, CURLOPT_POST, true);
		    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    $data = json_encode($fields);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		    // Execute post
		    $result = curl_exec($ch);
		    // Close connection
		    curl_close($ch);
		    echo $result; //INVALID_REGISTRATION
			   
		   //}
	   
	   
	  }
}

final class MMLibGcm{
		/*
	  static private $headers = array(
		'Authorization: key=AIzaSyCoKI_M3mIxbBzqfk159JXwVG7gg7NGmC8',
		'Content-Type: application/json'
	  );
		*/
	static private $headers = array(
		'Authorization: key=AIzaSyCGUm7ldlLGIyygrBaL_wz_WzYrCNIfXso',
		'Content-Type: application/json'
	  );
	  
	  static private $url = 'https://fcm.googleapis.com/fcm/send';
		
	  static function send($uuids, $title, $contents, $body,$linkurl,$sid){
		//title과 contents의 길이가 0이면 return 처리
		
		
		if(strlen($title) == 0 || strlen($contents) == 1) return NULL;
			
		$fields = array(
		  "registration_ids" => is_array($uuids) ? $uuids : array($uuids),
		 // "registration_ids"=>"APA91bH533MyvqKjC8JVY2sl49JJ59uhkH2p_WMP9J16cYnf9uBfaRej7exfSjAQCZn9emHpv29DmO8tKFYFhIF6tVdy-OEcqdJShUJlG_Nw--LRd1kY7KfvFTJtbbmzzQbkQMd0Wmqg",
		  "data" => array("message"=>$contents, "title"=>$title,"url"=>$linkurl, "body"=>$body, "sid"=>$sid)
		);   
		
		// Open connection
		$ch = curl_init();
	   
		// Set the URL, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, self::$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, self::$headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	   
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = json_encode($fields);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// Execute post
		$result = curl_exec($ch);
		// Close connection
		curl_close($ch);
		
		print_r($result);
		
		//echo $result; //INVALID_REGISTRATION

	  }
	}





function sendPush($uuid, $os, $title, $content, $url,$sid){
	  $regid_ios = array();
	  
	  if($os == 1){ //ios
/*
		  for ( $i = 0 , $j = 1; $i < $j ; $i++ ) {
		  	   array_push($regid_ios, $uuid);
		  }
*/
//		  	push($subject,"/workshop/2019Spring/app/php/bbs/view.php",$sid,$code);
		 MMLibApns::send($uuid, $title, $url,$content,"",$sid);     
		 //  send($uuids, $title, $linkurl, $body,$sid)
//			MMLibApns::send($uuid, $title, $url, $content,$sid);     
	  }else if($os == 2){ //android
		  MMLibGcm::send($uuid, $title, $url, $content,"",$sid);     
	  }
/*
	  if ( count( $regid_ios ) > 0 ) {
			$regid_ios = array_chunk($regid_ios, 150);
			MMLibApns::send($regid_ios, $subject, $url,$code,$sid);
	}
*/
}


//sendPush("cWoiyaXeZeY:APA91bFS1v9oTB_FrXLcZiaMdlwN601CSPfurHOJa1_uE4QPy84maVA2-OamXKckSP6wRsbabONLGd8CkHA274F5dUjZfRFGLe1SLYpavVTI0zB8W68O__8MceFkjTZhs7U8Srxy9L8o", 1, '제목', '내용', 'http://plasticsurgery.m2comm.co.kr',15092);
$arr = array("cilTq5XaiRQ:APA91bFAp6KZK596BE6Gw6dpAygV_gUJLbRYX9jNppDkyicV8cbdkumKDO0BkLqnHU6mX__IcF003qgyWAAnEy9L3vCP6yiA_2prEgJURlMycG1nZN3SCkhEBU8TwIWHVwYHRx8clFDh");
MMLibGcm::send($arr, "12", "22", "23","24",2); 
//sendPush($arr, 2, 'pushTest', 'push Test','url',2672);

//sendPush("dH4uTWWyO7s:APA91bHZq5rNC9Vlii-7WY8y4RqrPN1BS9xsYeNliau2kYjJ7R41sw_pssJmQgoepRrP-gFOu-3vsC2wsCFj-ybra8VPnnFg4zbWXOew8yakP1l43sk7aYU9zbheLfI9AKR8QziBYStq", 1, '제목', '내용', 'http://plasticsurgery.m2comm.co.kr',15092);


?>