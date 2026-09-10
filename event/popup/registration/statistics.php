<?php
	include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php';
	procAdminLoginChk();

	require_once $_SERVER['DOCUMENT_ROOT'].'/registration/include.statistics.php';

	$stats = getRegStatistics($conn);
	$excelBase = '/registration/statistics_excel.php';
?>
<script type="text/javascript">
	$(function () {
		$('#Popup_Title').html('등록통계');
		window.resizeTo(1200, 900);
	});
</script>
<div class="popupCon" style="width:1140px;padding:20px;background:#ffffff;">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/registration/include.statistics_view.php'; ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'popup/include.footer.php'; ?>
