<?include "./../header.php";?>



<?if($title){?>
<div id="fixedTop">
<div class="titArea">
	<h2><?=$title?></h2>
	<p class="fixedBtn">
		<a href="./back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>
		
	</p>
</div>
</div>
<?}?>
<?
$glanceYN="Y";
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

	$query = "select a.*,t.time time_info, r.name room_info, r.viewYN room_view, r.photo room_photo, r.view_type from session_tbl a, session_room_tbl r, session_time_tbl t where a.time=t.sid and a.room=r.sid and  a.type='1' and a.sid='".$glance."'";
	$query .= " order by a.tab asc, a.orderby asc";
	$result = mysqli_query($conn, $query);


?>


<div class="wrapper">
	<!-- container -->
	<div id="containerWrap">
		
<?
	include "./info.php";
?>

<?
	include "./memo.php";
?>
<?
if($setting_col['evaluation']=="Y2"){
	$setting_col['evaluation']="N";
}
	include "./evaluation.php";
?>
</div>
<p id="goTop" style="display: block;"><a onclick="javascript:window.scrollTo(0,0);"><i class="fas fa-chevron-up"></i>TOP</a></p>
<div style="width:100%;height:20px">&nbsp</div>



<div id="fixedArea">
	<?
	include "./alarm.php";
	?>
</div>
</body>
</html>

