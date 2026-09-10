<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
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
	$day = $ev_date+1;
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	function question_viewer(date,room){
		window.open('question_viewer.php?day='+date+'&room='+room,'Q&A','height=' + screen.height + ',width=' + screen.width + 'fullscreen=yes');
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
		<?for($date=0;$date<$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}else{?>class="btnLGrey2"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+$date, $ex_sdate[0]));?></a></li>
		<!-- <button class="btnBdPoint btnBig withIcon"><i class="fas fa-download"></i>btnBdPoint</button> -->
		<?}?>
	</div>
</div>
<div style="clear:both;"></div>
<div >
	<?
		$room_chk = $conn->getOne("select count(*) from workshop_session_category where kind='P' and del='N'");
		if($room_chk>0){
			if(!$room) $room = $conn->getOne("select t1.sid from workshop_session_category as t1 left join workshop_session_tbl as t2 on t1.sid=t2.room where t1.kind='P' and t1.del='N' and t2.del='N' and t2.ev_date='$ev_date' group by t2.room limit 0,1");

			
	?>
	<div style="float:left;">
		<div class="btn tp10 bp10" style="float:right;">
			<?
			$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
			$room_result=$conn->query($room_query);
			if(DB::isError($room_result)) die($room_result->getMessage());
			while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>	
			<a href="index.php?ev_date=<?=$ev_date?>&room=<?=$r['sid']?>" class="btnBdGrey"><i class="fas fa-sign-in-alt"></i><?=$r['title']?></a>
			<?}?>
			<a href="<?=$_SERVER['PHP_SELF']?>?ev_date=<?=$ev_date?>&room=2" class="btnSky"><i class="fas fa-sign-in-alt"></i>평의원회</a>
		</div>
	</div>
	<?}?>
	<div class="btn tp10 bp10" style="float:right;">
		<a href="javascript:question_viewer('<?=$day?>','<?=$room?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>사용자 화면</a>
	</div>
</div>
<?
	$query = "select t1.*,t2.name_kr,t2.license_number from question_tbl as t1 inner join councilor_tbl as t2 on t1.usid=t2.sid where t1.del='N' and t1.day='$day' and t1.room='$room' order by t1.signdate desc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef ">
		<colgroup>
			<col style="width: 15%;" />
			<col style="width: 15%" />
			<col style="width: 15%" />
			<col style="" />
		</colgroup>
		<thead>
			<tr>
				<th>이름</th>
				<th>면허번호</th>
				<th>질문 시간</th>
				<th>질문내용</th>
			</tr>
		</thead>
		<tbody>
		<?

			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

		?>
		<tr>
			<th ><?=$d['name']?></th>
			<th ><?=$d['license_number']?><br><?=$d['email']?></th>
			<th><?if($d['signdate']){?><?=date("Y.m.d H:i",$d['signdate'])?><?}?></th>
			<td style="font-weight:bold;text-align:left;padding-left:15px;"><?=nl2br($d['question'])?></td>
		</tr>
		<?}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>