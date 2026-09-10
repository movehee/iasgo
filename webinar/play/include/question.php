<div class="utilPopup questionSend Question_area" style="display: none;">
	<dl>
		<dt>Question</dt>
		<dd>
			<div class="formArea">
				<form id="QuestionF" name="QuestionF" method="post">
				<input type="hidden" name="room" value="<?=$room_sid?>">
					<fieldset>
						<legend>Question</legend>
						<textarea name="session_question" id="session_question" cols="30" rows="10" placeholder="Please write down any questions you may have about the lecture."></textarea>
						<span class="btn"><span class="btnDef btnSend">Send<input type="button" value="Send" class="send_question"></span></span>
					</fieldset>
				</form>
			</div>
		</dd>
	</dl>
	<p class="close"><a href="#" onclick="$('div.questionSend').hide();return false"><img src="/asset/layout/popup_close.png" alt="닫기"></a></p>
</div>