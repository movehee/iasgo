<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	$code = "day".$day;
	
	$deviceid = $_COOKIE['wmember_sid'];


	if(is_file($_SERVER['DOCUMENT_ROOT'] . "func/config_detail_times.php")) include_once $_SERVER['DOCUMENT_ROOT'] . "func/config_detail_times.php";
	

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$ev_date = $day;

	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ev_date-1), $ex_sdate[0]));
	$to_date_unixtime = strtotime($to_date);
	$week_s = date('w',$to_date_unixtime);
	
	
	$conference_month = $_PROGRAM['Month_eng'][$ex_sdate[1]];
	$conference_day = $ex_sdate[2]+$ev_date;
	$conference_week = $_PROGRAM['days_eng'][$week_s];
	

	
	unset($session_title);
	foreach($_DATE['date'.$day][$room] as $tskey=>$tsval){
		
		if(strtotime($to_date." ".$tsval['session_stime'])<$_Time['ing'] && strtotime($to_date." ".$tsval['session_etime'])>$_Time['ing']){
			
			//echo $to_date." ".$tsval['session_stime'].'~'.$to_date." ".$tsval['session_etime']."==".$tskey.'=='.$tsval['title'].'<br><br>';
			//echo 'day='.$day.'///room_sid='.$room_sid.'///tskey='.$tskey.'<br><br>';
			//print_r($_DATE['date'.$day.'_detail'][$room_sid][$tskey]);
			//echo '<br><br>';

			$absolute_room = $tsval['absolute_room'];

			foreach($_DATE['date'.$day.'_detail'][$room][$tskey] as $dkey=>$dval){
				$session_title = $tsval['title'];
				
				//echo $dval['detail_time'].'~~<br>';
				$ex_dval = explode("-",$dval['detail_time']);
				//echo $to_date." ".$ex_dval[0].'//'.$to_date." ".$ex_dval[1].'!!!!<br><br>';

				if(strtotime($to_date." ".$ex_dval[0])<$_Time['ing'] && strtotime($to_date." ".$ex_dval[1])>$_Time['ing']){
					$lecture_title = $dval['detail_title'];
					break;
				}
			}
		}
	}
	if($absolute_room) $room=$absolute_room;

	$query="SELECT * FROM voting_tbl where code='".$code."' and room='$room' and status in ('1','3') ".$where;
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
	$result->free();
	

	$voting_sid = $col['sid'];

	if(!$voting_sid){
		 echo json_encode(array('push'=>'3'));
		 exit;	
	}
	
	
	$chking = $conn->getOne("select count(*) from voting_result_tbl where code='$code' and voting_sid='$voting_sid' and deviceid='$deviceid'");
	if($chking>0){
		$query = "update voting_result_tbl set val='$voting'";
		$query .= ", voting_date='".time()."'";
		$query .= " where voting_sid='$voting_sid' and deviceid='$deviceid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		echo json_encode(array('push'=>'2'));
		exit;
	}else{
		$query = "insert into voting_result_tbl set code='$code'";
		$query .= ", voting_sid='$voting_sid'";
		$query .= ", deviceid='$deviceid'";
		$query .= ", val='$voting'";
		$query .= ", voting_date='".time()."'";
		$query .= ", room='$room'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		echo json_encode(array('push'=>'1'));
		exit;
	}


	$conn->disconnect();
?>