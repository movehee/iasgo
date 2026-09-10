<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include $DOCUMENT_ROOT . 'func/include.function.php';

$cnt = $conn->getOne("select count(*) from css_tbl where code='".$code."'");


if($cnt>0)
{
	$query = "update css_tbl SET ";
	$query .= "agenda_bg='".$_POST['agenda_bg']."'";
	$query .= ", agenda_bg_on='".$_POST['agenda_bg_on']."'";
	$query .= ", agenda_font='".$_POST['agenda_font']."'";
	$query .= ", agenda_font_on='".$_POST['agenda_font_on']."'";
	$query .= " where code='".$code."'";
}
else
{

	$query = "INSERT INTO css_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", agenda_bg='".$_POST['agenda_bg']."'";
	$query .= ", agenda_bg_on='".$_POST['agenda_bg_on']."'";
	$query .= ", agenda_font='".$_POST['agenda_font']."'";
	$query .= ", agenda_font_on='".$_POST['agenda_font_on']."'";
}

$conn->query($query);
?>

<script>
	opener.location.reload();
	window.close();
</script>