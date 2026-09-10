<?php
	$pageType = 'sub';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.header.php';
?>
<div class="sub-conbox inner-layer">
	<div class="complete-conbox font-paper">
		<img src="/assets/image/onsite/img_complete.png" alt="">
		<p>
			Your registration is complete. <br>
			Please make your payment at the registration desk.
		</p>
	</div>
</div>
<script>
	setTimeout(function () {
		location.href = '/';
	}, 5000);
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.footer.php'; ?>