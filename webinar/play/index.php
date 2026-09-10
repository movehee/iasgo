<?php
include $_SERVER['DOCUMENT_ROOT']."include/include.header.php";
include $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
include $_SERVER['DOCUMENT_ROOT']."/func/config_detail_times.php";
include $_SERVER['DOCUMENT_ROOT']."/func/config/play.php";
?>
<!-- <script type="text/javascript" src="/asset/jwplayer.js"></script> -->
<link type="text/css" rel="stylesheet" href="/asset/player.css">
<script type="text/javascript" src="play.js?0.3"></script>
<?
	if($_COOKIE['wmember_class']=='Y'){//부스
		//PutMessageClose("부스업체는 접근이 불가능합니다.");
		//exit;
	}


	if(date('Y-m-d') == "2022-09-20" && $_COOKIE['start_day_login']!='Y') {
		///PutMessageRefreshURL("Please log in again","/logout.php");
		//exit;
	}
	if($_COOKIE['lecture_yn'.$day]!='Y'){
		PutMessageRefreshURL("Live Session Room only can be accessible for only Virtual Access buyer. \\nThose who wish to purchase the Virtual Access may do so on-site at Coex","/enter/");
	}

	if($_SERVER['REMOTE_ADDR']!='218.235.94.220' && $_SERVER['REMOTE_ADDR']!='218.235.94.225') {}
		if($_COOKIE['wmember_level']!='M'){
			if($_COOKIE['wmember_days']!=$day){
				PutMessageRefreshURL("Please log in again","/logout.php");
				exit;
			}
			
			if($_Day['room_start'][$day]>$_Time['ing']){
				// PutMessageClose(date("Y-m-d H:i",$_Day['room_start'][$day])."부터 입장이 가능합니다.");
				PutMessageRefreshURL(date("Y-m-d H:i",$_Day['room_start'][$day])."부터 입장이 가능합니다.","/enter/");
				exit;
			}

//			if($day=='1' || $day=='2' || $day=='3'){
//				PutMessageClose("금일 강의가 종료되었습니다.");
//				exit;	
//			}
		}
	
	
	if(!$_COOKIE['Gkey']){
		PutMessageRefreshURL("Please log in again.","/play/block.php");
		exit;
	}
	
	if(!$room_sid) $room_sid=1;

	if($_COOKIE['wmember_class']=='P'){//Press
		PutMessageClose("접근이 제한됩니다.");
		exit;		
	}

	/** */
	//speaker 불러오기 위해 추가
	$ex_sdate = explode("-",$_Webinar['sdate']);
	$ev_date = $day;
	$to_date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($ev_date-1), $ex_sdate[0]));

	foreach($_DATE['date'.$day][$room_sid] as $tkey=>$tval){
		$Skey = $tkey;
		if($_Time['ing']<=strtotime($to_date." ".$tval['session_etime'])){
			break;
		} 
	}

	// echo $Skey;exit;

	if(!$Skey){ //세션이 없는경우 마지막 세션을 가져옴
		$Skey = end(array_keys($_DATE['date'.$day][$room_sid]));
	}
	//speaker 불러오기 위해 추가
	/** */


	foreach($_TIME['session'][$day][$room_sid] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		$ind[$tkey] = $tval[2];
		// if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
		// echo $tkey.'==='.date('Y-m-d H:i:s', $_Time['ing'])." <= ".$tval[1]."<br>";
		// }
		if($_Time['ing']<=strtotime($tval[1])){
			$before_edate = $end_date[($tkey-1)];
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			$ind_chk = $tval[2];
			break;
		}else{
			if($tkey=='C') continue;
			$befor_session = $tkey;
			$before_edate = $_TIME['session'][$day][$room][$tkey][1];
			$befor_ind = $_TIME['session'][$day][$room][$tkey][2];
		}
	}
	
	if(!$session){ //세션이 없는경우 마지막 세션을 가져옴
		$session = end(array_keys($_TIME['session'][$day][$room_sid]));
	}


	if($_SERVER['REMOTE_ADDR']=='218.235.94.225') {
		echo "day : " . $day . "<br>";
		echo "session : " . $session . "<br>";
		echo "Skey : " . $Skey ;
	}

	
	$key_val = $_COOKIE['wmember_sid']."_".time();

	$session_insert = "insert into checkin_detail_tbl".$_COOKIE['Gkey']." set room='$room_sid'";
	$session_insert .= ", session_in='$session'";
	$session_insert .= ", day='$day'";
	$session_insert .= ", key_val='$key_val'";
	$session_insert .= ", chk_type='E'";
	$session_insert .= ", location_kind='P'";
	$session_insert .= ", usid='".$_COOKIE['wmember_sid']."'";
	$session_insert .= ", check_in='".$_Time['ing']."'";
	$session_result=$conn->query($session_insert);
	if(DB::isError($session_result)) die($session_result->getMessage());


	$session_chkin = "In";
	
	$checkin_chk = $conn->getOne("select count(*) from checkin_tbl".$_COOKIE['Gkey']." where usid='".$_COOKIE['wmember_sid']."' and day='".$day."'");
	if(!$checkin_chk){
		$in_query = "insert into checkin_tbl".$_COOKIE['Gkey']." set usid='".$_COOKIE['wmember_sid']."', day='$day', first_date='".$_Time['ing']."', s".$session."_sdate='".$_Time['ing']."'";
		$in_result=$conn->query($in_query);
		if(DB::isError($in_result)) die($in_result->getMessage());
	}

	$enter_time = $conn->getOne("select first_date from checkin_tbl".$_COOKIE['Gkey']." where usid='".$_COOKIE['wmember_sid']."' and day='$day'");
	
	/*if($ind_chk=='Y'){
		$in_query = "update checkin_tbl_ind set first_date=if(first_date>0,first_date,'".$_Time['ing']."') where usid='".$_COOKIE['wmember_sid']."' and day='$day'";
		$in_result=$conn->query($in_query);
		if(DB::isError($in_result)) die($in_result->getMessage());
	}*/
