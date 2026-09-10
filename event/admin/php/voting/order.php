<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include $DOCUMENT_ROOT . 'func/include.function.php';



$query = "update voting_tbl SET orderby='-1' where lecture='".$lecture."' and del='N' and orderby=".$val1;
$conn->query($query);

$query = "update voting_tbl SET orderby='".$val1."' where lecture='".$lecture."' and del='N' and orderby=".$val2;
$conn->query($query);

$query = "update voting_tbl SET orderby='".$val2."' where lecture='".$lecture."' and del='N' and orderby='-1'";
$conn->query($query);

?>


<script>
	opener.location.reload();
	window.close();
</script>