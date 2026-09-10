<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM booth_event_tbl where code='".$code."'";
$query .= " and user_sid='".$user_sid."'";
$query .= " and booth_sid='".$booth_sid."'";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
   $json[] = $row;
}

if (count($json) == 0){
  //없으면 등록
  $query = "INSERT INTO booth_event_tbl SET signdate='".time()."'";
  $query .= ", code='".$code."'";
  $query .= ", user_sid='".$user_sid."'";
  $query .= ", booth_sid='".$booth_sid."'";

}else{
  // 이미 있으면 업데이트 (signData)
  $query = "UPDATE booth_event_tbl SET signdate='".time()."' where code='".$code."'";
  $query .= " and user_sid='".$user_sid."'";
  $query .= " and booth_sid='".$booth_sid."'";

}
mysqli_query($conn, $query);

echo "Y";
?>



<!-- 잠시 보류 -->
