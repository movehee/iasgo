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
<title>관리자</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/voting.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/feedback.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->


<link href="/css/jquery-ui.css" rel="stylesheet">
<script src="/script/jquery.1.11.1.js"></script>
<script src="/script/1.11.1.jquery-ui.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>


</head>
<body>
<?

$result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where code='".$_COOKIE['code']."' and del='N' and lecture='".$lecture."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$query="select * from voting_tbl where lecture='".$lecture."' and orderby='".$orderby."' and del='N'";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_array($result);


?>



<div class="wrapper">

	<div class="fullScreen03">

	
	<!--
		<h1>CLIENT LOGO</h1>
		
		
	-->
		<h2><?=$d['question']?></h2>
		<div class="scrollArea">

			<ul class="imgList col<?=$d['ui']?>ea">
				<?if($d['answer1']!="" || $d['answer1_img']!=""){?>
				<li><a href="">① <?=$d['answer1']?><?if($d['answer1_img']!=""){?><img src="/upload/<?=$d['answer1_img']?>" alt=""><?}?></a></li>
				<?}?>

				<?if($d['answer2']!="" || $d['answer2_img']!=""){?>
				<li><a href="">② <?=$d['answer2']?><?if($d['answer2_img']!=""){?><img src="/upload/<?=$d['answer2_img']?>" alt=""><?}?></a></li>
				<?}?>

				<?if($d['answer3']!="" || $d['answer3_img']!=""){?>
				<li><a href="">③ <?=$d['answer3']?><?if($d['answer3_img']!=""){?><img src="/upload/<?=$d['answer3_img']?>" alt=""><?}?></a></li>
				<?}?>

				<?if($d['answer4']!="" || $d['answer4_img']!=""){?>
				<li><a href="">④ <?=$d['answer4']?><?if($d['answer4_img']!=""){?><img src="/upload/<?=$d['answer4_img']?>" alt=""><?}?></a></li>
				<?}?>

				<?if($d['answer5']!="" || $d['answer5_img']!=""){?>
				<li><a href="">⑤ <?=$d['answer5']?><?if($d['answer5_img']!=""){?><img src="/upload/<?=$d['answer5_img']?>" alt=""><?}?></a></li>
				<?}?>

				<?if($d['answer6']!="" || $d['answer6_img']!=""){?>
				<li><a href="">⑥ <?=$d['answer6']?><?if($d['answer6_img']!=""){?><img src="/upload/<?=$d['answer6_img']?>" alt=""><?}?></a></li>
				<?}?>



				
	
			</ul>
			<?if($d['status']!="2"){?>
			<div id="util" class="util">
				<a onclick="javascript:start('<?=$d['code']?>','<?=$d['sid']?>','<?=$d['delay']?>')" class="start">START <i class="far fa-hand-point-right"></i></a>
			</div>
			<?}?>

			<div class="util">
				<a onclick="javascript:up('<?=$orderby?>','<?=$lecture?>')" class="prev"><img src="/admin/image/icon_prev_g.png" alt="이전"></a>
				<a onclick="javascript:down('<?=$orderby?>','<?=$max?>','<?=$lecture?>')" class="next"><img src="/admin/image/icon_next_g.png" alt="다음"></a>
			</div>


		</div>

		
	

	</div>

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
			alert(msg);
		}
	});


}


</script>

</body>
</html>