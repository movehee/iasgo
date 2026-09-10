<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "select money from regist_money_tbl ";
$query .= " where code='".$code."' ";
$query .= " and type0='".$type0."' ";
if($type1){
	$query .= " and type1='".$type1."' ";
}else{
	$query .= " and type1='0' ";
}

if($type2){
	$query .= " and type2='".$type2."' ";
}else{
	$query .= " and type2='0' ";
}

if($type3){
	$query .= " and type3='".$type3."' ";
}else{
	$query .= " and type3='0' ";
}

$result = mysqli_query($conn, $query);
$d = mysqli_fetch_array($result);
echo $d['money'];

?>