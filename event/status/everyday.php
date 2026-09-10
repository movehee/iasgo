<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$day_query = "select signdate from login_view_tbl where signdate>='2023-09-23' group by signdate order by signdate desc";
	$day_result=$conn->query($day_query);
	if(DB::isError($day_result)) die($day_result->getMessage());
	$dayNum =1;
	while(is_array($dd=$day_result->fetchRow(DB_FETCHMODE_ASSOC))){	
		if($dayNum=='1'){
			$fir_date = $dd['signdate'];
		}
		$everydays[] = $dd['signdate'];
		$dayNum++;
	}
	if(!$pick_day) $pick_day = date("Y-m-d");

	$login_cnt = $conn->getOne("select count(*) from login_view_tbl where signdate='$pick_day'");
?>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}
</style>
<script>
	function change_yy(str){
		location.href='everyday.php?pick_day='+str
	}
</script>
<div >
	<?if($everydays){?>
	<div class="btn" style="float:left;">
		<select id="pick_day" onchange="change_yy(this.value)">
			<?foreach($everydays as $tkey=>$tval){?>
			<option value="<?=$tval?>" <?if($pick_day==$tval){?>selected<?}?>><?=$tval?></option>
			<?}?>
		</select>
		
		<!-- <a href="<?=$PHP_SELF?>?pick_day=<?=$tval?>" <?if($pick_day==$tval){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=substr($tval,5,10)?></a></li> -->
		
		
	</div>
	<?}?>
	
</div>
<?
	
	
	$query = "select * from workshop_session_tbl where del='N' ";//and vod!=''
	if($ev_date!='all'){
		//$query .= " and ev_date='$ev_date'";
	}
	$query .= " order by ev_date asc, room asc, stime asc";
	
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div style="clear:both;padding-top:10px;font-size:25px;float:right;font-weight:bold;"><i>Login Count: <?=$login_cnt?></i></div>
<table class="tblDef tp10">
	<colgroup>
		<col style="width: 5%;">
		<col style="width: 8%;">
		<col style="width: 5%;">
		<col style="width: 8%;">
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="">
		<col style="width: 12%;">
		<col style="width: 75px;">
	</colgroup>
	<tbody>

		
		<tr>
			<th style="background:#263238;color:#ffffff;">일자</th>
			<th style="background:#263238;color:#ffffff;">시간</th>
			<th style="background:#263238;color:#ffffff;">Specialty</th>
			<th style="background:#263238;color:#ffffff;">Specialty2</th>
			<th style="background:#263238;color:#ffffff;">장소</th>
			<th style="background:#263238;color:#ffffff;">코드</th>
			<th style="background:#263238;color:#ffffff;">언어</th>
			<th style="background:#263238;color:#ffffff;">세션 명</th>
			<th style="background:#263238;color:#ffffff;">좌장</th>
			<th style="background:#263238;color:#ffffff;">Count</th>
		</tr>
		<?
			$ev_num = 0;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				$start_time = $ex_sdate_arr[0]." ".$d['stime'];
				$end_time = $ex_sdate_arr[0]." ".$d['etime'];
				
				unset($stay_time);
				unset($ex_chair);
				if($d['stime'] && $d['etime']){
					$time = strtotime($end_time)-strtotime($start_time);
					$hh = ($time/60/60)%24;
					$mm = sprintf("%02d", ($time/60)%60);
					$stay_time = "";
					if($hh>0) $stay_time = $hh."시간 ";
					if($mm>0) $stay_time .= $mm."분";
				}

				$rowspan_cnt=1;
				
				$detail_cnt = $conn->getOne("select count(*) from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N'");
				if($detail_cnt>0) $rowspan_cnt++;
				if($d['chair']){
					$ex_chair_position = explode("|",$d['chair_position']);
					$ex_chair = explode("|",$d['chair']);
					$rowspan_cnt++;
					$rowspan_cnt2 = 2;
				}
				if($d['session_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
				}

				//$vod_cnt = $conn->getOne("select count(*) from vod_view_tbl where session_sid='".$d['sid']."' and signdate='$pick_day'");
				
				
		?>
		<tr >
			<th style="background:#445964;color:#ffffff;" ><?=date("m.d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));?></th>
			<th style="background:#445964;color:#ffffff;" ><?=$d['stime']?> ~ <?=$d['etime']?><br />(<?=$stay_time?>)</th>
			<th style="background:#445964;color:#ffffff;" ><?=$d['part']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['part2']?></th>
			<th style="background:#445964;color:#ffffff;">Room <?=$d['room']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['code']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$_PROGRAM['lang_code'][$d['lang']]?></th>
			<th style="font-weight:bold;text-align:left;background:#445964;color:#ffffff;">
				<div style="float:left;">
				<?=$d['title']?>
				<?if($d['session_file']){?><img src="<?=IconType3($d['session_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"><?}?>
				</div>
			</th>
			<th style="background:#445964;color:#ffffff;" class="ar">
				<?if($ex_chair){?>
				<?foreach($ex_chair as $ckey=>$cval){?>
				<div><?=$cval?></div>
				<!-- <?if($ex_chair_position[$ckey]){?><div>(<?=$ex_chair_position[$ckey]?>)</div><?}?> -->
				<?}?>
				<?}?>
			</td>
			<th style="background:#445964;color:#ffffff;font-size:22px;">
				<?=$vod_cnt?>
			</th>
		</tr>

		<?
						
			$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' and time_skip!='Y' order by sort_num asc";
			$detail_query .= $sort_sql;
			$detail_result=$conn->query($detail_query);
			if(DB::isError($detail_result)) die($detail_result->getMessage());

			$set_time = $d['stime'];
			
			while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){	
				unset($pt_total_time);
				if($detail['pt_time']){
					$ex_pt = explode("/",$detail['pt_time']);
					$pt_total_time = $ex_pt[0]+$ex_pt[1];
					$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
				}

				$vod_detail_cnt = $conn->getOne("select count(*) from vod_view_tbl where session_sid='".$detail['sid']."'  and signdate='$pick_day'");
				
				
		?>
		<tr id="<?=$detail['sid']?>" <?if($detail['bg_color']){?>style="background:<?=$detail['bg_color']?> !important;"<?}?>>
			<td style="background:#F8F8F8;"></td>
			<td style="background:#F8F8F8;">
				<?if($detail['time_skip']=='Y'){?>
					<?=$detail['detail_time']?>
				<?}else{?>
					<?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?>-<?=$set_start?> <br />(<?=$detail['pt_time']?>분)<?}?>
				<?}?>
			</td>
			<td class="al lp10" colspan=3></td>
			
			<td>
			<?
				unset($author_code_arr);
				if($detail['author_code']) $author_code_arr[] = $detail['author_code'];
				if($detail['author_code2']) $author_code_arr[] = $detail['author_code2'];
				
				if($detail['pre_num']) echo $detail['pre_num'];
				if(count($author_code_arr)>0){
					echo implode("<br />",$author_code_arr);
				}

			?>
			</td>
			<td><?=$detail['abs_num']?></td>
			<td class="al lp10"><?=stripslashes($detail['title'])?></td>
			<td style="text-align:right;font-size:11px;cursor:default;line-height:180%;">
			<?
				$faculty_cnt = $conn->getOne("select count(*) from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'");
				unset($faculty_name_arr);
				
				if($faculty_cnt>0){
					$fquery = "select t2.* from faculty_matching as t1 inner join faculty_tbl as t2 on t1.faculty_sid=t2.sid where t1.session_sid='".$d['sid']."' and t1.session_detail_sid='".$detail['sid']."'";
					$fresult=$conn->query($fquery);
					if(DB::isError($fresult)) die($fresult->getMessage());

					while(is_array($f=$fresult->fetchRow(DB_FETCHMODE_ASSOC))){
						$faculty_name = $f['faculty_name'];
						if($f['faculty_aff']){
							$faculty_name .= " (".$f['faculty_aff'];
							if($f['faculty_country']){
								$faculty_name .= ", ".$f['faculty_country'];
							}
							$faculty_name .= ")";
						}
						//$faculty_name .= "&nbsp;&nbsp;&nbsp;<i class=\"fas fa-link\" style=\"font-size:16px;color:#127DAB;\" onclick=\"popup_call('session/faculty','sid=".$f['sid']."')\"></i>";

						$faculty_name_arr[] = $faculty_name;
					}
				}else{
					$faculty_name_arr[] = $detail['author'].($detail['country']?" (".$detail['country'].")":"");
					if(trim($detail['author2'])) $faculty_name_arr[] = $detail['author2'].($detail['country2']?" (".$detail['country2'].")":"");
					if(trim($detail['author3'])) $faculty_name_arr[] = $detail['author3'].($detail['country3']?" (".$detail['country3'].")":"");
					if(trim($detail['author4'])) $faculty_name_arr[] = $detail['author4'].($detail['country4']?" (".$detail['country4'].")":"");
				}
				if(count($faculty_name_arr)>0){
					echo implode("<br />",$faculty_name_arr);
				}
			?>
			</td>
			<td><?=$vod_detail_cnt?></td>
		</tr>
		<?
			if($detail['pt_time']){
				$set_time = $set_start;
			}
		}?>
		<?}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>