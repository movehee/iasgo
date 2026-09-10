<?include $_SERVER['DOCUMENT_ROOT'].'lib.php'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$_CONFIG['Name']?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script type="text/javascript" src="/script/jquery.js"></script>
<script type="text/javascript" src="/asset/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/asset/webinar.js"></script>
<script type="text/javascript" src="/script/webinar.js"></script>
<link type="text/css" rel="stylesheet" href="/script/colorbox/example3/colorbox_btn_none.css" />
<script type="text/javascript" src="/script/colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
//<![CDATA[
jQuery(function($) {
	if ($(window).height() > 850) {
		$("div.loginWrap").height($(window).height());
	}	
});
</script>
</head>
<?php
	$mAgent = array("iPhone","iPod","Android","Blackberry", 
		"Opera Mini", "Windows ce", "Nokia", "sony", "Edge" );
	$chkMobile = false;
	$edge_check = false;
	for($i=0; $i<sizeof($mAgent); $i++){
		if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
			$chkMobile = true;
			if( $mAgent[$i] == "Edge" ){ $edge_check = true; }
			break;
		}
	}

	if($chkMobile) {
		echo "<script>location.reload('https://mobile.virtual.kcr4u.org')<script>";
		exit;
	}
?>
<body style="zoom: 1;">
	<div class="loginWrap">				
		<div class="loginArea">	

			<div class="formArea">
				
				<h1><img src="/asset/layout/login_logo.png" alt="KCR 2023"></h1>	
				<form id="loginF" name="loginF" action="/login_reg.php" method="post">
				<input type="hidden" name="off" value="Y">
					<fieldset>
						<legend>Login</legend>
						<dl class="inputArea">
							<dt>
								<label for="">ID (E-mail address)</label>
								<span>
									* Your ID (E-mail) is same as when you registered <br>
									on the KCR 2023 official website.
								</span>
							</dt>
							<dd><input type="text" name="id" id="id" placeholder="Please enter your ID (E-mail)"></dd>

							<dt>
								<label for="">Password (Last Name)</label>
								<span>*Capital letter and small letter don't matter.</span>
							</dt>
							<dd><input type="password" name="passwd" id="passwd" placeholder="Please enter your Password"></dd>
						</dl>	
						<div class="btn">
							<input type="submit" value="LOGIN" name="" id="">					
							<a href="/load/find_pass.php" class="Load_Base" Wsize="700" Hsize="417" Tsize="25%">Find Password</a>
						</div>
					</fieldset>
				</form>
				
				<ul class="loginNote">
					<li>
						This homepage is optimized for <a href="https://www.google.com/chrome/thank-you.html?statcb=1&installdataindex=empty&defaultbrowser=0" target="_blank">Chrome</a> and <a href="https://www.microsoft.com/ko-kr/edge/download?form=MA13FJ" target="_blank">Microsoft Edge</a> browsers.<br>
						Other browsers are not recommended.
					</li>
					<li>Screen size is optimized for PC monitor size (1920px*970px).<br>Laptop, tablet PCs may scroll on the screen.</li>
				</ul>

			</div>


		</div>
		<!-- //loginArea -->
	</div>	
	<!-- //loginWrap -->
</body>
</html>