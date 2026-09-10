<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/faculty/";

$query="SELECT * FROM session_set_tbl where code='".$_COOKIE['code']."'";
$result = mysqli_query($conn, $query);
$s = mysqli_fetch_array($result);


if($_FILES['photo']['name'])
{
	$needle = strrpos(basename($_FILES['photo']['name']), ".") + 1;
	$slice = substr(basename($_FILES['photo']['name']), $needle);
	$uploadfile = time().$_POST['code']."1.".$slice;

	move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",photo = '".$uploadfile."'";
}
if($s['cv_file']=="Y"){
	if($_FILES['cv_file']['name'])
	{
		$needle = strrpos(basename($_FILES['cv_file']['name']), ".") + 1;
		$slice = substr(basename($_FILES['cv_file']['name']), $needle);
		$uploadfile = time().$_POST['code']."2.".$slice;

		move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploaddir.$uploadfile);
		$file_query .=",cv_file = '".$uploadfile."'";
	}
}
if(!empty($sid))
{
	$query = "update faculty_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",name_en='".$_POST['name_en']."'";
	$query .= ",office='".$_POST['office']."'";
	$query .= ",office_en='".$_POST['office_en']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",invitedYN='".$_POST['invitedYN']."'";
	$query .= ",country='".$_POST['country']."'";
	$query .= ",role='".$_POST['role']."'";
	$query .= ",group_gubun='".$_POST['group_gubun']."'";
	$query .= ",group_gubun_order='".$_POST['group_gubun_order']."'";
	$query .= ",group_code='".$_POST['group_code']."'";
	$query .= ",foreigner='".$_POST['foreigner']."'";
	if($s['cv_file']=="N"){
		$query .= ",cv_file='".$_POST['cv_file']."'";
	}
	$query .= $file_query;
	$query .= " where sid=".$sid;
}
else
{
	$query = "INSERT INTO faculty_tbl SET ";
	$query .= "code='".$_POST['code']."'";
	$query .= ",name='".$_POST['name']."'";
	$query .= ",name_en='".$_POST['name_en']."'";
	$query .= ",office='".$_POST['office']."'";
	$query .= ",office_en='".$_POST['office_en']."'";
	$query .= ",viewYN='".$_POST['viewYN']."'";
	$query .= ",country='".$_POST['country']."'";
	$query .= ",role='".$_POST['role']."'";
	$query .= ",group_gubun='".$_POST['group_gubun']."'";
	$query .= ",group_gubun_order='".$_POST['group_gubun_order']."'";
	$query .= ",group_code='".$_POST['group_code']."'";
	$query .= ",invitedYN='".$_POST['invitedYN']."'";
	$query .= ",foreigner='".$_POST['foreigner']."'";
	if($s['cv_file']=="N"){
		$query .= ",cv_file='".$_POST['cv_file']."'";
	}
	$query .= $file_query;
	//echo $query;
}

$result = $conn->query($query);

if(!$result) {
	echo "<script>alert('동명이인 등의 이유로 등록되지 않았습니다.');history.go(-1)</script>";
	exit;
}
?>
<script>
	opener.location.reload();
	window.close();
</script>