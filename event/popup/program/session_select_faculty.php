<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
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

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$code1 = $ev_date;

	$query = "select session_detail_sid,faculty_name from faculty_tbl as t1 right join faculty_matching as t2 on t1.sid=t2.faculty_sid where t2.sid='$dsid'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$faculty_name = $d['faculty_name'];

?>
<script style="text/javascript">
	var code1 = "<?=$code1?>";
	var program_sid = "<?=$sid?>";
	$(function(){
		$('#Popup_Title').html("<?=$session_date?> Session 선택");
		$('.color_close').on('click',function(){
			parent.$.colorbox.close();
		});
	});
	function select_session(fsid,dsid,sid,type){
		$.ajax({
			type:"POST",
			url:"/popup/program/session_select_faculty_reg.php",
			data:"sid="+sid+"&fsid="+fsid+"&dsid="+dsid+"&type="+type,
			async:false,
			success:function(msg){
				if(msg=='Y'){
					//parent.$('.session_title_area_'+fsid+'_'+dsid).css('color','#FF0080');
					parent.$('.session_title_area_'+fsid+'_'+dsid).load("/load/faculty_session_load.php?sid="+dsid);
					parent.$.colorbox.close();
				}
			}
		});
		
	}
</script>
<div class="popupCon" id="" style="width:100%;background:#fffff;">
	<div style="font-size:12px;padding-left:10px;padding-top:5px;" class="fcRed">
		★ 최초 클릭시 Faculty 의 성명이 동일한 세션이 먼저 표기됩니다.
	</div>
	<div style="padding:10px;">
		<div class="btn" style="float:left;">
			<a href="<?=$PHP_SELF?>?fsid=<?=$fsid?>&dsid=<?=$dsid?>" <?if($ev_date==''){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i>My Name</a></li>
			<?for($date=1;$date<=$date_count;$date++){?>	
			<a href="<?=$PHP_SELF?>?ev_date=<?=$date?>&fsid=<?=$fsid?>&dsid=<?=$dsid?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
			<?}?>
		</div>
	</div>
	<div style="padding:10px;overflow-y:auto; overflow-x:hidden; width:97%; height:600px;">
	<?
		$room_cnt = "select count(*) from workshop_session_category as t1 inner join workshop_session_tbl as t2 on t1.sid=t2.room  ";
		$room_cnt .= " where t1.del='N' and t1.kind='P'";
		if($ev_date){
			$room_cnt .= " and t2.ev_date='".$ev_date."'";
		}
		$session_cnt = $conn->getOne($room_cnt);
		
		if($session_cnt>0){
	?>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 12%;">
			<col style="width: 9%;">
			<col style="">
			<col style="width: 7%;">
		</colgroup>
		<tbody> 
			<?
			$session_query = "select * from workshop_session_tbl as t1 where del='N' ";
			if($ev_date){
				$session_query .= " and ev_date='".$ev_date."'";
			}else{
				$session_query .= " and ((chair like '%$faculty_name%' or chair2 like '%$faculty_name%' or chair3 like '%$faculty_name%' or chair4 like '%$faculty_name%')";
				$session_query .= " or (select count(*) from workshop_session_detail_tbl where session_sid=t1.sid and (author like '%$faculty_name%' or author_co like '%$faculty_name%'))>0)";
			}
			$session_query .= " order by room asc, stime asc";
			$session_result=$conn->query($session_query);
			if(DB::isError($session_result)) die($session_result->getMessage());
			
			while(is_array($session=$session_result->fetchRow(DB_FETCHMODE_ASSOC))){

				$convert_title = preg_replace("/\s+/", "",strtolower(strip_tags($session['title'])));
			?>
			<tr style="background:#445964;">
				<td style="color:#ffffff;"><?=$session['stime']?> ~ <?=$session['etime']?></td>
				<td style="color:#ffffff;"><?=$room_name[$session['room']]?></td>
				<td class="al" style="color:#ffffff;">
					<div><?=stripslashes($session['title'])?></div>
					<div class="ar" style="font-size:9px;"><?=str_replace($faculty_name,'<b style="background:yellow;color:red;">'.$faculty_name.'</b>',$session['chair'])?><?if($session['chair2']){?>, <?=str_replace($faculty_name,'<b style="background:yellow;color:red;">'.$faculty_name.'</b>',$session['chair2'])?><?}?></div>
				</td>
				<td style="color:#ffffff;">
					<span class="btnAdmin small blue<?if($session['sid']!=$d['code2']){?> empty<?}?>"><button type="button" onclick="select_session(<?=$fsid?>,<?=$dsid?>,<?=$session['sid']?>,'S')">선택</button></span>
				</td>
			</tr>
			<?
				$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$session['sid']."' and del='N' order by sort_num asc";
				$detail_query .= $sort_sql;
				$detail_result=$conn->query($detail_query);
				if(DB::isError($detail_result)) die($detail_result->getMessage());

				$set_time = $session['stime'];
				
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
					<?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?>-<?=$set_start?><?}?>
				</td>
				<td colspan=2>
					<div class="al lp10"><?=stripslashes($detail['title'])?></div>
					<div class="ar" style="font-size:9px;"><?=str_replace($faculty_name,'<b style="background:yellow;color:red;">'.$faculty_name.'</b>',$detail['author'])?><?if($detail['author_position']){?>(<span style="font-style: italic;"><?=str_replace($faculty_name,'<b style="background:yellow;color:red;">'.$faculty_name.'</b>',$detail['author_position'])?></span>)<?}?></div>
				</td>
				<td>
					<span class="btnAdmin small blue<?if($session['sid']!=$d['code2']){?> empty<?}?>"><button type="button" onclick="select_session(<?=$fsid?>,<?=$dsid?>,<?=$detail['sid']?>,'D')">선택</button></span>
				</td>
			</tr>	
			<?}?>
			<?}?>
		</tbody>
	</table>
	<?}else{?>
		<div class="ac fcRed" style="font-size:22px;padding-top:100px;">등록된 세션이 존재하지 않습니다.</div>
	<?}?>
	</div>
	
</div>