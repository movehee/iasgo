<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PPTC 2026</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	
	$('#tag_number').focus();
});
</script>
</head>
<?
if($_SERVER['REMOTE_ADDR']=='218.235.94.220'){
	$num = "1A";
}
?>
<body onclick="javascript:$('#tag_number').focus();">
<div class="wrapper attendance" -style="z-index:9999999;">
	<div id="container" >
		<div class="contents">
			<img src="/asset/sub/img_attendance_title.png" alt="">
			<div class="barcode-wrap">
				<p>Please scan the barcode on your name badge.</p>
			</div>
		</div>
	</div>
</div>	
<div style="position:absolute;top:0px;z-index:-111111;">
	<form id="tagF" name="tagF" action="tag_booth_reg.php" method="post" >
	<input type="text" name="tag_number" id="tag_number" value="<?=$num?>" style="">
	</form>
</div>
</body>
</html>
