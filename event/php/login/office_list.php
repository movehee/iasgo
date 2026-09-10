<?
// made by JinGu
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT DISTINCT office FROM login_tbl where code='".$code."'";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
    $json[] = $row['office'];
}

echo json_encode($json);

?>
