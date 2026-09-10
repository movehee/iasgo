<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	if(isAdminLogined()){
		PutLocation("/");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$_CONFIG['Name']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/css/webinar_admin.css">
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	if ($(window).height() > 760) {
		$("div.loginWrap").height($(window).height());
	}	
});
</script>
</head>
<body>
<div class="loginWrap">
	<h1 class="ac" style="z-index:9999 !important;color:#ffffff;position:absolute;top:10px;text-align:center;width:100%;font-size:40px;">
			<?=$_CONFIG['Name']?> 관리자
		</h1>
	<div class="loginArea">
		
		<div class="formArea" >
			<form id="loginF" name="loginF" action="login_reg.php" method="post">
				<fieldset>
					<legend>로그인</legend>
					<dl>
						<dt><label for="info1">ID</label></dt>
						<dd><input type="text" name="id" id="id"></dd>

						<dt><label for="info7">비밀번호</label></dt>
						<dd><input type="password" name="license_number" id="license_number"></dd>
					</dl>
					<div class="btn">
						<input type="submit" value="관리자 LOGIN">					
					</div>
				</fieldset>
			</form>
		</div>
	</div>

</div>
<!-- //loginWrap -->


</div>

</body>
</html>