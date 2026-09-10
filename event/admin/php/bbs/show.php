<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($show=="Y") {
	$show="N";
}else {
	$show="Y";
}
$query = "update bbs_tbl SET ";
$query .= "showYN='".$show."'";
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