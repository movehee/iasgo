<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM booth_event_tbl where code='".$code."'";
$query .= " and booth_sid='".$sid."'";
//echo $query;
$result = mysqli_query($conn, $query);

$cnt=0;
while($row = mysqli_fetch_array($result)){
	if($cnt>0){
		echo ",";
	}
	echo "'".$row['user_sid']."'";
	$cnt++;
}
?>