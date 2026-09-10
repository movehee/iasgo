<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$query = "delete from session_faculty_tbl where session_sid=".$sid." and gubun='".$info."'  and code='".$code."'";
$conn->query($query);


$pattern = ", ";
$val_list = split($pattern, urldecode($val));
for($i=0;$i< sizeof($val_list);$i++){
	$result = mysqli_query($conn, "select sid from faculty_tbl where code='".$code."' and name='".$val_list[$i]."'");
	$row = mysqli_fetch_array($result);
	if($row['sid']){
		$query = "INSERT INTO session_faculty_tbl SET ";
		$query .= "code='".$code."'";
		$query .= ", session_sid='".$sid."'";
		$query .= ", faculty_sid='".$row['sid']."'";
		$query .= ", gubun='".$info."'";
		$conn->query($query);
	}else {
		if($val_list[$i]){
			echo $val_list[$i]." ";
		}
	}
}
?>
