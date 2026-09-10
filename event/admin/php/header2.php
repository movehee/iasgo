<?
@error_reporting(E_ALL ^ E_NOTICE);
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.function.php';

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/config/'.$code.'.php')) {
	include_once $_SERVER['DOCUMENT_ROOT']."/config/".$code.".php";
}

if ($_COOKIE['admin']=="N" || $_COOKIE['admin']==""  || !$_COOKIE['admin']){
	//RefreshURL("/admin/php/login.php");
}

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
<script type="text/javascript" src="/admin/script/jquery.min.1.7.1.js"></script>
<script type="text/javascript" src="/admin/script/jquery.placeholder.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>

<script src="/script/1.7.1.jquery.min.js"></script>  
<script src="/script/1.8.18.jquery-ui.min.js"></script>  

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script>
  $( function() {
    $( document ).tooltip();
  } );
  </script>

<style>
.tooltipPoint{cursor: help !important;}


.ui-tooltip {
  padding: 5px 10px;
  color: #0034ce;
  box-shadow: 0 0 10px #ce1d1d;
 
  font-size:13px;
}

</style>
 
<!--
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />  
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>  
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
-->




</head>
<body>

