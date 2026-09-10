<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query="SELECT * FROM session_set_tbl where code='".$code."'";
$result = mysqli_query($conn, $query);
$d = mysqli_fetch_array($result);
if(!$d){
	$d['question_view_YN']="Y";
}

if(!$d['question_view_YN']) $d['question_view_YN']="Y";

if($room=='12'){
	$code="allergy2019sc";
}else if($room=='13'){
	$code="allergy2019sb";
}else if($room=='14'){
	$code="allergy2019sa";
}else if($room=='17'){
	$code="allergy2019sa";
}

$query = "INSERT INTO question_tbl SET ";
$query .= "code='".$code."'";
$query .= ",name='".$name."'";
$query .= ",office='".$office."'";
$query .= ",room='".$room."'";
$query .= ",lecture='".addslashes($lecture)."'";
$query .= ",signdate='".time()."'";
if($id){
	$query .= ",deviceid='".$id."'";
}else{
	$query .= ",deviceid='".$deviceid."'";
}

$query .= ",question='".$question."'";
$query .= ",session='".$session."'";
$query .= ",sub='".$sub."'";

$query .= ",question_tbl.show='".$d['question_view_YN']."'";

//echo $query;exit;
mysqli_query($conn, $query);

if (empty($mobile)) {
?>
	<script>
		alert("저장되었습니다.");
		location.href="./view.php?code=<?=$code?>";
	</script>
<?
}else{
	echo "Y";
}
