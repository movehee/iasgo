<?include "./../header.php";?>
<?


//$title="Category";
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";

$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);

$title = $setting_col['program_category_title']?$setting_col['program_category_title']:"Program by Session";




$query="SELECT * FROM session_category_tbl where code='".$code."' and del='N' and select_category='Y' order by orderby asc";
	$result = mysqli_query($conn, $query);
?>
<div id="fixedTop">
<!-- container -->
<?if($toptext){?>
	<div class="ws_titArea">
		<h2><?=$toptext?></h2>
		<p><a href="close.php">닫기</a></p>
	</div>
<?}?>
<div class="titArea">
	<h2><?=$title?></h2>
	<p class="fixedBtn">
		<a href="./back.php" class="back"><i class="fas fa-arrow-left" title="이전"></i></a>

	</p>
</div>
</div>
<div class="wrapper">
<ul class="subjectList">
	<?while(is_array($col = mysqli_fetch_array($result))){?>
		<li><a href="./list.php?category=<?=$col['sid']?>&tab=-4&code=<?=$code?>&toptext=<?=$toptext?>"><?=$col['info']?></a></li>
	<?}?>
</ul>

<div style="width:100%;height:20px">&nbsp</div>

<div id="fixedArea">
	<ul class="programMenu">
		<?if($setting_col['bottom_menu_now']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&tab=-1&deviceid=<?=$deviceid?>"><img src="/image/programMenu_01.png" alt="NOW"> </a></li>
		<?}?>

		<?if($setting_col['bottom_menu_program']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><img src="/image/programMenu_04.png" alt="Program"> </a></li>
		<?}?>

		<?if($setting_col['bottom_menu_glance']=="Y"){?>
		<li><a href="./glance.php?code=<?=$code?>&toptext=<?=$toptext?>&deviceid=<?=$deviceid?>"><img src="/image/programMenu_02.png" alt="Program At a Glance"> </a></li>
		<?}?>

		<?if($setting_col['bottom_menu_myfav']=="Y"){?>
			<li><a href="./list.php?code=<?=$code?>&toptext=<?=$toptext?>&tab=-2&deviceid=<?=$deviceid?>"><img src="/image/programMenu_03.png" alt="My Schedule"> </a></li>
		<?}?>


	</ul>
</div>


<script>
jQuery(function($) {

	$("ul.programMenu > li").css('width',$(window).width()/$("ul.programMenu > li").size()-1);
	//alert($("ul.programMenu > li") .size());
	//alert($("span.sessionTit").css('font-size'));
	//$("span.sessionTit").css('font-size','20px');
	//$("p.sessionBrief a span").css('font-size','20px');


});
</script>

</body>
</html>
