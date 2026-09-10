<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$result = mysqli_query($conn, "select orderby from feedback_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

$orderby = $row['orderby'];

$query = "update feedback_tbl SET del='Y' where sid=".$sid;
mysqli_query($conn, $query);


$query = "update feedback_tbl SET orderby=orderby-1 where code='".$_COOKIE['code']."' and orderby>".$orderby;
mysqli_query($conn, $query);

?>


<script>
	opener.location.reload();
	window.close();
</script>