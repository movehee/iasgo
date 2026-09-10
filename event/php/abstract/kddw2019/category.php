<?php
include_once "config.php";
?>

<ul class="subjectList">
<?php
	
	if($parent) {
		$query="SELECT sid as session_sid, category1 as sid, theme as info FROM session_tbl where code='".$code."' and type='1' and category1='$parent' order by orderby";
	}
	else {

		$query="SELECT * FROM session_category_tbl where code='".$code."' and del='N' order by orderby";

	}
	$result = mysqli_query($conn, $query);
	
	while(is_array($col = mysqli_fetch_array($result))){
?>
	<?if($col['sid'] == '368'){?>
		<?if($parent){?>
			<li><a href="./list.php?code=<?=$code?>&deviceid=<?=$deviceid?>&session_sid=<?=$col['session_sid']?>"><?=$col['info']?></a></li>
		<?}else{?>
			<li><a href="./category.php?code=<?=$code?>&deviceid=<?=$deviceid?>&parent=<?=$col['sid']?>"><?=$col['info']?></a></li>
		<?}?>
	<?}else{?>
		<li><a href="./list.php?code=<?=$code?>&deviceid=<?=$deviceid?>&category1=<?=$col['sid']?>"><?=$col['info']?></a></li>
	<?}?>
<?}?>

</ul>