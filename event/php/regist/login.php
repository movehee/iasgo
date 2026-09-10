<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$sql = "select count(*) cnt from event_tbl where code='".$code."' and password='".$password."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if($row['cnt']>=1){
  echo "Y";
}else{
  echo "N";
}

?>
