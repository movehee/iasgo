<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	$query = "select * from question_tbl where sid='$sid'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<script>
	function answer_ok(){
		if(!$('#answer').val()){
			alert(" Please enter your content");
			return false;
		}
		if(confirm("Would you like to send a reply by e-mail?")){
			$('#session_answerF').submit();
		}
	}
</script>
<form name="session_answerF" id="session_answerF" method="post" action="session_qna_reg.php">
<input type="hidden" name="sid" value="<?=$d['sid']?>">
<div class="popupWrap" id="popupSessionQna" style="height:760px;">
	<h1>Q&A</h1>
	<div class="popupCon" >
		<dl class="qnaCon" style="overflow-y:scroll;height:150px;">
			<dt style="min-height:122px;">
				<span class="tit">Question : <?=nl2br($d['question'])?></span>
				<span class="info"><?=date("Y.m.d",$d['signdate'])?> / <?=$d['name']?></span>
			</dt>
		</dl>
		<dl class="qnaCon" style="overflow-y:scroll;height:300px;">
			<dd>
				<?if($mode=='answer'){?>
					<textarea style="width:97%;height:200px;" name="answer" id="answer" placeholder='Please enter your content.'><?=$d['answer']?></textarea>
				<?}else{?>
					<?
					if(!$d['answer']){
						echo "<div class='ac fcRed' style='font-size:23px;padding-top:50px;'> No comments.</div>";
					}else{
						echo nl2br($d['answer']);
					}
					?>
				<?}?>
			</dd>
		</dl>
		<p class="btn ac" style="border-top:0px;">
			<?if($mode=='answer'){?>
				<a href="javascript:answer_ok()" class="btnDef">Send</a>
			<?}else{?>
				<a href="<?=$PHP_SELF?>?sid=<?=$sid?>&mode=answer" class="btnDef">Reply</a>
			<?}?>
			<a class="btnBdDef color_close">Close</a>
		</p>
	</div>
	<div class="close"><a class="color_close"><img src="/asset/layout/layerpopup_close.png" alt="닫기"></a></div>
</div>
</form>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>