<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


$query = "SELECT * FROM (select count(*) cnt, a.user_sid,b.sid from booth_event_tbl a LEFT JOIN booth_event_gift_tbl b ON a.user_sid=b.user_sid AND b.CODE='".$code."' WHERE a.code='".$code."' group BY a.user_sid) c WHERE c.cnt>=".$setting_col['booth_event_cnt']." AND c.sid IS null  order by rand();";


$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

if($row['user_sid']) {

	// echo $row['user_sid'];


	$query = "INSERT INTO booth_event_gift_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ",user_sid='".$row['user_sid']."'";
	$query .= ",signdate='".time()."'";

	$result = mysqli_query($conn, $query);

	$json = array($row['user_sid']);
	echo json_encode($json);
}

//테스트
//$json = array('10220');
//echo json_encode($json);
?>
