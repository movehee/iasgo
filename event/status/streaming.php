<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$ave_day = $ev_date;

	$query = "select count(*) ";
	$query .= " , sum(case when login_day".$ave_day.">0 and country='K' then 1 else 0 end) as login_cnt_K";
	$query .= " , sum(case when login_day".$ave_day.">0 and country='F' then 1 else 0 end) as login_cnt_F";
	$query .= " , sum(case when login_day".$ave_day.">0 and login_kind='P'  then 1 else 0 end) as login_Pcnt";
	$query .= " , sum(case when login_day".$ave_day.">0 and login_kind='M'  then 1 else 0 end) as login_Mcnt";
	foreach($_CONFIG['room'] as $tkey=>$tval){
		$query .= ", sum(case when room='$tkey' and country='K' then 1 else 0 end) RK_cnt".$tkey;	
		$query .= ", sum(case when room='$tkey' and country='F' then 1 else 0 end) RF_cnt".$tkey;	
	}
	$query .= " from registration_tbl where del='N' and member_level!='M' and classification not in ('M','Y')";
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();


	$Rcnt = count($_CONFIG['room']);
?>
<script>
$(document).ready(function(){
	var Rcnt = "<?=$Rcnt?>";
	var load_cnt = setInterval( function () {
		$.ajax({
			type : 'POST',
			url : '/status/play_count.php',
			//data:{ room_sid : room},
			success : function(data) {
				var parse_data = JSON.parse(data);
				//alert(parse_data.room1_kcnt);
				$('#r1_kor').html(parse_data.room1_Kcnt);
				$('#r2_kor').html(parse_data.room2_Kcnt);
				$('#r3_kor').html(parse_data.room3_Kcnt);
				$('#r4_kor').html(parse_data.room4_Kcnt);
				$('#r5_kor').html(parse_data.room5_Kcnt);
				$('#r6_kor').html(parse_data.room6_Kcnt);
				$('#r7_kor').html(parse_data.room7_Kcnt);
				$('#r8_kor').html(parse_data.room8_Kcnt);
				$('#r9_kor').html(parse_data.room9_Kcnt);

				$('#r1_eng').html(parse_data.room1_Fcnt);
				$('#r2_eng').html(parse_data.room2_Fcnt);
				$('#r3_eng').html(parse_data.room3_Fcnt);
				$('#r4_eng').html(parse_data.room4_Fcnt);
				$('#r5_eng').html(parse_data.room5_Fcnt);
				$('#r6_eng').html(parse_data.room6_Fcnt);
				$('#r7_eng').html(parse_data.room7_Fcnt);
				$('#r8_eng').html(parse_data.room8_Fcnt);
				$('#r9_eng').html(parse_data.room9_Fcnt);


			}
		});
	}, 60000);
});
</script>
<style>
div#playzone {}
div#playzone:after {clear: both;display: block;height: 0;line-height: 0;font-size: 0;content: "";}
div#playzone > * {float: left;width: calc(48% - 5px);margin:0 0 0 20px;margin-top:3px;border: 1px solid #043669;box-sizing:border-box;}
div#playzone > *:nth-child(2n+1) {clear: both;margin-left: 0;}

div#playzone dt {background-color: #043669;color: #fff;padding: 10px 15px;}
div#playzone dd {margin: 0;padding: 15px;}
div#playzone dd > div {width: 100%;height: 353px;}
</style>

<div id="playzone" >
	<?for($i=1;$i<=$Rcnt;$i++){?>
	<?if($i=='1' || $i=='3' || $i=='5' || $i=='9'){?>
	<dl>
		<dt><?=$_Day['room_title'][$i]?><div style="float:right;">국내 : <span id="r<?=$i?>_kor"><?=$cnt['RK_cnt'.$i]?></span>명/ 해외 : <span id="r<?=$i?>_eng"><?=$cnt['RF_cnt'.$i]?></span>명</div></dt>
		<dd>
			<div id='my_video<?=$i?>'>
				<iframe style="border:0;width: 100%; height: 353px;" src="<?=$_PROGRAM['movie'][$i]?>"  allowfullscreen="true" ></iframe>
			</div>
		</dd>
	</dl>
	<?}?>
	<?}?>
</div>

</center>

<!-- <script  type="text/javascript"  src="https://cdn.jwplayer.com/libraries/KC7Ayk5o.js"></script> -->

<script type='text/javascript'> 
	
	<?for($i=1;$i<=9;$i++){?>
	// 	var playlink<?=$i?> = "<?=$_PROGRAM['movie'][$i]?>";
	// 	const playerInstance<?=$i?> = jwplayer('my_video<?=$i?>');
	// 	playerInstance<?=$i?>.setup({ 
	// 	file:playlink<?=$i?>,
	// 	//file:'https://liveto.nowcdn.co.kr/live2/kaim/playlist.m3u8',
	// 	//image: '/image/play/player_logo.png',
	// 	width: '100%',        
	// 	height: '100%',
	// 	mute :false, //  true 소리 false 없음
	// 	autostart:true, //  true 자동재생 false 수동
	// 	modes: [
	// 	   { type: "html5" },
	// 	   { type: "flash", src: "/js/jwplayer/player.swf" },
	// 	   { type: "download" }
	// 	]});
	// <?}?>
</script>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>