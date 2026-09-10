<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(substr($_POST['color'],0,1)!="#"){
	$_POST['color'] = "#".$_POST['color'];
}

if(!empty($sid))
{
	$query = "update abstract_category_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",info='".$_POST['info']."'";
	$query .= ",color='".$_POST['color']."'";
	$query .= ",parent='".$_POST['parent']."'";
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from abstract_category_tbl where code='".$code."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO abstract_category_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",info='".$_POST['info']."'";
	$query .= ",color='".$_POST['color']."'";
	$query .= ",parent='".$_POST['parent']."'";
	$query .= ",orderby='".($maxs+1)."'";
}

$conn->query($query);
echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>
