<?php
include_once "config.php";
?>

<ul class="subjectList">
<?php
	$query="SELECT * FROM session_category_tbl where code='".$code."' and del='N' order by orderby";
	$result = mysqli_query($conn, $query);
	
	while(is_array($col = mysqli_fetch_array($result))){

?>
	<li><a href="./list.php?code=<?=$code?>&deviceid=<?=$deviceid?>&category1=<?=$col['sid']?>"><?=$col['info']?></a></li>
<?}?>

</ul>