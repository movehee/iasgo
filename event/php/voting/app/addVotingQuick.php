<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "select max(orderby) maxs from voting_tbl where lecture='".$lecture."' and room='$room' and del='N'");
$row = mysqli_fetch_array($result);

$max = $row['maxs'];

$query = "INSERT INTO voting_tbl SET ";
$query .= "lecture='".$lecture."'";
$query .= ",code='".$code."'";

$query .= ",question='선택해주세요'";
$query .= ",answer1='1번'";
$query .= ",answer2='2번'";
$query .= ",answer3='3번'";
$query .= ",answer4='4번'";
$query .= ",answer5='5번'";
// $query .= ",answer6='6번'";
$query .= ",correct=''";
$query .= ",delay='5'";
$query .= ",orderby='".($max+1)."'";
$query .= ",type='1'";
$query .= ",signdate='".time()."'";
$query .= ",ui='1'";
$query .= ",room='$room'";
mysqli_query($conn, $query);

echo "Y";

?>
