
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title>Easy Voting System</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/fullScreen.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->


<link href="/css/jquery-ui.css" rel="stylesheet">
<script src="/script/jquery.1.11.1.js"></script>
<script src="/script/1.11.1.jquery-ui.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>


<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	

	$("div.wrapper, div.question").outerHeight($(window).height());
	$("div.wrapper").outerWidth($(window).width());
	$("div.fullScreen").outerHeight($("div.wrapper").height());

	//$("dl.option").outerHeight(($("div.wrapper").height()-60)/6);

	var rePaddingL = $("div.question").outerWidth() + 40;
	$("div.fullScreen").css({"padding-left":rePaddingL})

	$(window).resize(function(){
		$("div.wrapper, div.question").outerHeight($(window).height());
		$("div.wrapper").outerWidth($(window).width());
		$("div.fullScreen").outerHeight($("div.wrapper").height());

		//$("dl.option").outerHeight(($("div.wrapper").height()-60)/6);

		var rePaddingL = $("div.question").outerWidth() + 40;
		$("div.fullScreen").css({"padding-left":rePaddingL})			

		});

	});


//]]>
</script>

</head>
<body>


<div class="wrapper">
	<input type="hidden" id="start_type" value="1">
	<input type="hidden" id="start_txt" value="">
	<div class="fullScreen">

		<div class="question">
					<div class="text">
				선택해주세요			</div>
		</div>

		<div class="answer">

						<dl class="option ">

				<dt  class="fSize_s">① 1번</dt>
				
				<dd>
					<div class="graphBar"><div  style="width:25%;">
										<span>25%</span>
										</div></div>
				</dd>
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">② 2번</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:12.5%;">
										<span>12.5%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">③ 3번</dt>
				<dd>
					<div class="graphBar"><div  style="width:16.666666666667%;">
										<span>16.7%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">④ 4번</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:12.5%;">
										<span>12.5%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">⑤ 5번</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:0%;">
										<span>0%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">⑥ 6666</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:4.1666666666667%;">
										<span>4.2%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">⑦ 77777</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:0%;">
										<span>0%</span>
										</div></div>
				</dd>
			
			</dl>
			
						<dl class="option ">

				<dt  class="fSize_s">⑧ 88888</dt>

			
				<dd>
					<div class="graphBar"><div  style="width:29.166666666667%;">
										<span>29.2%</span>
										</div></div>
				</dd>
			
			</dl>
			


		</div>
		<!-- //answer -->
		
		<div id="util" class="util">
			<!-- 결과보기 버튼 클릭 후 노출 -->
			<span class="result" style="display: ;"><img src="/image/voting_result.png" alt="Voting Result"></span>
					<a onclick="javascript:up('1','1')" class="prev"><i class="fas fa-angle-left" title="이전"></i></a>
			<a onclick="javascript:down('1','1','1')" class="next"><i class="fas fa-angle-right" title="다음"></i></a>
		</div>
		




	</div>

	
	<!-- //fullScreen -->

</div>

<!-- //wrapper -->

<script type="text/javascript">
var delay = 10;
var cd;
var id;
var timer=false;

function up(sid,lecture) {
	if(sid>1)
	{
		val2 = sid-1;
		location.href="./screen.php?lecture="+lecture+"&orderby="+val2;
	}
}
function down(sid,max,lecture) {
	if(Number(sid)<Number(max))
	{
		val2 = Number(sid)+Number(1);
		location.href="./screen.php?lecture="+lecture+"&orderby="+val2;
	}
}



function start(code,sid,delay2) {
	delay = delay2;
	cd = code;
	id = sid;


	var start_type = $("#start_type").val();
	if(start_type == '1') {

		document.getElementById("util").innerHTML="<span class='count'>"+delay+"</span>";

		$.ajax({
			type:"POST",
			url:"./start.php",
			data:"code="+code+"&sid="+sid,
			success:function(msg){
				if(timer) {clearInterval(timer);}
				timer = setInterval(function() {
					delay = delay-1;
					var audio = new Audio('./count.wav');
					audio.play();
					document.getElementById("util").innerHTML="<a class='exit'><i class='fas fa-times'></i></a><span class='count'>"+delay+"</span></a>";
					if(delay<=0){
						clearInterval(timer);
						document.getElementById("util").innerHTML="<a onclick='javascript:end()' class='start'>결과보기 <i class='far fa-hand-point-right'></i></a>";
					}
				}, 1000);
			}
			
		});

	}
	else if(start_type == '2') {
		
		document.getElementById("util").innerHTML="<a class='start' onclick='javascript:end()' >"+$("#start_txt").val()+"</a>";
		$.ajax({
			type:"POST",
			url:"./start.php",
			data:"code="+code+"&sid="+sid,
			success:function(msg){
				
			}
			
		});
	}

}

function end(){

	$.ajax({
		type:"POST",
		url:"./end.php",
		data:"code="+cd+"&sid="+id,
		success:function(msg){
			location.reload();
		}
	});


}

$(function() {
	$("div#util").on("click", ".exit", function(){
		clearInterval(timer);
		document.getElementById("util").innerHTML="<a onclick='javascript:end()' class='start'>결과보기 <i class='far fa-hand-point-right'></i></a>";
	});
});

</script>

</body>
</html>