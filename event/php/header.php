<?
@error_reporting(E_ALL ^ E_NOTICE);
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(file_exists($_SERVER['DOCUMENT_ROOT'].'/config/'.$code.'.php')) {
	include_once $_SERVER['DOCUMENT_ROOT']."/config/".$code.".php";
}

$query="SELECT * FROM event_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$event_col = mysqli_fetch_array($result);

 $temp = explode("/",$_SERVER["REQUEST_URI"]);


if($event_col['nameYN']=="Y"){
	if(!$_COOKIE['name']) {
		RefreshURL("/php/login/view.php?code=".$code);
	}
}if($event_col['officeYN']=="Y"){
	if(!$_COOKIE['office']) {
		RefreshURL("/php/login/view.php?code=".$code);
	}
}if($event_col['emailYN']=="Y"){
	if(!$_COOKIE['email']) {
		RefreshURL("/php/login/view.php?code=".$code);
	}
}if($event_col['licenseYN']=="Y"){
	if(!$_COOKIE['license']) {
		RefreshURL("/php/login/view.php?code=".$code);
	}	
}if($event_col['agree_message'] || $event_col['agreeYN']=='Y'){
	if(!$_COOKIE['agree']) {
		RefreshURL("/php/login/view.php?code=".$code);
	}
}if($event_col['login_feedbackYN']=="Y" && $temp[2]!="login"){
	if(!$_COOKIE['login_feedback']=="Y") {
		RefreshURL("/php/login/view2.php?code=".$code);
	}	
}

include_once $_SERVER['DOCUMENT_ROOT']."/string.php";


$agenda_array = array();
$agenda_query="SELECT * FROM agenda_tbl where code='".$code."'";
$agenda_result = mysqli_query($conn, $agenda_query);
while(is_array($agenda_col = mysqli_fetch_array($agenda_result))){
	$agenda_array[$agenda_col['sid']] = $agenda_col['name'];
}



