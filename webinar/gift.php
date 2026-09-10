<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KCR 2023</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/qrEvent.css">
<script type="text/javascript" src="/script/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript" src="/script/webinar.js?v=0.1"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {

});
//]]>
</script>
</head>
<body onload="$('#regist_number').focus();">

<div class="wrapper">
	<h1>Exhibition QR Event!</h1>
<a href="/load/etc/gift.php?gift_num=<?=$gift_num?>" class="Load_Base" id="Gbtn" Wsize='802'  Hsize='700' Tsize='5%'></a>
	<div class="eventRoulette">

		<div class="eventPrize"><img src="/asset/event/event_prize.png" alt="Event Prize"></div>
		
		<!-- Start 클릭시 class="start" 추가 -->
		<div class="roulettezone start">
			<div class="roulette">
				<img src="/asset/event/roulette.png" alt="">
			</div>
			<div class="btn">
				<a href="javascript:$('#GF').submit()">Start</a>
			</div>
		</div>
		<!-- //roulettezone -->
		<?if($gift_num){?>
		<!-- <div class="rouletteResult">
			<?if($gift_num!='X'){?>
			<?if($gift_num=='N'){?>
				Unfortunately, next time
			<?}else{?>
				<?
					if($gift_num=='1'){
						$prize = "st";
					}else if($gift_num=='2'){
						$prize = "nd";
					}else if($gift_num=='3'){
						$prize = "rd";
					}else if($gift_num=='4'){
						$prize = "th";
					}
				?>
				
			<strong><?=$gift_num?><sup><?=$prize?></sup> prize</strong>
			 <?=$_Gift['gift_F'][$gift_num]['title']?>
			<?}?>
			<?}?>
		</div> -->
		<?}?>
	</div>
	<!-- //eventRoulette -->

	<div class="registNum">
		<form id="GF" name="GF" action="gift_reg.php" method="post">
			<fieldset>
				<legend>Registration Number</legend>
				<label for="">Registration Number</label>
				<input type="text" name="regist_number" id="regist_number">
				<input type="submit" value="START">
			</fieldset>
		</form>

		<div class="alertNote">
			<!-- <?if($gift_num=='X'){?>
				<img src="/asset/event/alertNote.png" alt="">You are not a participant in the 2<sup>nd</sup>  event.
			<?}?> -->
		</div>
	</div>
	<!-- //registNum -->
</div>
<?if($gift_num){?>
<script>
	$(function(){
		$('#Gbtn').trigger('click');
	});
</script>
<?}?>
</body>
</html>