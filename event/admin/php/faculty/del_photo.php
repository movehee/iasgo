<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "update faculty_tbl set photo='' where sid=".$sid;
mysqli_query($conn, $query);

?>


<script>
	opener.location.reload();
	window.close();
</script>