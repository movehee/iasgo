<?
	include_once $_SERVER['DOCUMENT_ROOT'].'webinar/admin/include.header.php';
	
	$workshop_manager_query = "select * from workshop_manager";
	$workshop_manager_result = $conn->query($workshop_manager_query);
	$workshop_manager_result->fetchInto(&$manager,DB_FETCHMODE_ASSOC);
	$workshop_manager_result->free();
	
	if($manager['edate']){
		$chkdate = strtotime($manager['edate'])-strtotime($manager['sdate']);
		$date_count = date("d",$chkdate);
	}else{
		$date_count = 1;	
	}
	$ex_sdate = explode("-",$manager['sdate']);

	if(!$ev_date) $ev_date = 0;
	
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
<script type="text/javascript" src="/webinar/script/drag/js/jquery.tablednd.js"></script>
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
				url:"/admin/session/hide_chk.php",
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
					url:"/admin/session/sort_change.php",
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
		<?for($date=0;$date<$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" class="btnDef"><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+$date, $ex_sdate[0]));?></a></li>
		<?}?>
	</div>

	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('excel/upload','kind=sessions')" class="btnGrey withIcon"><i class="fas fa-edit"></i>Agenda 등록</a>
	</div>
</div>
<div style="clear:both;padding-bottom:5px;"></div>
<?
	$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
?>
<div style="float:right;">
	<ul class="subMenu">
		<?
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>	
		<li <?if($room==$r['sid']){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>&room=<?=$r['sid']?>"><?=$r['title']?></a></li>

		<?}?>
	</ul>
</div>
<?}?>
<?
	if($room){
		$add_room = " and room='$room'";	
	}
	$query = "select * from workshop_session_tbl where ev_date='$ev_date' $add_room and del='N' order by stime asc";
	echo $query;
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef ">
		<colgroup>
			<col style="width: 15%;" />
			<col style="width: " />
			<col style="width: 15%;" />
			<col style="width: 20%;" />
			<col style="width: 6%;" />
			<col style="width: 6%;" />
			<col style="width: 4%;" />
		</colgroup>
		<thead>
			<tr>
				<th>시간</th>
				<th>주제</th>
				<th>연자</th>
				<th>소속</th>
				<th>CV</th>
				<th>Lecture</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
		<?

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
				if($d['chair']){
					$ex_chair = explode("/",$d['chair']);
					$rowspan_cnt++;
					$rowspan_cnt2 = 2;
				}
				if($d['session_file']){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."webinar/upload/session/" . $d["session_file"]) . "&filename=" . base64_encode($d["session_realfile"]);
				}
				if($d['session_file2']){
					$queryString2 = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."webinar/upload/session/" . $d["session_file2"]) . "&filename=" . base64_encode($d["session_realfile2"]);
				}
		?>
		<tr>
			<th rowspan="<?=$rowspan_cnt?>"><?=$d['stime']?> ~ <?=$d['etime']?><br />(<?=$stay_time?>)</th>
			
			<th style="font-weight:bold;text-align:left;padding-left:15px;">
				<?=$d['title']?>
				<!-- <?if($d['session_file']){?><img src="<?=IconType3($d['session_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"><?}?>
				<div style="float:right;"><span class="rBtnAdmin small navy"><button type="button" onclick="popup_call('TableGender/session_detail','session_sid=<?=$d['sid']?>')">Detail Progeam</button></span></div> -->
			</th>
			<th><?=$d['author']?></th>
			<th ><?=$d['position']?></th>
			<th><?if($d['session_file']){?><a href="/webinar/func/download.php?<?=$queryString?>"><?=IconType2($d['session_file'])?></a><?}?></th>
			<th><?if($d['session_file2']){?><a href="/webinar/func/download.php?<?=$queryString2?>"><?=IconType2($d['session_file2'])?></a><?}?></th>

			<th rowspan="<?=$rowspan_cnt2?>">
				<img src="/<?=$_Path['link']?>/admin/image/icon_modify.png" onclick="popup_call('TableGender/session','sid=<?=$d['sid']?>')">
				<img src="/<?=$_Path['link']?>/admin/image/icon_del.png" onclick="common_delete('<?=$d['sid']?>','sessions')">
			</th>
		</tr>
		<?if($d['chair']){?>
		<tr>
			<td colspan=6 class="ar">
				<table cellpadding=0 cellspacing=0 style="padding:0px;margin:0px;" align="right">
					<tr>
						<td valign="top" style="font-weight:bold;color:#000000;color:blue;">Chair : </td>
						<td style="text-align:left;padding-left:10px;">
							<?foreach($ex_chair as $ckey=>$cval){?>
							<div><?=$cval?></div>
							<?}?>
						</td>
					</tr>
				</table>
				
			</td>
		</tr>
		<?}?>
		<?
			
			if($detail_cnt>0){
			$detail_query = "select * from workshop_session_detail_tbl where session_sid='".$d['sid']."' and del='N' order by sort_num asc";
			$detail_query .= $sort_sql;
			$detail_result=$conn->query($detail_query);
			if(DB::isError($detail_result)) die($detail_result->getMessage());
		?>
		<tr >
			<td colspan=8 style="padding:0px;margin:0px;border-left:0px;">
				<table class="tblDef tblList sort_table" style="border:0px;padding:0px;" id="<?=$d['sid']?>">
					<colgroup>
						<col style="width:99px;">
						<col style="width:95px;">
						<col style="*">
						<col style="width: 200px;">
						<col style="width: 300px;">
						<col style="width: 75px;">
					</colgroup>
					<thead>
						<tr >
							<th style="background:#E1E4EE;">PT/DC</th>
							<th style="background:#E1E4EE;">코드</th>
							<th style="background:#E1E4EE;">Title</th>
							<th style="background:#E1E4EE;">Author</th>
							<th style="background:#E1E4EE;">Co Author</th>
							<th style="background:#E1E4EE;">관리</th>
						</tr>
					</thead>
					<tbody>
						<?
							$set_time = $ex_sdate_arr[0]." ".$d['stime'];
							while(is_array($detail=$detail_result->fetchRow(DB_FETCHMODE_ASSOC))){	
								unset($pt_total_time);
								if($detail['pt_time']){
									$ex_pt = explode("/",$detail['pt_time']);
									$pt_total_time = $ex_pt[0]+$ex_pt[1];
									$set_start = date("H:i",strtotime("+".$pt_total_time." minutes",strtotime($set_time)));
								}
								
								
						?>
						<tr id="<?=$detail['sid']?>">
							<td><?if($detail['pt_time']){?><?=date("H:i",strtotime($set_time))?>-<?=$set_start?> <br />(<?=$detail['pt_time']?>분)<?}?></td>
							<td><?=$detail['code']?></td>
							<td class="al lp10"><?=$detail['title']?></td>
							<td><?=$detail['author']?></td>
							<td>
								<div><?=$detail['author_co']?></div>
								<div style="font-style: italic;"><?=$detail['author_position_co']?></div>
							</td>
							<td style="cursor:default;">
								<img src="/<?=$_Path['link']?>/admin/image/icon_modify.png" onclick="popup_call('TableGender/session_detail','sid=<?=$detail['sid']?>')">
								<img src="/<?=$_Path['link']?>/admin/image/icon/icon_del.png" onclick="common_delete('<?=$detail['sid']?>','session_detail')">
							</td>
						</tr>
						<?
							if($detail['pt_time']){
								$set_time = $ex_sdate_arr[0]." ".$set_start;
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

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'admin/include.footer.php';
?>