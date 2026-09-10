<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


if(!empty($sid))
{
	$query = "update lecture_tbl SET ";
	$query .= "name='".$_POST['name']."'";
	$query .= " where sid=".$sid;
}
else
{
	$query = "INSERT INTO lecture_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",signdate='".time()."'";
}

mysqli_query($conn, $query);

?>

<script>
	opener.location.reload();
	window.close();
</script>