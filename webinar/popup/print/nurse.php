<?include $_SERVER['DOCUMENT_ROOT']."lib.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMKASID 2022</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<link type="text/css" rel="stylesheet" href="/asset/Roboto.css">
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
});
//]]>
</script>
<?$Nurse_name = $conn->getOne("select if(name_eng!='',name_eng,name_kr) from registration_tbl where sid='".$_COOKIE['wmember_sid']."'");?>
<style type="text/css">
#popupCertificate {position: relative;width: 1000px;font-family: 'Roboto-Regular', sans-serif;}
#popupCertificate div.bg {}
#popupCertificate img {display: block;width: 100%;}

.name {position: absolute;top: 457px;left: 376px; width:579px; color: #000;text-align: center;font-size: 60px;font-family: 'times new roman';}
</style>
</head>
<body onload="print()">
<div id="popupCertificate">
	<div class="bg"><img src="/asset/layout/certificate_bg.png" alt="CERTIFICATE OF ATTENDANCE"></div>
	<div class="name"><?=$Nurse_name?></div>
</div>

</body>

</html>