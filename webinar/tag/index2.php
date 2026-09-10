<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>대한의료관련감염관리학회 출결</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	var min_H = $("div.attendanceCon").outerHeight() + 100;

	if (min_H < $(window).height()){
		var min_H = $(window).height() - $("h1").outerHeight();
	}

	$("div.contents").css({
		"min-height":min_H
	});

	// 브라우저창 사이즈가 변경될 때
	$(window).resize(function(){

		if (min_H < $(window).height()){
			var min_H = $(window).height() - $("h1").outerHeight();
		}

		$("div.contents").css({
			"min-height":min_H
		});

	});
	$('#tag_number').focus();
});
</script>
</head>
<body  onclick="$('#tag_number').focus();">
<form id="tagF" name="tagF" action="tag_reg.php" method="post" >
<input type="hidden" name="kind" id="kind" value="echo">
<div class="attendance" style="z-index:999;">
	<h1><img src="asset/topVisual.png" alt=""></h1>
	<div class="contents">
		<div class="attendanceCon">
			<div class="attendanceNote tp30">
				<b style="color:#0654BC;">Basic Echo Review Course</b><br />
				우측바코드 리더기에<br>
				<span>명찰의 바코드를 <span>인식</span>시켜주세요.</span>
				<img src="/asset/attendance/arr_right.png" alt="">
			</div>
		</div>
	</div>
	<!-- //contents -->
	
</div>	
<div style="position:absolute;top:0px;z-index:1;">
	<input type="text" name="tag_number" id="tag_number" value="" >
</div>
</form>
</body>

</html>
