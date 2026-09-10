<?php
	$pageType = 'sub';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.init.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.header.php';
?>
<div class="sub-conbox inner-layer">
	<div class="complete-conbox font-paper">
		<img src="/assets/image/onsite/img_complete.png" alt="">
		<p>
			등록 완료되었습니다. <br>
			등록데스크에서 결제해주시기 바랍니다.
		</p>
	</div>
</div>
<script>
	setTimeout(function () {
		location.href = '/';
	}, 5000);
</script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/onsite/include.footer.php'; ?>