?>
<script type="text/javascript">
var room = "<?=$room_sid?>";
var day = "<?=$day?>";	
var key_val = "<?=$key_val?>";
var country = "<?=$_COOKIE['wmember_country']?>";

<?if($_SERVER['REMOTE_ADDR']!='218.235.94.220' && $_SERVER['REMOTE_ADDR']!='218.235.94.225') {?>

var doubleFlag = false;
this.doubleCheck = function doubleCheck() {
	if(doubleFlag == true) {
		return doubleFlag;
	} else {
	doubleFlag = true;
		return false;
	}
}

document.addEventListener('keydown', function(e) {
	if ((e.which || e.keyCode) == 116){
		e.preventDefault(); //F5 방지
	}	
});
window.addEventListener('beforeunload', function(e) {
	none(e);
});
<?}?>

</script>
<script>
	$(document).ready(function(){
		// Details = setInterval( function () {
		// 	if($('#detail_viewer').length>0){
		// 		$(".play_tech_area").load("/load/play/session_detail.php?day="+day+"&room_sid="+room);
		// 	}
		// }, 10000);

		Details = setInterval( function () {			
			$.ajax({
				type : 'POST',
				data : {day: day, room_sid: room, mode: "interval"},
				url : '/load/play/session_detail.php',
				dataType: 'JSON',
				success : function(data) {
					
					$(".play_tech_area").html(data.session_detail);


					if($('#fsid').attr("Skey") != data.Skey) {
						$('#fsid').attr("Skey", data.Skey);

						$("#fsid option").not("option[value='']").remove();

						var option = "";
						$.each(data.speakers, function(i){
							option += '<option value="'+data.speakers[i]['key']+'">'+data.speakers[i]['val']+'</option>'; 
						});

						$('#fsid').append(option);
					}
					
					$("#top_title").html(data.session_title);

					if(data.voting == 'N') {
						$("#voting_btn").addClass("txtFlicker");
					} else {
						$("#voting_btn").removeClass("txtFlicker");
					}
				}

			});
		}, 10000);
	});

    function session_eval(session_key) {
        $.colorbox({href:"/load/session_evaluation.php?session_sid="+session_key, iframe:true, transition:"fade", width:1000, maxWidth:"100%", height:800, maxHeight:"100%", top:50, speed:150, fixed:false,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
    }    
</script>
<style>
.flicker {display: inline-block;animation-duration:1s;animation-name:flicker; animation-iteration-count: infinite;}
@keyframes flicker {
	0% {opacity:0;}
	50% {opacity:1;}
	100% {opacity:0;}
}
</style>

<input type="hidden" name="survey_key" id="survey_key" value="">
<input type="hidden" name="out_chking" id="out_chking" value="Y">

<div class="contents">

	<div id="player">
	
		<div id="playzone">
			<div class="playerPannel">
				<div class="scrollArea">
					<dl class="sessionInfo type<?=$room_sid?>">
						<dt>
							<span class="room" pub-room=""> <?=$_Day['room_title'][$room_sid]?></span>
							<!-- <span class="room" pub-room="(Room <?=$room_sid?>)"> <?=$_Day['room_title'][$room_sid]?></span> -->
							<span class="tit" id="top_title">
								<!-- State-of-the-art lymphatic intervention (SF04) -->
								<?=$_DATE['date'.$day][$room_sid][$Skey]['title']?>
							</span>
							<span class="name"><?=$_COOKIE['wmember_name']?> (<?=$_COOKIE['wmember_aff']?>)</span>
						</dt>

						<!-- <?if($_COOKIE['wmember_country']=='K'){?>
						<div class="btn">
							<li id="session_checkin_area"><a href="#" class="in inout_txt">Waiting..</a></li>
						</div>
						<?}?> -->

						<dd class="btn">
						<?if($_COOKIE['wmember_country']=='K'){?>
							<!-- <a id="session_checkin_area" class="log">퇴장시간 기록</a> -->
							<li id="session_checkin_area" class="log"><a href="#" class="in inout_txt">Waiting..</a></li>

							<a href="javascript:room_close('exit')" class="exit" style="margin-left: 10px;">EXIT</a>
						<?}else{?>
							<a href="/enter/" class="out">EXIT</a>
						<?}?>
						</dd>
					</dl>

					<ul class="playerMenu">
						<li><a class="viewPopup" href="javascript:viewer_area('notice')">Notice</a></li>
						<li><a href="javascript:room_refresh()">Refresh</a></li>

						<li><a href="/load/tech.php" class="Load_Base"  Wsize='803' Hsize='495' Tsize='15%'>Technical Support </a></li>
						
				<!-- 		<li><a class="viewPopup" id="voting_btn" href="javascript:viewer_area('voting')">Voting</a></li> -->

						<li><a href="/load/glance.php" class="Load_Base" Wsize='1215' Hsize='800' Tsize='6%'>Program at a Glance</a></li>
						<li><a href="javascript:room_close('selection')">Room Selection</a></li>
					</ul>
				</div>


				<?
					//개별 팝업으로 나오는 거
					include $_SERVER['DOCUMENT_ROOT']."play/include/notice.php";
					// include $_SERVER['DOCUMENT_ROOT']."play/include/question.php";
					
					// include $_SERVER['DOCUMENT_ROOT']."play/include/tech.php";
				?>


			</div>
			<!-- //playerPannel -->

			<?
				//개별 팝업으로 나오는 거
				include $_SERVER['DOCUMENT_ROOT']."play/include/voting.php";
				// include $_SERVER['DOCUMENT_ROOT']."play/include/question.php";
				
				// include $_SERVER['DOCUMENT_ROOT']."play/include/tech.php";
			?>
			
			<div id='my_video'>
				<iframe style="border:0;width: 100%; height: 100%" src="<?=$_PROGRAM['movie'][$room_sid]?>"  allowfullscreen="true" ></iframe>
			</div>

		</div>
		<!-- //playzone -->

		<?
		$speakers = array();
		if($_DATE['date'.$day.'_detail'][$room_sid][$Skey]){
			foreach($_DATE['date'.$day.'_detail'][$room_sid][$Skey] as $tkey=>$tval){
				// if(!trim($tval['detail_author'])) continue;				
				if($tval['detail_author']){
					$ex_author = explode("(",$tval['detail_author']);
					array_push($speakers, array("key"=>$tval['faculty_sid']."|:|".base64_encode($tval['detail_title']), "val"=>$ex_author[0]));
				}

			}
		}
		
		?>
		
<!-- 		<dl class="qna">
			<dt>LIVE Q&amp;A</dt>
			<dd>
				<form id="QuestionF" name="QuestionF" method="post">
				<input type="hidden" name="room_sid" value="<?=$room_sid?>">
					<fieldset>
						<select name="fsid" id="fsid" Skey="<?=$Skey?>">
							<option value="">Speaker's Name</option>
							<?php foreach($speakers as $speaker): ?>
								<option value="<?=$speaker['key']?>"><?=$speaker['val']?></option>
							<?php endforeach;?>
						</select>
						<textarea name="session_question" id="session_question" cols="30" rows="10" placeholder="Please type your question here."></textarea>
						<input type="submit" value="Submit" class="send_question">
					</fieldset>
				</form>
			</dd>
		</dl> -->
		
		<div class="play_tech_area">
		<?include $_SERVER['DOCUMENT_ROOT'].'load/play/session_detail.php'?>
		</div>


	</div>
	<!-- //player -->

	<dl class="sponsor">
		<dt>Sponsored by</dt>
		<dd>
			<ul>
				<li><a href="https://www.cmscorea.co.kr/" target="_blank"><img src="/asset/layout/footer_pla_cms.png" alt="central medical service"></a></li>
						<li style="margin-right: 10px;" ><a href="https://www.guerbet.com/ko-kr" target="_blank"><img src="/asset/layout/footer_pla_guerbet.png" alt="guerbet"></a></li>
						<li style="margin-right: 10px;" ><a href="https://www.bayer.com/ko/kr/korea-home" target="_blank"><img src="/asset/layout/footer_pla_bayer.png" alt="bayer"></a></li>
						<li><a href="http://www.dkls.co.kr/" target="_blank"><img src="/asset/layout/footer_pla_dongkook.png" alt="dongkook lifescience"></a></li>
						<li style="margin-right: 10px;" ><a href="https://www.gehealthcare.co.kr/" target="_blank"><img src="/asset/layout/footer_pla_ge.png" alt="ge healthcare"></a></li>
						<li style="margin-right: 10px;" ><a href="https://www.bracco.com/" target="_blank"><img src="/asset/layout/footer_pla_bracco.png" alt="bracco"></a></li>
						<li><a href="https://www.united-imaging.com/en/" target="_blank"><img src="/asset/layout/footer_pla_united.png" alt="united imaging"></a></li>
						<li><a href="http://www.taejoon.co.kr/service/contents/poduct/information.do?page=1&mprSeq=&tabClick=1&initial=&mprForm=&mprLang=K&mprName=&mprClass=MPR01&mprSymp=" target="_blank"><img src="/asset/layout/footer_pla_accuzen.png" alt="accuzen"></a></li>
<!-- 
				<li><a href="https://www.siemens-healthineers.com/kr" target="_blank"><img src="/asset/bnr/gold_02.jpg" alt="Siemens Healthineers Ltd."></a></li>
				<li><a href="http://www.philips.co.kr/healthcare" target="_blank"><img src="/asset/bnr/gold_04.jpg" alt="Philips Korea"></a></li>
				<li><a href="http://kr.medical.canon" target="_blank"><img src="/asset/bnr/gold_05.jpg" alt="Canon Medical Systems Korea"></a></li>
				<li><a href="http://samsunghealthcare.com/kr" target="_blank"><img src="/asset/bnr/gold_06.jpg" alt="SAMSUNG MEDISON"></a></li>
				<li><a href="https://www.infinitt.com" target="_blank"><img src="/asset/bnr/gold_03.jpg" alt="INFINITT Healthcare"></a></li>
				<li><a href="http://www.guerbet.com/ko-kr" target="_blank"><img src="/asset/bnr/gold_01.jpg" alt="Imaging Solution Korea"></a></li>

				<li><a href="http://www.claripi.com" target="_blank"><img src="/asset/bnr/silver_01.jpg" alt="ClariPi Inc"></a></li>

				<li><a href="http://www.dasol-ls.com" target="_blank"><img src="/asset/bnr/bronze_04.jpg" alt="Dasol Life Science Inc"></a></li>
				<li><a href="http://www.jw-medical.co.kr/medical/ko/main.jsp" target="_blank"><img src="/asset/bnr/bronze_03.jpg" alt="JW Medical"></a></li>
				<li><a href="http://www.withhealthcare.com" target="_blank"><img src="/asset/bnr/bronze_01.jpg" alt="With Healthcare"></a></li>
				<li><a href="http://www.dkms.co.kr" target="_blank"><img src="/asset/bnr/bronze_02.jpg" alt="DK Medical Solutions"></a></li>
				<li><a href="http://www.lunit.io" target="_blank"><img src="/asset/bnr/bronze_06.jpg" alt="Lunit Inc."></a></li>
				<li><a href="http://www.iheuron.com" target="_blank"><img src="/asset/bnr/bronze_05.jpg" alt="Heuron"></a></li>
				<li><a href="http://www.vuno.co/" target="_blank"><img src="/asset/bnr/bronze_07.jpg" alt="VUNO Inc."></a></li>
				<li><a href="http://annalise.ai" target="_blank"><img src="/asset/bnr/bronze_08.jpg" alt="Annalise.ai"></a></li> -->
			</ul>
		</dd>
	</dl>
	
</div>
<!-- //contents -->





<?include $_SERVER['DOCUMENT_ROOT']."include/include.footer.php"?>


<?if(!$_COOKIE['agree_day'.$day.'_'.$room_sid]){?><?}?>
<?if($_SERVER['REMOTE_ADDR']!='218.235.94.225'){?>
<?include $_SERVER['DOCUMENT_ROOT']."play/include/agree.php"?>
<?}?>
<?if($_COOKIE['wmember_class']!='M'){?>
<?
	$login_code = $_COOKIE['wmember_sid']."_".GenerateString(10);
	$session_query = "update registration_tbl set session_code='$login_code', room='$room_sid' where sid='".$_COOKIE['wmember_sid']."'";
	$session_result = $conn->query($session_query);
	if(DB::isError($session_result)) {
		die($session_result->getMessage());
	}
?>
<script>
	function popup_link(link){
		window.open(link,'','width=1500,height=1000');
	}
	var login_code = "<?=$login_code?>";
	$(document).ready(function(){
		var loginchk = setInterval( function () {
			$.ajax({
				type : 'POST',
				url : '/load/play/loginchk.php',
				data: { usid: "<?=$_COOKIE['wmember_sid']?>",login_code: login_code, room:room},
				success : function(result) {
					var parse_data = JSON.parse(result);
					if(parse_data.loginchk=="N"){
						// location.href="/play/block.php"; //임시 막음
						location.replace("/play/block.php");
						return false;
					}else if(parse_data.loginchk=="P"){
						alert("Viewable session has ended.");
						// opener.location.href="/logout.php";
						// self.close();
						location.href = "/logout.php";
					}
				}
			});
		}, 60000);//60000
	});
</script>
<?}?>

</body>
</html>
<?
if($conn){
	$conn->disconnect();
}
?>