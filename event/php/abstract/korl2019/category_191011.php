<?php
include_once "config.php";

if(!$top_tab) $top_tab = 1;
?>

<ul class="tabMenu">
	<li class="menu <?if($top_tab=='1'){?>on<?}?>"><a href="?code=<?=$code?>&top_tab=1">By Type</a></li>
	<li class="menu <?if($top_tab=='2'){?>on<?}?>"><a href="?code=<?=$code?>&top_tab=2">By Topics</a></li>
</ul>

<ul class="subjectList">
<?php
foreach($_abs_category[$top_tab] as $key => $val) {
?>
	<li><a href="./list.php?code=<?=$code?>&deviceid=<?=$deviceid?>&parent=<?=$top_tab?>&tab=<?=$key?>"><?=$val?></a></li>
<?}?>

</ul>