<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<?
if(!$kind) $kind="time";
?>
<div class="btn bp5 ac" >
	<a href="<?=$PHP_SELF?>?kind=time" class="<?if($kind=='time'){?>btnRed<?}else{?>btnBdGrey<?}?> withIcon"><i class="fas fa-edit"></i>시간설정</a>
	<a href="<?=$PHP_SELF?>?kind=country" class="<?if($kind=='country'){?>btnRed<?}else{?>btnBdGrey<?}?> withIcon"><i class="fas fa-edit"></i>국가 설정</a>
</div>

<div style="padding-top:20px;" class="ac">
	<?
	include $_SERVER['DOCUMENT_ROOT']."base_setting/".$kind.".php"; 
	?>
</div>

<?include $_SERVER['DOCUMENT_ROOT']."include.footer.php"?>		