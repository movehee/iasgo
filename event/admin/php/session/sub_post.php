<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
//include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/session/";

if($_FILES['lecture_file']['name'])
{
	$needle = strrpos(basename($_FILES['lecture_file']['name']), ".") + 1;
	$slice = substr(basename($_FILES['lecture_file']['name']), $needle);
	$uploadfile = time().$_POST['code']."1.".$slice;
	$up_result = move_uploaded_file($_FILES['lecture_file']['tmp_name'], $uploaddir.$uploadfile);
	/*
	if(!$up_result) {

		print_r($_FILES);
		echo "<br><Br>";
		echo "upload fail<br>";
		echo $_FILES['lecture_file']['tmp_name'].", ".$uploaddir.$uploadfile;
		exit;
	}*/
	$file_query .=",lecture_file = '".$uploadfile."'";
}

if($_FILES['abstract_file']['name'])
{
	$needle = strrpos(basename($_FILES['abstract_file']['name']), ".") + 1;
	$slice = substr(basename($_FILES['abstract_file']['name']), $needle);
	$uploadfile = time().$_POST['code']."2.".$slice;
	move_uploaded_file($_FILES['abstract_file']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",abstract_file = '".$uploadfile."'";
}

if($_FILES['cv_file']['name'])
{
	$needle = strrpos(basename($_FILES['cv_file']['name']), ".") + 1;
	$slice = substr(basename($_FILES['cv_file']['name']), $needle);
	$uploadfile = time().$_POST['code']."3.".$slice;
	move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",cv_file = '".$uploadfile."'";
}


if(!empty($sid))
{
	$query = "update session_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",link_session='".$_POST['link_session']."'";
	$query .= ",type='2'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",title='".addslashes($_POST['title'])."'";
	$query .= ",speaker='".$_POST['speaker']."'";
	$query .= ",abs_sid='".$_POST['abs_sid']."'";
	$query .= ",abs_no='".$_POST['abs_no']."'";
	$query .= ",abs_info='".$_POST['abs_info']."'";
	$query .= ",purpose='".$_POST['purpose']."'";
	$query .= ",methods='".$_POST['methods']."'";
	$query .= ",results='".$_POST['results']."'";
	$query .= ",conclusions='".$_POST['conclusions']."'";
	$query .= ",keywords='".$_POST['keywords']."'";
	$query .= ",sub_session='".$_POST['sub_session']."'";

	
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{

	$result = mysqli_query($conn, "select max(orderby) max from session_tbl where code='".$code."' and link_session='".$_POST['link_session']."'");
	$row = mysqli_fetch_array($result);
	
	$maxs = $row['max'];



	$query = "INSERT INTO session_tbl SET ";

	$query .= "code='".$_POST['code']."'";
	$query .= ",link_session='".$_POST['link_session']."'";
	$query .= ",type='2'";
	$query .= ",title='".addslashes($_POST['title'])."'";
	$query .= ",time='".$_POST['time']."'";
	$query .= ",speaker='".$_POST['speaker']."'";
	$query .= ",abs_sid='".$_POST['abs_sid']."'";
	$query .= ",abs_no='".$_POST['abs_no']."'";
	$query .= ",abs_info='".$_POST['abs_info']."'";
	$query .= ",purpose='".$_POST['purpose']."'";
	$query .= ",methods='".$_POST['methods']."'";
	$query .= ",results='".$_POST['results']."'";
	$query .= ",conclusions='".$_POST['conclusions']."'";
	$query .= ",keywords='".$_POST['keywords']."'";
	$query .= ",sub_session='".$_POST['sub_session']."'";
	$query .= ",orderby='".($maxs+1)."'";
	$query .= $file_query;
}

$result = $conn->query($query);
if(!$result) {
	echo $query;
	exit;
}
?>
<script>
	opener.location.reload();
	window.close();
</script>
