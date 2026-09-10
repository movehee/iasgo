<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$_COOKIE['code']."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " photo_order='".$_POST['photo_order']."'";
	$query .= ", photo_type='".$_POST['photo_type']."'";
	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO session_set_tbl SET ";
	$query .= " photo_order='".$_POST['photo_order']."'";
	$query .= ", photo_type='".$_POST['photo_type']."'";

	$query .= "code='".$code."'";
	
}
mysqli_query($conn, $query);
?>
<script>
	opener.location.reload();
	window.close();
</script>