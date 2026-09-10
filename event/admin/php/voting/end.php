<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query="update voting_tbl set status='2' where sid='".$sid."' and code='".$code."'";

mysqli_query($conn, $query);

$query = "select (select count(*) from voting_result_tbl where val='1' and voting_sid='".$sid."') val1, (select count(*) from voting_result_tbl where val='2' and voting_sid='".$sid."') val2, (select count(*) from voting_result_tbl where val='3' and voting_sid='".$sid."') val3, (select count(*) from voting_result_tbl where val='4' and voting_sid='".$sid."') val4, (select count(*) from voting_result_tbl where val='5' and voting_sid='".$sid."') val5, (select count(*) from voting_result_tbl where val='6' and voting_sid='".$sid."') val6";

$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);

echo $col['val1']."||".$col['val2']."||".$col['val3']."||".$col['val4']."||".$col['val5']."||".$col['val6'];

?>

