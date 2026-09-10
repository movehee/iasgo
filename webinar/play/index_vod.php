<?
header('Content-Type: application/json; charset=utf-8');
session_start(); 
include $_SERVER['DOCUMENT_ROOT']."lib.php";

if($_COOKIE['wmember_sid']!='5288'){
	if($_COOKIE['wmember_level']!="M"){
		if(strtotime("2020-10-26 00:00")<time()){
			//PutMessageClose("행사가 종료되었습니다.");
			//exit;
		}
	}
}

$_VOD['link'] = array(
	'1'=>"https://player.vimeo.com/external/539011686.hd.mp4?s=49554629142d6d89e60c178ae72e0a6fac8ea8cd&profile_id=174",
	'2'=>"https://player.vimeo.com/external/539012296.hd.mp4?s=048378a6a8d04acb9970361b538336961dfac3d0&profile_id=174",
	'3'=>"https://player.vimeo.com/external/539012839.hd.mp4?s=912a84393e34344ffc6be200052c93391f0873e5&profile_id=174",
	'4'=>"https://player.vimeo.com/external/539440156.hd.mp4?s=37ca694c31e3427e9d16b994edaa143ad65db5aa&profile_id=174"
);

$_VOD['time'] = array(
	'1'=>"3542",
	'2'=>"3416",
	'3'=>"3764",
	'4'=>"3123"
);

$stream_url = $_VOD['link'][$vsid]; //영상 주소
$all_time = $_VOD['time'][$vsid];
$cur_time = 0;

if(!$vsid){
	PutMessageBack("영상주소를 가져오지 못하였습니다.\다시 방을 선택해주세요.");
	exit;
}

if(strtotime("2021-04-25 23:59:59")<time()){
	PutMessageClose("초음파교육 수강이 종료되었습니다.");
	exit;
}

$vchk = $conn->getOne("select count(*) from vod_result_tbl where vsid='$vsid' and usid='".$_COOKIE['wmember_sid']."'");
if(!$vchk){
	$in_query = "insert into vod_result_tbl set r_time='".$all_time."', usid='".$_COOKIE['wmember_sid']."', vsid='$vsid'";
	$in_result = $conn->query($in_query);
	if(DB::isError($in_result)) {
		die($in_result->getMessage());
	}
}else{
	$query = "select * from vod_result_tbl where vsid='$vsid' and usid='".$_COOKIE['wmember_sid']."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	$cur_time = $d['c_time'];
	$p = ($d['c_time']/$d['r_time'])*100;
	$cur_per = round($p);
	if($d['finish']=='Y'){
		$cur_time = 0;
	}
}



if(!$cur_time){
	$cur_time = 0;
}
$number = $_COOKIE['wmember_sid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>대한내과학회</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/player.css">
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/asset/jwplayer.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/player.js"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<script src="/review/flowplayer.min.js"></script>
<link rel="stylesheet" href="//releases.flowplayer.org/6.0.5/skin/minimalist.css">
<link rel="stylesheet" href="/review/functional.css">
<link rel="stylesheet" href="/review/flowplayer_custom.css">

<script type="text/javascript">

// ********************************* flowplayer onload/on seektime setting  ********************************* //
window.resizeTo(1400,965);
flowplayer(function (api, root) {
	var all_time = '<?=$all_time?>';
	 var che = <?=$cur_time?>;
	 
	api.on("load", function () {
		//$(".movieArea").find("background-image").attr('');
	}).on("ready", function () {
		api.seek(che);
	}).on("play", function() {
		//alert(1);
		//alert();
	}).on("seek", function() {
		//alert(2);
	}).on("resume", function() {
		//alert(3);
		//$(".movieArea").find("background-image").attr('');
		$("#graph").removeClass("ready");
	}).on("pause", function() {
		//alert(4);
	}).on("stop", function() {
		//alert(5);
	});
});
setInterval(function(){
	var all_time = <?=round($all_time)?>;
	var api = flowplayer(), currentPos;
	currentPos = api.ready ? api.video.time : 0;
	var elapsed = currentPos.toString();
	//console.log((currentPos/all_time)*100);
	var elapsed2 =  Math.round((currentPos/all_time)*100);
	showUser(elapsed,elapsed2);
},60000);//60000
//********************************* 5 secound check  ********************************* //

//************************** current time connect call  ****************************** //
function showUser(str,str2) {
	
	var usid = <?=$number?>;
    if (str == "") {
        //document.getElementById("txtHint").innerHTML = "";
        return;
     } else {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                //document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
             }
			//alert(xmlhttp.status);
        }
		if(str>0){
			xmlhttp.open("GET","/play/vod_update.php?cur_time="+str+"&usid="+usid+"&vsid="+<?=$_GET['vsid']?>,true);
			xmlhttp.send();
		}
    }
	<?if($d['finish']!='Y'):?>
	$(".bar").css('width',str2+"%");
	$(".graph").attr("data-num",str2+'%');
	if(str2>=99){
		//$("#flicker_area").attr("class",'flicker');
	}
	<?endif?>
}
function complete_vod(vsid){
	$.ajax({
		type:"POST",
		url:"/play/vod_confirm_reg.php",
		data:"vsid="+vsid,
		async:false,
		success:function(msg){
			if(msg=="Y"){
				alert("수강을 완료하였습니다.\n수고하셨습니다.");
				location.reload();
				return;
			}else{
				alert("아직 수강을 완료하지 못했습니다.");
				return;
			}
		}
	});
}
</script>
<?if($d['finish']!='Y'):?>
<style>
	.fp-time {display:none!important}
	.fp-controls {display:none!important}/* *//*20150728임시로 컨트롤바 아웃*/
	.flicker {display: inline-block;animation-duration:1s;animation-name:flicker; animation-iteration-count: infinite;color:red;}
	@keyframes flicker {
		0% {opacity:0;}
		50% {opacity:1;}
		100% {opacity:0;}
	}
