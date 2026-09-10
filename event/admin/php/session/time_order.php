<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include $DOCUMENT_ROOT . 'func/include.function.php';



$query = "update session_time_tbl SET orderby='-1' where code='".$code."' and del='N' and tab='".$tab."' and orderby=".$val1;
$conn->query($query);
echo $query;
$query = "update session_time_tbl SET orderby='".$val1."' where code='".$code."' and tab='".$tab."' and del='N' and orderby=".$val2;
$conn->query($query);
echo $query;
$query = "update session_time_tbl SET orderby='".$val2."' where code='".$code."' and tab='".$tab."' and del='N' and orderby='-1'";
$conn->query($query);
echo $query;
?>


<script>
	opener.location.reload();
	window.close();
</script>

