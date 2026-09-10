<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/faculty/";

if($_FILES['image']['name'])
{
	$uploadfile = time().basename($_FILES['image']['name']);
	move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$uploadfile);
	$file_query .=",faculty_def_image = '".$uploadfile."'";
}


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$_COOKIE['code']."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];

if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " faculty_favor='".$_POST['faculty_favor']."'";
	$query .= ", faculty_photo='".$_POST['faculty_photo']."'";
	$query .= ", faculty_txt_type='".$_POST['faculty_txt_type']."'";
	$query .= ", faculty_view_type='".$_POST['faculty_view_type']."'";
	$query .= ", faculty_txt_type_list_eng='".$_POST['faculty_txt_type_list_eng']."'";
	$query .= ", faculty_txt_type_view_eng='".$_POST['faculty_txt_type_view_eng']."'";
	$query .= ", faculty_txt_type_list_kor='".$_POST['faculty_txt_type_list_kor']."'";
	$query .= ", faculty_txt_type_view_kor='".$_POST['faculty_txt_type_view_kor']."'";
	$query .= ", faculty_session_type='".$_POST['faculty_session_type']."'";
	$query .= ", faculty_orderby='".$_POST['faculty_orderby']."'";

	
	$query .= ", faculty='".$_POST['faculty']."'";
	$query .= $file_query;
	$query .= " where code='".$code."'";
}
else
{
	$query = "INSERT INTO session_set_tbl SET ";
	
	$query .= " faculty_favor='".$_POST['faculty_favor']."'";
	$query .= ", faculty_photo='".$_POST['faculty_photo']."'";
	$query .= ", faculty_txt_type='".$_POST['faculty_txt_type']."'";
	$query .= ", faculty_view_type='".$_POST['faculty_view_type']."'";
	$query .= ", faculty_txt_type_list_eng='".$_POST['faculty_txt_type_list_eng']."'";
	$query .= ", faculty_txt_type_view_eng='".$_POST['faculty_txt_type_view_eng']."'";
	$query .= ", faculty_txt_type_list_kor='".$_POST['faculty_txt_type_list_kor']."'";
	$query .= ", faculty_txt_type_view_kor='".$_POST['faculty_txt_type_view_kor']."'";
	$query .= ", faculty_session_type='".$_POST['faculty_session_type']."'";
	$query .= ", faculty='".$_POST['faculty']."'";
	$query .= ", faculty_orderby='".$_POST['faculty_orderby']."'";
	$query .= $file_query;
	$query .= "code='".$code."'";
	
}
mysqli_query($conn, $query);
?>
<script>
	opener.location.reload();
	window.close();
</script>