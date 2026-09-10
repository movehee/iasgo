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
<title>KSELS 2020</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/css/common_v3.css">
<link type="text/css" rel="stylesheet" href="/css/ksels2020.css">
<link type="text/css" rel="stylesheet" href="/admin/button_package/button.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/script/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/script/user.js"></script>
<script type="text/javascript" src="/script/ksels.js"></script>
<link type="text/css" rel="stylesheet" href="/admin/css/admin_v2.css" />

<script src="/script/fancybox/jquery.min.js"></script>
<link rel="stylesheet" href="/script/fancybox/jquery.fancybox.min.css" />
<script src="/script/fancybox/jquery.fancybox.min.js"></script>

<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});
//]]>
</script>
</head>
<body>
<div style="padding-top:45px" >

	<div id="headerWrap" style="width:100%;margin-bottom:0px;">

		<dl id="skipNavi">
			<dt>Skip Navigation</dt>
			<dd><a href="#container">Skip to contents</a></dd>
		</dl>

		<div class="header" style="height:80px;width:100%;">
			<h1 style="top:10px;padding-left:20px;">
				<a href="#"><img src="/image/layout/header_logo.png" alt="KSELS 2020"></a>
				<div style="float:left;position:absolute;color:#ffffff;left:250px;top:0px;margin:0px;width:900px;font-size:20px;">
					<?if($sid=='1'){?>
						<div style="float:left;">Laparoscopic Distal Gastrectomy Using 4K Vision</div> 
						<div style="float:right;padding-top:5px;">Hyung-Ho Kim (Seoul National University Bundang Hospital)</div>
					<?}else if($sid=='2'){?>
						<div style="float:left;">Laparoscopic revisional gastric bypass; gastric band to Roux-en Y gastric bypass</div>
						<div style="float:right;padding-top:5px;">Yong Jin Kim (H Plus Yangji Hospital)</div>
					<?}else if($sid=='3'){?>
						<div style="float:left;">Paraesophageal hernia repair</div>
						<div style="float:right;padding-top:30px;">Joong-Min Park (Chung-Ang University College of Medicine)</div>
					<?}else if($sid=='4'){?>
						<div style="float:left;">Laparoscopic Hepatectomy using 4K Imaging System: Comparing with 3D Flexible System</div>
						<div style="float:right;padding-top:5px;">Kyung-Suk Suh (Seoul National University College of Medicine)</div>
					<?}else if($sid=='5'){?>
						<div style="float:left;">taTME - Where Do We stand</div>
						<div style="float:right;padding-top:30px;">Sung Chan Park (National Cancer Center)</div>
					<?}else if($sid=='6'){?>
						<div style="float:left;">Laparoscopic lateral lymph node dissection for advanced low rectal cancer</div>
						<div style="float:right;padding-top:5px;">Takashi Akiyoshi (Japanese Foundation for Cancer Research)</div>
					<?}else if($sid=='7'){?>
						<div style="float:left;">Pancreas surgery with 4K and ICG</div>
						<div style="float:right;padding-top:30px;">Horacio Asbun (Miami Cancer Institute)</div>
					<?}else if($sid=='8'){?>
						<div style="float:left;">Anastomotic technique for esophageal cancer</div>
						<div style="float:right;padding-top:30px;">Andrea Pietrabissa (University of Pavia)</div>
					<?}?>
				</div>
			</h1>
		</div>
	</div>
	<!-- //headerWrap -->
	<div id="container">
	<div class="contents bp30" style="width:100%;">
<?
	procLoginChk();
?>
<script>
	var key="<?=$sid?>";
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+17;
		window.resizeTo(re_width,850);	
	});
</script>
<div class="popupCon" id="" style="width:1200px;background:#fffff;padding:0px;margin:0px;padding-top:50px;">
	<?if($sid=='1'){?>
		<iframe src="https://player.vimeo.com/video/451427111" width="98%" height="610" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='2'){?>
		<iframe src="https://player.vimeo.com/video/451428056" width="100%" height="700" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='3'){?>
		<iframe src="https://player.vimeo.com/video/447031626" width="98%" height="610" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='4'){?>
		<iframe src="https://player.vimeo.com/video/451428503" width="98%" height="630" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='5'){?>
		<iframe src="https://player.vimeo.com/video/452736518" width="98%" height="630" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='6'){?>
		<iframe src="https://player.vimeo.com/video/447028562" width="98%" height="630" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='7'){?>
		<iframe src="https://player.vimeo.com/video/452737291" width="98%" height="630" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}else if($sid=='8'){?>
		<iframe src="https://player.vimeo.com/video/451428669" width="98%" height="630" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
	<?}?>
</div>
