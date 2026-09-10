<?php include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?php
	$mn = $_GET['mn'] ? $_GET['mn'] : 1;
?>
<div class="contents">

	<div class="sponsors">
				
		<?php include './include/include.top_menu.php';?>	
		<?php include './content/con'.$mn.'.php';?>	

	</div>
	
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>