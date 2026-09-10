<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


/*
{
	code: $code,
	deviceid: $deviceid, 
	sid: $sid, (photo_sid)
	val: $val, (1:추가, 0:삭제)

}

*/

if(is_null($code) || is_null($deviceid) || is_null($sid) || is_null($val)) {
	echo json_encode(array("result"=>"N", "result_txt"=>"등록오류 입니다."));
	exit;
}

if($val=="0")
{
	$query = "delete from photo_favor_tbl where deviceid='".$deviceid."' and photo_sid='".$sid."'";	
	$result = mysqli_query($conn, $query);
} else {
	$query = "insert into photo_favor_tbl (code,deviceid,photo_sid) VALUES ('".$code."','".$deviceid."','".$sid."')";	
	$result = mysqli_query($conn, $query);
	
}






$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.sid='".$sid."'";
$query .= " and a.del='N'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
echo json_encode(array("result"=>"Y", "cnt"=>$row['cnt']));
?>