<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	$role_query = "select * from faculty_role_tbl order by sid asc";
	$role_result=$conn->query($role_query);
	if(DB::isError($role_result)) die($role_result->getMessage());
	while(is_array($role=$role_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$role_sid[] = $role['sid'];
		$role_title[$role['sid']] = $role['role_title'];
	}

	$query = "select * from faculty_tbl where sid='$faculty_sid'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
	$room_result=$conn->query($room_query);
	if(DB::isError($room_result)) die($room_result->getMessage());
	while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$room_title_sub[$r['sid']] = $r['title_sub'];
	}

	$vchk = $conn->getOne("select count(sid) from faculty_favor_tbl where faculty_sid='$faculty_sid' and usid='".$_COOKIE['wmember_sid']."'");
?>
<script>
	// $(document).ready(function(){	
	// 	parent.$.colorbox.resize({width:940,height:495,top:100});
	// });
</script>
<div class="popupWrap" id="popupSpeaker">
	<h1 class="bg">
		<?=$d['faculty_name']?> <span><?=$d['faculty_aff']?></span>
		<span class="util"><a faculty_sid="<?=$faculty_sid?>" class="faculty_favor_btn favor<?if($vchk){?> on<?}?>">Favorite</a></span>
	</h1>
	<div class="popupCon">

		<div class="scrollArea">
			<?
				$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
				$date_count = date("d",$chkdate);
				$ex_sdate = explode("-",$_Webinar['sdate']);

				$query = "select * from faculty_matching as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid where faculty_sid='".$faculty_sid."'";

				if($type=="chair") {
					$query .= " AND t1.faculty_kind='4'";
				} else if($type=="invite") {
//					$query .= " AND t1.faculty_kind='2'"; //2022-09-01 아래로 수정
					$query .= " AND t1.faculty_kind='3' and t1.category=4";
				}

				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					if($d['session_detail_sid']>0){
						$query2 = "select * from workshop_session_detail_tbl where sid='".$d['session_detail_sid']."'";
						$result2 = $conn->query($query2);
						$result2->fetchInto(&$row,DB_FETCHMODE_ASSOC);
						$result2->free();
					}

					$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['ev_date']-1), $ex_sdate[0]));
			?>
			<table class="tblDef">
				<colgroup>
					<col style="width: 20%;">
					<col style="width: *;">
				</colgroup>
				<tbody>
					<tr>
						<td colspan="2" class="bg">
							<strong><?=stripslashes($d['code_title'])?> <span><?=$_PROGRAM['gubun_code'][$d['part']]?"(".$_PROGRAM['gubun_code'][$d['part']].")":""?></span></strong>
							<?=stripslashes($d['title'])?>
						</td>
					</tr>
					<tr>
						<th>Role</th>
						<td><?=$role_title[$d['faculty_kind']]?></td>
					</tr>
					<tr>
						<th>Session Date & Time</th>
						<td>
							<?=Days_convert($to_date,"M. D (w)","s")?>
							<?=$d['stime']?>-<?=$d['etime']?>
						</td>
					</tr>
					<tr>
						<th>Room</th>					
						<td><?=$_Day['room_title'][$d['room']]?></td>
					</tr>
					<?if($row['title']){?>
					<tr>
						<th>Lecture Title</th>
						<td><?=stripslashes($row['title'])?></td>
					</tr>
					<?}?>
				</tbody>
			</table>

			<?}?>
		</div>
		<!-- //scrollArea -->
	</div>
	
	<div class="close"><a class="color_close"></a></div>
</div>
<!-- //popupWrap -->

<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>