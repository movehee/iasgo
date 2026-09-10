<?
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
?>
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
<?

$result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where code='".$_COOKIE['code']."' and del='N' and lecture='".$lecture."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$query="select * from voting_tbl where lecture='".$lecture."' and orderby='".$orderby."' and del='N'";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_array($result);

if($d['status']==2){
	$query="select (select count(*) from voting_result_tbl where val='1' and voting_sid=".$d['sid'].") val1, (select count(*) from voting_result_tbl where val='2' and voting_sid=".$d['sid'].") val2, (select count(*) from voting_result_tbl where val='3' and voting_sid=".$d['sid'].") val3, (select count(*) from voting_result_tbl where val='4' and voting_sid=".$d['sid'].") val4, (select count(*) from voting_result_tbl where val='5' and voting_sid=".$d['sid'].") val5, (select count(*) from voting_result_tbl where val='6' and voting_sid=".$d['sid'].") val6, (select count(*) from voting_result_tbl where voting_sid=".$d['sid'].") val;";
	
	$result = mysqli_query($conn, $query);
	$r = mysqli_fetch_array($result);	

}

?>


<div class="wrapper">

	<div class="fullScreen">

		<div class="question">
		<?if($d['image']!=""){?>
			<div class="img"><img src="/upload/<?=$d['image']?>" alt=""></div>
		<?}?>
			<div class="text">
				<?=$d['question']?>
			</div>
		</div>

		<div class="answer">

			<?if($d['answer1']!="" || $d['answer1_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer1'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer1'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="1"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer1'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer1'], 'utf-8')>0){?>_s<?}?>">① <?=$d['answer1']?></dt>
				
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="1"){echo "class='point'";}?> style="width:<?=$r['val1']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val1']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			</dl>
			<?}?>

			<?if($d['answer2']!="" || $d['answer2_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer2'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer2'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="2"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer2'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer2'], 'utf-8')>0){?>_s<?}?>">② <?=$d['answer2']?></dt>

			
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="2"){echo "class='point'";}?> style="width:<?=$r['val2']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val2']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			
			</dl>
			<?}?>

			<?if($d['answer3']!="" || $d['answer3_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer3'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer3'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="3"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer3'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer3'], 'utf-8')>0){?>_s<?}?>">③ <?=$d['answer3']?></dt>
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="3"){echo "class='point'";}?> style="width:<?=$r['val3']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val3']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			
			</dl>
			<?}?>

			<?if($d['answer4']!="" || $d['answer4_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer4'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer4'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="4"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer4'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer4'], 'utf-8')>0){?>_s<?}?>">④ <?=$d['answer4']?></dt>

			
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="4"){echo "class='point'";}?> style="width:<?=$r['val4']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val4']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			
			</dl>
			<?}?>

			<?if($d['answer5']!="" || $d['answer5_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer5'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer5'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="5"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer5'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer5'], 'utf-8')>0){?>_s<?}?>">⑤ <?=$d['answer5']?></dt>

			
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="5"){echo "class='point'";}?> style="width:<?=$r['val5']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val5']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			
			</dl>
			<?}?>

			<?if($d['answer6']!="" || $d['answer6_img']!=""){?>
			<dl class="option <?if(mb_strlen($d['answer6'], 'utf-8')>50){?>ss<?}else if(mb_strlen($d['answer6'], 'utf-8')>25){?> s<?}?>">

				<dt <?if($d['status']==2 && $d['correct']=="6"){?>style='color:#12a3df'<?}?> class="fSize<?if(mb_strlen($d['answer6'], 'utf-8')>50){?>_ss<?}else if(mb_strlen($d['answer6'], 'utf-8')>0){?>_s<?}?>">⑥ <?=$d['answer6']?></dt>

			
				<dd>
					<div class="graphBar"><div <?if($d['correct']=="6"){echo "class='point'";}?> style="width:<?=$r['val6']*100/$r['val']?>%;">
					<?if($d['status']==2 && $r['val']){?>
					<span><?=round($r['val6']*100/$r['val'],1)?>%</span>
					<?}?>
					</div></div>
				</dd>
			
			</dl>
			<?}?>

		</div>
		<!-- //answer -->
		
		<div id="util" class="util">
		<?if($d['status']!="2"){?>
			<a href="javascript:start('<?=$d['code']?>','<?=$d['sid']?>','<?=$d['delay']?>')" class="start"><img src="/admin/image/icon_start.png" alt=""> START</a>
		<?}?>
			<a onclick="javascript:up('<?=$orderby?>','<?=$lecture?>')" class="prev"><i class="fas fa-angle-left" title="이전"></i></a>
			<a onclick="javascript:down('<?=$orderby?>','<?=$max?>','<?=$lecture?>')" class="next"><i class="fas fa-angle-right" title="다음"></i></a>



		</div>
		




	</div>

	
	<!-- //fullScreen -->

</div>

<!-- //wrapper -->

<script type="text/javascript">
var delay = 10;
var cd;
var id;


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
	$.ajax({
		type:"POST",
		url:"./start.php",
		data:"code="+code+"&sid="+sid,
		success:function(msg){

		
			document.getElementById("util").innerHTML="<span class='count'>"+delay+"</span>";
			timer = setInterval(function() {
				delay = delay-1;
				var audio = new Audio('./count.wav');
				audio.play();
				document.getElementById("util").innerHTML="<span class='count'>"+delay+"</span>";
				if(delay==0){
					clearInterval(timer);
					document.getElementById("util").innerHTML="<a onclick='javascript:end()' class='start'>결과보기 <i class='far fa-hand-point-right'></i></a>";
				}
			}, 1000);
		}
	});
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


</script>

</body>
</html>