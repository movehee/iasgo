<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

for($i=0;$i<$value;$i++){

	$result = mysqli_query($conn, "select max(orderby) max from abstract_tbl where code='".$code."'");
	$row = mysqli_fetch_array($result);

	$maxs = $row['max'];



	$query = "INSERT INTO abstract_tbl SET ";

	$query .= "code='".$code."'";
	$query .= ",orderby='".($maxs+1)."'";


	$conn->query($query);
}
?>
