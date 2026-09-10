<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
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
<div class="popupWrap" id="popupOnair">
	<h1>On Air Session</h1>
	<div class="popupCon">
		<div class="liveNote">
			<ul class="timeInfo">
				<li class="time"><?=date("H i")?></li>
				<li><a href="https://dateful.com/time-zone-converter" target="_blank"><img src="/asset/layout/icon_time_grey.png" alt="">Time Zone<br>Converter</a></li>
			</ul>
		</div>
		<?
		$ready_time = strtotime(date("Y-m-d H:i:s",$_Time['ing'])."+ 40 minutes");
		$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");

		if($room_chk>0){
			
			if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
		
			$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
			//echo $room_query;

			$room_result=$conn->query($room_query);
			if(DB::isError($room_result)) die($room_result->getMessage());
			while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
				//if($r['sid']==8) continue;
				$next_session = $conn->getOne("select count(*) from workshop_session_tbl where room='".$r['sid']."' and del='N' and ev_date='$ev_date' and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']."");
				
				$session_query = "select * from workshop_session_tbl where room='".$r['sid']."' and del='N' and ev_date='$ev_date'  ";
				if($next_session==0){// 미지막 세션일 경우
					$stand_time = strtotime(date("Y-m-d H:i:s",$_Time['ing'])."- 300 minutes");
					//$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$stand_time." order by stime asc limit 0,1 ";
					$session_query .= " order by stime desc limit 0,1 ";
				}else{
					if($_COOKIE['wmember_level']=='M'){
						if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
							$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']."  order by stime asc limit 0,1 ";
						}else{
							$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." order by stime asc limit 0,1 ";
							//$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." and unix_timestamp(concat('$to_date',' ',stime))<=".$ready_time." order by stime asc limit 0,1 ";
						}
						
					}else{
						//$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." and unix_timestamp(concat('$to_date',' ',stime))<=".$ready_time." order by stime asc limit 0,1 ";
						$session_query .= " and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']." order by stime asc limit 0,1 ";
					}
					
				}
				
				$session_result = $conn->query($session_query);
				$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
				$session_result->free();
				
				if(!$session['title']) continue;

				unset($chair_arr);
				unset($close_class);
				$difficulty = $session['difficulty'];
				
				if($session['chair']) $chair_arr[] = $session['chair'];
				if($session['chair2']) $chair_arr[] = $session['chair2'];

				if($ready_time<strtotime($to_date." ".$session['stime'])){
					$close_class="closed";
				}
				if($session['absolute_room']>0 && $r['sid']!=$session['absolute_room']){
					$close_class="closed";
				}
		?>

		<div class="room">
			<dl class="roomInfo">
				<dt>
					<?=$r['title']?>
					<span><?=$session['stime']."~".$session['etime']?></span>	
				</dt>
				<dd>
					<?if($ready_time<strtotime($to_date." ".$session['stime'])){?>
						<a href="javascript:alert('there are no sessions currently available')" class="btnEnter">Enter</a>
					<?}else{?>
						<?if($session['absolute_room']>0){?>
							<a href="javascript:direct_room(<?=$session['absolute_room']?>)" class="btnEnter">Enter</a>
						<?}else{?>
							<a href="javascript:direct_room(<?=$r['sid']?>)" class="btnEnter">Enter</a>
						<?}?>
					<?}?>
				</dd>
			</dl>

			<dl class="session">
				<dt>
					<?=stripslashes($session['title'])?>
				</dt>
				<dd class="chairs">
					<?
					if(count($chair_arr)>0){
						echo implode("<br />",$chair_arr);
					}
					?>
				</dd>
				<dd class="sessionInfo">
					<ul>
						<?
						$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' and hiding_room!='Y' order by sort_num asc";
						//$detail_query .= $sort_sql;
						$detail_result=$conn->query($detail_query);
						if(DB::isError($detail_result)) die($detail_result->getMessage());

						while(is_array($d=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){
							$faculty_cnt = $conn->getOne("select count(*) from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$session['sid']."' and t1.session_detail_sid='".$d['sid']."'");

							unset($faculty_name_arr);
							unset($faculty_cv_arr);
							unset($faculty_abs_arr);
							if($faculty_cnt>0){
								$fquery = "select t2.* from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='$session_sid' and t1.session_detail_sid='".$d['sid']."'";
								$fresult=$conn->query($fquery);
						
								if(DB::isError($fresult)) die($fresult->getMessage());

								
								while(is_array($f=$fresult->fetchRow(DB_FETCHMODE_ASSOC))){
									
									$faculty_name = $f['faculty_name'];
									if($f['faculty_aff']){
										$faculty_name .= "(".$f['faculty_aff'];
										if($f['faculty_country']){
											$faculty_name .= ", ".$f['faculty_country'];
										}
										$faculty_name .= ")";
									}
									$faculty_sid[] = $f['sid'];
									$faculty_cv_file[$f['sid']] = $f['faculty_cv'];
									if($f['faculty_cv']){
										$faculty_cv_arr = "<a href=\"javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=".$f['sid']."')\" class=\"cv\">CV</a>";
									}
									if($f['faculty_abs']){
										$faculty_abs_arr = "<a href=\"javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=".$f['sid']."')\" class=\"abs\">Abstract</a>";
									}
									$faculty_name_arr[] = "<a href=\"faculty_session_list.php?faculty_sid=".$f['sid']."\">".$faculty_name."</a>";
								}
							}else{
								$faculty_name_arr[] = $d['author'];
								if(trim($d['author2'])) $faculty_name_arr[] = $d['author2'];
								if(trim($d['author3'])) $faculty_name_arr[] = $d['author3'];
								if(trim($d['author4'])) $faculty_name_arr[] = $d['author4'];
							}
						?>
						<li>
							<span class="thumb"><img src="<?=$photo_src?>" alt=""></span>
							<span class="time"><?=$d['detail_time']?></span>
							<span class="tit"><?=stripslashes($d['title'])?></span>
							<span class="info">
								<?if($d['time_skip']!='Y'){?>
								<?=implode("<br />",str_replace("(","<br />(",$faculty_name_arr))?>
								<?}?>
							</span>
						</li>
						<?}?>
					</ul>
				</dd>
			</dl>
		</div>
		<?}?>
		<?}?>
	<div>
	<div class="close"><a class="color_close"><img src="/asset/layout/layerpopup_close.png" alt="Close"></a></div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>