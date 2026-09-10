<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
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

	require_once $_SERVER['DOCUMENT_ROOT'] . "func/config_detail_times.php";


	if($_COOKIE['wmember_level']!='M'){
		if( $_Time['ing'] < strtotime("2023-09-20")) {
			PutMessageRefreshURL("The access is available from Sep 20.","/enter/");
		}
	


		if( "2022-09-24" < date('Y-m-d')) {
			//PutMessageRefreshURL("there are no sessions currently available","/enter/");
		}
	}
	// print_R($_DATE['date1_detail'][2][1]);
	
	if($day=='1'){
		$room_type="A";
	}else{
		$room_type="B";
	}
?>
<div class="contents">
	<div class="room room<?=$room_type?>">
	<h3><span><?=Days_convert($to_date,"M D (w)")?></span></h3>
	<p class="note">Please select a Room to Enter.</p>

	<div class="roomItem <?=$close_class?>">
	<?
	$ready_time = strtotime(date("Y-m-d H:i:s",$_Time['ing'])."+ 30 minutes");
	$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");

	if($room_chk>0){
		if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
	
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		//echo $room_query;

		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))) {
			
			if($day=='1'){
				if($r['sid']!=1 && $r['sid']!=3  && $r['sid']!=5  && $r['sid']!=9) continue;
			}else{
				if($r['sid']!=1 && $r['sid']!=3  && $r['sid']!=5) continue;
			}
			$next_session = $conn->getOne("select count(*) from workshop_session_tbl where room='".$r['sid']."' and del='N' and ev_date='$ev_date' and unix_timestamp(concat('$to_date',' ',etime))>=".$_Time['ing']."");
			
			$session_query = "select * from workshop_session_tbl where room='".$r['sid']."' and del='N' and ifnull(hiding_room,'')!='Y' and ev_date='$ev_date'  ";
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

			if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
				// echo $session_query . "<br>";
			}
			
			$session_result = $conn->query($session_query);
			$session_result->fetchInto(&$session,DB_FETCHMODE_ASSOC);
			$session_result->free();

			//해당시간 lecture 가져오는 부분
			$session_detail = null;
			if($session) {
				$session_detail_query = "select * from workshop_session_detail_tbl where del='N' and session_sid=" . $session['sid'] . " and unix_timestamp(concat('$to_date',' ',SUBSTRING_INDEX(detail_time,'-',-1)))>=".$_Time['ing']." order by detail_time asc limit 0,1 ";
				$session_detail_result = $conn->query($session_detail_query);
				$session_detail_result->fetchInto(&$session_detail,DB_FETCHMODE_ASSOC);
				$session_detail_result->free();
			}

			// print_R($session_detail);

			
			
			// if(!$session['title']) continue;
			if($session) {

			$room_close = false;

			unset($chair_arr);
			unset($close_class);
			$difficulty = $session['difficulty'];
			
			if($session['chair']) $chair_arr[] = $session['chair'];
			if($session['chair2']) $chair_arr[] = $session['chair2'];
			if($session['chair3']) $chair_arr[] = $session['chair3'];

			if($ready_time<strtotime($to_date." ".$session['stime'])){
				$close_class="disabled";
			}
			if($session['absolute_room']>0 && $r['sid']!=$session['absolute_room']){
				$close_class="disabled";
			}

			if( $ev_date=="1" && $r['sid'] == "6") { //예외처리
				$close_class="disabled";
			}

			if( $session['sid'] == "167" || $session['sid'] == "174") { //예외처리
				$room_close = true;
				$close_class="disabled";
			}



			if( $ev_date == "5" && $_Time['ing'] > strtotime("2022-09-24 13:55:00") ) { //예외처리
				if( $r['sid'] == "9" ) {

				} else {
					$room_close = true;
					$close_class="disabled";
				}
			}

			if( $r['sid'] == "9" ) { $close_class = ""; }
			else {
				// $room_close = true;
				$close_class="disabled";
			}
			
			
			
			?>
			
				<dl class="roomInfo">
					<dt>
						<span class="type">
							<span class="<?=$_PROGRAM['lang_class'][$session['lang']]?>"><?=$_PROGRAM['lang_code'][$session['lang']]?></span>
							<?if($session['part']){?><span class="ch"><?=$session['part']?></span><?}?>
							<?if($session['difficulty']){?><span class="<?=$_PROGRAM['difficulty_code'][$session['difficulty']]?>"><?=$_PROGRAM['difficulty'][$session['difficulty']]?></span><?}?>
						</span>
						<span class="room"><?=$_Day['room_title'][$r['sid']]?></span>
						<span class="tit"><?=stripslashes($session['code_title'])?> (<?=$session['code']?>)</span>
						<span class="info"><?=stripslashes($session['title'])?></span>
						<span class="time"><?=$session['stime']?>-<?=$session['etime']?></span>
					</dt>

					<!-- <dd class="util">
						<a class="detail">Enter</a>

							<?if(/*$ready_time<strtotime($to_date." ".$session['stime']) || */$room_close){?>
								<a href="javascript:alert('there are no sessions currently available')">Enter</a>
							<?}else{?>
								<?if($session['absolute_room']>0){?>
									<a href="javascript:direct_room(<?=$session['absolute_room']?>)">Enter</a>
								<?}else{?>
									<a href="javascript:direct_room(<?=$r['sid']?>)">Enter</a>
								<?}?>
							<?}?>


					</dd> -->
					<dd class="scrollArea">
						<ul>
							<?
							$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' and hiding_room!='Y' order by sort_num asc";
							//$detail_query .= $sort_sql;
							$detail_result=$conn->query($detail_query);
							if(DB::isError($detail_result)) die($detail_result->getMessage());

							while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))) {
								$faculty_query = "select t2.sid,t2.faculty_photo,t2.faculty_name,t2.faculty_aff,t2.faculty_country from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$session['sid']."' and session_detail_sid='".$detail['sid']."'";
								$faculty_result = $conn->query($faculty_query);
								$faculty_result->fetchInto(&$f,DB_FETCHMODE_ASSOC);
								$faculty_result->free();
								

								if($f['faculty_photo']){
									$photo_src = $_CONFIG['Admin_link']."upload/faculty/".$f['faculty_photo'];
								}else{
									$photo_src = null;
								}
								unset($faculty_name_arr);
								if($f['sid']){
									// $faculty_name = $f['faculty_name'];
									// if($f['faculty_aff']){
									// 	$faculty_name .= " (".$f['faculty_aff'];
									// 	if($f['faculty_country']){
									// 		$faculty_name .= ", ".$f['faculty_country'];
									// 	}
									// 	$faculty_name .= ")";
									// }

									$faculty_name = $f['faculty_name'];
									if($f['faculty_country']){
										$faculty_name .= " (".$f['faculty_country'].")";
									}

									$faculty_name_arr[] = "<a href=\"/load/faculty_session_list.php?prev=award&faculty_sid=".$f['sid']."\" class=\"Load_session_list\">".$faculty_name."</a>";
								}else{
									$faculty_name_arr[] = stripslashes($detail['author']);
								}


								$active_class="";
								$ex_time = explode("-",$detail['detail_time']);
								if(strtotime($to_date." ".$ex_time[0])<$_Time['ing'] && strtotime($to_date." ".$ex_time[1])>$_Time['ing']){
									$active_class="active";
								}
							?>
							<li class="<?=$active_class?>">
								<span class="tit"><?=$detail['title']?></span>
								<span class="name">
								<?
									if(count($faculty_name_arr)>0){
										echo implode("",$faculty_name_arr);
									}
								?>
								</span>
								<?if($photo_src){?>
									<span class="photo"><img src="<?=$photo_src?>"></span>	
								<?}else{?>
									<span class="photo"><img src="/asset/layout/roomInfo.png"></span>	
								<?}?>
							</li>
							<?}?>
						</ul>
					</dd>
					<dd class="util">
						<?if(/*$ready_time<strtotime($to_date." ".$session['stime']) || */$room_close){?>
							<a href="javascript:alert('there are no sessions currently available')">Enter</a>
						<?}else{?>
							<?if($session['absolute_room']>0){?>
								<a href="javascript:direct_room(<?=$session['absolute_room']?>)">Enter</a>
							<?}else{?>
								<a href="javascript:direct_room(<?=$r['sid']?>)">Enter</a>
							<?}?>
						<?}?>
					</dd>
				</dl>
				
			<?}?>
		<?}?>
	<?}?>
</div>
</div>
</div>

<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>