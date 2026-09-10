<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$home_url = $_SERVER['HTTP_HOST'];
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	var hurl = "<?=$home_url?>";
	function sms_send(sms,sid){
		window.open("http://ezv.kr/sms/?sms="+encodeURIComponent(sms)+"&sid="+encodeURIComponent(sid)+"&hurl="+encodeURIComponent(hurl),"","width=600,height=500");
	}
</script>
<style>
	.dragRow{border:2px solid red !important;}
	.dragRow2{background:#f1ff44 !important;}
	.dragRow3{background:#FFA042 !important;}
	.dragRow_role{border:2px solid red !important;}
	.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}
</style>
<div style="clear:both;"></div>
<?
	$query = "select t1.*,if(t2.cell,t2.cell,t1.cell) as cell,t2.license_number,if(t2.email,t2.email,t1.email) as email from technical_tbl as t1 left join registration_tbl as t2 on t1.usid=t2.sid where t1.del='N' order by t1.signdate desc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef ">
		<colgroup>
			<col style="width: 5%" />
			<col style="width: 5%" />
			<col style="width: 5%;" />
			<col style="width: 7%" />
			<col style="width: 7%" />
			<col style="width: 5%" />
			<col style="width: 15%" />
			<col style="" />
			<col style="width: 4%;" />
			<col style="width: 4%;" />
			<col style="width: 4%;" />
		</colgroup>
		<thead>
			<tr>
				<th>행사일</th>
				<th>Room</th>
				<th>이름</th>
				<th>면허번호 / 이메일</th>
				<th>연락처</th>
				<th>질문 시간</th>
				<th>Session</th>
				<th>내용</th>
				<th>발송</th>
				<th>처리</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
		<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<th><?=date("m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($d['day']-1), $ex_sdate[0]))?></th>
			<th><?if($d['room']){?>Room <?=$d['room']?><?}?></th>
			<th><?=$d['name']?></th>
			<th ><?=$d['license_number']?><br><a href="mailto:<?=$d['email']?>"><?=$d['email']?></a></th>
			<th ><?=$d['cell']?></th>
			<th><?if($d['signdate']){?><?=date("H:i",$d['signdate'])?><?}?></th>
			<th ><?=$d['session']?></th>
			<td style="font-weight:bold;text-align:left;padding-left:15px;"><?=nl2br($d['question'])?></td>
			<td ><?if($d['cell']){?><i class="fas fa-sms" style="font-size:30px;cursor:pointer;" onclick="sms_send('<?=$d['cell']?>','<?=$d['sid']?>')"></i><?}?></td>
			<td><input type="checkbox" name="proccess" value="Y" class="push" <?if($d['proccess']=="Y"){?>checked<?}?> key="<?=$d['sid']?>" kind="proccess" style="width:20px;height:20px;"></td>
			<td>
				<img src="/image/icon_del.png" onclick="common_delete('<?=$d['sid']?>','tech')">
			</td>
		</tr>
		<?}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>