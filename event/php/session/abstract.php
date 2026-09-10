<?include "./../header.php";?>
<?


$abs_setting_query="SELECT * FROM abstract_set_tbl where code='".$code."'";
$abs_setting_result = mysqli_query($conn, $abs_setting_query);
$abs_setting_col = mysqli_fetch_array($abs_setting_result);


$title = $abs_setting_col['abstract_txt'];

/*
$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);
*/


$query="SELECT a.* FROM session_category_tbl a, session_tbl b, session_tbl c where a.sid=b.category1 and b.sid=c.link_session and a.code='".$code."' and (c.abs_no not in('') or c.lecture_file not in ('')) and c.abs_no is not null and a.del='N' group by a.sid order by orderby asc";
$result = mysqli_query($conn, $query);

?>
<div id="fixedTop">
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
		<li><a href="./list.php?category=<?=$col['sid']?>&tab=-7&code=<?=$code?>"><?=$col['info']?></a></li>
	<?}?>
</ul>


</body>
</html>

