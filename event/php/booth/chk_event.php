<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

//선물교환

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


$query = "SELECT count(*) cnt FROM booth_tbl a, booth_event_tbl b where a.sid=b.booth_sid and a.code='".$code."'  and a.del='N' and b.user_sid='".$user_sid."' and a.del='N' and a.event_YN='Y'";	
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);


$query = "SELECT count(*) cnt FROM booth_tbl a, booth_event_tbl b where a.sid=b.booth_sid and a.code='".$code."'  and a.del='N' and b.user_sid='".$user_sid."' and a.event2_YN='Y'";	
$result = mysqli_query($conn, $query);
$row2 = mysqli_fetch_array($result);


$query = "SELECT signdate FROM booth_event_gift_tbl where code='".$code."' and user_sid='".$user_sid."'";	
$result = mysqli_query($conn, $query);
$row3 = mysqli_fetch_array($result);
$eventYN = "N";
if($row3['signdate']){
	
}else{
	$row3['signdate']=0;

	if($row['cnt']>=$setting_col['booth_event_cnt'] && $row2['cnt']>=$setting_col['booth_event_cnt2']){
		$query = "insert booth_event_gift_tbl set code='".$code."', user_sid='".$user_sid."', signdate=".time();	
		$result = mysqli_query($conn, $query);
		$eventYN = "Y";
	}

}

$json=array(
	'cnt'=>$row['cnt'],
	'vip_cnt'=>$row2['cnt'],
	'eventYN'=>$eventYN,
	'gift'=>$row3['signdate']
);
echo json_encode($json);

?>