	<div class="note">
		This is a list marked in "favorites" (★) in e-posters and sessions.
	</div>


	<h3 class="subTit">E-posters Favorites Lists</h3>
	<div id="my_favor_area" class="scrollArea">
		<ul class="favorList">
			<?
				$query = "select t2.* from e_poster_favor as t1 inner join e_poster as t2 on t1.psid=t2.sid where t1.usid='".$_COOKIE['wmember_sid']."' and t2.del='N'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($f=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					unset($aff_info);
					if($f['presenter_aff']) $aff_info[] = stripslashes($f['presenter_aff']);
					if($f['country'])  $aff_info[] = ($f['country']);

					$poster_file = $conn->getOne("select filename from e_poster_file where psid='".$f['sid']."' order by sort_num asc limit 0,1");
					$on_check = $conn->getOne("select count(*) from e_poster_favor where usid='".$_COOKIE['wmember_sid']."' and psid='".$f['sid']."'");
					$my_like = $conn->getOne("select count(*) from e_poster_like where usid='".$_COOKIE['wmember_sid']."' and psid='".$f['sid']."'");
					$total_like = $conn->getOne("select count(*) from e_poster_like where psid='".$f['sid']."'");
			?>
			<li class="on" id="F_area<?=$f['sid']?>">
				<a href="/poster/view.php?sid=<?=$f['sid']?>&category=<?=$f['category']?>">
					<span class="num"><?=$f['poster_number']?></span>
					<span class="thumb">
						<?if($poster_file){?>	
							<img src="<?=$_Azure['link']?>upload/e_poster/thumb/<?=$poster_file?>" alt="">
						<?}?>
					</span>
					<span class="tit"><?=stripslashes($f['subject'])?></span>
				</a>
				<a href="javascript:favor_list_chk(<?=$f['sid']?>,'add');$('#F_area<?=$f['sid']?>').remove();" id="favor_<?=$f['sid']?>" class="favor <?if($on_check>0){?>on<?}?>">Favor</a>
			</li>
			<?}?>
		</ul>
	</div>


	<?
		$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
		$date_count = date("d",$chkdate);
		$ex_sdate = explode("-",$_Webinar['sdate']);

		$Scnt = $conn->getOne("select count(t1.sid) from session_favor_tbl as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid where usid='".$_COOKIE['wmember_sid']."'");
		if($Scnt>0){
		$query = "select t2.* from session_favor_tbl as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid where usid='".$_COOKIE['wmember_sid']."' order by ev_date asc, stime asc";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	?>	

	<h3 class="subTit">Session Favorites Lists</h3>
	<div id="my_favor_area" class="scrollArea">

		<?
		while(is_array($d=$session=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($session['ev_date']-1), $ex_sdate[0]));

			unset($chair_arr);

			if($session['chair']) $chair_arr[] = stripslashes($session['chair']);
			if($session['chair2']) $chair_arr[] = stripslashes($session['chair2']);
			if($session['chair3']) $chair_arr[] = stripslashes($session['chair3']);
			if($session['chair4']) $chair_arr[] = stripslashes($session['chair4']);


			unset($On_air);
			if(strtotime($to_date." ".$session['stime'])<=$_Time['ing'] && strtotime($to_date." ".$session['etime'])>=$_Time['ing']){
				$On_air ="Y";
			}
		?>
		<table class="session type3" id="session<?=$d['sid']?>">
			<colgroup>
				<col style="width: 10%;">
				<col style="width: *;">
			</colgroup>
			<tbody>
				
				<tr class="sessionTit">
					<th>
						<span><?=Days_convert($to_date,"M.D(w)","s")?></span>
						<?=$session['stime']."-".$session['etime']?>
					</th>
					<td>

						<span class="room" pub-room=""> <?=$_Day['room_title'][$session['room']]?></span>
						<!-- <span class="room" pub-room="(Room <?=$d['room']?>)"> <?=$_Day['room_title'][$session['room']]?></span> -->


						<span class="tit">
							<?=stripslashes($session['code_title'])?> (<?=$session['code']?>)
							<span class="type">
								<span class="<?=$_PROGRAM['lang_class'][$session['lang']]?>"><?=$_PROGRAM['lang_code'][$session['lang']]?></span>
								<?if($d['part']){?><span class="ch"><?=$session['part']?></span><?}?>
								<?if($d['difficulty']){?><span class="<?=$_PROGRAM['difficulty_code'][$session['difficulty']]?>"><?=$_PROGRAM['difficulty'][$session['difficulty']]?></span><?}?>
							</span>
						</span>
						<?=stripslashes($session['title'])?>

						<span class="util">
							<?if($On_air == 'Y') {?>
							<a href="javascript:direct_room(<?=$d['room']?>)" class="onair">On-Air</a>
							<?}?>
							<!-- <a href="#" class="vod">VOD</a> -->
							<a href="/load/session_evaluation.php?session_sid=<?=$session['sid']?>" class="eval Load_Base" Wsize="1000" Hsize="800" Tsize="50">Session Evaluation</a>
						</span>
					</td>

					<?if($chair_arr){?>
					<tr class="chairs">
						<th>Chair<?if(count($chair_arr)>1){?>s<?}?></th>
						<td>
							<?=implode(", ",str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$chair_arr))?>

							<span class="util">
								<?
								$session_favor_chk = $conn->getOne("select count(sid) from session_favor_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='".$d['sid']."'");
								?>
								<a href="javascript:session_favor_remove('<?=$d['sid']?>','<?=$session_favor_chk ? 'del' : 'add'?>')" id="favor_btn<?=$d['sid']?>" class="favor<?if($session_favor_chk){?> on<?}?>">Session Favorite</a>
							</span>
						</td>
					</tr>
					<?}?>

					<?
					$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' ";
					if($keyword){
						$detail_query .= " and (title like '%$keyword%' or author like '%$keyword%' or author_position_co like '%$keyword%')";
					}
					$detail_query .= " order by sort_num asc";
					$detail_query .= $sort_sql;
					$detail_result=$conn->query($detail_query);
					if(DB::isError($detail_result)) die($detail_result->getMessage());

					$set_time = $ex_sdate_arr[0]." ".$d['stime'];


					
					while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))) {
						unset($author_arr);
						
						unset($pt_total_time);
						if($detail['pt_time']){
							$ex_pt = explode("/",$detail['pt_time']);
							$pt_total_time = $ex_pt[0]+$ex_pt[1];
							$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
						}

						$faculty_sid = $conn->getOne("select t2.sid from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'");

					
						$author_arr[] = $detail['author'].($detail['country']?" (".$detail['country'].")":"");
						if(trim($detail['author2'])) $author_arr[] = $detail['author2'].($detail['country2']?" (".$detail['country2'].")":"");
						if(trim($detail['author3'])) $author_arr[] = $detail['author3'].($detail['country3']?" (".$detail['country3'].")":"");
						if(trim($detail['author4'])) $author_arr[] = $detail['author4'].($detail['country4']?" (".$detail['country4'].")":"");
					?>

					<tr>
						<th>
							<?if($detail['time_skip']!='Y'){?>
							<?=date("H:i",strtotime($set_time))?>-<?=$set_start?>
							<?}?>
						</th>
						<td>
							<span class="tit"><?=str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",stripslashes($detail['title']))?></span>
							
							<?
								if($author_arr){
									foreach($author_arr as $tkey=>$tval){
										echo "<div>".str_replace($keyword,"<b style='color:#0027ff;background:#ffeb3b;'>$keyword</b>",$tval)."</div>";
									}
								}
							?>

							<span class="util">
								<?if($detail['cv_file']){?>
								<a href="javascript:popup_call('Azure','kind=detail_cv&sid=<?=$detail['sid']?>')" class="cv">CV</a>
								<?}else{?>
									<?
										$faculty_cv = $conn->getOne("select faculty_cv from faculty_tbl where sid='$faculty_sid'");
										if($faculty_cv){
											?>
											<a href="javascript:popup_call('Azure','kind=faculty_cv&faculty_sid=<?=$faculty_sid?>')" class="cv">CV</a>
											<?
										}
									?>
								<?}?>
								<?if($detail['abs_file']){?>
									<a href="javascript:popup_call('Azure','kind=detail_abs&sid=<?=$detail['sid']?>')" class="abstract">Lecture Note</a>
								<?}else{?>
									<?
										$faculty_abs = $conn->getOne("select faculty_abs from faculty_tbl where sid='$faculty_sid'");
										if($faculty_abs){
											?>
											<a href="javascript:popup_call('Azure','kind=faculty_abs&faculty_sid=<?=$faculty_sid?>')" class="abstract">Lecture Note</a>
											<?
										}
									?>
								<?}?>
							</span>
						</td>
					</tr>

					<?
						if($detail['pt_time']){
							$set_time = $ex_sdate_arr[0]." ".$set_start;
						}
					}
					?>
				</tr>
				
			</tbody>
		</table>
		<?}?>
	</div>
	<?}?>




	<h3 class="subTit">Invited Guests Favorites  List</h3>
	<div id="my_favor_area" class="scrollArea">
		<table class="tblDef invited">
		<colgroup>
			<col style="width: 15%;">
			<col style="width: *;">
			<col style="width: 10%;">
		</colgroup>
		<tbody>
			<?
				$query = "select t2.* from faculty_favor_tbl as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.usid='".$_COOKIE['wmember_sid']."'";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($f=$result->fetchRow(DB_FETCHMODE_ASSOC))){

					$f_link = "/load/faculty_session_list.php?type=invite&faculty_sid=" . $f['sid'];
			?>
			<tr>
				<td><a href="<?=$f_link?>" class="Load_Base" Wsize="800" Hsize="600" Tsize="200"><?=$f['faculty_name']?></a></td>
				<td><?=$f['faculty_aff']?></td>
				<td><?=$f['faculty_country']?></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	</div>


	<script>
		function session_favor_remove(sid,mode){
			$.ajax({
				type:"POST",
				url:"/load/session_favor.php",
				data:"sid="+sid+"&mode="+mode,
				async:false,
				success:function(msg){
					var parse_data = JSON.parse(msg);
					if(parse_data.push=='R'){
						$('#session'+sid).remove();
					}else if(parse_data.push=='D'){
						$('#session'+sid).remove();
					}else{
						alert("에러가 발생하였습니다. 잠시후에 다시 이용해주세요");
					}
				}
			});
			
		}
	</script>