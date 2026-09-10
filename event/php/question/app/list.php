<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM question_tbl where code='".$code."' and del='N' and `show`='Y'";

if(!empty($room)) {
  $query .= "and room='".$room."'";
}
$query .= " order by signdate desc";


$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){

    $questions[] = array(
      'sid' => $row['sid'],
      'question' => $row['question'],
      'name' => $row['name'],
      'office' => $row['office'],
      'email' => $row['email'],
      'license' => $row['license'],
      'room' => $row['room'],
      'lecture' => $row['lecture_name'],
      'deviceid' => $row['deviceid'],
      'signdate' => $row['signdate'],
      'session' => $row['session'],
      'view' => $row['view'],
      'sub' => $row['sub']
    );

}

echo json_encode($questions);

?>
