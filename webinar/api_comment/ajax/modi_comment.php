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

#임시 입력데이터
$content_arr = array(
	'content'		=> (!empty($_POST['content'])?$_POST['content']:''),
	'signdate'		=> '',
	'modifydate'	=> time(),
	'op1'			=> (!empty($_POST['cop1'])?$_POST['cop1']:''),
	'op2'			=> (!empty($_POST['cop2'])?$_POST['cop2']:''),
	'op3'			=> (!empty($_POST['cop3'])?$_POST['cop3']:'')
);

$query = "update comment_tbl set content='".(!empty($_POST['content'])?$_POST['content']:'')."',
								 modifydate='".time()."',
								 op1='".(!empty($_POST['cop1'])?$_POST['cop1']:'')."',
								 op2='".(!empty($_POST['cop2'])?$_POST['cop2']:'')."',
								 op3='".(!empty($_POST['cop3'])?$_POST['cop3']:'')."' where sid='".$_POST['this_sid']."'";
									  
									  
									  
$result = $conn->query($query);
if(DB::isError($result)) {
   die($result->getMessage());
}

##부적절한 단어가 포홤되어있는지확인.
$Fresult = fuck_match($words, $content_arr['content']); 
if(!empty($Fresult)){##욕을쓸경우 욕쓰지 말라고 메세지띄움
	$return = false;
	$msg = "내용에 부적절한 단어가 포함되어있습니다.";
	echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
	exit;
}

echo json_encode(array('_return' => $return, 'msg' => $msg, 'row'=>$row)); 
exit;