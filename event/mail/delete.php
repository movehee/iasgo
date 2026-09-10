<?
##### 환경파일 include
include "config.php";
procLoginChk();

	$query = "delete from $mail_tbl where sid='${_GET['sid']}'";
	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());	
	
	
	$query = "delete from $mail_list_tbl where mail_sid='${_GET['sid']}'";
	$result = $conn->query($query);
	if(DB::isError($result)) die($result->getMessage());	
	
	PutLocation("/admin/mail/list.php?search_query=".urlencode($search_query));
?>