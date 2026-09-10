<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select orderby,code from regist_type_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

$query = "update regist_type_tbl SET del='Y' where sid=".$sid;
mysqli_query($conn, $query);

$query = "update regist_type_tbl SET orderby=orderby-1 where code='".$row['code']."' and orderby>".$row['orderby'];
mysqli_query($conn, $query);


?>


<script>
	opener.location.reload();
	window.close();
</script>