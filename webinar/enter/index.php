<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<div class="contents">

	<div class="mainCon">
		<h2><img src="/asset/layout/main_tit.png" alt="KCR 2023 / 2023.9.20.WED ~ 9.23.SAT COEX, SEOUL, KOREA, Exploring Beyond the Horizon"></h2>

		<ul class="mainMenu">
			<li><a href="/session/">Live Session</a></li>
			<li><a href="/program/">Program</a></li>
			<li><a href="/faculty/">Invited Guests</a></li>
			<li><a href="/poster/">E-posters</a></li>
			<li><a href="/case/">KCR Quiz </a></li>
		</ul>

		<dl class="mainNotice">
			<dt>Notice</dt>
			<dd>
				<ul>
					<?
					$query = "select * from w_notice_tbl where del='N'";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());
					while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
					?>
					<li><a href="/load/notice.php?notice_sid=<?=$d['sid']?>" class="Load_notice"><?=$d['subject']?></a></li>
					<?}?>
				</ul>
			</dd>
		</dl>

	</div>
</div>

<div class="layerPopup" id="layerPopup"  >
	<div class="popupWrap" id="popupAgree">
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
									해당 일 행사 종료 후 2시간 뒤 부터 My page에서 최종 평점 확인이 가능합니다.
								</li>
								<li>Virtual Congress는 모바일에서 참여 및 출결 기록이 가능합니다. 여러 기기 동시 접속은 불가능 합니다.</li>
								<li>Virtual Congress는 Chrome과 Microsoft Edge browsers와 1920px*970px 해상도의 PC환경에 적합합니다.</li>
								<li>허가 영상의 재촬영이나 다운로드는 불법입니다. 저작권 및 초상권 등 법적인 이유로 온라인 강의 영상을 복제하는 것을 금합니다.</li>
							</ul>
						</div>
					</div>


					<p class="agree">
						<input type="checkbox" name="" id="">
						<label for="">내용확인했으며 이에 동의합니다.</label>
					</p>

					<div class="btn">
						<input type="submit" value="동의하기">
					</div>

				</fieldset>
			</form>
		</div>

	</div>
</div>

<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>