<?php 
##특정데이터 삭제
header("Content-Type: text/html; charset=UTF-8");
include $_SERVER['DOCUMENT_ROOT']."func/include.connect.php";

$return = true;
$msg = '';
$row = array();

if(is_file($_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php")) include $_SERVER['DOCUMENT_ROOT'] . "api_comment/config.php";
else{
	$return = false;
	$msg = "COMMENT 설정파일이 없습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}
include $DOCUMENT_ROOT . "api_comment/YY.php";


if(empty($_POST['this_sid'])){
	##수정시 sid는 필수
	$return = false;
	$msg = "필수 sid가 없습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}

$query = "delete from comment_tbl where sid='".$_POST['this_sid']."' or csid='".$_POST['this_sid']."'";
$result = $conn->query($query);
if(DB::isError($result)) {
   die($result->getMessage());
}


echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
exit;