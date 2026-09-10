<?
header('Content-Type: text/html; charset=UTF-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$file_path=$DOCUMENT_ROOT."/upload/photo/"; 

$query = "insert into photo_tbl set code='".$_REQUEST['code']."', tab='".$_REQUEST['tab']."', signdate='".$_REQUEST['signdate']."',  idx='".$_REQUEST['file_idx']."', url='".$_REQUEST['code']."_".$_REQUEST['signdate']."_".$_REQUEST['file_idx'].".png'";


$base_to_php = explode(',', $_REQUEST['zipfile']);
$img = base64_decode($base_to_php[1]);


$file = $file_path.$_REQUEST['code']."_".$_REQUEST['signdate']."_".$_REQUEST['file_idx'].".png";
$success = file_put_contents($file, $img);

$conn->query($query);

?>
