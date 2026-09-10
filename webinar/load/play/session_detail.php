<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
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
			$S_sid = $tval['session_sid'];
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
			$S_sid = $tval['session_sid'];
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
		$S_sid = $_DATE['date'.$day][$room_sid]['session_sid'];
	}
	
?>

<?php if($mode == "interval") { 
	$speakers = array();
	ob_start(); //출력 버퍼링 활성	
}?>
	
<table class="session type<?=$room_sid?>" id="detail_viewer">
	<colgroup>
		<col style="width: 10%;">
		<col style="width: *;">
	</colgroup>
	<tbody>
		<tr class="sessionTit">
			<th>
				<span><?=Days_convert($to_date,"M.D(w)","s")?></span>
				<?=$S_stime?>-<?=$S_etime?>
			</th>
			<td>
				<span class="room" pub-room=""> <?=$_Day['room_title'][$room_sid]?></span>
			<!-- 	<span class="room" pub-room="(Room <?=$room_sid?>)"> <?=$_Day['room_title'][$room_sid]?></span> -->
				<span class="tit">
					<?=stripslashes($S_Code_title)?> (<?=$S_Code?>)
					<span class="type">

						<span class="<?=$_PROGRAM['lang_class'][$S_lang]?>"><?=$_PROGRAM['lang_code'][$S_lang]?></span>

						<?if($S_part){?><span class="ch"><?=$S_part?></span><?}?>
						<?if($S_difficulty){?><span class="<?=$_PROGRAM['difficulty_code'][$S_difficulty]?>"><?=$_PROGRAM['difficulty'][$S_difficulty]?></span><?}?>
					</span>
				</span>
				<?=stripslashes($S_title)?>

				<span class="util">
				<?php if(!in_array($S_sid, $_No_eval)):?>
					<a onclick="session_eval(<?=$S_sid?>)" class="eval">Session Evaluation</a>
				<?php endif;?>
				</span>
			</td>
		</tr>

		<?if(trim($tval['chair'])){?>
		<tr class="chairs">
			<th>Chair<?if(count($ex_chair)>1){?>s<?}?></th>
			<td>
				<!-- <?foreach($ex_chair as $ckey=>$cval){?>
				<?=stripslashes($cval)?>
				<?}?> -->
				<?=implode(", ", $ex_chair)?>

				<!-- <span class="util">
					<a href="#" class="favor">Session Favorite</a>
				</span> -->
			</td>
		</tr>
		<?}?>

		<?
			if($_DATE['date'.$day.'_detail'][$room_sid][$Skey]){
			foreach($_DATE['date'.$day.'_detail'][$room_sid][$Skey] as $tkey=>$tval){
				unset($ex_author);
				unset($ex_country);
				// $kor="";
				// if($tval['detail_kor']=='Y'){
				// 	$kor = "<span class=\"kor\">Kor</span>";
				// }
				if($tval['detail_author']){
					//$ex_author = explode("/",stripslashes($tval['detail_author']));
					$ex_author = stripslashes(str_replace("("," (",$tval['detail_author']));
					if(trim($tval['detail_author_position'])){
						$ex_author .= " (".stripslashes($tval['detail_author_position']).")";
					}

					if($mode == "interval") { 
						$sp_author = explode("(",$tval['detail_author']);
						// $speakers[] = $sp_author[0];
						array_push($speakers, array("key"=>$tval['faculty_sid']."|:|".base64_encode($tval['detail_title']), "val"=>$sp_author[0]));
						
					}
				}
				if($tval['detail_country']){
					$ex_country = explode("/",stripslashes($tval['detail_country'])) ;
				}

				$_d_time = explode("-", $tval['detail_time']);

				if(strtotime($to_date." ".$_d_time[0])<$_Time['ing'] && strtotime($to_date." ".$_d_time[1])>=$_Time['ing']){
					$On_air = "Y";
				} else {
					$On_air = "N";
				}
		?>
			<tr <?if($On_air=='Y'){?>class="active"<?}?>>
				<th><?=stripslashes($tval['detail_time'])?></th>
				<td>
					<span class="tit"><?=stripslashes($tval['detail_title'])?></span>
					<?
					unset($author_arr);
					if($ex_author){
						echo $ex_author;
						// echo $kor;
					}
					?>

					<?if($tval['faculty_cv'] || $tval['faculty_abs'] || $tval['detail_cv'] || $tval['detail_abs']){?>
					<span class="util">
						<?if($tval['detail_cv']){?><a class="cv" href="javascript:popup_call('Azure','kind=detail_cv&sid=<?=$tval['detail_key']?>')">CV</a>
						<?}else if($tval['faculty_cv']){?><a class="cv" href="javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=<?=$tval['faculty_sid']?>')">CV</a><?}?>

						
						<?if($tval['detail_abs']){?>
							<a class="abstract" href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$tval['detail_key']?>')">Lecture Note</a>
						<?}else if($tval['faculty_abs']){?>
							<a class="abstract" href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$tval['faculty_sid']?>')">Lecture Note</a>
						<?}?>
					</span>
					<?}?>
				</td>
			</tr>
			<?}?>
		<?}?>
		
	</tbody>
</table>



<?php if($mode == "interval") { 
	$session_detail = ob_get_contents(); //파일내용 변수에 저장
	ob_end_clean(); //출력 버퍼 지우고 출력 버퍼링 종료

	$session_title = $_DATE['date'.$day][$room_sid][$Skey]['title'];
	if( isset($_VOTING['date'.$ev_date][$room_sid]) ) {

		if( strtotime($to_date . " " . $_VOTING['date'.$ev_date][$room_sid]['stime']) <= $_Time['ing'] && $_Time['ing'] <= strtotime($to_date . " " . $_VOTING['date'.$ev_date][$room_sid]['etime'])) {
			$voting = "Y";
		} else {
			$voting = "N";
		}
				
	} else {
		$voting = "N";
	}


	echo json_encode(array("Skey"=>$Skey, "session_detail"=>$session_detail, "session_title"=>$session_title, "speakers"=>$speakers, "voting"=>$voting));exit;
}?>