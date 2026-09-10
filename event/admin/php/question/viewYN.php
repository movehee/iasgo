<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
exit;
$query = "update question_tbl SET ";
$query .= "question_tbl.view='N'";
$query .= " where code='".$code."'";

if($room){
	$query .= " and room='".$room."'";
}

$conn->query($query);

if($view=="Y") {
	$view="N";
}else {
	$view="Y";
}



$query = "update question_tbl SET ";
$query .= "question_tbl.view='".$view."'";
$query .= " where sid=".$sid;
mysqli_query($conn, $query);
?>

<script>
	opener.location.reload();
	window.close();
</script>