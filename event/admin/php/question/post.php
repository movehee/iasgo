<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(!empty($sid))
{
	$query = "update question_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ",signdate='".time()."'";
	$query .= ",question='".$_POST['question']."'";

	$query .= " where sid=".$sid;
}
else
{
	$query = "INSERT INTO question_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ",signdate='".time()."'";
	$query .= ",question='".$_POST['question']."'";
}

mysqli_query($conn, $query);

?>

<script>
	opener.location.reload();
	window.close();
</script>