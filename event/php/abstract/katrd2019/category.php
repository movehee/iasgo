<?php
include_once "config.php";
?>


<ul class="subjectList">
<?php
foreach($_abs_category as $key => $val) {
?>
	<li><a href="./list.php?code=<?=$code?>&deviceid=<?=$deviceid?>&parent=<?=$key?>&tab=<?=$tab?>"><?=$val?></a></li>
<?}?>

</ul>