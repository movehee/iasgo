<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	$code = "day".$day;

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
		$lecture_title = $session_title;		
	}
	if($absolute_room) $room_sid=$absolute_room;

	if($fsid){
		$ex_fsid = explode("|:|",$fsid);
		$session_detail = base64_decode($ex_fsid[1]);

		if($ex_fsid[0]) {
			$lecture_name = $conn->getOne("select faculty_name from faculty_tbl where sid=".$ex_fsid[0]);
		}
	}else{
		$session_detail = $lecture_title;
	}

	$user_query = "select *,if(ifnull(name_eng,'')!='',name_eng,name_kr) as name,if(ifnull(aff_eng,'')!='',aff_eng,aff_kor) as aff from registration_tbl where sid='".$_COOKIE['wmember_sid']."'";
	$user_result = $conn->query($user_query);
	$user_result->fetchInto(&$user,DB_FETCHMODE_ASSOC);
	$user_result->free();
	
	$query = "insert into question_tbl set code='$code'";
	$query .= ", name='".$user['name']."'";
	$query .= ", usid='".$user['sid']."'";
	$query .= ", office='".$user['aff']."'";
	$query .= ", email='".$user['email']."'";
	$query .= ", cell='".$user['cell']."'";
	$query .= ", day='".$day."'";
	$query .= ", room='".$room_sid."'";
	$query .= ", lecture_time='".$lecture_time."'";
	$query .= ", session='".addslashes($session_title)."'";
	$query .= ", session_detail='".base64_decode($ex_fsid[1])."'";
	$query .= ", question='".$session_question."'";
	$query .= ", org_fsid='".$fsid."'";
	$query .= ", lecture_name='".$lecture_name."'";
	$query .= ", fsid='".($ex_fsid[0] ? $ex_fsid[0] : '')."'";
	$query .= ", signdate='".$_Time['ing']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	
	if($_SERVER['wmember_level']!='M'){
		// if(file_exists($_SERVER['DOCUMENT_ROOT'].'load/play/question_mailing.php')){
		// 	include_once $_SERVER['DOCUMENT_ROOT'].'load/play/question_mailing.php';
		// }
	}
	

	$conn->disconnect();

	echo "Y";

?>