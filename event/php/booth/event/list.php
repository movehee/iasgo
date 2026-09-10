<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

//http://ezv.kr/php/booth/event/list.php?code=kingca2019&booth_sid=1

$query = "SELECT * FROM booth_event_tbl where code='".$code."'";
$query .= " and booth_sid='".$booth_sid."'";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
   $json[] = $row;
}
echo json_encode($json);
?>

<!-- 잠시 보류 -->
