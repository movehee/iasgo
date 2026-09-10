<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_evaluation_tbl where deviceid='".$deviceid."' and session_sid='".$session_sid."'");
$row = mysqli_fetch_array($result);


if($row['cnt']>0)
{
	$query = "update session_evaluation_tbl SET ";
	$query .= "deviceid='".$deviceid."'";
	$query .= ",session_sid='".$session_sid."'";
	$query .= ",score='".$score."'";
	$query .= ",memo='".$memo_txt."'";
	$query .= " where deviceid='".$deviceid."' and session_sid='".$session_sid."'";
}
else
{

	$query = "INSERT INTO session_evaluation_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ",regist_sid='".$regist_sid."'";
	$query .= ",deviceid='".$deviceid."'";
	$query .= ",score='".$score."'";
	$query .= ",session_sid='".$session_sid."'";
	$query .= ",signdate='".time()."'";
	$query .= ",memo='".$memo_txt."'";
}

mysqli_query($conn, $query);

echo "Y";




