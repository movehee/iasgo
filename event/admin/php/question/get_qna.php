<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM question_tbl where code='".$code."'";
if($room){
	$query .= " and room='".$room."'";
}
$query .= " and del='N' and view='Y' and question_tbl.show='Y'";
$result = mysqli_query($conn, $query);


$d = mysqli_fetch_array($result);


if($d['question']){
	echo nl2br($d['question']);
}else{
	if (empty($mobile)){
		echo "<h2 class='centerTit'>Q &amp; A</h2>";
	}else{
		echo "Q & A";
	}
}

?>
