<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$result = mysqli_query($conn, "select sid from voting_tbl where code='".$code."' and status in ('1','3')");
$d = mysqli_fetch_array($result);


if($d){

$json = array(
	'sid'=>$d['sid'],
	'question'=>$d['question'],
	'answer1'=>$d['answer1'],
	'answer2'=>$d['answer2'],
	'answer3'=>$d['answer3'],
	'answer4'=>$d['answer4'],
	'answer5'=>$d['answer5'],
	'answer6'=>$d['answer6']);
echo json_encode($json);
}else{
	echo "N";
}
?>