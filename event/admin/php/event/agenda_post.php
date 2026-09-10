<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/agenda/";

if($_FILES['image']['name'])
{
	$uploadfile = time().basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image = '".$uploadfile."'";
}
$eventdates = explode("-",$eventdate);
if(!empty($sid))
{
	$query = "update agenda_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",day='".$_POST['day']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",eventdate='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{
	$query = "INSERT INTO agenda_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",day='".$_POST['day']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",eventdate='".mktime(0, 0, 0, $eventdates[1], $eventdates[2], $eventdates[0])."'";
	$query .= $file_query;
}

$conn->query($query);
echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>