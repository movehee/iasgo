<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select * from workshop_session_category where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Session 장소 등록");
	
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,400);
	});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="category_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>장소</th>
				<td class="al">
					<input type="text" name="title" id="title" value="<?=$d['title']?>" style="width:80%;">
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<?if($d['sid']){?>
			<input type="submit" value="저장" class="btnPoint btnBig">
		<?}else{?>
			<input type="button" value="수정" class="btnPoint btnBig" onclick="location.href='<?=$PHP_SELF?>?sid=<?=$sid?>&mode=form'">
		<?}?>
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>
<??>
