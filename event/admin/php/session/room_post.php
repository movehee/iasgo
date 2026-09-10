<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/room/";

if($_FILES['photo']['name'])
{


	$needle = strrpos(basename($_FILES['photo']['name']), ".") + 1;
	$slice = substr(basename($_FILES['photo']['name']), $needle);
	$uploadfile = time().$_POST['code']."1.".$slice;
	move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",photo = '".$uploadfile."'";
}
$eventdates = explode("-",$eventdate);
if(!empty($sid))
{
	$query = "update session_room_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",add_room='".$_POST['add_room']."'";
	$query .= ",add_cnt='".$_POST['add_cnt']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",view_type='".$_POST['view_type']."'";

	
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from session_room_tbl where code='".$code."' and tab='".$_POST['tab']."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO session_room_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",tab='".$_POST['tab']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",add_room='".$_POST['add_room']."'";
	$query .= ",add_cnt='".$_POST['add_cnt']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",view_type='".$_POST['view_type']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= $file_query;
}

$conn->query($query);
echo $query;
?>
<script>
	opener.location.reload();
	window.close();
</script>