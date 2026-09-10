<div class="layerPopup" style="display: block;">
	<div class="popupWrap" id="popupAgree">
		<?if($_COOKIE['wmember_country']=='K'){?>
		<h1><img src="/asset/player/bl_agree.png" alt="">주의사항</h1>
		<p>
			아래 내용을 반드시 숙지하신 후,  <span>‘동의하기’</span> 를 클릭해 주십시오.
		</p>

		<div class="formArea">
			<form id="" name="" action="" method="post">
				<fieldset>
					<legend>Agree</legend>

					<div class="bg">
						<div class="agreeCon">
							<ul class="listNum">
								<li>대한의사협회 평점 인정 기준에 따라, 각 [세션] 마다 입·퇴장 기록이 필요합니다.<br>
									<span style="color: #0168b7;">[입장시간 기록]</span> : 퇴장시간 기록 버튼 클릭 시 활성화 됩니다.<br>
									<span style="color: #ff7e00;">[체류시간 기록]</span> : 체류시간 기록 버튼을 누르시면 체류시간이 업데이트 됩니다.<br>
									<span style="color: #eb0000;">[퇴장시간 기록]</span> : 구간 별 세션 종료 후 활성화 됩니다.<br>
									해당 일 행사 종료 후 2시간 뒤 부터 My page에서 평점 확인이 가능합니다.
								</li>
								<li>Virtual Congress는 모바일에서 참여 및 출결 기록이 가능합니다. 여러 기기 동시 접속은 불가능 합니다.</li>
								<li>Virtual Congress는 Chrome과 Microsoft Edge browsers와 1920px*970px 해상도의 PC환경에 적합합니다.</li>
								<li>허가 영상의 재촬영이나 다운로드는 불법입니다. 저작권 및 초상권 등 법적인 이유로 온라인 강의 영상을 복제하는 것을 금합니다.</li>
							</ul>
						</div>
					</div>

					<p class="agree">
						<input type="checkbox" name="agree_chk" id="agree_chk">
						<label for="agree_chk">위의 내용 확인하였으며, 이에 동의합니다.</label>
					</p>

					<div class="btn">
						<input type="button" value="동의 및 입장하기" id="agree_confirm">
					</div>

				</fieldset>
			</form>
		</div>
		<?}else{?>
		<h1><img src="/asset/player/bl_agree.png" alt="">Caution</h1>
		<p>
			Please acknowledge the following and press '<span style="color: #ffeb3b;">I Agree</span>' to enter the Virtual Congress.
		</p>

		<div class="formArea">
			<form id="" name="" action="" method="post">
				<fieldset>
					<legend>Agree</legend>

					<div class="bg">
						<div class="agreeCon">
							<ul class="listNum">
								<li>The Virtual Congress is optimized for PCs (Chrome and Microsoft Edge browsers) and mobiles.</li>
								<li>Re-recording or downloading unauthorized lecture videos is forbidden due to copyrights and portrait rights</li>
							</ul>
						</div>
					</div>


					<p class="agree">
						<input type="checkbox" name="agree_chk" id="agree_chk">
						<label for="agree_chk">I agree</label>
					</p>

					<div class="btn">
						<input type="button" value="Enter" id="agree_confirm">
					</div>


				</fieldset>
			</form>
		</div>		
		<?}?>

	</div>
</div>
