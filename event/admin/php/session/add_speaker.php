<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



for($i=0;$i<$value;$i++){


	$result = mysqli_query($conn, "select max(orderby) max from session_tbl where type='2' and link_session='".$session."'");
	$row = mysqli_fetch_array($result);

	$maxs = $row['max'];



	$query = "INSERT INTO session_tbl SET ";

	$query .= "code='".$code."'";
	$query .= ",link_session='".$session."'";
	$query .= ",type='2'";
	$query .= ",orderby='".($maxs+1)."'";


	$conn->query($query);
}




?>
