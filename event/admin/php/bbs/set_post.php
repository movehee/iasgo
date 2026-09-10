<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


if (   ( $_POST['push_code'] != $_POST['oldPushCode'] ) && !empty($_POST['push_code']) ) {
	$searchQuery = "select * from event_tbl where pushcode = '".trim($_POST['push_code'])."'";
	$result = mysqli_query($conn, $searchQuery);
	
	$name = '';
	$count = 0;
	while($row = $result->fetch_assoc()) {
		if ( $row['code'] == "" ) continue;
		$count += 1;
		$name .= $row['code']."  ";
	}
	
	
	if ( $count > 0 ) {
		echo "<script>alert('PushCode가 동일한 행사가 ".$count."개 있습니다. (  ".$name." ).');</script>";
	}
}

$query = "update event_tbl SET ";
$query .= " android_key='".$_POST['android_key']."'";
$query .= ",ios_key='".$_POST['ios_key']."'";
$query .= ",bbs_name='".$_POST['bbs_name']."'";
$query .= ",test_token1='".$_POST['test_token1']."'";
$query .= ",test_token2='".$_POST['test_token2']."'";
$query .= ",testYN='".$_POST['testYN']."'";
$query .= ",push_title='".$_POST['push_title']."'";
$query .= ",pushcode='".trim($_POST['push_code'])."'";

$query .= " where code='".$_POST['code']."'";
//echo $query;
$conn->query($query);
?>
<script>
	opener.location.reload();
	window.close();
</script>