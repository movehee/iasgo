<?
@error_reporting(E_ALL ^ E_NOTICE);
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";


if(file_exists($_SERVER['DOCUMENT_ROOT'].'/config/'.$code.'.php')) {
	include_once $_SERVER['DOCUMENT_ROOT']."/config/".$code.".php";
}

if(!empty($code) && $_COOKIE['admin']!="N" && $_COOKIE['admin']!=""  && $_COOKIE['admin']){
	ob_start();
	setcookie('code', $code, time() + 60*60*24, '/', $_cookie_domain);
	$_COOKIE['code'] = $code;
}

if(!empty($_COOKIE['code']))
{
	$query="SELECT * FROM event_tbl where code='".$_COOKIE['code']."'";
	
	$result = mysqli_query($conn, $query);
	$event_db= mysqli_fetch_array($result);
	if(!$event_db) {
		RefreshURL("/admin/php/login.php");
	}
}else if ($_COOKIE['admin']=="N" || $_COOKIE['admin']==""  || !$_COOKIE['admin']){

	RefreshURL("/admin/php/login.php");
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
<title>Easy Voting System</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/voting.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/feedback.css" />
<link type="text/css" rel="stylesheet" href="/admin/php/css/colpick.css" />
<!--
<link type="text/css" rel="stylesheet" href="/admin/css/session.css" />
-->
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->

<!-- <link href="/css/jquery-ui.css" rel="stylesheet"> -->
<script src="/script/jquery.1.11.1.js"></script>
 
<script type="text/javascript" src="/admin/script/user.js?v=<?=time()?>"></script>

<script type="text/javascript" src="/script/1.12.1-jquery-ui.js" ></script>
<!--
<script type="text/javascript" src="/script/jquery-3.3.1.min.js" ></script>
-->

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>

<script type="text/javascript" src="/admin/script/colpick.js"></script>

 


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
 

<div class="wrapper">


	<div id="headerWrap">
		<div>
			
	
			<h1 style="width:1400px;margin-top:15px">
			
			<?if(!empty($_COOKIE['code'])){?>
				<?=$event_db['name']?>
			<?}?>
				<?if(stristr($_SERVER['REMOTE_ADDR'], "218.235.94") || $_COOKIE['admin']=='admin'){?>
				<p class="btn" style="position: absolute; right: 0;top: 10px;"><a href="/admin/php/event/ezv_manual_v1.0_190726.pdf" target="_blank" class="btnDef" alt=""><i class="fas fa-info-circle"></i>관리자메뉴얼</a><??></p>
				<?}?>
			</h1>    
			
			<? if( $_COOKIE['admin'] == "admin" ){ ?>
			<ul id="gnb">
				<li><a href="/admin/php/event/list.php?code=<?=$code?>">행사관리</a></li>
				<li><a href="/admin/php/agenda/agenda.php?code=<?=$code?>">Agenda</a></li>
				<li><a href="/admin/php/voting/list.php?code=<?=$code?>">Voting</a></li>
				<li ><a href="/admin/php/question/list.php?code=<?=$code?>">Question</a></li>
				<li><a href="/admin/php/feedback/list.php?code=<?=$code?>">Feedback</a></li>
				<li><a href="/admin/php/regist/list.php?code=<?=$code?>">Registration</a></li>
				<li><a href="/admin/php/session/list2.php?code=<?=$code?>">Session</a></li>
				<li><a href="/admin/php/abstract/list.php?code=<?=$code?>">Abstract</a></li>
				<li><a href="/admin/php/faculty/list.php?code=<?=$code?>">Faculty</a></li>
				<li><a href="/admin/php/photo/list.php?code=<?=$code?>">Photo</a></li>
				<li><a href="/admin/php/bbs/list.php?code=<?=$code?>">Notice</a></li>
				<li><a href="/admin/php/booth/list.php?code=<?=$code?>">Booth</a></li>
				<li><a href="/admin/php/banner/list.php?code=<?=$code?>">Banner</a></li>
				<li><a href="/admin/php/css/view.php?code=<?=$code?>">CSS</a></li>
				<li><a onclick="javascript:window.open('/admin/php/qr.php?code=<?=$code?>');">QR Code</a></li>
				<li><a href="/admin/php/log/list.php?code=<?=$code?>">Log</a></li>
				<li><a href="/admin/php/login.php" class="logout">Logout</a></li>
			</ul>	
			<? }else{ ?>
			<ul id="gnb">
				<?if($_COOKIE['admin']!="N"){?>
				<li><a href="/admin/php/event/list.php?code=<?=$code?>">행사관리</a></li>
				<?}?>


				<?if($event_db['agendaYN']!="Y" && $event_db['sessionYN']!="Y" && $event_db['registrationYN']=="Y" && $_COOKIE['admin']=="admin"){?>
				<li><a href="/admin/php/agenda/agenda.php?code=<?=$code?>">Agenda</a></li>
				<?}?>

				<?if($event_db['agendaYN']=="Y" || $event_db['sessionYN']=="Y"){?>
				<li><a href="/admin/php/agenda/agenda.php?code=<?=$code?>">Agenda</a></li>
				<?}?>
				<?if($event_db['votingYN']=="Y"){?>
				<li><a href="/admin/php/list.php?code=<?=$code?>">Voting</a></li>
				<?}?>
				<?if($event_db['questionYN']=="Y"){?>
				<li ><a href="/admin/php/question/list.php?code=<?=$code?>">Question</a></li>
				<?}?>
				<?if($event_db['feedbackYN']=="Y"){?>
				<li><a href="/admin/php/feedback/list.php?code=<?=$code?>">Feedback</a></li>
				<?}?>
				<?if($event_db['sessionYN']=="Y"){?>
				<li><a href="/admin/php/regist/list.php?code=<?=$code?>">Registration</a></li>
				<li><a href="/admin/php/session/list2.php?code=<?=$code?>">Session</a></li>
				<li><a href="/admin/php/abstract/list.php?code=<?=$code?>">Abstract</a></li>
				<li><a href="/admin/php/faculty/list.php?code=<?=$code?>">Faculty</a></li>
				<li><a href="/admin/php/photo/list.php?code=<?=$code?>">Photo</a></li>
				<li><a href="/admin/php/bbs/list.php?code=<?=$code?>">Notice</a></li>
				<li><a href="/admin/php/booth/list.php?code=<?=$code?>">Booth</a></li>
				<li><a href="/admin/php/banner/list.php?code=<?=$code?>">Banner</a></li>
				<?}?>

				<?if($event_db['registrationYN']=="Y"){?>
				<li><a href="/admin/php/regist/list.php?code=<?=$code?>">Registration</a></li>
				<li><a onclick="javascript:window.open('/admin/php/qr.php?code=<?=$code?>');">QR Code</a></li>
				<?}else{?>

				<li><a href="/admin/php/css/view.php?code=<?=$code?>">CSS</a></li>
				<li><a onclick="javascript:window.open('/admin/php/qr.php?code=<?=$code?>');">QR Code</a></li>

				<?}?>

				<?if($_COOKIE['admin']!="N"){?>
				<li><a href="/admin/php/log/list.php?code=<?=$code?>">Log</a></li>
				<?}?>
				<li><a href="/admin/php/login.php" class="logout">Logout</a></li>
			</ul>
			<? } ?>
		</div>
	</div> 

