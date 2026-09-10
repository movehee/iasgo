<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if( !$_POST ){ die; }

if( $status == "Y" ){ //전부 종료한번해준다.
	$query = "update session_tbl set feedback_yn='N' where code='".$code."' and type='1'";
	$result = mysqli_query($conn, $query);
}

$query = "update session_tbl set feedback_yn='".$status."' where sid='".$sid."' and code='".$code."'";
$result = mysqli_query($conn, $query);

?>