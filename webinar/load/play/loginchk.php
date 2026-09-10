<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

$chking = $conn->getOne("select count(*) from registration_tbl where sid='$usid' and session_code='$login_code'");
/*if($_COOKIE['wmember_sid']){
$query = "update checkin_tbl".$_COOKIE['Gkey']." set s3_edate='".time()."', last_date='".time()."', s7_sdate='3'";
$query .= " where usid='".$_COOKIE['wmember_sid']."' and day='2' and s3_sdate>0";
$result = $conn->query($query);
if(DB::isError($result)) {
die($result->getMessage());
}
}*/
$conn->disconnect();

if($chking>0){
echo json_encode(array('loginchk'=>'Y'));
}else{
echo json_encode(array('loginchk'=>'N'));
}
exit;
?>