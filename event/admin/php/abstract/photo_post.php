<?
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$file_path=$DOCUMENT_ROOT."/upload/abstract/thumbnail/"; 

$query = "insert into abstract_file_tbl set code='".$_REQUEST['code']."', signdate='".$_REQUEST['signdate']."', abstract_sid='".$_REQUEST['abstract_sid']."',  idx='".$_REQUEST['file_idx']."', file='".$_REQUEST['code']."_".$_REQUEST['abstract_sid']."_".$_REQUEST['signdate']."_".$_REQUEST['file_idx'].".png'";


$base_to_php = explode(',', $_REQUEST['zipfile']);
$img = base64_decode($base_to_php[1]);


$file = $file_path.$_REQUEST['code']."_".$_REQUEST['abstract_sid']."_".$_REQUEST['signdate']."_".$_REQUEST['file_idx'].".png";
$success = file_put_contents($file, $img);

$conn->query($query);

?>
