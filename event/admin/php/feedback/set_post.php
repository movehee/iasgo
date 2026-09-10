<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];


$eventdates = explode("-",$feedback_end_time);

if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " feedback_all_chk='".$_POST['feedback_all_chk']."'";
	$query .= ", feedback_end_time='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";

	

	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO session_set_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", feedback_end_time='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";
	$query .= ", feedback_all_chk='".$_POST['feedback_all_chk']."'";


}
mysqli_query($conn, $query);
?>
<script>
	opener.location.reload();
	window.close();
</script>