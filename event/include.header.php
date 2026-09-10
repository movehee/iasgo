<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	procAdminLoginChk();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>관리자 | <?=$_Site['Name']?></title>	
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/css/common_v3.css" />
<link type="text/css" rel="stylesheet" href="/css/sub.css" />
<link type="text/css" rel="stylesheet" href="/css/admin_v2.css" />
<link type="text/css" rel="stylesheet" href="/css/webinar.css" />
<link type="text/css" rel="stylesheet" href="/button_package/button.css" />

<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/script/user_admin.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {

});
//]]>
</script>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>
<link rel='stylesheet' type='text/css' href='/mail/conf/jquery-flick.css'/>
<SCRIPT LANGUAGE="javascript" SRC="/script/jquery.ui-jalert.js"></SCRIPT>
<script type="text/javascript" src="/script/jquery.popupoverlay.js"></script>
<link rel="stylesheet" href="/script/jquery.ui.timepicker.css">
<script src='/script/jquery.ui.timepicker.js'></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<link rel="stylesheet" href="/script/colorbox/example3/colorbox.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
//<![CDATA[
	$(function(){
		$(".tooltip").tooltip({
			content:function(){
				return $(this).prop('title');
			}
		});
		$(".tooltip_area").tooltip({
			content:function(){
				return $(this).prop('title');
			}
		});
		$('.timepicker').timepicker(); //타임픽커
		$('#fade').popup({
			transition: 'all 0.3s',
			scrolllock: true
		});
	});
//]]>
</script>
<style>
	.admin_menu2{width:200px !important;}
	.admin_menu9{width:110px !important;}
	.admin_menu10{width:110px !important;}
</style>
</head>

<body id="body">
<div id="mask"></div>
<div class="wrapper" >
	<div id="headerWrap">
		<!-- <a href="/logout.php"><div style="right:45px;top:10px;position:absolute;float:right;color:red;font-style:italic;font-weight:bold;font-size:21px;font-family:Helvetica;">LOGOUT</div></a> -->
		<div>
			
			<dl id="skipNavi">
				<dt>Skip Navigation</dt>
				<dd><a href="#container">Skip to contents</a></dd>
			</dl>
			<h1 style="top:70px;z-index:999999;"><a href="/" -target="_blank" style="color:#ffffff;text-decoration:none;font-style:italic;font-size:23px;padding-top:5px;"> <?=$_CONFIG['Name']?></a></h1>  

			<ul id="gnb" style="padding-left:150px;width:1350px;">
				<?foreach($_CONFIG['admin_menu'] as $tkey=>$tval){?>
			
				<li class="admin_menu<?=$tkey?> <?if($main_num==$tkey){?>on<?}?>"><a href="<?=$_CONFIG['admin_link'][$tkey]?>" style="font-size:17px !important;"><?=$tval?></a>
					<?if($_CONFIG['admin_sub'.$tkey.'_menu']){?>
					<ul>
						<?foreach($_CONFIG['admin_sub'.$tkey.'_menu'] as $tkey2=>$tval2){?>
						<li><a href="<?=$_CONFIG['admin_sub'.$tkey.'_link'][$tkey2]?>" style="font-size:15px !important;"><?=$tval2?></a></li>
						<?}?>
					</ul>
					<?}?>
				</li>
				<?}?>
				
			</ul>

			<!-- <dl class="otherAdmin">
				<dt><a href="/" class="trigger"><span>관리자</span>페이지</a></dt>
			</dl>

			<ul class="headerUtil">
				
				<li><a href="">HOME</a></li>
				<li><a href="/member/logout.php" class="bg">Logout</a></li>
			</ul> -->
		</div>
		
    </div> 
	<!-- //header -->
	<hr class="hidden" />
   
	<!--전체보기일 경우 class="wide" 추가 -->
    <div id="container">
		<?if($ex_url[3]!='index.php' && $ex_url[3]!=''){?>
		<div class="titArea">
			<h2 class="pageTit"><?=$_CONFIG['admin_menu'][$main_num]?><?if($_CONFIG['A_2dep_'.$main_num][$sub_num]){?> <span style="color:blue;font-size:16px;">- <?=$_CONFIG['A_2dep_'.$main_num][$sub_num]?></span><?}?></h2>
			<?if($_CONFIG['A_2dep_'.$main_num]){?>
			<ul id="lnb">
				<?foreach($_CONFIG['A_2dep_'.$main_num] as $tkey=>$tval){?>
				<li <?if($sub_num==$tkey){?>class="on"<?}?>><a href="<?=$_CONFIG['A_2dep_'.$main_num.'_link'][$tkey]?>"><?=$tval?></a></li>
				<?}?>
			</ul>
			<?}?>
		</div>
		<?}?>