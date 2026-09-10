<?php
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";



	$query="SELECT * FROM event_tbl where code='".$code."'";

	$result = mysqli_query($conn, $query);
	$event_col = mysqli_fetch_array($result);

	//$bbs_query="SELECT * FROM bbs_tbl where sid='".$sid."'";
	$bbs_query="SELECT * FROM bbs_tbl where del='N' and sid='".$sid."'";
	$bbs_result = mysqli_query($conn, $bbs_query);
	$bbs_col = mysqli_fetch_array($bbs_result);


	if($code=="all2019f"){

		$conn = mysqli_connect(
		  '121.254.129.98',
		  'allergy',
		  'allergy!@#',
		  'allergy');
		mysqli_set_charset($conn, 'utf8');

		$query = "select token,device from app_push where  1=1  and fall_2019 ='Y' ";
		if($event_col['testYN']=="Y"){
			$query .= " and token in ('".$event_col['test_token1']."','".$event_col['test_token2']."')";
		}else {
			//$query .= " weqeweq;";
		}
	}else {
		
		//앱에 추가되는 행사가 있는경우
		if ( $event_col['pushcode'] ) {
			$query = "select * from token_tbl where 1=1 and pushYN='Y' and pushCode = '".$event_col['pushcode']."'"; 
			if($event_col['testYN']=="Y"){
				$query .= " and token in ('".$event_col['test_token1']."','".$event_col['test_token2']."')";
			}
			$query .= " group by token";
			//$query .= " group by deviceid ";
			
		} else {
			$query = "select token,device from token_tbl where  1=1  and pushYN ='Y' and code='".$code."' ";
			if($event_col['testYN']=="Y"){
				$query .= " and token in ('".$event_col['test_token1']."','".$event_col['test_token2']."')";
			} 
			$query .= " group by token";	
		}
	}


	$result = $conn->query($query);


	//echo $query;
	/* 아이폰과 안드로이드 배열 생성*/
	$arr['registration_ids'] = array();
	$arr['registration_ids2'] = array();
	/* 아이폰과 안드로이드 배열 생성*/

	/* 아이폰과 안드로이드 초기값 생성*/
	$conidx = 0;
	$conidx2 = 0;
	/* 아이폰과 안드로이드 초기값 생성*/

	while(is_array($d = mysqli_fetch_array($result))){

		if(strpos($d['device'],'android') !== false){
			$arr['registration_ids'][$conidx] = $d['token'];
			 $conidx++;
		}

		if(strpos($d['device'],'IOS') !== false){
			$arr['registration_ids2'][$conidx2] = $d['token'];
			$conidx2++;
		}
	}


	$headers = array(
		'Authorization: key='.$event_col['android_key'],
		"Content-Type: application/json"
	  );
//	  $url = 'http://android.googleapis.com/gcm/send';
	  		$url = "https://fcm.googleapis.com/fcm/send"; 

/*
	  if ( $code == "kses190818" || $code == "koa2019f" ) {
	  	$url = "http://fcm.googleapis.com/fcm/send"; 
	  }
*/

		if($event_col['push_title']){
			$title = $event_col['push_title'];
		}else{
			$title = $bbs_col['subject'];
		}


		$fields = array(
		  "registration_ids" => is_array($arr['registration_ids']) ? $arr['registration_ids'] : array($arr['registration_ids']),
		 // "registration_ids"=>"APA91bH533MyvqKjC8JVY2sl49JJ59uhkH2p_WMP9J16cYnf9uBfaRej7exfSjAQCZn9emHpv29DmO8tKFYFhIF6tVdy-OEcqdJShUJlG_Nw--LRd1kY7KfvFTJtbbmzzQbkQMd0Wmqg",
		  "data" => array("message"=>$bbs_col['subject'], "sid"=>$sid, "code"=>$code, "title"=>$title,"url"=>$sid,"linkurl"=>$sid, "body"=>$bbs_col['subject'])
		);

		// Open connection
		$ch = curl_init();

		// Set the URL, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_POST, true);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = json_encode($fields);
		//echo $data;
		//echo $data;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// Execute post
		$result = curl_exec($ch);
		//echo $result;
		// Close connection
		curl_close($ch);



	$headers = array(
		'Authorization: key='.$event_col["ios_key"],
		'Content-Type: application/json'
	  );
  	$url = 'https://fcm.googleapis.com/fcm/send';

	if($event_col['push_title']){
		$title = $event_col['push_title'];
	}else{
		$title = $bbs_col['subject'];
	}

	$fields = array(
		'registration_ids' => is_array($arr['registration_ids2']) ? $arr['registration_ids2'] : array($arr['registration_ids2']),
		'content_available'  => true,
		'priority' => 'high',
		'notification' => array("linkurl"=>$sid, "title"=>$title, "body"=>$bbs_col['subject'],"sound"=>"default", "code"=>$code),
		'data'=>array("sid"=>$sid,"message"=>$bbs_col['subject'],"code"=>$code),
	);

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($ch, CURLOPT_POST, true);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = json_encode($fields);
	//echo $data;
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	// Execute post
	$result = curl_exec($ch);
	
	// Close connection
	curl_close($ch);


	echo "푸쉬가 발송되었습니다.";
?>
