<div class="utilPopup TechSend Tech_area" style="display: none;">
	<dl>
		<dt>기술지원 문의</dt>
		<dd>
			<div class="note">
				영상이 정상적으로 나오지 않으실 경우 아래 파일을 다운로드 받아 설치 바랍니다.<br>
				<a href="/Root_Sectigo_RootCA_import.zip">Root_Sectigo_RootCA_import.zip <img src="/asset/player/bl_download.png" alt=""></a>
			</div>
			<div class="formArea">
				<form id="techF" name="techF" method="post">
				<input type="hidden" name="room" value="<?=$room_sid?>">
					<fieldset>
						<legend>기술지원 문의</legend>
						<textarea name="tech_question" id="tech_question" cols="30" rows="10" placeholder="사이트 관련하여 오류 및 문의사항을 입력해주세요. 답변은 문자 및 메일로 전달드립니다."></textarea>
						<span class="btn"><span class="btnDef btnSend">Send<input type="button" value="Send" class="send_tech"></span></span>
					</fieldset>
				</form>
			</div>
		</dd>
	</dl>
	<p class="close"><a href="#" onclick="$('div.TechSend').hide();return false"><img src="/asset/layout/popup_close.png" alt="닫기"></a></p>
</div>