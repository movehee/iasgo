<?
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL,'ko_KR.UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/banner/";

if($_FILES['image']['name'])
{
	$uploadfile = time()."1".basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image = '".$uploadfile."'";
}
if($_FILES['image2']['name'])
{
	$uploadfile = time()."2".basename($_FILES['image2']['name']);
	move_uploaded_file($_FILES['image2']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image2 = '".$uploadfile."'";
}
if($_FILES['image3']['name'])
{
	$uploadfile = time()."3".basename($_FILES['image3']['name']);
	move_uploaded_file($_FILES['image3']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",image3 = '".$uploadfile."'";
}

$sdates = explode("-",$sdate);

if($edate != ""){
	$edates = explode("-", $edate);
}else{
	//$edates = explode("-", "2100-12-31");

	$edates[1] = "12";
	$edates[2] = "31";
	$edates[0] = "2030";
}
if(!empty($sid))
{
	$query = "update banner_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",linkurl='".$_POST['linkurl']."'";
	$query .= ",gubun='".$_POST['gubun']."'";
	
	$query .= ",sdate='".mktime(0, 0, 0, $sdates[1], $sdates[2], $sdates[0])."'";
	$query .= ",edate='".mktime(23, 59, 59, $edates[1], $edates[2], $edates[0])."'";
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from banner_tbl where code='".$code."' and del='N'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO banner_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",linkurl='".$_POST['linkurl']."'";
	$query .= ",gubun='".$_POST['gubun']."'";
	$query .= ",sdate='".mktime(0, 0, 0, $sdates[1], $sdates[2], $sdates[0])."'";
	$query .= ",edate='".mktime(23, 59, 59, $edates[1], $edates[2], $edates[0])."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= $file_query;
}

$conn->query($query);
//echo $query;
?>

<script>
	opener.location.reload();
	window.close();
</script>