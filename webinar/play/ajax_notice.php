<?php
include $_SERVER['DOCUMENT_ROOT']."lib.php";

$nchk = $conn->getOne("select count(*) from w_notice_tbl where del='N' and push='Y' and find_in_set($room_sid,room_sid)");
if($nchk==0){
echo json_encode(array('push'=>'N'));
exit;
}
$query = "select * from w_notice_tbl where del='N' and push='Y' and find_in_set($room_sid,room_sid)";
$result = $conn->query($query);
$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
$result->free();

$conn->disconnect();

if($_COOKIE[$d['code']]){
echo json_encode(array('push'=>'N'));
//echo "N";
//exit;
}else{
echo json_encode(array('push'=>$d['code']));
//echo $d['code'];
}
exit;
?>