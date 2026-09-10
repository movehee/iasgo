<?php
	include $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	procAdminLoginChk();

	require_once $_SERVER['DOCUMENT_ROOT'].'/registration/include.statistics.php';

	$stats = getRegStatistics($conn);
	$excelBase = '/registration/statistics_excel.php';
?>
<div class="contents">
	<h3 style="margin-bottom:15px;">등록통계</h3>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/registration/include.statistics_view.php'; ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].$_Path['link'].'/include.footer.php'; ?>
