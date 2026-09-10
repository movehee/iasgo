<div class="layerPopup" style="display: block;">
	<div class="popupWrap" id="popupAgree">
		<?if($_COOKIE['wmember_country']=='K'){?>
		<h1><i class="fas fa-exclamation-circle" style="margin-right:10px"></i>주의사항</h1>
		<p>
			아래 내용을 반드시 숙지하시고 ‘<span style="color: #ffeb3b;">동의하기</span>’ 버튼을 누르시면<br>
			Virtual Congress 에 입장하실 수 있습니다.
		</p>

		<div class="formArea">
			<form id="" name="" action="" method="post">
				<fieldset>
					<legend>Agree</legend>

					<div class="bg">
						<div class="agreeCon">
							<ul class="listNum">
								<li>
									각 세션별로 시작, 종료 시 마다 <span>[입장하기]</span> & <span>[퇴장하기]</span> 버튼을 반드시 클릭해 주십시오.
									<ul>
										<li>※ 의협 온라인학술대회 평점인정 기준 입니다. 각 세션별 입출 기록, 최초 입장시간, 최종 퇴장시간이 없을 경우 평점 인정이 불가능합니다.</li>
										<li>※ 부여된 평점은 당일 행사 종료 2시간 후 마이페이지에서 확인 가능합니다.</li>
									</ul>
								</li>
								<li>
									정확한 체류시간 확인을 위해 모든 강의 종료 후 퇴장시에는 <span>[Exit]</span> 버튼을 반드시 클릭 후 종료해 주십시오.
									<ul>
										<li>- HOME버튼이 아닌 인터넷 창의 X버튼을 누르신 후 종료하실 경우 정확한 기록이 남지 않습니다.</li>
										<li>- 강의 중 다른 강의장으로 이동할 경우 좌측 <span>[Room Selection]</span> 클릭 후 이동해 주시길 바랍니다.</li>
										<li>※ 해당 버튼을 누르면 자동으로 해당 룸에서 퇴장처리되며, 체류시간이 최종 퇴장시간으로 업데이트 됩니다.</li>
									</ul>
								</li>
								<li>
									본 플랫폼은 PC에 최적화 되어있으며 크롬 (Chrome) 최신 버전 및 Microsoft Edge (구 인터넷 익스플로러) 10버전 이상 에서 사용해주시기 바랍니다.(PC로 시청이 불가능 할 경우 Mobile로 시청 부탁드립니다.)
								</li>
								<li>강의영상의 재촬영이나 다운로드는 저작권 및 초상권 등 법적인 이유로 금하고 있습니다.</li>
							</ul>
						</div>
					</div>

					<p class="agree">
						<span class="inputC"><input type="checkbox" name="agree_chk" id="agree_chk" ></span>
						<label for="agree_chk">동의하기</label>
					</p>

					<div class="btn">
						<input type="button" value="입장" id="agree_confirm">
					</div>

				</fieldset>
			</form>
		</div>
		<?}else{?>
		<h1><i class="fas fa-exclamation-circle" style="margin-right:10px"></i>Caution</h1>
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
						<span class="inputC"><input type="checkbox" name="agree_chk" id="agree_chk" ></span>
						<label for="agree_chk">I Agree</label>
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
