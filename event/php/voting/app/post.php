<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";


if(empty($sid)){
	$query="SELECT * FROM voting_tbl where code='".$code."' and status in ('1','3')";
}else{
	$query="SELECT * FROM voting_tbl where code='".$code."' and sid='".$sid."'";
}
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);

$sid = $col['sid'];




$result = mysqli_query($conn, "select status from voting_tbl where sid='".$sid."'");
$row = mysqli_fetch_array($result);
$status = $row['status'];

if($status=="1"){

	$result = mysqli_query($conn, "select count(*) cnt from voting_result_tbl where voting_sid='".$sid."' and deviceid='".$deviceid."'");
	$row = mysqli_fetch_array($result);

	$chk = $row['cnt'];
	if($chk==0){
		$query = "insert into voting_result_tbl set code='".$code."', deviceid='".$deviceid."', voting_sid='".$sid."',  val='".$val."'";
		$result = mysqli_query($conn, $query);
		echo "1";
	}else{
		$query = "update voting_result_tbl set val='".$val."' where deviceid='".$deviceid."' and voting_sid='".$sid."'";
		$result = mysqli_query($conn, $query);
		echo "2";
	}
}else {
	echo "3";
}
?>
