<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	
	$sch_tbl = "workshop_schedule_tbl";

	$_SE['content_position'] = array("left"=>"LEFT","center"=>"CENTER","right"=>"RIGHT");

	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$query = "select * from workshop_schedule_tbl where sid='$sid'";

	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	
	$session_date = date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['bsid']-1), $ex_sdate[0]));
	$select_session = preg_replace("/\s+/", "",strtolower(strip_tags($d['content'])));
	
	$code1 = $d['bsid'];
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
	function select_session(sid){
		$.ajax({
			type:"POST",
			url:"/popup/program/session_select_reg.php",
			data:"code2="+sid+"&code1="+code1+"&sid="+program_sid,
			async:false,
			success:function(msg){
				if(msg=='Y'){
					parent.$('#link_icon'+program_sid).css('color','#FF0080');
					parent.$.colorbox.close();
				}
			}
		});
		
	}
</script>
<div class="popupCon" id="" style="width:100%;background:#fffff;">
	<div style="font-size:12px;padding-left:10px;padding-top:5px;" class="fcRed">
		★ 바탕색이 노랑색으로 표시된 세션은 선택된 세션이 아닌 선택한 프로그램과 세션명이 같다는 표시입니다.<br>
		★ 선택이 완료된 세션은 오른쪽의 버튼이 파랑색으로 표시됩니다.
	</div>
	<div style="padding:10px;overflow-y:auto; overflow-x:hidden; width:97%; height:600px;">
	<?
		$room_cnt = "select count(*) from workshop_session_category as t1 inner join workshop_session_tbl as t2 on t1.sid=t2.room  ";
		$room_cnt .= " where t2.ev_date='".$d['bsid']."' and t1.del='N' and t1.kind='P'";
		$session_cnt = $conn->getOne($room_cnt);
		
		if($session_cnt>0){
	?>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 17%;">
			<col style="">
			<col style="width: 7%;">
		</colgroup>
		<tbody> 
			<?
				

				$room_query = "select t1.sid,t1.title from workshop_session_category as t1 inner join workshop_session_tbl as t2 on t1.sid=t2.room  ";
				$room_query .= " where t2.ev_date='".$d['bsid']."' and t1.del='N' and t1.kind='P' group by t1.sid";
				$room_result=$conn->query($room_query);
				if(DB::isError($room_result)) die($room_result->getMessage());

				while(is_array($room=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
					$session_title = str_replace(" ","&nbsp;",$room['title']);
			?>
			<tr>
				<th colspan=3 class="al" style="background:#445964;color:#ffffff;"><?=$room['title']?></th>
			</tr>
			<?
					$session_query = "select * from workshop_session_tbl where ev_date='".$d['bsid']."' and room='".$room['sid']."' and del='N' order by stime asc";
					$session_result=$conn->query($session_query);
					if(DB::isError($session_result)) die($session_result->getMessage());

					while(is_array($session=$session_result->fetchRow(DB_FETCHMODE_ASSOC))){

						$convert_title = preg_replace("/\s+/", "",strtolower(strip_tags($session['title'])));
			?>
			<tr <?if($convert_title==$select_session){?>style="background:yellow;"<?}?>>
				<td><?=$session['stime']?> ~ <?=$session['etime']?></td>
				<td class="al"><?=stripslashes($session['title'])?></td>
				<td>
					<span class="btnAdmin small blue<?if($session['sid']!=$d['code2']){?> empty<?}?>"><button type="button" onclick="select_session(<?=$session['sid']?>)">선택</button></span>
				</td>
			</tr>
			<?}}?>
		</tbody>
	</table>
	<?}else{?>
		<div class="ac fcRed" style="font-size:22px;padding-top:100px;">등록된 세션이 존재하지 않습니다.</div>
	<?}?>
	</div>
	
</div>