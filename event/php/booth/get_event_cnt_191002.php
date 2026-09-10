<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


$query = "SELECT count(*) cnt FROM booth_tbl a, booth_event_tbl b where a.sid=b.booth_sid and a.code='".$code."'  and a.del='N' and b.user_sid='".$user_sid."' and a.del='N' and a.tab in ('1','2') and b.booth_sid not in ('0')";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);


$query = "SELECT count(*) cnt FROM booth_tbl a, booth_event_tbl b where a.sid=b.booth_sid and a.code='".$code."'  and a.del='N' and b.user_sid='".$user_sid."' and a.vip='6' and a.sid not in ('96') ";
$result = mysqli_query($conn, $query);
$row2 = mysqli_fetch_array($result);


$query = "SELECT signdate FROM booth_event_gift_tbl where code='".$code."' and user_sid='".$user_sid."'";
$result = mysqli_query($conn, $query);
$row3 = mysqli_fetch_array($result);
if(!$row3['signdate']){
	$row3['signdate']=0;
}

$query = "SELECT count(*) cnt FROM booth_tbl where code='".$code."' and del='N' and tab in ('1','2')";
$result = mysqli_query($conn, $query);
$row4 = mysqli_fetch_array($result);

//$row3['signdate']=0;
$eventYN = "N";
if($row['cnt']>=$setting_col['booth_event_cnt'] && $row2['cnt']>=$setting_col['booth_event_cnt2']){
	$eventYN = "Y";
}
$json=array(
	'cnt'=>$row['cnt'],
	'vip_cnt'=>$row2['cnt'],
	'gift'=>$row3['signdate'],
	'eventYN'=>$eventYN,
	'total'=>$row4['cnt']
);
echo json_encode($json);
?>
