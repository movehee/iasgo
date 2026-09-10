<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query = "update question_tbl SET ";
$query .= " view='N'";
$query .= " where code='".$code."'";

if($room){
	$query .= " and room='".$room."'";
}

mysqli_query($conn, $query);


$query = "update question_tbl SET ";
$query .= " view='Y'";
$query .= " , answer_ok='Y'";
$query .= " where sid='".$sid."'";

mysqli_query($conn, $query);

?>
