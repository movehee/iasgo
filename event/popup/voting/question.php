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
	$query = "select * from voting_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Voting 문제등록');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,600);

		$('#queF').submit(function(){
			if(!$('#question').val()){
				alert("질문을 입력해주세요");
				$('#question').focus();
				return false;
			}
			if(!$('#answer1').val()){
				alert("문항1번을 입력해주세요");
				$('#answer1').focus();
				return false;
			}
			if(!$('#answer2').val()){
				alert("문항2번을 입력해주세요");
				$('#answer2').focus();
				return false;
			}
		});
	});
</script>
<style>
	
</style>
<div class="popupCon" id="popupCon" style="width:700px;padding:20px;background:#ffffff;">
<form method="post" name="queF" id="queF" action="question_reg.php">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="code" id="code" value="<?=$code?>"/>
<input type="hidden" name="lecture" id="lecture" value="<?=$lecture?>"/>
<input type="hidden" name="room" id="room" value="<?=$room?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>질문</th>
				<td class="al">
					<input type="text" name="question" id="question" value="<?=$d['question']?>" style="width:80%;">
				</td>
			</tr>
			<?for($i=1;$i<=5;$i++){?>
			<tr>
				<th>문항<?=$i?></th>
				<td class="al">
					<input type="text" name="answer<?=$i?>" id="answer<?=$i?>" value="<?=$d['answer'.$i]?>" style="width:80%;">
				</td>
			</tr>
			<?}?>
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
