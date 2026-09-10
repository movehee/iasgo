<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.header.php';?>
<?
	$mn = $_GET['mn'] ? $_GET['mn'] : 1;

	$booth_query = "select * from booth where sid='$booth_sid'";
	$booth_result = $conn->query($booth_query);
	$booth_result->fetchInto(&$booth,DB_FETCHMODE_ASSOC);
	$booth_result->free();

?>
<style>
div#popupSponsor div.popupCon > div {height: 630px !important;}
</style>

<div class="popupWrap" id="popupSponsor">
	<h1 class="bg"><?if($booth['booth_sid']=="5"||$booth['booth_sid']=="6"){?>Exhibitors<?}else{?>Sponsors<?}?></h1>
	<div class="popupCon">
		
		<?php include './include.top_menu.php';?>	
		<?php include './content/con'.$mn.'.php';?>	
	</div>
	<!-- //popupCon -->
	<div class="close"><a href="# return false;" class="color_close"></div>
</div>
<!-- //popupWrap -->


<?include_once $_SERVER['DOCUMENT_ROOT'].'load/include/include.footer.php';?>