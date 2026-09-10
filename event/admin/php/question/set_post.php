<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select count(*) cnt from session_set_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);


$cnt = $row['cnt'];


if($cnt>0)
{
	$query = "update session_set_tbl SET ";

	$query .= " question_view_YN='".$_POST['question_view_YN']."'";
	$query .= ", question_lecture_view='".$_POST['question_lecture_view']."'";

	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO session_set_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", question_view_YN='".$_POST['question_view_YN']."'";
	$query .= ", question_lecture_view='".$_POST['question_lecture_view']."'";
	

}
mysqli_query($conn, $query);
?>
<script>
	opener.location.reload();
	window.close();
</script>