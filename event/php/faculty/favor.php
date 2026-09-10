<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";


$result = mysqli_query($conn, "select count(*) cnt from faculty_favor_tbl where code='$code' and faculty_sid='".$faculty_sid."' and deviceid='".$_POST['deviceid']."'");
//echo "select count(*) cnt from faculty_favor_tbl where faculty_sid='".$faculty_sid."' and deviceid='".$deviceid."'";
$row = mysqli_fetch_array($result);



	if($row['cnt']==0){
		$query = "insert into faculty_favor_tbl set code='$code', deviceid='".$_POST['deviceid']."', faculty_sid='".$faculty_sid."'";

		$result = mysqli_query($conn, $query);
		echo "Y";

	}else{
		$query = "delete from faculty_favor_tbl where code='$code' and deviceid='".$_POST['deviceid']."' and faculty_sid='".$faculty_sid."'";
		
		$result = mysqli_query($conn, $query);
		echo "N";
	}
?>