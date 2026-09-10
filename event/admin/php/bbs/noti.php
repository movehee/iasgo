<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($noti=="Y") {
	$noti="N";
}else {
	$noti="Y";
}
$query = "update bbs_tbl SET ";
$query .= "notiYN='".$noti."'";
$query .= ",signdate='".time()."'";
$query .= " where sid=".$sid;
mysqli_query($conn, $query);
?>
<!--
<script>
	opener.location.reload();
	window.close();
</script>
-->