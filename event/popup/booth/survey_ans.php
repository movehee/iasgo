<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		//window.resizeTo(re_width,950);
	});
</script>
<?
	$query = "select * from survey_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>

<div class="popupCon" id="" style="width:400px;padding:20px;background:#ffffff;">
<form method="post">
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 8%;">
			<col style="width: ;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>선택지</th>
			</tr>
		</thead>
		<tbody>
			<?				
				for($i=1; $i<=5; $i++) {
			?>
			<tr>
				<td style="padding:0px !important;"><span class="numberic"><?=$i?></span></td>
				<td>
					<input type="text" style="width:90%" value="<?=$d['ans'.$i]?>" class="Ch_con" kind="survey" field="ans<?=$i?>" key="<?=$d['sid']?>">
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
