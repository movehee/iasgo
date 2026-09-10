<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AOCR 2022 & KCR 2022</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	$("#sel_day").on("change", function() {
		var day = $(this).val();
		console.log(day)
		$("img.img").hide();
		$("#img"+day).show();
	});
});
//]]>
</script>
<?php
	$n_date = date("Y-m-d H:i");

	// if($_SERVER['REMOTE_ADDR']=='218.235.94.225') $n_date = "2022-09-22 10:00";

	if( $n_date >= "2022-09-19 18:30") {
		$open1 = true;
		$n_sel = "1";
	}
	if( $n_date >= "2022-09-20 18:30") {
		$open2 = true;
		$n_sel = "2";
	}
	if( $n_date >= "2022-09-21 18:30") {
		$open3 = true;
		$n_sel = "3";
	}
	if( $n_date >= "2022-09-22 18:30") {
		$open4 = true;
		$n_sel = "4";
	}
	if( $n_date >= "2022-09-23 18:30") {
		$open5 = true;
		$n_sel = "5";
	}
?>
<body>

	<div class="popupWrap" id="popupEblast">
		<h1>Today's Highlights</h1>
		<div class="popupCon">
			<select id="sel_day">
				<?php if($open5):?><option value="5" <?php if($n_sel=="5"):?>selected<?php endif;?>>DAY 5. September 24 (Sat)</option><?php endif;?>	
				<?php if($open4):?><option value="4" <?php if($n_sel=="4"):?>selected<?php endif;?>>DAY 4. September 23 (Fri)</option><?php endif;?>
				<?php if($open3):?><option value="3" <?php if($n_sel=="3"):?>selected<?php endif;?>>DAY 3. September 22 (Thu)</option><?php endif;?>
				<?php if($open2):?><option value="2" <?php if($n_sel=="2"):?>selected<?php endif;?>>DAY 2. September 21 (Wed)</option><?php endif;?>
				<?php if($open1):?><option value="1" <?php if($n_sel=="1"):?>selected<?php endif;?>>DAY 1. September 20 (Tue)</option><?php endif;?>
			</select>
			<div class="scrollArea" style="max-height:650px;">
				<?php if($open1):?><img src="https://webinar2cdnstorage.blob.core.windows.net/cdn/aocr2022/upload/main/Day1.jpg" alt="" class="img" id="img1" <?php if($n_sel!="1"):?>style="display:none;"<?php endif;?>><?php endif;?> <!--day1-->
				<?php if($open2):?><img src="https://webinar2cdnstorage.blob.core.windows.net/cdn/aocr2022/upload/main/Day2.jpg" alt="" class="img" id="img2" <?php if($n_sel!="2"):?>style="display:none;"<?php endif;?>><?php endif;?> <!--day2-->
				<?php if($open3):?><img src="https://webinar2cdnstorage.blob.core.windows.net/cdn/aocr2022/upload/main/Day3.jpg" alt="" class="img" id="img3" <?php if($n_sel!="3"):?>style="display:none;"<?php endif;?>><?php endif;?> <!--day3-->
				<?php if($open4):?><img src="https://webinar2cdnstorage.blob.core.windows.net/cdn/aocr2022/upload/main/Day4.jpg" alt="" class="img" id="img4" <?php if($n_sel!="4"):?>style="display:none;"<?php endif;?>><?php endif;?> <!--day4-->
				<?php if($open5):?><img src="https://webinar2cdnstorage.blob.core.windows.net/cdn/aocr2022/upload/main/Day5.jpg" alt="" class="img" id="img5" <?php if($n_sel!="5"):?>style="display:none;"<?php endif;?>><?php endif;?> <!--day5-->
 
			</div>
		</div>
	</div>
	<!-- //popupWrap -->



</body>
</html>