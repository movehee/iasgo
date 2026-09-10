<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';


	$play_time = $_GET['cur_time']; //플레이되는 시간
	$vsid = $_GET['vsid']; //영상의 키값
	$usid = $_GET['usid']; //유저키값
	
	if(!$vsid){
		exit;
	}
	if(!$usid){
		exit;
	}

	$_VOD['time'] = array(
		'1'=>"3542",
		'2'=>"3416",
		'3'=>"3764",
		'4'=>"3123"
	);

	if($play_time>0){
		$finish="N";
		//$t_time = $conn->getOne("select r_time from vod_result_tbl where usid='$usid' and vsid='$vsid'");
		$t_time = $_VOD['time'][$vsid];
		if(($t_time-120)<=round($play_time)){
			$finish="Y";
			$play_time = $t_time;
		}

		$query = "update vod_result_tbl set start_time=if(start_time>0,start_time,'".time()."')";
		$query .= ", end_time=if(finish='Y',end_time,'".time()."')";
		$query .= ", c_time=if(finish='Y','".$t_time."','".round($play_time)."')";
		$query .= ", finish=if(finish='Y','Y','".$finish."')";
		$query .= " where usid='$usid' and vsid='$vsid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
	}
?>