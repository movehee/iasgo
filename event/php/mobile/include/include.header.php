<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/lib.php";
if(!$code){ PutMessageBack("행사 코드값이 누락되었습니다. 다시 시도해주세요."); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Easy Voting System</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/php/mobile/css/common_v1.1.css" />
<link type="text/css" rel="stylesheet" href="/php/mobile/css/form.css" />
<link type="text/css" rel="stylesheet" href="/php/mobile/css/skoms_conference_mobile.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="/php/mobile/script/jquery.min.1.7.1.js"></script>
<script type="text/javascript" src="/php/mobile/script/user.js"></script>
<script type="text/javascript" src="/php/mobile/script/jquery-ui.min.js"></script>
<script type="text/javascript" src="/php/mobile/script/developer2.js"></script> <!-- 공통으로 사용하는 스크립트는 여기에 -->
<script type="text/javascript" src="/php/mobile/script/developer.js"></script> <!-- 모바일에서만 필요한 스크립트는 여기에 -->
</head>

<body>
<div class="wrapper">
	<div id="lnb" class="ac padding0 fwBold">
		<span style="color:#fff; font-size:16px; letter-spacing:1.8px; line-height:2.3"><?=$e['name']?></span>
	</div>
	
    <div id="container">
    	
