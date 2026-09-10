<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$result = mysqli_query($conn, "SELECT * FROM voting_tbl where lecture='".$sid."' and del='N'");
while($row = mysqli_fetch_array($result)){

    $query = "update voting_tbl SET ";
    $query .= " voting_tbl.status='0'";
    $query .= " where sid='".$row['sid']."'";

    mysqli_query($conn, $query);

    $query = "delete from voting_result_tbl ";
    $query .= " where voting_sid='".$row['sid']."'";

    mysqli_query($conn, $query);
}




?>
