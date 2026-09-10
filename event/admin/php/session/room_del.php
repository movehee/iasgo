<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "delete from session_room_tbl where sid=".$sid;
$conn->query($query);

?>


<script>
	opener.location.reload();
	window.close();
</script>