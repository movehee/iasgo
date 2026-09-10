<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;

?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	function question_viewer(date,room){
		window.open('question_viewer.php?day='+date+'&room='+room,'Q&A','height=' + screen.height + ',width=' + screen.width + 'fullscreen=yes');
	}
	function showing_reset(room){
		if(confirm("선택하신 방의 좌장석 노출여부를 모두 해제하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/question/all_chk.php",
				data:"room="+room,
				async:false,
				success:function(msg){
					if(msg!='Y'){
						alert("통신에 실패하였습니다.");
					}else{
						$('.chk_room'+room).prop('checked',false);
					}
				}
			});
		}
	}
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
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
</div>
<div style="clear:both;"></div>
<div >
	<?
		$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");
		if($room_chk>0){
			//if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");
	?>
	<div style="float:left;">
		<div class="btn tp10 ">
			<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>" class="<?if(!$room){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i>ALL</a>
			<?
			$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
			$room_result=$conn->query($room_query);
			if(DB::isError($room_result)) die($room_result->getMessage());
			while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
				$room_key[] = $r['sid'];
				$room_title[$r['sid']] = $r['title'];
			?>	
			<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>&room=<?=$r['sid']?>" class="<?if($room==$r['sid']){?>btnSky<?}else{?>btnBdGrey<?}?>"><i class="fas fa-sign-in-alt"></i><?=$r['title']?></a>
			<?}?>
		</div>
	</div>
	<div class="btn tp10 " style="float:right;">
		<a href="question_excel_backup.php?ev_date=<?=$ev_date?>&room=<?=$room?>" class="btnGreen2 withIcon"><i class="fas fa-download" style="font-size:15px;padding-top:0px;"></i>Excel Backup</a>
	</div>
	<div class="btn tp10" style="clear:both;">
		<?if($room_key){?>
		<div style="float:left;">
			<?foreach($room_key as $tkey=>$tval){?>
			<a href="javascript:showing_reset('<?=$tval?>')" class="btnRed"><i class="fas fa-sign-in-alt"></i><?=$room_title[$tval]?> 노출해제</a>
			<?}?>
		</div>
		<?}?>
		<!-- <a href="javascript:question_viewer('<?=$day?>','<?=$room?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>사용자 화면</a> -->
		<div class="fcRed" style="float:right;">※ 노출 체크 해제시 좌장화면에서 보이지 않습니다.</div>
	</div>
	<?}?>
	<div class="fcRed btn tp10 " style="clear:both;"></div>
</div>
<?
	// $query = "select t1.*,t2.cell,t2.license_number,t2.email from question_tbl as t1 left join registration_tbl as t2 on t1.usid=t2.sid where t1.del='N' and t1.day='$ev_date'  ";
	$query = "select * from question_tbl as t1 where t1.del='N' and t1.day='$ev_date'  ";
	if($room){
		$query .= " and t1.room='$room'";
	}
	$query .= " order by t1.signdate desc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef ">
		<colgroup>
			<col style="width: 5%;" />
			<col style="width: 5%;" />
			<col style="width: 12%" />
			<col style="width: 8%" />
			<col style="width: 5%" />
			<col style="width: 23%" />
			<col style="" />
			<col style="width: 4.5%;" />
			<col style="width: 4%;" />
			<col style="width: 3%;" />
			<col style="width: 4%;" />
		</colgroup>
		<thead>
			<tr>	
				<th>Room</th>
				<th>이름</th>
				<th>면허번호</th>
				<th>연락처</th>
				<th>질문 시간</th>
				<th>Session</th>
				<th>질문내용</th>
				<th>좌장석 <br />노출여부</th>
				<th>좌장<br />선택</th>
				<th>답변</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
		<?

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

				unset($license_number);
				unset($name);
				if($d['usid']) {
					$result_user = $conn->query("select * from registration_tbl where sid=".$d['usid']);
					$result_user->fetchInto(&$user, DB_FETCHMODE_ASSOC);
					$result_user->free();

					$name = $d['name'];
					$license_number = $user['license_number'];
				} else {
					$name = "현장";
				}

		?>
		<tr>
			<th>Room <?=$d['room']?></th>
			<th><?=$name?></th>
			<th><?=$license_number?><br><?=$d['email']?></th>
			<th><?=$d['cell']?></th>
			<th><?if($d['signdate']){?><?=date("H:i",$d['signdate'])?><?}?></th>
			<th class="al">
			<?
				echo "<b>".strip_tags($d['session'])."</b>";
				if($d['session_detail']){
					echo "<div style='font-size:12px;padding-left:10px;'>".strip_tags($d['session_detail']).'</div>';
				}
			?>
			</th>
			<td style="font-weight:bold;text-align:left;padding-left:15px;"><?=nl2br($d['question'])?></td>
			
			<td>
				<input type="checkbox" name="show" value="Y" class="push AD_chk chk_room<?=$d['room']?>" <?if($d['show']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" kind="question" pval="&room=<?=$d['room']?>&day=<?=$day?>">
			</td>
			<td>
				<input type="checkbox" name="view" value="Y" class="push AD_chk Viewchk" <?if($d['view']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" kind="view" pval="&room=<?=$d['room']?>&day=<?=$day?>">
			</td>
			<td>
				<?if($d['answer_ok']=="Y"){?>
					완료
				<?}else{?>
					<input type="checkbox" name="answer_ok" value="Y" class="push AD_chk" <?if($d['answer_ok']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" kind="answer_ok" pval="&room=<?=$d['room']?>&day=<?=$day?>">
				<?}?>
			</td>
			<td>
				<img src="/image/icon_del.png" onclick="common_delete('<?=$d['sid']?>','question')">
			</td>
		</tr>
		<?}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>