<?
	$pageType = 'intro';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.header.php';
?>
<section class="intro-contents">
	<h1 class="intro-tit">
		<a href="/"><img src="/assets/image/onsite/img_intro_tit.png" alt="IASGO 2026"></a>
		<strong>
			On-Site Registration
		</strong>
	</h1>
	<div class="btn-wrap text-center">
		<a href="/onsite/postform_domestic.php" class="btn btn-type1 color-type-gra1">Domestic</a>
		<a href="/onsite/postform_overseas.php" class="btn btn-type1 color-type-gra2">Overseas</a>
	</div>
</section>
<?
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.footer.php';
?>
