<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include $DOCUMENT_ROOT . 'func/include.function.php';

$cnt = $conn->getOne("select count(*) from css_tbl where code='".$_COOKIE['code']."'");

				

if($cnt>0)
{
	$query = "update css_tbl SET ";
	$query .= "feedback_bg_bold='".$_POST['feedback_bg_bold']."'";
	$query .= ", feedback_font_bold='".$_POST['feedback_font_bold']."'";
	$query .= ", feedback_bg='".$_POST['feedback_bg']."'";
	$query .= ", feedback_font='".$_POST['feedback_font']."'";
	$query .= ", feedback_btn='".$_POST['feedback_btn']."'";
	$query .= ", feedback_btn_font='".$_POST['feedback_btn_font']."'";
	$query .= ", feedback_font2='".$_POST['feedback_font2']."'";
	$query .= " where code='".$_COOKIE['code']."'";
}
else
{

	$query = "INSERT INTO css_tbl SET ";
	$query .= "code='".$_COOKIE['code']."'";
	$query .= ", feedback_bg_bold='".$_POST['feedback_bg_bold']."'";
	$query .= ", feedback_font_bold='".$_POST['feedback_font_bold']."'";
	$query .= ", feedback_bg='".$_POST['feedback_bg']."'";
	$query .= ", feedback_font='".$_POST['feedback_font']."'";
	$query .= ", feedback_btn='".$_POST['feedback_btn']."'";
	$query .= ", feedback_btn_font='".$_POST['feedback_btn_font']."'";
	$query .= ", feedback_font2='".$_POST['feedback_font2']."'";
}
echo $query;
$conn->query($query);
?>

<script>
	opener.location.reload();
	window.close();
</script>