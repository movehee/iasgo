<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
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


	foreach($_TIME['session'][$day][$room_sid] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		$ind[$tkey] = $tval[2];
		if($_Time['ing']<=strtotime($tval[1])){
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			$ind_chk = $tval[2];
			$delay_time = $tval[3];
			$N_session = $tval[4];
			break;
		}else{
			if($tkey=='C') continue;
			$befor_session = $tkey;
			$before_edate = $_TIME['session'][$day][$room_sid][$tkey][1];
			$befor_ind = $_TIME['session'][$day][$room_sid][$tkey][2];
			$delay_time = $_TIME['session'][$day][$room_sid][$tkey][3];
			$befor_N_session = $_TIME['session'][$day][$room][$tkey][4];
		}
	}
	if(!$session){ //세션이 없는경우 마지막 세션을 가져옴
		$session = end(array_keys($_TIME['session'][$day][$room_sid]));
	}
	
	foreach($_DATE['date'.$day][$room_sid] as $tkey=>$tval){
		if($_Time['ing']<=strtotime($to_date." ".$tval['session_etime'])){
			$Skey = $tkey;
			$S_title = $tval['title'];
			$S_stime = $tval['session_stime'];
			$S_etime = $tval['session_etime'];
			$S_Code = $tval['code'];
			$S_Code_title = $tval['code_title'];
			$S_difficulty = $tval['difficulty'];
			$S_part = $tval['part'];
			$S_lang = $tval['lang'];
			if($tval['chair2']) $tval['chair'] .= "|".$tval['chair2'];
			$S_Chair = str_replace("|",", ",$tval['chair']);
			$ex_chair = explode("|",$tval['chair']);
			$S_Chair_position = $tval['chair_position'];
			break;
		}else{
			$Skey = $tkey;
			$S_title = $tval['title'];
			$S_stime = $tval['session_stime'];
			$S_etime = $tval['session_etime'];
			$S_Code = $tval['code'];
			$S_Code_title = $tval['code_title'];
			$S_difficulty = $tval['difficulty'];
			$S_part = $tval['part'];
			$S_lang = $tval['lang'];
			if($tval['chair2']) $tval['chair'] .= "|".$tval['chair2'];
			$S_Chair = str_replace("|",", ",$tval['chair']);
			$ex_chair = explode("|",$tval['chair']);
			$S_Chair_position = $tval['chair_position'];
		}
	}
	
	if(!$Skey){ //세션이 없는경우 마지막 세션을 가져옴
		$Skey = end(array_keys($_DATE['date'.$day][$room_sid]));
	}
	
?>
<dl class="qna">
	<dt>Question</dt>
	<dd>
		<div class="formArea">
			<form id="QuestionF" name="QuestionF" method="post">
			<input type="hidden" name="room_sid" value="<?=$room_sid?>">
				<fieldset>
					<legend>Question</legend>
					<!-- <select name="fsid" id="fsid">
						<option value="">Select Author</option>
						<?
						if($_DATE['date'.$day.'_detail'][$room_sid][$Skey]){
						foreach($_DATE['date'.$day.'_detail'][$room_sid][$Skey] as $tkey=>$tval){
							if(!trim($tval['detail_author'])) continue;
							unset($ex_author);
							unset($ex_country);
							$kor="";
							if($tval['detail_kor']=='Y'){
								$kor = "<span class=\"kor\">Kor</span>";
							}
							if($tval['detail_author']){
								//$ex_author = explode("/",stripslashes($tval['detail_author']));
								$ex_author = explode("(",$tval['detail_author']);
								if(trim($tval['detail_author_position'])){
									$ex_author .= " (".stripslashes($tval['detail_author_position']).")";
								}
							}
							if($tval['detail_country']){
								$ex_country = explode("/",stripslashes($tval['detail_country'])) ;
							}
						?>
						<option value="<?=$tval['faculty_sid']?>|:|<?=base64_encode($tval['detail_title'])?>">
						<?
						unset($author_arr);
						if($ex_author){
							echo $tkey.". ".$ex_author[0];
							echo $kor;
						}
						?>
						</option>
						<?}}?>
					</select> -->
					<!-- 2022-03-17 텍스트 입력창에서 select 박스 변경으로 인한 주석처리
					<input type="text" name="lecture_name" id="lecture_name" placeholder="Please enter the name of the speaker" >
					-->
					<input type="text" id="lecture_name" name="lecture_name" placeholder="Please enter the speaker name">
					<textarea name="session_question" id="session_question" cols="30" rows="10" placeholder="Please type in your questions in the this text box. The questions will be directly addressed to chairs."></textarea>
					<input type="submit" value="Send" class="send_question">
				</fieldset>
			</form>
		</div>
	</dd>
</dl>