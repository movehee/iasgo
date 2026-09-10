<?php
	if (!isset($pageType)) {
		$pageType = 'sub';
	}
	$wrapClass = ($pageType == 'intro') ? 'intro' : 'sub';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5, user-scalable=yes, viewport-fit=cover">
<meta name="format-detection" content="telephone=no, address=no, email=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="Author" content="IASGO 2026">
<meta name="Keywords" content="IASGO 2026">
<meta name="description" content="IASGO 2026">
<title>IASGO 2026</title>
<link type="text/css" rel="stylesheet" href="/assets/css/slick.css">
<link type="text/css" rel="stylesheet" href="/assets/css/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" href="/assets/css/onsite.css">
<script type="text/javascript" src="/assets/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/slick.min.js"></script>
<script type="text/javascript" src="/assets/js/common.js"></script>
<script type="text/javascript" src="/assets/js/onsite.js"></script>
</head>
<body>
	<div class="wrap <?=$wrapClass?>">
		<?php if ($pageType == 'sub'): ?>
			<section id="container">
				<article class="contents">
					<div class="sub-visual">
						<div class="sub-visual-con inner-layer">
							<span class="slogan">
								<img src="/assets/image/onsite/img_slogan_text.png" alt="GO Together! IASGO Forever!">
							</span>
							<h2 class="sub-visual-tit">
								<a href="/"><img src="/assets/image/onsite/img_subvisual_text.png" alt="IASGO 2026"></a>
							</h2>
							<a href="/" class="tag">On-Site Registration</a>
						</div>
					</div>
		<?php endif; ?>