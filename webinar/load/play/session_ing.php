<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
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

	
?>
<dl>
	<dt>On Air Session</dt>
	<dd class="scrollArea">

		<?
		foreach($_DATE['date'.$day] as $tkey=>$tval){
			
			foreach($_DATE['date'.$day][$tkey] as $tskey=>$tsval){
				if(strtotime($to_date." ".$tsval['session_stime'])<$_Time['ing'] && strtotime($to_date." ".$tsval['session_etime'])>$_Time['ing']){
				unset($lecture_title);
				unset($cv_file);
				unset($abs_file);
				unset($detail_abs);
				
				foreach($_DATE['date'.$day.'_detail'][$tkey][$tskey] as $dkey=>$dval){
					$ex_dval = explode("-",$dval['detail_time']);
					unset($chair_arr);
					if($tsval['chair']) $chair_arr[] = $tsval['chair'];
					if($tsval['chair2']) $chair_arr[] = $tsval['chair2'];
					if($tsval['chair3']) $chair_arr[] = $tsval['chair3'];

					

					if(strtotime($to_date." ".$ex_dval[0])<$_Time['ing'] && strtotime($to_date." ".$ex_dval[1])>$_Time['ing']){
						$fsid = $dval['faculty_sid'];
						$lecture_title = $dval['detail_title'];
						$lecture_author = str_replace("("," (",$dval['detail_author']);
						$lecture_position = $dval['detail_author_position'];
						$lecture_time = $dval['detail_time'];
						$cv_file = $dval['faculty_cv'];
						$abs_file = $dval['faculty_abs'];
						$detail_abs = $dval['detail_abs'];
						$detail_key = $dval['detail_key'];
					}	
					
					
				}
				if($tsval['absolute_room'] && $tsval['absolute_room']!=$tkey) continue;
		?>
		<dl class="session">
			<dt><?if($tsval['title']){?><span class="lecture"><?=stripslashes($tsval['title'])?></span><?}?></dt>
			<dd class="room">Channel<?=$tkey?> <span><?=Days_convert($to_date,'M D (w)')?>, <?=$tsval['session_stime']?>-<?=$tsval['session_etime']?></span></dd>
			<?if(count($chair_arr)>0){?><dd>Chairperson<?if(count($chair_arr)>1){?>s<?}?> :  <?=stripslashes(implode(", ",$chair_arr))?></dd><?}?>
			<dd>
				<table>
					<colgroup>
						<col style="width:12%;" />
						<col style="width:*;" />
						<col style="width:40%;" />
					</colgroup>
					<tbody>
						<tr>
							<td><?=$lecture_time?> </td>
							<td>
								<?=$lecture_title?>
								<span class="btn">
									<?if($cv_file){?><a href="javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=<?=$fsid?>')">CV</a><?}?>
									<?if($detail_abs){?>
										<a href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$detail_key?>')">Abstract</a>
									<?}else{?>
										<?if($abs_file){?><a href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$fsid?>')">Abstract</a><?}?>
									<?}?>
								</span>

							</td>
							<td><?=$lecture_author?></td>
						</tr>
					</tbody>
				</table>
			<dd>
				<a href="javascript:going_room(<?=$tkey?>)" class="enter">Enter</a>
			</dd>
		</dl>

		<!-- <dl class="session">
			<dt>Room <?=$_Day['room_key'][$tkey]?> <span>
			<?=Days_convert($to_date,'M D (w)')?>, <?=$tsval['session_stime']?>-<?=$tsval['session_etime']?></span></dt>
			<dd>
				<span class="session"><?=stripslashes($tsval['title'])?></span>
				<?if($lecture_title){?><span class="lecture"><?=stripslashes($lecture_title)?></span><?}?>
				<?if($lecture_author){?><span class="group"><?=stripslashes($lecture_author)?> (<?=stripslashes($lecture_position)?>)</span>	<?}?>
				<a href="javascript:going_room(<?=$tkey?>)" class="enter">Enter</a>
			</dd>
		</dl> -->
		<?
				}	
			}
		?>
		<?}?>
		<!-- <dl class="session">
			<dt>Room 2 <span>August 28 (Fri), 08:00-09:30</span></dt>
			<dd>
				[Symposium 01] UGI 1 :  Laparoscopic Endoscopic <br>
				Cooperative Surgery (LECS) for Gastric 
				<a href="#" class="enter">Enter</a>
			</dd>
		</dl>

		<dl class="session">
			<dt>Room 3 <span>August 28 (Fri), 08:00-09:30</span></dt>
			<dd>
				[Symposium 01] UGI 1 :  Laparoscopic Endoscopic <br>
				Cooperative Surgery (LECS) for Gastric 
				<a href="#" class="enter">Enter</a>
			</dd>
		</dl> -->

	</dd>
</dl>
<p class="close"><a href="#" onclick="$('div.utilPopup').hide();return false"><img src="/asset/player/popup_close.png" alt="Close"></a></p>