<?php
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

$query_sub = "select * from e_poster_category where depth='2' and psid='".$psid."' and del='N' order by sort_num asc";
$result_sub=$conn->query($query_sub);
if(DB::isError($result_sub)) die($result_sub->getMessage());

while(is_array($sub=$result_sub->fetchRow(DB_FETCHMODE_ASSOC))) {
	$category_data[] = array("key"=>$sub['sid'], "value"=>$sub['title']);
}

echo json_encode($category_data);