<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==false){
		//PutMessageBack("접근이 불가능합니다.");
		//exit;
	}
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}
	
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	$(function(){
		$('.hide_yn').on('click',function(){
			
			$(".hide_yn").not($(this)).prop('checked',false);
			var keyval = $(this).val();
			
			if($(this).is(':checked')==true){
				var chkval = "Y";
			}else{
				var chkval = "N";
			}
			$.ajax({
				type:"POST",
				url:"/session/hide_chk.php",
				data:"keyval="+keyval+"&chkval="+chkval,
				success:function(msg){
					
				}
			});
		});

		$(".sort_table").tableDnD({ 
			//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
			onDragStyle : 'dragRow2', 
			onDropStyle : 'dragRow2', 
			onDragClass: 'dragRow2',
			onDragStart: function(table, row){ 
				onDragClass: 'dragRow';
			},
			onDrop: function(table, row){ 
				var rows = table.tBodies[0].rows;
				var debugStr = "";
				var debugStr = new Array();
				for (var i=0; i<rows.length; i++) {
					//debugStr += rows[i].id + "||"; 
					debugStr[i] = rows[i].id; 
				}
				var join_sort = debugStr.join(",");
				$.ajax({
					type:"POST",
					url:"/session/sort_change.php",
					data:"sort_val="+join_sort,
					cache:false,
					async:false,
					success:function(msg){
						if(msg=='Y'){
							alert("변경되었습니다.");
							location.reload();
						}
					}
				});
			}
		});
		$('#session_detail_chk').on('click',function(){
			if($(this).is(':checked')==true){
				$('.session_detail_tr').hide();
			}else{
				$('.session_detail_tr').show();
			}
		});
	});
</script>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}
</style>
<div >
	<div class="btn" style="float:left;">
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=all" <?if($ev_date=='all'){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i>ALL</a></li>
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" class="<?if($ev_date==$date){?>btnRed<?}else{?>btnBdGrey<?}?>"><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
	<div class="btn" style="float:right;">
		<a href="excel_evaluation.php" class="btnGreen2 withIcon"><i class="fas fa-download" style="font-size:15px;padding-top:0px;"></i>Excel Download</a>
	</div>
</div>
<?
	/*$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		if(!$room){
			//$room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
			$rquery = "select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N'  ";
			if($ev_date!='all'){
				$rquery .= " and t2.ev_date='$ev_date'";
			}
			$rquery .= " group by t2.room limit 0,1";
			$room = $conn->getOne($rquery);
		}
	}*/
