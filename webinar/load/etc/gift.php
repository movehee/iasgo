<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<!-- $(document).ready(function(){
parent.$.colorbox.resize({width:800,height:1000});
}); -->
<script>
	$(document).ready(function(){
		Details = setInterval( function () {			
			parent.$.colorbox.close();	
		}, 4000);
	});
</script>
<div class="popupWrap" id="popupFaq" style="">
	<h1><img src="/asset/layout/popup_faq.png" alt="KCR 2023" onclick="location.reload();"></h1>
	<div class="popupCon">
	<?if($gift_num=='X'){//등록번호가 일치하는게 없을때?>
		<div class="ac" style="font-weight:bold;font-size:40px;padding-top:200px;height:400px;letter-spacing: -1px; font-family: 'Roboto-Medium', sans-serif;">
		You are not a participant in the 2<sup>nd</sup> event
		</div>
	<?}?>
	<?if($gift_num=='A'){//참여내역이 있을때?>
		<div class="ac" style="font-size:40px;padding-top:200px;height:400px;letter-spacing: -1px; font-family: 'Roboto-Medium', sans-serif;">
		You have already participated.
		</div>
	<?}?>
	<?if($gift_num=='R'){ // 참여내역 없을때?>
		<div class="ac" style="font-size:30px;padding-top:200px;height:400px;letter-spacing: -1px; font-family: 'Roboto-Medium', sans-serif;">
		Please start by participating in the sponsor booth event.
		</div>
	<?}?>
	<?if($gift_num=='N'){//꽝일때?>
		<div class="ac" style="font-size:50px;padding-top:200px;height:400px;letter-spacing: -1px; font-family: 'Roboto-Medium', sans-serif;">
		Thank you for participating.
		</div>
	<?}?>

	

	<?if($gift_num==1 || $gift_num==2 || $gift_num==3 || $gift_num==4){?>
		<div class="ac" style="font-size:35px;height:400px;">
		<div class="eventRoulette">
			<div class="rouletteResult">
				<div style="padding-bottom:5px;"><img src="https://virtual.kcr4u.org/asset/event/rouletteResult.png"></div>
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
				<div><img src="/image/event_prize<?=$gift_num?>.png"></div>
				<strong><?=$gift_num?><sup><?=$prize?></sup> prize</strong>
				<br /><?=$_Gift['gift_F'][$gift_num]['title']?>
			</div>
		</div>
	<?}?>
	</div>
	<div class="close"><a class="color_close"><img src="/asset/layout/popup_faq_close.png" alt="close"></a></div>
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>
