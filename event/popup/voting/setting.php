<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
<link rel='stylesheet' type='text/css' href='/mail/conf/jquery-flick.css'/>
<SCRIPT LANGUAGE="javascript" SRC="/script/jquery.ui-jalert.js"></SCRIPT>
<script type="text/javascript" src="/script/jquery.popupoverlay.js"></script>
<link rel="stylesheet" href="/script/jquery.ui.timepicker.css">
<script src='/script/jquery.ui.timepicker.js'></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<link rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script src="/script/colorbox/jquery.colorbox.js"></script>
<?
	$query = "select * from event_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	if($d['eventdate']){
		$eventdate = date("Y-m-d",$d['eventdate']);
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Voting 설정');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,400);

		$('#vsetF').submit(function(){
			if(!$('#code').val()){
				alert("코드를 입력해주세요");
				return false;
			}
			if(!$('#eventdate').val()){
				alert("일자를 선택해주세요");
				return false;
			}
		});
	});
</script>
<style>
	
</style>
<div class="popupCon" id="" style="width:500px;padding:20px;background:#ffffff;">
<form method="post" name="vsetF" id="vsetF" action="setting_reg.php">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>Code</th>
				<td class="al">
					<input type="text" name="code" id="code" value="<?=$d['code']?>" style="width:80%;">
				</td>
			</tr>
			<tr>
				<th>일자</th>
				<td class="al">
					<input type="text" name="eventdate" id="eventdate" value="<?=$eventdate?>" class="date" style="width:80%;" readonly>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<?if(!$d['sid']){?>
			<input type="submit" value="저장" class="btnPoint btnBig">
		<?}else{?>
			<input type="submit" value="수정" class="btnPoint btnBig">
		<?}?>
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>
<??>
