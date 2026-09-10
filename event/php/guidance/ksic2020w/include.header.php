<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KSIC 2020</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi" />
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="./css/common_v1.0.css" />
<link type="text/css" rel="stylesheet" href="./css/ksicApp.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="./script/user.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	
});
//]]>
</script>
</head>

<?

	$uri = explode("/", $_SERVER['REQUEST_URI']);
	$code=$uri[sizeof($uri)-2];

	if($code == "ksic2020w") $code = "ksic2020"; //예외처리

	include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
	if(!$p) { $p=1; }
	$sql = "select * from regist_tbl where sid='$number'";
	$result = mysqli_query($conn, $sql);
	$d = mysqli_fetch_array($result);
?>
<body>

<div class="wrapper">

	<!-- container -->
	<div id="containerWrap" class="conference">
		
		<div class="titArea">
			<h1><img src="./image/conferenceInfo/header.png" alt="KSIC 2020"></h1>
		</div>


		<ul class="lnb">
			<li <?if($p=='1'){?>class="on"<?}?> ><a href="<?=$_SERVER['SCRIPT_NAME']?>?number=<?=$number?>&p=1">행사 정보</a></li>
			<li <?if($p=='2'){?>class="on"<?}?> ><a href="<?=$_SERVER['SCRIPT_NAME']?>?number=<?=$number?>&p=2">평점 안내</a></li>
			<li <?if($p=='3'){?>class="on"<?}?> ><a href="<?=$_SERVER['SCRIPT_NAME']?>?number=<?=$number?>&p=3">나의 평점</a></li>
			<li <?if($p=='4'){?>class="on"<?}?> ><a href="<?=$_SERVER['SCRIPT_NAME']?>?number=<?=$number?>&p=4">Application</a></li>
		</ul>

		<div class="contents">