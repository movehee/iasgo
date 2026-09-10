<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";
	
	$query = "select *, (select title from workshop_session_category where sid=t1.room) as room from workshop_session_tbl as t1 where ev_date='$ev_key' and del='N' order by room asc,stime asc, etime asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div class="form-group" >
<select name="session_sid" id="session_sid" style="width:80%;" class="pickout"  placeholder="Select a ">
	<option value="">선택</option>
	<?
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<option value="<?=$d['sid']?>" >[<?=$d['room']?>] [<?=$d['part']?>][<?=$d['part2']?>][<?=$d['code']?>]<?=$d['stime']."~".$d['etime']." - ".stripslashes($d['title'])?></option>
	<?}?>
</select>
</div>