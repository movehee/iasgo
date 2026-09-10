<?
if($_GET['number']){
	define('M2', true);
	include "./config.php";
	//include "${DOCUMENT_ROOT}func/include.connect.php";

	$query = "select count(sid) from $mail_list_tbl where readdate > 0 and sid='${_GET['number']}'";
	$chk = $conn->getOne($query);
	
	if($chk <= 0){
		$query = "SELECT mail_sid, (SELECT count(sid) FROM $mail_list_tbl WHERE mail_sid=t1.mail_sid AND readdate > 0) as count FROM $mail_list_tbl as t1 where sid='${_GET[number]}'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	
		$result->fetchInto(&$d, DB_FETCHMODE_ASSOC);
		$result->free();	
		
		$sid = $d['mail_sid'];
		$count = $d['count']++;	
	
		$readdate=time();
		$query="UPDATE $mail_list_tbl SET readdate='${readdate}' WHERE sid='${_GET[number]}'";
		
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	
		$query="UPDATE $mail_tbl SET `total_read`='$count' WHERE sid='$sid'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
	}

}
?>