?>
<div style="clear:both;">
	<div class="btn tp10 bp10" style="float:left;">
		<a href="javascript:popup_call('excel/upload','kind=sessions')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Session Excel 등록</a>
		<a href="javascript:popup_call('excel/upload','kind=session_detail')" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Session Detail Excel 등록</a>
		<a href="session_sorting.php?ev_date=<?=$ev_date?>" class="btnSky withIcon"><i class="fa fa-sort" style="font-size:15px;padding-top:0px;"></i>Session Sorting</a>
		<?if($room){?>
		<a href="javascript:popup_call('TableGender/session','ev_date=<?=$ev_date?>&room=<?=$room?>')" class="btnGrey withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Session 개별등록</a>
		<?}?>
		
	</div>
	<div class="btn tp10 bp10" style="float:right;">
		<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>" class="<?if(!$room){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i>ALL</a>
		<?
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>	
		<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>&room=<?=$r['sid']?>" class="<?if($room==$r['sid']){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i><?=$r['title']?></a>
		<?}?>
	</div>
</div>

<?
	
	$query = "select * from workshop_session_tbl where del='N' ";
	if($room) $query .= " and room='$room'";
	if($ev_date!='all'){
		$query .= " and ev_date='$ev_date'";
	}
	$query .= " order by ev_date asc, room asc, stime asc";
	
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>

<table class="tblDef">
	<colgroup>
		<col style="width: 8%;">
		<!-- <col style="width: 5%;">
		<col style="width: 8%;"> -->
		<col style="width: 5%;">
		<col style="width: 4%;">
		<col style="width: 4%;">
		<col style="">
		<col style="width: 20%;">
		<col style="width: 75px;">
		<col style="width: 75px;">
		<col style="width: 75px;">
	</colgroup>
	<tbody>

		<tr>
			<th style="background:#263238;color:#ffffff;text-align:center;" colspan=9>
				<div style="width:100%;display:flex;justify-content: center;">
					<div style="float:left;font-size:16px;"><input type="checkbox" class="Cookie_chk" id="session_detail_chk" <?if($_COOKIE['session_detail_chk']){?>checked<?}?> style="width:18px;height:18px;"><label for="session_detail_chk" >대세션 타이틀만 확인합니다.</label></div>
					<div class="btn" style="float:right;padding-left:30px;">
						<span class="btnAdmin medium yellow"><button type="button" onclick="popup_call('TableGender/session_detail','session_sid=<?=$d['sid']?>')"><i class="fas fa-wrench" style="font-size:13px;padding-top:0px;"></i>Session 일괄수정</button></span>
						<!-- <a href="javascript:popup_call('excel/upload','kind=sessions')" class="btnGrey2 withIcon"><i class="fas fa-wrench" style="font-size:15px;padding-top:0px;"></i>Session 일괄수정</a> -->
					</div>
				</div>
			</th>
		</tr>
		<tr>
			<th style="background:#263238;color:#ffffff;">시간</th>
			<!-- <th style="background:#263238;color:#ffffff;">Specialty</th>
			<th style="background:#263238;color:#ffffff;">Specialty2</th> -->
			<th style="background:#263238;color:#ffffff;">장소</th>
			<th style="background:#263238;color:#ffffff;">코드</th>
			<th style="background:#263238;color:#ffffff;">언어</th>
			<th style="background:#263238;color:#ffffff;">세션 명</th>
			<th style="background:#263238;color:#ffffff;">좌장</th>
			<th style="background:#263238;color:#ffffff;">Hiding<br>(Program)</th>
			<th style="background:#263238;color:#ffffff;">Hiding<br>(Room)</th>
			<th style="background:#263238;color:#ffffff;">관리</th>
		</tr>
		<?
		$ev_num = 0;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

			$start_time = $ex_sdate_arr[0]." ".$d['stime'];
			$end_time = $ex_sdate_arr[0]." ".$d['etime'];
			
			unset($stay_time);
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
			
			if($d['session_file']){
				$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
			}

			unset($chair_arr);
			if($d['chair']) $chair_arr[] = stripslashes($d['chair']);
			if($d['chair2']) $chair_arr[] = stripslashes($d['chair2']);
			if($d['chair3']) $chair_arr[] = stripslashes($d['chair3']);
			if($d['chair4']) $chair_arr[] = stripslashes($d['chair4']);
		?>
		<?
		if($ev_date=='all' && $d['ev_date']!=$ev_num){
			$ev_num++;
		?>
		<tr>
			<td colspan=10 class="al" style="background:#FF0000;height:26px;font-weight:bold;color:#ffffff;">
				<span style="font-size:13px;">▷</span><i style="font-size:15px;"> <?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));?></i>
			</td>
		</tr>
		<?}?>
		<tr >
			<th style="background:#445964;color:#ffffff;" ><?=$d['stime']?> ~ <?=$d['etime']?><br />(<?=$stay_time?>)</th>
			<!-- <th style="background:#445964;color:#ffffff;" ><?=$d['part']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['part2']?></th> -->
			<th style="background:#445964;color:#ffffff;"><?=$room_name[$d['room']]?></th>
			<th style="background:#445964;color:#ffffff;"><?=$d['code']?></th>
			<th style="background:#445964;color:#ffffff;"><?=$_PROGRAM['lang_code'][$d['lang']]?></th>
			<th style="text-align:left;background:#445964;color:#ffffff;font-size:17px;">
				<div style="float:left;">
				<?=stripslashes($d['title'])?>
				<?if($d['logo_file']){?><img src="/upload/session/<?=$d['logo_file']?>"><?}?>
				<?if($d['session_file']){?><img src="<?=IconType3($d['session_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"><?}?>
				</div>
				<div style="float:right;">
					<div><span class="btnAdmin small empty green" style='width:130px;'><button type="button" onclick="popup_call('TableGender/session_detail','session_sid=<?=$d['sid']?>')">Detail Progeam 등록</button></span></div>
					<div><span class="btnAdmin small empty orange" style='width:130px;'><button type="button" onclick="popup_call('session/evaluation','session_sid=<?=$d['sid']?>')">Session Evaluation</button></span></div>
					<?if($detail_cnt>0){?>
					<!-- <div><span class="btnAdmin small empty orange"><button type="button" onclick="popup_call('TableGender/session_detail','session_sid=<?=$d['sid']?>')">Detail Progeam 수정</button></span></div> -->
					<?}?>
				</div>
			</th>
			<th style="background:#445964;color:#ffffff;font-size:11px;" class="ar">
				<?
				if(count($chair_arr)>0){
					echo implode("<br />",$chair_arr);
				}
				?>
			</td>
			<td style="cursor:default;background:#445964;color:#ffffff;">
				<input type="checkbox" style="width:20px;height:20px;margin:0px;" key="<?=$d['sid']?>" kind="session_hide" class="check_value" <?if($d['hiding']=='Y'){?>checked<?}?>>
			</td>
			<td style="cursor:default;background:#445964;color:#ffffff;">
				<input type="checkbox" style="width:20px;height:20px;margin:0px;" key="<?=$d['sid']?>" kind="session_hide_room" class="check_value" <?if($d['hiding_room']=='Y'){?>checked<?}?>>
			</td>
			<th style="background:#445964;color:#ffffff;">
				<div><span class="btnAdmin small lightBlue" style="width:97%;"><button type="button" onclick="popup_call('TableGender/session','sid=<?=$d['sid']?>')" style="width:100%;">수정</button></span></div>
				<div style="padding-top:2px;"><span class="btnAdmin small  red" style="width:97%;"><button type="button" onclick="common_delete('<?=$d['sid']?>','sessions')" style="width:100%;">삭제</button></span></div>
				
			</th>
		</tr>
		<?
			if($detail_cnt>0){
		?>
		<tr class="session_detail_tr" <?if($_COOKIE['session_detail_chk']){?>style="display:none;"<?}?>>
			<td colspan=9 style="padding:0px;margin:0px;border-left:0px;">
				<table class="tblDef sort_table" style="border:0px;padding:0px;" id="<?=$d['sid']?>">
					<colgroup>
						<col style="width: 8%;">
						<col style="*">
						<col style="width: 200px;">
						<col style="width: 125px;">
						<col style="width: 400px;">
						<col style="width: 75px;">
						<col style="width: 75px;">
						<col style="width: 75px;">
						
					</colgroup>
					<thead>
						<tr >
							<th style="background:#6B8A9A;">PT/DC</th>
							<th style="background:#6B8A9A;">Session Detail Title</th>
							<th style="background:#6B8A9A;">Presentation No.</th>
							<th style="background:#6B8A9A;">Abstract No.</th>
							<th style="background:#6B8A9A;">Speaker</th>
							<th style="background:#6B8A9A;">Hiding<br>(Program)</th>
							<th style="background:#6B8A9A;">Hiding<br>(Room)</th>
							<th style="background:#6B8A9A;">관리</th>
						</tr>
					</thead>
					<tbody>
						<?
						
							$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' order by sort_num asc";
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
								
								
						?>
						<tr id="<?=$detail['sid']?>" <?if($detail['bg_color']){?>style="background:<?=$detail['bg_color']?> !important;"<?}?>>
							<td style="background:#F8F8F8;">
								<?if($detail['time_skip']=='Y'){?>
									<?=$detail['detail_time']?>
								<?}else{?>
									<?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?>-<?=$set_start?> <br />(<?=$detail['pt_time']?>분)<?}?>
								<?}?>
							</td>
							
							<?if($detail['time_skip']=='Y'){?>
								<td class="al lp10"><?=$detail['plan_intent']?></td>
							<?}else{?>
								<td class="al lp10"><?=stripslashes($detail['title'])?></td>
							<?}?>
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
										$faculty_name .= "&nbsp;&nbsp;&nbsp;<i class=\"fas fa-link\" style=\"font-size:16px;color:#127DAB;\" onclick=\"popup_call('session/faculty','sid=".$f['sid']."')\"></i>";

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
							<td style="cursor:default;">
								<input type="checkbox" style="width:20px;height:20px;margin:0px;" key="<?=$detail['sid']?>" kind="session_detail_hide" class="check_value" <?if($detail['hiding']=='Y'){?>checked<?}?>>
							</td>
							<td style="cursor:default;">
								<input type="checkbox" style="width:20px;height:20px;margin:0px;" key="<?=$detail['sid']?>" kind="session_detail_hide_room" class="check_value" <?if($detail['hiding_room']=='Y'){?>checked<?}?>>
							</td>
							<td style="cursor:default;">
								<img src="/image/icon/icon_modify.png" onclick="popup_call('TableGender/session_detail','sid=<?=$detail['sid']?>')">
								<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$detail['sid']?>','session_detail')">
							</td>
						</tr>
						<?
							if($detail['pt_time']){
								$set_time = $set_start;
							}
						}?>
						
					</tbody>
				</table>
			</td>
		</tr>
		<?}?>
		<?}?>
	</tbody>
</table>
<div class="btn tp10 bp10 ar">
	<a href="create_session.php" class="btnGreen2 withIcon"><i class="fas fa-upload" style="font-size:15px;padding-top:0px;"></i>Session Config 생성</a>
</div>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>