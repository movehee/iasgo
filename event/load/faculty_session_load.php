<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
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

	$query = "select fsid,dsid,faculty_kind,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,session_sid,session_detail_sid,ev_date,stime,etime,room,title,detail_time,detail_title,pre_num from (";
	$query .= "select t1.sid as fsid,t2.sid as dsid,t2.faculty_kind,faculty_name,faculty_aff,faculty_photo,faculty_cv,faculty_abs,faculty_info,t2.session_sid,t2.session_detail_sid"; 
	$query .= ",t3.ev_date,t3.stime,t3.etime,t3.room,t3.title,t4.detail_time,t4.title as detail_title,t4.pre_num";
	$query .= " from faculty_tbl as t1 left join faculty_matching as t2 on t1.sid=t2.faculty_sid";
	$query .= " left join workshop_session_tbl as t3 on t3.sid=t2.session_sid";
	$query .= " left join workshop_session_detail_tbl as t4 on t4.sid=t2.session_detail_sid";
	$query .= ") A where dsid='$sid'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>

<th style="background:#445964;color:yellow;" >
	<?if($d['stime']){?><?=$d['stime']?> ~ <?=$d['etime']?><?}?>
	<?if($d['detail_time']){?><div style="font-size:12px;color:#ffffff;"><?=$d['detail_time']?></div><?}?>
</th>
<th style="background:#445964;color:#ffffff;">
	<?=$room_name[$d['room']]?>
	<?if($d['pre_num']){?>
		<div style="font-size:14px;">(<?=$d['pre_num']?>)</div>
	<?}?>
</th>
<th style="text-align:left;background:#445964;color:#ffffff;font-size:17px;">
	<?if($d['title']){?>
		<div style="color:yellow;"><?=stripslashes($d['title'])?></div>
	<?}?>
	<?if($d['detail_title']){?>
		<div style="font-size:14px;padding-left:20px;"><?=stripslashes($d['detail_title'])?></div>
	<?}?>
	<div style="float:right;"><span class="btnAdmin small darkPink" ><button type="button" onclick="reset_session(<?=$d['fsid']?>,<?=$d['dsid']?>)" style="width:100%;">Delete</button></span></div>
</th>
<th style="background:#445964;color:#ffffff;margin:0px;padding:0px;" >
	<?if($d['faculty_photo']){?>
	<?}else{?>
		<i class="far fa-id-card" style="font-size:60px;"></i>
	<?}?>
</td>
<th style="background:#445964;color:#ffffff;font-size:11px;">
	<div style="float:right;padding:0px;margin:0px;">
		<span class="btnAdmin small empty darkGray" ><button type="button" onclick="">CV</button></span>
	</div>
	<div style="color:yellow;float:left;">[<?=$_Faculty['role'][$d['faculty_kind']]?>]</div>
	<div style="float:left;clear:both;"><?=$d['faculty_name']?></div>
	<div style="float:right;clear:both;"><i><?=$d['faculty_aff']?></i></div>
</td>
<th style="background:#445964;color:#ffffff;">
	<div><span class="btnAdmin small lightBlue" style="width:97%;"><button type="button" onclick="popup_call('session/faculty','sid=<?=$d['fsid']?>')" style="width:100%;">수정</button></span></div>
	<div style="padding-top:2px;"><span class="btnAdmin small  red" style="width:97%;"><button type="button" onclick="common_delete('<?=$d['dsid']?>','faculty_detail')" style="width:100%;">삭제</button></span></div>
</th>
