<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM question_tbl where code='".$code."'";

if($room){
	$query .= " and room='".$room."'";
}

$query .= " and del='N' and question_tbl.show='Y'";


$result = mysqli_query($conn, $query);




while($row = mysqli_fetch_array($result)){
    $json[] = $row;
}
echo json_encode($json);

?>