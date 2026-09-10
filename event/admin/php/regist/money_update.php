<?
header('Content-Type: text/html; charset=utf-8');
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$result = mysqli_query($conn, "select count(*) cnt from regist_money_tbl where code='".$code."' and type0='".$type0."' and type1='".$type1."' and type2='".$type2."' and type3='".$type3."'");
$row = mysqli_fetch_array($result);

$cnt = $row['cnt'];

if($cnt>0)
{
	$query = "update regist_money_tbl SET ";
	$query .= " money='".$_POST['val']."'";
	$query .= " where code='".$code."' and type0='".$type0."' and type1='".$type1."' and type2='".$type2."' and type3='".$type3."'";
	$conn->query($query);
}else{
	$query = "INSERT INTO regist_money_tbl SET ";
	$query .= "code='".$code."'";
	$query .= ", type0='".$_POST['type0']."'";
	$query .= ", type1='".$_POST['type1']."'";
	$query .= ", type2='".$_POST['type2']."'";
	$query .= ", type3='".$_POST['type3']."'";
	$query .= ", money='".$_POST['val']."'";
	$conn->query($query);
}
echo $query;
?>
