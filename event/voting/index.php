<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
?>
<script type="text/javascript" src="/webinar/script/drag/js/jquery.tablednd.js"></script>
<script>
	function question_viewer(){
		window.open('voting.php','Q&A','height=' + screen.height + ',width=' + screen.width + 'fullscreen=yes');
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
	<div class="fcRed" style="float:left;margin-top:10px;">※ Code는 반드시 day1~ 방법으로 입력해주세요.(Ex. 행사 첫째날 day1, 둘째날 day2)</div>
	<div class="btn" style="float:right;">
		<!-- <a href="javascript:question_viewer()" class="btnGrey withIcon"><i class="fas fa-edit"></i>등록</a> -->
		<a href="javascript:popup_call('voting/setting','sid=<?=$d['sid']?>&day=<?=$ev_date?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>등록</a>
	</div>
</div>
<div style="clear:both;padding-bottom:5px;"></div>
<?
	$query = "select * from event_tbl where del='N' order by sid desc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef ">
		<colgroup>
			<col style="width: 5%;" />
			<col style="width: 22%;" />
			<col style="width: 22%" />
			<col style="" />
			<col style="width: 5%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>행사명</th>
				<th>일자</th>
				<th>CODE</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
		<?
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

		?>
		<tr>
			<th><?=$n?></th>
			<td><?=$_CONFIG['Name']?></td>
			<td><?=date("Y.m.d",$d['eventdate'])?></td>
			<td><?=$d['code']?></td>
			<td>
				<img src="/image/icon/icon_modify.png" onclick="popup_call('voting/setting','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','voting_day')">
			</td>
		</tr>
		<?$n++;}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>