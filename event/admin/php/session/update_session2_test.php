<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$query = "delete from session_faculty_tbl_test where session_sid=".$sid." and gubun='".$info."' and code='".$code."'";
$conn->query($query);


$pattern = ", ";
$val_list = split($pattern, urldecode($val));

$err_list = array();
$new_list = array();

for($i=0;$i< sizeof($val_list);$i++){

	$find = false;
	$result = mysqli_query($conn, "select sid, name from faculty_tbl where code='".$code."' and name='".$val_list[$i]."'");
	if($result->num_rows == '1') {
		$find = true;

	} else {
		$result = mysqli_query($conn, "select sid, name from faculty_tbl where code='".$code."' and name_en='".$val_list[$i]."'");
		if($result->num_rows == '1') {
			$find = true;
		} else {
			$err_list[] = $val_list[$i];
		}
	}

	if($find) {
		$row = mysqli_fetch_array($result);

		$query = "INSERT INTO session_faculty_tbl_test SET ";
		$query .= "code='".$code."'";
		$query .= ", session_sid='".$sid."'";
		$query .= ", faculty_sid='".$row['sid']."'";
		$query .= ", gubun='".$info."'";
		$conn->query($query);
		

		$new_list[] = $row['name'];
	}

}

echo json_encode(array('new_list' => implode(", ", $new_list), 'err_list' => implode(", ", $err_list))); exit;
?>
