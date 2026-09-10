<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$query = "select * from registration_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	$admin_yn="Y";
?>
<link rel="stylesheet" href="/css/pickout.css">
<style>
.pk-field{width:300px !important;border-color:red;}	
.pk-search{width:90%;}
.pk-modal{padding:0; margin:0;width:30%;}
</style>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('MEMO');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,455);
	});
	
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:600px;padding:20px;background:#ffffff;">
<form method="post" name="memoF" id="memoF" action="memo_reg.php">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>메모</th>
				<td class="al">
					<textarea style="width:98%;height:140px;" name="memo"><?=$d['memo']?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="submit" value="저장" class="btnPoint btnBig">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>