<?
	header('Content-Type: text/html; charset=UTF-8');

	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
	
	$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
	$setting_result = mysqli_query($conn, $setting_query);
	$setting_col = mysqli_fetch_array($setting_result);

	if($session_sid) {
		$query = "select a.*,t.time time_info, r.name room_info from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.sid='".$session_sid."'";
	} else {

		if(!$tab){
			$result = mysqli_query($conn, "SELECT sid from agenda_tbl where eventdate='".mktime(0, 0, 0, date("m"), date("d"), date("y"))."' and code='".$code."' and del='N'");
			$row = mysqli_fetch_array($result);
			$tab = $row['sid'];

			if(!$tab){
				$result = mysqli_query($conn, "SELECT sid from agenda_tbl where code='".$code."' and del='N' order by sid asc limit 1");
				$row = mysqli_fetch_array($result);
				$tab = $row['sid'];
			}
		}

		$time_query = "select * from session_time_tbl where tab='".$tab."' and del='N' order by orderby asc";
		$time_result = mysqli_query($conn, $time_query);

		$query = "select a.*,t.time time_info, r.name room_info from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.code='".$code."' and a.tab='".$tab."' and a.viewYN='Y' and a.qna_viewYN = 'Y'";

		if($setting_col['question_lecture_view']=="1") {

			$query .= " and a.time in ('0'";

			while(is_array($time_col = mysqli_fetch_array($time_result))){
					
					if ( strpos($time_col['time'], "~") ) {
							$time_temp = explode('~', $time_col['time']);
					} else if ( strpos($time_col['time'], "-") ) {
						$time_temp = explode('-', $time_col['time']);
					}
				
				
					$plusTime = strtotime("+10 minutes");
					$minusTime = strtotime("-10 minutes");
					
					$staTime = date("H:i",strtotime($time_temp[0]));
					$endTime = date("H:i",strtotime($time_temp[1]));
					
		
					if($staTime<date("H:i" ,$plusTime ) && $endTime >date("H:i" , $minusTime)){
						$query .=",'".$time_col['sid']."'";
					}
				}
				$query .= ")";
		}

		if($code=='katrd2019') {
			$query .= " order by time, room";
		}

	}
	
	$result = mysqli_query($conn, $query);

	while(is_array($col = mysqli_fetch_array($result))){
		$json2 = null;
		$subquery = "SELECT * FROM session_tbl ";
		$subquery .= "  WHERE type = '2' and sub_session='0' ";
		if($col['link_session']){
			$subquery .= " and link_session = '".$col['link_session']."' ";
		}else{
			$subquery .= " and link_session = '".$col['sid']."' ";
		}
		$subquery .= " order by orderby asc ";

		$totalquery = str_replace("SELECT * FROM", "SELECT count(*) cnt FROM", $subquery);
		$totalresult=mysqli_query($conn, $totalquery);
		$totalcol = mysqli_fetch_array($totalresult);

		if($totalcol['cnt']>0) {

			$subresult=mysqli_query($conn, $subquery);

			$qna_lecture_speaker_txt = str_replace("{lecture}", "", $setting_col['qna_lecture_style']); // 셋팅된 값에서 speaker 관련된 값만 남긴다.
			
			while(is_array($subcol = mysqli_fetch_array($subresult))){


				if($setting_col['faculty_type']==1){ //faculty 연동시
					
					$faculty_query="SELECT b.* FROM session_faculty_tbl a, faculty_tbl b WHERE a.faculty_sid=b.sid and a.gubun='speaker' and a.session_sid='".$subcol['sid']."' order by a.sid asc";

					$faculty_result=mysqli_query($conn, $faculty_query);
					$speaker = $title_speaker = "";
					$i = 0;
					while(is_array($faculty_d = mysqli_fetch_array($faculty_result))){
						if($i!=0){
							$speaker = $speaker . ", ";
							$title_speaker = $title_speaker . ", ";
						}

						/*faculty 셋팅*/
						$speaker = $faculty_d['name']?$faculty_d['name']:$faculty_d['name_en'];
						

						if($setting_col['qna_lecture_style']) { //Q&A 강의 표시방법 사용시
							$title_speaker_txt = str_replace("{speaker}", $faculty_d['name'], $qna_lecture_speaker_txt);
							$title_speaker_txt = str_replace("{speaker_en}", $faculty_d['name_en'], $title_speaker_txt);
						}
						else {
							$title_speaker .= $subcol['speaker'];
						}

						$i++;
					}
				} else {
					$speaker = $subcol['speaker'];
					$title_speaker = $subcol['speaker'];
				}

				if($setting_col['qna_lecture_style']) { //Q&A 강의 표시방법 사용시

					$lecture_view_txt = $setting_col['qna_lecture_style'];

					$lecture_view_txt = str_replace("{lecture}", $subcol['title'], $lecture_view_txt);
					$lecture_view_txt = str_replace($qna_lecture_speaker_txt, $title_speaker_txt, $lecture_view_txt);

					$title = $lecture_view_txt;

				} else {
					$title = $subcol['title'];
				}
				
				$json2 [] = array(
					'sid'=>$subcol['sid'],
					'title'=>strip_tags($title),
					'speaker'=>strip_tags($speaker),
					'etc_speaker'=>strip_tags($subcol['etc_speaker'])
				);
			}

			if($setting_col['qna_sesstion_style']) {
				$sesstion_view_txt = $setting_col['qna_sesstion_style'];

				$sesstion_view_txt = str_replace("{theme}", $col['theme'], $sesstion_view_txt);
				$sesstion_view_txt = str_replace("{sub_theme}", $col['sub_theme'], $sesstion_view_txt);
				$theme = $sesstion_view_txt;

			} else {
				$theme = $col['theme'];
			}


		

			$json [] = array(
				'sid'=>$col['sid'],
				'room'=>$col['room'],
				'theme'=>strip_tags($theme),
				'sub'=>$json2
			);

		}

	}

	echo json_encode($json);
?>
