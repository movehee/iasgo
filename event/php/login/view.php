<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$css_query="SELECT * FROM css_tbl where code='".$code."'";
$result = mysqli_query($conn, $css_query);
$css_col = mysqli_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="format-detection" content="telephone=no" />
<title>Easy Voting</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi" />
<link type="text/css" rel="stylesheet" href="/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/css/voting_user.css" />
<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->

<link href="/css/jquery-ui.css" rel="stylesheet">
<script type="text/javascript" src="/script/1.11.2.jquery.min.js"></script>

<style>
	span.changeBg2 {display:inline-block;font-size: 11px;line-height:22px !important;border-radius:0px;width:22px;height:22px;background-position:center 0;text-align: center;color: #ffffff;background-color: #ffffff;}

	span.changeBg2.on {color: #fff;background-color: #ff0000;}
	
</style>
</head>
<body style="height:100%">

<?
include_once $_SERVER['DOCUMENT_ROOT']."/string.php";
$query="SELECT * FROM event_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$event_col = mysqli_fetch_array($result);



?>
 <script>
jQuery(function($) {
	$(window).ready(function(){
		var win_h = $(window).height();
		$("div.wrapper").css({"height":$(window).outerHeight()});
	});

	
});
</script> 
<div class="wrapper" style="height:100%;width:100%">

<div class="intro">
	<h1>
	<?if($event_col['login_img']){?>
	<img src="/upload/logo/<?=$event_col['login_img']?>" alt="간편하고 스마트한 모바일 보팅! Easy Voting">
	<?}else{?>
		<img src="/image/logo_voting.png" alt="간편하고 스마트한 모바일 보팅! Easy Voting">
	<?}?>
	</h1>
	<!--
	<div class="introCon">
		<strong>Voting</strong>이 시작되었습니다.<br />
		<strong>Voting</strong>에 참여해주세요!
	</div>
	-->
	<div class="btnArea">
		<form id="frm" name="frm" action="./post.php" method="post">
			<input type="hidden" name="code" value="<?=$code?>">
			<input type="hidden" name="agree" id="agree" value="">
			<fieldset>
				<legend>로그인</legend>
				<?if($event_col['nameYN']=="Y"){?>
				<input type="text" name="name" id="name" placeholder="성함을 입력해 주세요">
				<?}?>
				<?if($event_col['officeYN']=="Y"){?>
				<input type="text" name="office" id="office" placeholder="소속을 입력해 주세요">
				<?}?>
				<?if($event_col['emailYN']=="Y"){?>
				<input type="text" name="email" id="email" placeholder="e-mail을 입력해 주세요">
				<?}?>
				<?if($event_col['licenseYN']=="Y"){?>
				<input type="text" name="license" id="license" placeholder="면허번호를 입력해 주세요">
				<?}?>
				<p class="btn"><a onclick="frm_submit('<?=$event_col['nameYN']?>','<?=$event_col['officeYN']?>','<?=$event_col['emailYN']?>','<?=$event_col['licenseYN']?>','<?=($event_col['agreeYN']=='Y'||$event_col['agree_message'])?'Y':'';?>');" class="btnDef">START</a></p>
			</fieldset>
		</form>

		<?if($event_col['agree_message']){?>
			<div style="padding:10px; border:1px solid #ffffff; margin: 30px 10px 0 10px;"><?=$event_col['agree_message']?></div>
		<?}?>

		<?if($event_col['agree_message'] || $event_col['agreeYN']=='Y'){?>
		<div style="padding-top:30px;">
			<span class="changeBg2 inputR" id="agree_box" name="agree"  onclick="agree()"><i  style="line-height: 24px;" class="fas fa-check"></i></span><label onclick="agree()">&nbsp;&nbsp;<?=$string['agree_txt']?></label>
		</div>
		<?}?>
			
		
		
	</div>
</div>

</div>

<script>

	function agree(){

		if(document.getElementById("agree").value){
			document.getElementById("agree").value="";
			document.getElementById("agree_box").classList.remove('on');
		}else{
			document.getElementById("agree").value="Y";
			document.getElementById("agree_box").classList.add('on');
		}
	}
	function frm_submit(a1,a2,a3,a4,a5){
		if(a5 && !document.getElementById("agree").value){
			alert("개인정보 동의를 확인해주세요.");
			return false;
		}
		if(a1 && !document.getElementById("name").value){
			alert("성함을 입력해 주세요.");
			return false;
		}
		if(a2 && !document.getElementById("office").value){
			alert("소속을 입력해 주세요.");
			return false;
		}
		if(a3 && !document.getElementById("email").value){
			alert("e-mail을 입력해 주세요.");
			return false;
		}
		if(a4 && !document.getElementById("license").value){
			alert("면허번호를 입력해 주세요.");
			return false;
		}
		document.getElementById('frm').submit();
	}

	

</script>
<!-- //wrapper -->



</body>
</html>