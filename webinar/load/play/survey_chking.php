<?
include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
$session_key = $conn->getOne("select session_key from session_survey_activation");
$conn->disconnect();
if($session_key){
echo json_encode(array('session_key'=>$session_key));
}else{
echo json_encode(array('session_key'=>'N'));
}
exit;
?>