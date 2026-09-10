<?include $_SERVER['DOCUMENT_ROOT']."lib.php";?>
<?if($key=='1'){?>
<select name="major_year" id="major_year">
	<option value="">연차선택</option>
	<?for($i=1;$i<=4;$i++){?>
		<option value="<?=$i?>"><?=$i?>년차</option>
	<?}?>
</select>
<?}else if($key=='2'){?>
<select name="title_sub" id="title_sub">
	<option value="">구분선택</option>
	<?foreach($_REG['memberGubun_sub2'] as $tkey=>$tval){?>
		<option value="<?=$tkey?>"><?=$tval?></option>
	<?}?>
</select>
<?}else if($key=='5'){?>
<select name="title_sub" id="title_sub">
	<option value="">구분선택</option>
	<?foreach($_REG['memberGubun_sub5'] as $tkey=>$tval){?>
		<option value="<?=$tkey?>"><?=$tval?></option>
	<?}?>
</select>
<?}?>