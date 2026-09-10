<?
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";

if ($device_id) {
	$deviceid = $device_id;
}

$query="SELECT * FROM token_tbl where deviceid='".$deviceid."' and code='".$code."'";
$result = mysqli_query($conn, $query);
$col = mysqli_fetch_array($result);

// echo $deviceid;

if($col)
{
	$query = "update token_tbl set token = '".$token."', device='".$device."'";

	if($code == "korl2019") {
		$query .= ", name='1'";
	}

	if($name){
		$query .= ", name='".$name."'";
	}

	if($office){
		$query .= ", office='".$office."'";
	}
	
	if ($regType) {
		$query .= ", reg_type='".$regType."'";
	}

	$query .= " where deviceid='".$deviceid."' and code='".$code."'";
	$result = mysqli_query($conn, $query);
	// echo $col['sid'];

	if($code == "icksh2020") {
		echo $col['sid'];
	}if($code == "kses2020s") {
		echo $col['sid'];
	}if($code == "icorl2020") {
		echo $col['sid'];
	}else{
	  echo $deviceid;
	}



} else {
	$query = "insert into token_tbl (token,device,deviceid,name,office,signdate,code,pushcode,reg_type) VALUES ('".$token."','".$device."','".$deviceid."','".$name."','".$office."','".time()."','".$code."','".$pushCode."','".$regType."')";
	$result = mysqli_query($conn, $query);

	$query="SELECT * FROM token_tbl where deviceid='".$deviceid."' and code='".$code."'";
	$result = mysqli_query($conn, $query);
	$col = mysqli_fetch_array($result);
	// echo $col['sid'];

	if($code == "icksh2020") {
		echo $col['sid'];
	}if($code == "kses2020s") {
		echo $col['sid'];
	}if($code == "icorl2020") {
		echo $col['sid'];
	}else{
		echo $deviceid;
	}

}
?>
