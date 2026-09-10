<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.header.php';?>
<?
if(!$tab) $tab=1;
?>
<div class="contents">

    <ul class="subMenu" style="margin-bottom: 25px;">
        <li <?if($tab == '1'){?>class="on"<?}?>><a href="/faculty">Invited Speakers</a></li>
        <li <?if($tab == '2'){?>class="on"<?}?>><a href="/faculty/?tab=2">Chairpersons</a></li>
    </ul>

	<div class="keywordSearch">
		<form id="searchF" name="searchF" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<input type="hidden" name="tab" value="<?=$tab?>">
			<fieldset>
				<legend>Search</legend>
				<input type="text" name="search_keyword" id="search_keyword" value="<?=stripslashes($search_keyword)?>" placeholder="Keyword / Faculty Name, Affiliation, Lecture Title">
				<span class="btn"><input type="submit" value="Search"></span>
			</fieldset>
		</form>		
	</div>
    <?include_once $_SERVER['DOCUMENT_ROOT'].'faculty/inc/con'.$tab.'.php';?>

    
</div>
<?include_once $_SERVER['DOCUMENT_ROOT'].'include/include.footer.php';?>