<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<!-- $(document).ready(function(){
parent.$.colorbox.resize({width:800,height:1000});
}); -->
<?
	$query = "select * from w_notice_tbl ";
	if(!$notice_sid){
		$query .= " where use_yn='Y' and del='N' order by top desc,sort_num desc limit 0,1";
	}else{
		$query .= " where use_yn='Y' and del='N' and sid='$notice_sid'";
	}
	
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}

	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$content_sid = $d['sid'];


?>
<div class="popupWrap" id="popupBbs">
	<div class="popupCon">
		<dl class="bbsCon">
			<dt>FAQ</dt>
			<dd class="scrollArea">
				<dl class="faq">
					<dt class=""><a class="trigger" href="#"> When will  be able to attend the Live Session Room?</a></dt>
					<dd class="toggleCon">
						You have 30 minutes before the session starts to access the Live Session Room.<br>(For Koreans) 세션 시작 이전 시간은 평점에서 제외되는 점 참고 부탁 드립니다.
					</dd>
				</dl>
				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Technical Support</a></dt>
					<dd class="toggleCon">
						<strong>[기술 지원]</strong><br>
						접속ID 관련 문의<br>
						Tel. +82-2-6207-8176 &nbsp;&nbsp; E-mail. <a href="mailto:kcr@kcr4u.org" class="conLink">kcr@kcr4u.org</a><br>
						유선 연락 시 문의가 누락될 수 있어 가급적 이메일로 문의 주시면 순차적으로 확인후 조속히 답변 드리겠습니다.<br><br>

						<strong>[Technical Support]</strong><br>
						If you have any technical, ID/Password issues, please contact us.<br>
						Tel. +82-2-6207-8179 &nbsp;&nbsp; E-mail. <a href="mailto:kcr@kcr4u.org" class="conLink">kcr@kcr4u.org</a>
					</dd>
				</dl>
				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Click below to contact us</a></dt>
					<dd class="toggleCon">
						<strong>[Scientific Programs]</strong><br>
						Tel. +82-2-6207-8174 / +82-2-6207-8173 &nbsp;&nbsp;  E-mail. <a href="mailto:sci@kcr4u.org" class="conLink">sci@kcr4u.org</a> / <a href="mailto: abstract@kcr4u.org" class="conLink"> abstract@kcr4u.org</a><br><br>

						<strong>[General & 평점 문의]</strong><br>
						Tel. 02-3452-7241 &nbsp;&nbsp; E-mail. <a href="mailto:ask@kcr4u.org" class="conLink">ask@kcr4u.org</a>
					</dd>
				</dl>
 
				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Is Real Time Q&A possible?</a></dt>
					<dd class="toggleCon">
						Yes, real-time Q&A is possible. All virtual participants will be able to join in interactive communication and ask questions through the virtual platform directly. These processes will be regulated by session chairs and all Q&A will be streamed in real time via the virtual platform
					</dd>
				</dl>

				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Can I log-in with another device?</a></dt>
					<dd class="toggleCon">
						Yes, but multiple access will not be allowed in real-time.
					</dd>
				</dl>

				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Can I access with the mobile device?</a></dt>
					<dd class="toggleCon">
						Yes, but It is recommended you to use 'Chrome' browser on your PC.
					</dd>
				</dl>

				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Will the Online Congress take place at the same time as the Congress dates?</a></dt>
					<dd class="toggleCon">
						Yes, the platform will be available from September 18 (Sun), 2022, with all sessions live-streamed according to the program schedule.
					</dd>
				</dl>

				<dl class="faq">
					<dt class=""><a class="trigger" href="#">Can people still register now?</a></dt>
					<dd class="toggleCon">
						Yes, the registration is available during the congress.<br><br>
						Since the virtual platform and the congress website registration information are not linked. So, online onsite registrants send your name and congress website ID(E-mail) information to register@kcr4u.org after completing the registration fee payment. Please note that it may take some time to create an virtual platform account.<br><br>
						After registration, please login with your email and Reg No.
					</dd>
				</dl>
			</dd>
		</dl>
		<?
			$Notice_cnt = $conn->getOne("select count(sid) from w_notice_tbl where use_yn='Y' and del='N' ");
		?>
		<div class="bbsList">
			<p class="count">Total <span><?=$Notice_cnt?></span></p>
			<ul>
				<li class="faq readed">
					<a href="#">FAQ</a>
				</li>
				<?
					$query = "select * from w_notice_tbl where use_yn='Y' and del='N' order by top desc,sort_num desc";
					$result=$conn->query($query);
					if(DB::isError($result)) die($result->getMessage());
					$n=1;
					while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))) {

					$vchk = $conn->getOne("select count(sid) from w_notice_view_tbl where nsid='".$d['sid']."' and usid='".$_COOKIE['wmember_sid']."'");
				?>
					<?if($d['top']=='Y'){?>
						<li class="notice<?if($vchk){?> readed<?}?>">
							<a href="notice.php?notice_sid=<?=$d['sid']?>">
								<span class="tit"><?=$d['subject']?></span>
							</a>
						</li>
					<?}else{?>
						<li class="<?if($notice_sid==$d['sid']){?>on<?}?><?if($vchk){?> readed<?}?>">
							<a href="notice.php?notice_sid=<?=$d['sid']?>"><span class="tit"><?=$d['subject']?></span></a>
						</li>
					<?}?>
				<?}?>
			</ul>
		</div>
	</div>
	<!-- //popupCon -->
	<div class="close"><a class="color_close"></a></div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>
