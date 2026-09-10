<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$ev_date='1';

	$fsql = " where del='N' and login".$ev_date."='Y' and login_day".$ev_date." is null and member_level!='M' and classification not in ('Y','M')";

	$ncnt = $conn->getOne("select count(*) from registration_tbl " .$fsql);
	$query = "select * from registration_tbl " .$fsql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$send_cell[] =  $d['cell'];
	}

	$sms_arr = implode(",",$send_cell);
?>
<form name="sendF" method="post" action="http://ezv.kr/sms/login_none.php">
	<input type="hidden" id="hurl" value="gie-event.ezv.kr">
	<input type="hidden" id="ncnt" value="<?=$ncnt?>">
	<input type="hidden" id="send_cell" value="<?=$send_cell?>">
</form>
<script>
	var sms = "<?=$sms_arr?>";
	location.href="http://ezv.kr/sms/?sms="+encodeURIComponent(sms);
	//document.sendF.submit();
	//window.open("http://ezv.kr/sms/?sms="+encodeURIComponent(sms)+"&sid="+encodeURIComponent(sid)+"&hurl="+encodeURIComponent(hurl),"","width=600,height=500");
</script>