</style>
<?endif?>

</head>
<body>

<div id="player">
	<div class="playerTit">
		<h1><img src="/asset/player/player_logo.png" alt=""></h1>
		<div class="note">※ 영상 화면을 클릭하여 재생을 시작해 주세요. Click the video screen to start playing.</div>
		
		<dl>
			<dt>
				<?=$_COOKIE['wmember_name']?>(<?=$_COOKIE['wmember_aff']?>)
				<span>입장시간: <?=date("H시 i분 s초",$_COOKIE['wmember_logindate'])?></span>
			</dt>
			<dd>
				<a href="<?=$PHP_SELF?>?vsid=<?=$vsid?>" class="refresh">새로고침</a>
				<a href="/play/room_vod.php" class="out">
				초음파교육 퇴장하기
				</a>
			</dd>
		</dl>

	</div>
	<div class="flowplayer" data-ratio="0.4167" data-key="$238996279069523">
		<video>
			<source type="video/mp4" src="<?=$stream_url?>">
		</video>
	</div>

	<script type='text/javascript'> 
		$(document).ready(function(){
		
			var width = screen.width;
			var height = screen.height;

			window.resizeTo(width,height);
			//화면 리사이징 끝
			


			//새로고침 및  x,alt+f4시 퇴장 처리
			/*document.addEventListener('keydown', function(e) {
				//none(e);
				if ((e.which || e.keyCode) == 116){
					e.preventDefault();
				}	
			});

			window.addEventListener('beforeunload', function(e) {
				none(e);
			});*/

		});
	</script>
	<div class="playerPannel">
		<dl class="state">
			<dt>진도율</dt>
			<dd class="graph" data-num="<?=$cur_per?>%">
				<div class="graphBar bar" style="width: <?=$cur_per?>%;"></div>
			</dd>
			<dd>
				진도율 100%가 되신 뒤 아래 보이는 완료버튼을 클릭하셔야 최종 이수완료가 됩니다.
			</dd>

			
		</dl>
		<div class="playComp"><a href="javascript:complete_vod('<?=$vsid?>')"><img src="/asset/player/playComp.png" alt=""> <b id="flicker_area" -class="flicker" >수강 완료</b></a></div>
		<div class="programNote">
			<p>수강을 완료하시면 영상의 재생구간 조정이 가능합니다.</p>
			<p>영상의 경우 사용자의 환경에 따라 늦게 불러오는 경우가 있을 수 있습니다.</p>
			<p>※ 초음파 교육(VOD) 은 4월 25일(일) 24:00까지 수강을 완료해야 내과전공의 초음파교육 건수가 인정되오니 교육이수에 참고하시기 바랍니다.</p>
		</div>

	</div>
	<!-- //pannel -->
</div>
<?
	$login_code = $_COOKIE['wmember_sid']."_".GenerateString(10);
	$session_query = "update registration_tbl set session_code='$login_code' where sid='".$_COOKIE['wmember_sid']."'";
	$session_result = $conn->query($session_query);
	if(DB::isError($session_result)) {
		die($session_result->getMessage());
	}
?>
<script>
	var login_code = "<?=$login_code?>";
	$(document).ready(function(){
		var loginchk = setInterval( function () {
			$.ajax({
				type : 'POST',
				url : '/play/load/loginchk.php',
				data: { usid: "<?=$_COOKIE['wmember_sid']?>",login_code: login_code, },
				success : function(result) {
					var parse_data = JSON.parse(result);
					if(parse_data.loginchk=="N"){
						location.href="/play/block.php";
						return false;
					}
				}
			});
		}, 60000);//60000
	});
</script>
</body>
</html>