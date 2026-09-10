<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procLoginChk();
?>
<script type="text/javascript" src="/script/jquery.1.9.0.js"></script>
<script style="text/javascript">
	$(function(){
		window.resizeTo(1200,950);
	});
</script>
<body style="margin:0px;padding:0px;" oncontextmenu='return false' onselectstart='return true' ondragstart='return true'> 
<?
	$file_query = "select * from e_poster_file where psid='".$sid."' order by sort_num asc";
	$file_result=$conn->query($file_query);
	if(DB::isError($file_result)) die($file_result->getMessage());

	while(is_array($f=$file_result->fetchRow(DB_FETCHMODE_ASSOC))){
?>
<img src="<?=$_Azure['link']?>upload/e_poster/<?=$f['filename']?>" alt="" style="width:100%;">
<?}?>
</body>