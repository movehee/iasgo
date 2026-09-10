<?
// made by JinGu
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query = "SELECT *  FROM event_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);


if ( $result->num_rows  > 0) {
	echo json_encode(array("success"=>"Y","msg"=>"로그인 성공"));
} else {
		echo json_encode(array("success"=>"N","msg"=>"유효하지 않은 코드입니다."));
}


?>
