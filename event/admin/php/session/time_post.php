<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";




if($showYN == 'Y') {

	$time_sp = explode("-", $_POST['time']);
	$stime = $time_sp[0];
	$etime = $time_sp[1];

	$chk_query = " 
	select * from (
	select 
	SUBSTRING_INDEX(time, '-', 1) s_time,
	SUBSTRING_INDEX(time, '-', -1) e_time
	from session_time_tbl where del='N' and code='".$_POST['code']."' and tab='".$_POST['tab']."' and showYN='Y'";

	if(!empty($sid))
	{
		$chk_query .= "and sid!='$sid'";
	}

	$chk_query .= "
	) a where 
	
	(s_time < '$stime' and '$stime' < e_time) or
	(s_time < '$etime' and '$etime' < e_time) or
	(s_time < '$stime' and '$etime' < e_time) 
	";

	$chk_result = $conn->query($chk_query);

	$chk_num = $chk_result->num_rows;

	if($chk_num) {
		echo "<script>alert('등록 하려는 시간대를 포함하거나 겹치는 시간이 이미 등록되어있습니다. 등록 시간을 변경하거나 보임여부를 N 으로 등록해주세요.');history.go(-1);</script>";
		exit;
	}

}




$chk_query = "select * from session_time_tbl where del='N' ";
$chk_query .= "and code='".$_POST['code']."' ";
$chk_query .= "and tab='".$_POST['tab']."' ";
$chk_query .= "and time='".$_POST['time']."' ";
if(!empty($sid))
{
	$chk_query .= "and sid!='$sid'";
}

$chk_result = $conn->query($chk_query);

$chk_num = $chk_result->num_rows;
if($chk_num) {
	echo "<script>alert('이미 등록되어있는 시간입니다.');history.go(-1);</script>";
	exit;
}

if(!empty($sid))
{
	$query = "update session_time_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",showYN='".$_POST['showYN']."'";
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from session_time_tbl where code='".$code."' and tab='".$_POST['tab']."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO session_time_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= ",showYN='".$_POST['showYN']."'";
}

$conn->query($query);
echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>
