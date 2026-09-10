<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$result_chk = mysqli_query($conn, "select sid from faculty_tbl where code='$code' and group_code='$sid'");
if($result_chk->num_rows) {
	echo "err";exit;
}



$result = mysqli_query($conn, "select orderby,code from faculty_group_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

$query = "delete from faculty_group_tbl where sid=".$sid;
mysqli_query($conn, $query);

$query = "update faculty_group_tbl SET orderby=orderby-1 where code='".$row['code']."' and orderby>".$row['orderby'];
mysqli_query($conn, $query);


?>


<script>
	opener.location.reload();
	window.close();
</script>