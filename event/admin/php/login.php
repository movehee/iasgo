<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/config.php";
ob_start();
setcookie('admin', 'N', time(), '/', $_cookie_domain);
setcookie('code', 'N', time(), '/', $_cookie_domain);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="kor" xml:lang="kor"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Voting 관리자</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
<link type="text/css" rel="stylesheet" href="/admin/css/common_v2.css" />
<link type="text/css" rel="stylesheet" href="/admin/css/admin.css" />

<!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js">IE7_PNG_SUFFIX=".png";</script>
<![endif]-->

<script type="text/javascript" src="/admin/script/jquery.min.1.7.1.js"></script>
<script type="text/javascript" src="/admin/script/jquery.placeholder.js"></script>
<script type="text/javascript" src="/admin/script/user.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {

});
//]]>
</script>
</head>
<body>

<div class="wrapper">



	<div class="adminLogin">
		
		<h1><img src="/admin/image/login_logo.png" width="250px" alt="Easy Voting" /></h1>
		<form id="login_form" name="login_form" action="./login_ok.php" method="post">
			<fieldset>
				<legend>관리자 로그인</legend>
				<div class="formArea">
					<dl>
						<dt class="hidden">Code</dt>
						<dd><input type="text" name="code" id="code" class="_placeholder" placeholder="행사코드를 입력해 주세요" /></dd>

						<dt class="hidden">비밀번호</dt>
						<dd><input type="password" name="password" id="password" class="_placeholder" placeholder="비밀번호를 입력해 주세요" /></dd>
					</dl>

					<p class="btn"><input type="submit" class="btnDef" value="로그인"/></p>
				</div>
			</fieldset>
		</form>

	</div>
	
<?include "./footer.php";?>

