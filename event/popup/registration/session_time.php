<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	include_once $_SERVER['DOCUMENT_ROOT']."func/config_time.php";
	procAdminLoginChk();

	$sid = isset($sid) ? (int)$sid : 0;
	if ($sid < 1) {
		PutMessageBack('잘못된 접근입니다.');
	}

	$group_key = isset($group_key) ? trim($group_key) : '';

	$checkin_tbl = 'checkin_tbl';
	$detail_tbl = 'checkin_detail_tbl';

	$query = "select * from ".$checkin_tbl." where sid='".$sid."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	if (!$d || !$d['sid']) {
		PutMessageBack('데이터가 없습니다.');
	}

	$loop_cnt = 0;
	if (isset($_TIME['session'][$d['day']])) {
		$loop_cnt = count($_TIME['session'][$d['day']]);
	}
	$time_max_count = $loop_cnt;
	$scoreMaxHour = isset($_TIME['score_max_hour']) ? (int)$_TIME['score_max_hour'] : 6;

	$name_kr = $conn->getOne("select name_kr from registration_tbl where sid='$d[usid]'");
	$classification = $conn->getOne("select classification from registration_tbl where sid='$d[usid]'");
	
	$name_info = $name_kr."(".$_REG['class_kind'][$classification].")";
	unset($stay_hours);
	unset($stay_min);
	unset($score);
	unset($sum_score);
	unset($sum_times);

	for($i=1;$i<=$loop_cnt;$i++){
		if($d['s'.$i.'_sdate']>0) ${"s".$i."_stime"} = date("H:i",$d['s'.$i.'_sdate']);
		if($d['s'.$i.'_edate']>0)  ${"s".$i."_etime"} = date("H:i",$d['s'.$i.'_edate']);

		${"mm".$i}=0;
		${"s".$i."_sdate"} = "";
		${"s".$i."_edate"} = "";

		${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
		${"s".$i."_edate"} = $d['s'.$i.'_edate'];
		if(strtotime($_TIME['session'][$d['day']][$i][0])>$d['s'.$i.'_sdate']){
			${"s".$i."_sdate"} = strtotime($_TIME['session'][$d['day']][$i][0]);
		}
		if(strtotime($_TIME['session'][$d['day']][$i][1])<$d['s'.$i.'_edate']){
			${"s".$i."_edate"} = strtotime($_TIME['session'][$d['day']][$i][1]);
		}
		if(${"s".$i."_edate"}){
			${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
			${"mm".$i} = (${"s".$i."_time"}/60);
		}
		$sum_times += (${"mm".$i});
	}
	
	$sum_score = floor($sum_times);
	
	if($sum_score>0){
		if($sum_score>=60){
			$stay_hours = sprintf("%02d", floor($sum_score/60));
			$stay_min = sprintf("%02d", floor($sum_score%60));
		}else{
			$stay_hours = 0;
			$stay_min = sprintf("%02d", floor($sum_score%60));
		}
		$score = floor($stay_hours);
		if ($score > $scoreMaxHour) {
			$score = $scoreMaxHour;
		}
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('<?=$name_info?>님 입/퇴실관리');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);

		$('#title').on('change',function(){
			var key = $(this).val();
			$(".title_sub_area").load("/registration/change_title.php?key="+key);	
		});
	});
	function time_fill(skey,time){
		var ex_time = time.split("~");
		var stime = ex_time[0].replace(':','');
		var etime = ex_time[1].replace(':','');
		var first_date = $('#first_date').val();
		var in_stime = $('#session'+skey+'_stime').val().replace(':','');
		var in_etime = $('#session'+skey+'_etime').val().replace(':','');
		if(skey=='1'){
			$('#session'+skey+'_stime').val(first_date);
		}else{
			if(in_stime=='' || in_stime>stime){
				$('#session'+skey+'_stime').val(ex_time[0]);
			}
		}
		if(in_etime=='' || in_etime<etime){
			$('#session'+skey+'_etime').val(ex_time[1]);
		}
	}
	function input_time(session,time,kind){
		if(kind=='s'){
			$('#session'+session+'_stime').val(time);
		}else{
			$('#session'+session+'_etime').val(time);
		}
	}
	// 필수세션 없음
	// function time_fill_ind(){
	// 	$('#ind_session_stime').val($('#session3_stime').val());
	// 	$('#ind_session_etime').val($('#session3_etime').val());
	// }
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1100px;padding:20px;background:#ffffff;">
<div>
	<div style="float:left;width:43%;">
		<form method="post" name="postForm" id="postForm" action="session_time_reg.php" enctype="multipart/form-data">
		<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
		<input type="hidden" name="usid" id="usid" value="<?=$d['usid']?>"/>
		<input type="hidden" name="session_day" id="session_day" value="<?=${"session_date".$d['day']}?>"/>
		<!-- <input type="hidden" name="first_date" id="first_date" value="<?=date("H:i",$d["first_date"])?>"/> -->
		<input type="hidden" name="group_key" id="group_key" value="<?=$group_key?>"/>
		<input type="hidden" name="in_day" id="in_day" value="<?=$d['day']?>"/>
		<table class="tblDef inputTbl" style="width:100%;">
			<colgroup>
				<col style="width: 30%;">
				<col style="width: *;">
			</colgroup>
			<tbody>
				
				<tr>
					<th>일자</th>
					<td class="al">
						<?=${"session_date".$d['day']}?>
					</td>
				</tr>
				<tr>
					<th>강의장 입장</th>
					<td class="al">
						<input type="text" name="first_date" id="first_date" value="<?=date("H:i",$d["first_date"])?>" style="width:80px;">
					</td>
				</tr>
				<?
				foreach($_TIME['session'][$d['day']] as $tkey=>$tval){
					$standard_time = trim(substr($_TIME['session'][$d['day']][$tkey][0],10,6)).'~'.trim(substr($_TIME['session'][$d['day']][$tkey][1],10,6));
				?>
				<tr>
					<th>세션 <?=$tkey?><br /><span class="fcRed">(<?=$standard_time?>)</span></th>
					<td class="al">
						<input type="text" id="session<?=$tkey?>_stime" name="session<?=$tkey?>_stime" value="<?=${"s".$tkey."_stime"}?>" style="width:80px;" > ~ 
						<input type="text" id="session<?=$tkey?>_etime" name="session<?=$tkey?>_etime" value="<?=${"s".$tkey."_etime"}?>" style="width:80px;" >

						<span class="rBtnAdmin small green"><button type="button" onclick="time_fill('<?=$tkey?>','<?=$standard_time?>')">시간채우기</button></span>
					</td>
				</tr>
				<?}?>
				<tr>
					<th>최종 퇴장</th>
					<td class="al">
						<input type="text" name="last_date" id="last_date" value="<?if($d["last_date"]>0){?><?=date("H:i",$d["last_date"])?><?}?>" style="width:80px;">
					</td>
				</tr>
				<?php /* 필수세션 없음
				if($d['day'] == "5"){ ?>
				<tr>
					<th>체류시간</th>
					<td class="al"><?=$stay_hours.":".$stay_min?></td>
				</tr>
				<tr>
					<th>필수세션</th>
					<td class="al">
						<input type="text" id="ind_session_stime" name="ind_session_stime" value="" style="width:80px;" > ~
						<input type="text" id="ind_session_etime" name="ind_session_etime" value="" style="width:80px;" >
					</td>
				</tr>
				<? } */ ?>
			</tbody>
		</table>
		<div class="btnArea btn">
			<?if(!$d['sid']){?>
				<input type="submit" value="저장" class="btnPoint btnBig">
			<?}else{?>
				<input type="submit" value="수정" class="btnPoint btnBig">
			<?}?>
			<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
		</div>
	</div>
	</form>
	<div style="float:right;width:55%;">
		<table class="tblDef inputTbl" style="width:100%;">
			<colgroup>
				<col style="width: 15%;">
				<col style="width: 10%;">
				<col style="width: 20%;">
				<col style="width: 10%;">
				<col style="width: 20%;">
				<col style="width: 10%;">
				<col style="width: 10%;">
			</colgroup>
			<tbody>
				<tr>
					<th>Day</th>
					<th>회의장</th>
					<th>입장세션</th>
					<th>입장</th>
					<th>퇴장세션</th>
					<th>퇴장</th>
					<th>기기</th>
					<th>체류</th>
				</tr>
				<?
					$session_color = array("1"=>"#FEFFE1","2"=>"#EDEDED","3"=>"#FDE3EC","4"=>"#E0EFFC","5"=>"#F4D5F0","6"=>"#EEFD86","7"=>"#FFCFC8","8"=>"#97FDA4","9"=>"#BAD3DA");

					$log_query = "select sid_s,day_s,room_s,check_in_s,session_in_s,chk_type_s,location_kind_s,sid_e,day_e,room_e,check_in_e,session_in_e,chk_type_e,location_kind_e from ((";
					$log_query .= "select A.sid as sid_s,A.day as day_s, A.room as room_s,A.check_in as check_in_s, A.session_in as session_in_s,A.chk_type as chk_type_s,A.location_kind as location_kind_s,B.sid as sid_e,B.day as day_e, B.room as room_e,B.check_in as check_in_e,B.session_in as session_in_e, B.chk_type as chk_type_e,B.location_kind as location_kind_e from 
					(select * from checkin_detail_tbl_history T1 where usid='".$d['usid']."' and check_in in (select min(check_in) from checkin_detail_tbl_history where usid='".$d['usid']."' and key_val=T1.key_val)) A inner join
					(select * from checkin_detail_tbl_history T2 where usid='".$d['usid']."' and check_in in (select max(check_in) from checkin_detail_tbl_history where usid='".$d['usid']."' and key_val=T2.key_val)) B on A.key_val=B.key_val order by check_in_s asc";
					$log_query .= ") union all (";
					$log_query .= "select A.sid as sid_s,A.day as day_s, A.room as room_s,A.check_in as check_in_s, A.session_in as session_in_s,A.chk_type as chk_type_s,A.location_kind as location_kind_s,B.sid as sid_e,B.day as day_e, B.room as room_e,B.check_in as check_in_e,B.session_in as session_in_e, B.chk_type as chk_type_e,B.location_kind as location_kind_e from 
					(select * from ".$detail_tbl." T1 where usid='".$d['usid']."' and check_in in (select min(check_in) from ".$detail_tbl." where usid='".$d['usid']."' and key_val=T1.key_val)) A inner join
					(select * from ".$detail_tbl." T2 where usid='".$d['usid']."' and check_in in (select max(check_in) from ".$detail_tbl." where usid='".$d['usid']."' and key_val=T2.key_val)) B on A.key_val=B.key_val order by check_in_s asc";
					$log_query .= ")) A where day_s='$day' order by check_in_s asc";
					
					
					$log_result=$conn->query($log_query);
					if(DB::isError($log_result)) die($log_result->getMessage());

					$n=1;
					while(is_array($log=$log_result->fetchRow(DB_FETCHMODE_ASSOC))){
				?>
				<tr style="background:<?=$session_color[$log['session_in_s']]?>;">
					<td style="height:20px !important;"><?=$log['day_s']?></td>
					<td style="height:20px !important;">
					<?
						echo "제".$log['room_s']."회의장";
					?>
					</td>
					<td style="height:20px !important;">
					<?if($log['session_in_s']!='N' && $log['session_in_s']!='N2'){?>
						<?php /* if($log['session_in_s']=='S'){ ?>필수세션<? }else{ */ ?><?=$log['session_in_s']?><?php /* } */ ?>
					<?}?>
					</td>
					<td style="height:20px !important;">
						<?if($log['check_in_s']>0){?><a href="javascript:input_time('<?=$log['session_in_s']?>','<?=date('H:i',$log['check_in_s'])?>','s')"><?=date('H:i:s',$log['check_in_s'])?><?}?>
					</td>
					<td style="height:20px !important;">
						<?if($log['sid_s']!=$log['sid_e']){?>
						<?if($log['session_in_e']!='N' && $log['session_in_e']!='N2'){?>
							<?php /* if($log['session_in_e']=='S'){ ?>필수세션<? }else{ */ ?><?=$log['session_in_e']?><?php /* } */ ?>
						<?}?>
						<?}?>

					</td>
					<td style="height:20px !important;">
						<?if($log['sid_s']!=$log['sid_e']){?><?if($log['check_in_e']>0){?><a href="javascript:input_time('<?=$log['session_in_e']?>','<?=date('H:i',$log['check_in_e'])?>','e')"><?=date('H:i:s',$log['check_in_e'])?></a><?}?><?}?>
					</td>
					<td style="height:20px !important;"><?=$_Log['location_kind'][$log['location_kind_s']]?></td>
					<td style="height:20px !important;">
					<?
						if($log['sid_s']!=$log['sid_e']){
							echo $_Log['chk_type'][$log['chk_type_e']];
							
						}else{
							echo $_Log['chk_type'][$log['chk_type_s']];
						}
					?>
					</td>
				</tr>
				<?}?>
				
			</tbody>
		</table>
	</div>
</div>
<div style="clear:both;"></div>


</div>