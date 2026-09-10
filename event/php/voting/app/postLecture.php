<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if($sid){
		$query="update lecture_tbl set name='".$name."',room='".$room."', signdate='".Time()."' where sid='".$sid."'";
		$result = mysqli_query($conn, $query);
		echo "update";
}else{
	$query = "insert into lecture_tbl (code,name,signdate,del,room) VALUES ('".$code."','".$name."','".Time()."','N','".$room."')";
	$result = mysqli_query($conn, $query);
	echo "insert";
}


?>
