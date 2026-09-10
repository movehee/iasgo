<?
include_once $_SERVER['DOCUMENT_ROOT'].'/func/include.function.php';
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config.php";
$sql = "select * from booth_tbl where  code='".$code."' and password='".$password."' and id='".$id."' and del='N' and tab in ('1','2')  ";

$result = mysqli_query($conn, $sql);


$row = mysqli_fetch_array($result);
if($row){
	$json=array(
		'sid'=>$row['sid'],
		'name'=>$row['name'],
		'image'=>$row['image']
	);
	echo json_encode($json);
}else{
	echo "N";
}

//echo $row['cnt'];
?>