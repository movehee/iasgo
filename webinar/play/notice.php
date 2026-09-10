<?
include $_SERVER['DOCUMENT_ROOT']."lib.php";
$query = "select * from w_notice_tbl where del='N' and push='Y' and code='$code'";
if($room_sid){
	$query .= " and find_in_set($room_sid,room_sid)";
}
$result = $conn->query($query);
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();
?>

<dt>Notice</dt>
<dd class="scrollArea" id="Notice_content">
	<input type="hidden" id="Notice_key" value="<?=trim($d['code'])?>">
	<?=strip_tags($d['content'])?>
</dd>
<dd class="close"><a href="javascript:Notice_Close('<?=$d['code']?>')"><img src="/asset/player/viewPopup_close.png" alt="Close"></a></dd>