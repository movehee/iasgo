<?
include $DOCUMENT_ROOT . 'func/include.function.php';
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


$result = mysqli_query($conn, "SELECT * FROM event_tbl where code='".$code."'");
$event_db = mysqli_fetch_array($result);

$result = mysqli_query($conn, "SELECT * FROM question_tbl where del='N' and code='".$code."' and view='Y'");
$d = mysqli_fetch_array($result);

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title><?=$event_db['name']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/voting.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/feedback.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->

<link href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>
<style>
div::-webkit-scrollbar { 

    display: none
</style>
</head>
<body>

<div class="wrapper" style="background:url()">

	<div class="fullScreenQna">
		<h1>Question</h1>
		<div id="qna" class="qnaCon" style="font-size:40px;">
			<?if($d['question']){?>
				<?=nl2br($d['question'])?>
			<?}else{?>
				<h2 class="centerTit">Q &amp; A</h2>
			<?}?>
		</div>

		<div class="util">
			<!-- <a onclick="javascript:reset('<?=$code?>')" class="viewQna"><i class="fas fa-question-circle"></i> Q &amp; A</a> -->
			<!--
			<a href="#" class="refresh"><i class="fas fa-sync-alt"></i> 새로고침</a>
			-->
		</div>
	</div>

</div>
<!-- //wrapper -->



</body>

<script>

	function reset(code){
		$.ajax({
			type:"POST",
			url:"./reset.php",
			data:"code="+code,
			success:function(msg){
				document.getElementById("qna").innerHTML="<h2 class='centerTit'>Q &amp; A</h2>";
			}
		});
	}
	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	var code = getParameterByName("code");
	setInterval(function() {
		
		$.ajax({
			type:"POST",
			url:"./get_qna.php",
			data:"code="+code,
			success:function(msg){
				document.getElementById("qna").innerHTML=msg;
			}
		});
		
	}, 500);

</script>
</html>