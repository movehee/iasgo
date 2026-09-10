<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

if(empty($sid)){
	$query="SELECT * FROM voting_tbl where code='".$code."' and status in ('1','3')";
}else{
	$query="SELECT * FROM voting_tbl where code='".$code."' and sid='".$sid."'";
}
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);

if(!empty($col)){
	$row = array(
		'answer1' => $col['answer1'],
		'answer2' => $col['answer2'],
		'sid' => $col['sid'],
		'code' => $col['code'],
		'lecture' => $col['lecture'],
		'question' => $col['question'],
		'status' => $col['status']
	 );

if ($col['answer3']) {
	$row['answer3'] = $col['answer3'];
}
if ($col['answer4']) {
	$row['answer4'] = $col['answer4'];
}
if ($col['answer5']) {
	$row['answer5'] = $col['answer5'];
}
if ($col['answer6']) {
	$row['answer6'] = $col['answer6'];
}
	echo json_encode($row);
}else{
	echo "N";
}




?>
