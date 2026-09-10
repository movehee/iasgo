<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	$code = "day".$day;

	//$to_time = strtotime("2020-09-17 11:11:00");
	/*$to_time = $_Time['ing'];
	
	foreach($_TIME['session'][$day] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		if($to_time<=strtotime($tval[1])){
			$before_edate = $end_date[($tkey-1)];
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			break;
		}
	}

	foreach($_TIME['session_detail'][$day][$room] as $tkey=>$tval){
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		if($to_time>strtotime($tval[0]) && $to_time<=strtotime($tval[1])){
			$lecture_time = $tval[0]."~".$tval[1];
			$session_detail = $tkey;
			break;
		}
	}*/


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
	foreach($_DATE['date'.$day][$room_sid] as $tskey=>$tsval){
		
		if(strtotime($to_date." ".$tsval['session_stime'])<$_Time['ing'] && strtotime($to_date." ".$tsval['session_etime'])>$_Time['ing']){
			
			//echo $to_date." ".$tsval['session_stime'].'~'.$to_date." ".$tsval['session_etime']."==".$tskey.'=='.$tsval['title'].'<br><br>';
			//echo 'day='.$day.'///room_sid='.$room_sid.'///tskey='.$tskey.'<br><br>';
			//print_r($_DATE['date'.$day.'_detail'][$room_sid][$tskey]);
			//echo '<br><br>';

			$absolute_room = $tsval['absolute_room'];

			foreach($_DATE['date'.$day.'_detail'][$room_sid][$tskey] as $dkey=>$dval){
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
	if($session_title){
		$lecture_title = '['.$session_title.']<br>'.$lecture_title;		
	}
	if($absolute_room) $room_sid=$absolute_room;
	
	
	



	$query = "insert into question_tbl set code='$code'";
	$query .= ", name='".$_COOKIE['wmember_name']."'";
	$query .= ", usid='".$_COOKIE['wmember_sid']."'";
	$query .= ", day='".$day."'";
	$query .= ", room='".$room_sid."'";
	$query .= ", lecture_time='".$lecture_time."'";
	$query .= ", session='".$lecture_title."'";
	$query .= ", question='".$session_question."'";
	$query .= ", lecture_name='".$lecture_name."'";
	$query .= ", signdate='".$_Time['ing']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();

	echo "Y";

?>