$css_query="SELECT * FROM css_tbl where code='".$code."'";
$result = mysqli_query($conn, $css_query);
$css_col = mysqli_fetch_array($result);
if($deviceid){
	$_COOKIE['deviceid'] = $deviceid;
	$id = $deviceid;
} else if(empty($_COOKIE['deviceid'])) {
	$ran_str = generateRandomString(20);
	setcookie('deviceid', $ran_str, time() + 60*60*24, '/', $_cookie_domain);
	$_COOKIE['deviceid'] = $ran_str;
	$deviceid= $_COOKIE['deviceid'];
	$id = $_COOKIE['deviceid'];

}


		for($i=0;$i< sizeof($temp);$i++){
		  //echo $temp[$i]."<br>\n";
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
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?if(!$include){?>
<?if($user_scalable){?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.5, minimum-scale=0, user-scalable=yes, target-densityDpi=medium-dpi, viewport-fit=cover" />
<?}else{?>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi, viewport-fit=cover" />
<?}?>

<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />

<link type="text/css" rel="stylesheet" href="/css/common_v2.css?<?=date('ymd')?>" />
<link type="text/css" rel="stylesheet" href="/css/feedback.css?<?=date('ymd')?>" />
<link type="text/css" rel="stylesheet" href="/css/question.css?<?=date('ymd')?>" />
<link type="text/css" rel="stylesheet" href="/css/font-awesome.css?<?=date('ymd')?>" />
<link type="text/css" rel="stylesheet" href="/css/hgkim.css?<?=date('ymd')?>" />
<?if($temp[2]=="voting"){?><link type="text/css" rel="stylesheet" href="/css/voting_user.css?<?=date('ymd')?>" /><?}?>

<?if($temp[2]=="session" || $temp[2]=="addition" || $temp[2]=="faculty" || $temp[2]=="bbs" || $temp[2]=="abstract" || $temp[2]=="booth" || $temp[2]=="agenda"){?><link type="text/css" rel="stylesheet" href="/css/session.css?<?=date('ymdH')?>" /><?}?>

<!--
<link type="text/css" rel="stylesheet" href="/css/simple-line-icons.css" />
-->
<style>
	div.titArea {position:relative;height:40px;border-top:1px solid #505870;background-color:#ffffff;}
	div.titArea h2 {padding:12px 40px 8px;text-align:center;color:#000000;font-size:16px;line-height:18px;/* font-family: 'Roboto'*/;font-weight: bold; }
	div.titArea .pageUtil {position:absolute;right:10px;top:50%;height:26px;margin-top:-13px;}
	div.titArea .pageUtil > * {float:left;margin-left:5px;}
	div.titArea .pageUtil > *:first-child {margin-left:0;}
	div.titArea .pageUtil a.now {display:block;height:14px;padding:5px;border-radius:4px;border:1px solid #fff;background:transparent;color:#fff;font-size:10px;line-height:14px;text-align:center;/* font-family: 'Roboto', sans-serif; */}
.fixedBtn > a {position:absolute;top:0;display:block;width:40px;height:40px;color:#000000;font-size:16px;}
.fixedBtn a i {display:block;padding:12px 0;text-align:center;}


.fixedBtn a.gnb,
.fixedBtn a.back {left:0;}
.fixedBtn a.search {right:0;}
	div.titArea {background-color:<?=$css_col['session_topmenu_bg']?> !important;}
	div.titArea h2 {color:<?=$css_col['session_topmenu_font']?> !important;}
	.fixedBtn > a {color:<?=$css_col['session_topmenu_font']?> !important;}
</style>
<style>
	ul.changeBg a.on {color: <?=$css_col['feedback_btn_font']?>;background-color: <?=$css_col['feedback_btn']?>;}
	span.changeBg.on {color: <?=$css_col['feedback_btn_font']?>;background-color: <?=$css_col['feedback_btn']?>;}
	ul.changeBg2 a.on {color: <?=$css_col['feedback_btn_font']?>;background-color: <?=$css_col['feedback_btn']?>;}
	span.changeBg2.on {color: <?=$css_col['feedback_btn_font']?>;background-color: <?=$css_col['feedback_btn']?>;}
	

	.btnPoint {background-color:<?=$css_col['feedback_send']?>!important;border-color:<?=$css_col['feedback_send_border']?>!important;color:#fff;}


	.subTitBg {background-color: <?=$css_col['feedback_bg']?>;color: <?=$css_col['feedback_font']?>;}
	.subTitBg span {background-color: <?=$css_col['feedback_bg_bold']?>;color: <?=$css_col['feedback_font_bold']?>;height:100%}

	.subTit2 {color: <?=$css_col['feedback_font2']?>!important;}
	.subTit {color: <?=$css_col['feedback_font2']?>!important;}
	div.qnaArea h2 {background-color: <?=$css_col['question_bg']?>!important;color: <?=$css_col['question_font']?>!important;}

	li.menu {background-color:<?=$css_col['menu_bg']?>!important; color:<?=$css_col['menu_font']?>!important;}

	li.menu.on {background-color:<?=$css_col['menu_bg_on']?>!important; color:<?=$css_col['menu_font_on']?>!important;font-weight:700;}
	

</style>
<?}?>
<?if($temp[2]=="session" || $temp[2]=="bbs" || $temp[2]=="faculty" || $temp[2]=="abstract" || $temp[2]=="booth" || $temp[2]=="agenda"){?>
<style>

html { 
-webkit-text-size-adjust: none!important;
-moz-text-size-adjust: none!important;
-ms-text-size-adjust: none!important;
}

	dl.period .on span.day {background-color:<?=$css_col['session_day_bg']?>!important;}

	/* 토글메뉴 */
	div.toggleMenu {background-color:<?=$css_col['session_select_bg']?>!important;}
	div.toggleMenu a.trigger {color:<?=$css_col['session_select_font']?>!important;}
	div.toggleMenu .toggleCon {background-color:<?=$css_col['session_select_bg']?>!important;color:<?=$css_col['session_select_font']?>!important;}
	h3.dayInfo{background-color:<?=$css_col['session_bar_bg']?>!important;color:<?=$css_col['session_bar_font']?>!important;}
	span.category {color:<?=$css_col['session_category_font']?>!important;}
	.sessionTit {color:<?=$css_col['session_theme_font']?>!important;}

	.chairperson {color:<?=$css_col['session_chair_font']?>!important;}
	.sessionTit2 {color:<?=$css_col['session_title_font']?>!important;}
	.speaker {color:<?=$css_col['session_speaker_font']?>!important;}
	ul.sessionList {background-color:<?=$css_col['session_sub_bg']?>!important;}
	a.favor,
	a.favorTxt {border:1px solid <?=$css_col['session_favor']?>;color:<?=$css_col['session_favor']?>!important;}
	a.favor.on,
	a.favorTxt.on {border:1px solid <?=$css_col['session_favor']?> !important;background-color:<?=$css_col['session_favor']?> !important;color:#ffffff !important;}

	a.btnAbs {border:1px solid <?=$css_col['session_abstract']?>;color:<?=$css_col['session_abstract']?>!important;}
	a.btnLect{border:1px solid <?=$css_col['session_lecture']?>;color:<?=$css_col['session_lecture']?>!important;}
	a.btnCV {border:1px solid <?=$css_col['session_cv']?>;color:<?=$css_col['session_cv']?>!important;}
	a.btnMemo {border:1px solid <?=$css_col['session_memo']?>;color:<?=$css_col['session_memo']?>!important;}

	a.btnEvaluation {border:1px solid <?=$css_col['session_evaluation']?>;color:<?=$css_col['session_evaluation']?>!important;}
	a.btnQuestion {border:1px solid <?=$css_col['session_question']?>;color:<?=$css_col['session_question']?>!important;}
	.sessionCode2 {color:<?=$css_col['abs_no_font']?>!important;}
	.sessionCode {color:<?=$css_col['abs_sid_font']?>!important;}
	.glance_time, .glance_room{  position:absolute;border:1px solid #dbdbdb;font-weight:bold;font-size:12px; background-color:<?=$css_col['glance_top_bg']?>!important;text-align:center;color:<?=$css_col['glance_top_font']?>!important;}

	div.searchArea {background-color:<?=$css_col['session_search_bg']?> !important;}
	div.searchArea input[type=text]{color:<?=$css_col['session_search_font']?> !important;border-color:<?=$css_col['session_search_bg']?> !important;background-color:<?=$css_col['session_search_bg']?> !important;}
	#fixedArea ul.programMenu {background-color:<?=$css_col['session_bottom_menu_bg']?> !important;}
	div.searchArea button {color:<?=$css_col['session_search_font']?> !important;}

	div.searchArea input[type=text]::-moz-placeholder { color: <?=$css_col['session_search_font']?>; }
	div.searchArea input[type=text]::-webkit-input-placeholder { color: <?=$css_col['session_search_font']?>; } 
	div.searchArea input[type=text]::-ms-input-placeholder { color: <?=$css_col['session_search_font']?>; }
	
	dt.faculty_list_group {background-color:<?=$css_col['facutly_list_group_bg']?>!important;color:<?=$css_col['facutly_list_group_font']?>!important;}

	div.speakersInfo {background-color:<?=$css_col['facutly_top_bg']?> !important;}
	div.speakersInfo dl {color:<?=$css_col['facutly_top_font']?> !important;}

	span.bullet {border-radius: <?=$css_col['session_category_radius']?>px !important;}
	span.bullet.kor {background-color:<?=$css_col['session_bullet_kor']?> !important;}
	span.bullet.eng {background-color:<?=$css_col['session_bullet_eng']?> !important;}


	dl.descript {background-color:<?=$css_col['session_sub_session1_bg']?>;}
	dl.descript > dt {color:<?=$css_col['session_sub_session1_font']?>;}
	
	dl.descript.type2 {background-color:<?=$css_col['session_sub_session2_bg']?>;}
	dl.descript.type2 > dt {color:<?=$css_col['session_sub_session2_font']?>;}

	
</style>
<?}?>


<script type="text/javascript" src="/script/1.11.2.jquery.min.js"></script>
<script type="text/javascript" src="/script/user.js?v=1"></script>


</head>
<body>
