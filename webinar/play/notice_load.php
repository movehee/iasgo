<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";

	$query="SELECT * FROM w_notice_tbl where del='N' and push='Y' and find_in_set($room_sid,room_sid) order by sid desc limit 0,1";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
	$result->free();
	
	if(!$col['sid']){
		echo "Important notice will be listed here";
	}else{
		echo $col['content'];
	}
	$conn->disconnect();
?>