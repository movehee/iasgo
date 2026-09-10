<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(substr($_POST['color'],0,1)!="#"){
	$_POST['color'] = "#".$_POST['color'];
}
if(substr($_POST['glance_color'],0,1)!="#"){
	$_POST['glance_color'] = "#".$_POST['glance_color'];
}



if(!empty($sid))
{
	$query = "update session_category_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",abb='".$_POST['abb']."'";
	$query .= ",info='".$_POST['info']."'";
	$query .= ",color='".$_POST['color']."'";
	$query .= ",glance_type='".$_POST['glance_type']."'";
	$query .= ",glance_color='".$_POST['glance_color']."'";
	$query .= ",select_category='".$_POST['select_category']."'";
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from session_category_tbl where code='".$code."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO session_category_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",abb='".$_POST['abb']."'";
	$query .= ",info='".$_POST['info']."'";
	$query .= ",color='".$_POST['color']."'";
	$query .= ",glance_type='".$_POST['glance_type']."'";
	$query .= ",glance_color='".$_POST['glance_color']."'";
	$query .= ",select_category='".$_POST['select_category']."'";
	$query .= ",orderby='".($maxs+1)."'";
}

$conn->query($query);
echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>
