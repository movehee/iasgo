<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select orderby,code from regist_set_tbl where sid=".$sid);
$row = mysqli_fetch_array($result);

$query = "update regist_set_tbl SET del='Y' where sid=".$sid;
mysqli_query($conn, $query);


for($i=$row['orderby'];$i<=40;$i++){
	$query = "update regist_tbl SET info".$i."=info".($i+1)." where code='".$row['code']."'";
	mysqli_query($conn, $query);
}



$query = "update regist_set_tbl SET orderby=orderby-1 where code='".$row['code']."' and orderby>".$row['orderby'];
mysqli_query($conn, $query);





?>


<script>
	opener.location.reload();
	window.close();
</script>