<? include $_SERVER['DOCUMENT_ROOT']."lib.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko"><!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AOCR 2022 & KCR 2022</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="/asset/block.css">
<script type="text/javascript" src="/script/jquery.js"></script>
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script>
	opener.location.href="/logout.php";
</script>
</head>
<body>


<div class="layerPopup" style="display:block;">
	<div class="popup" id="poupAgree">
		<h1><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>Notice</h1>
		<p>
			<span class="fcRed">The network connection is unstable.<br />네트워크 연결이 불안정합니다.</span><br /><br>Please log in again.<br /> 다시 로그인 해주세요.<br>
		</p>

		<div class="formArea">
			<form id="" name="" action="" method="post">
				<fieldset>
					<legend>동의</legend>

					<!-- <div class="bg">
						<div class="agreeCon">
							<ul class="txtIn1" style="height: 400px;">
								<li>1. 동시에 여러PC에서 접속이 금지되어 있습니다.</li>
								<li>2. 기타 브라우저의 기능이 정상적으로 구동이 되지 않을 경우 관리자에게 문의부탁드립니다.</li>
							</ul>
						</div>
					</div> --> 
					<div class="btnArea btn">
						<input type="button" value="Close" id="submit_agree" class="btnDef btnBig" onclick="location.href='/logout.php'"  >
					</div>

				</fieldset>
			</form>
		</div>

	</div>
</div>
<?
	if($conn){
		$conn->disconnect();
	}
?>
</body>
</html>