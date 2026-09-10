<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


if($val=="0")
{
	$query = "delete from photo_favor_tbl where deviceid='".$deviceid."' and photo_sid='".$sid."'";	
	$result = mysqli_query($conn, $query);
} else {
	$query = "insert into photo_favor_tbl (deviceid,photo_sid) VALUES ('".$deviceid."','".$sid."')";	
	$result = mysqli_query($conn, $query);
	
}


$query = "insert into log_tbl (query) VALUES ('deviceid:".$deviceid."val:".$val."sid:".$sid."') ";
$result = mysqli_query($conn, $query);




$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.sid='".$sid."'";
$query .= " and a.del='N'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
echo $row['cnt'];
?>