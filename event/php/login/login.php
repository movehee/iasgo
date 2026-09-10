<?
// made by JinGu
include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$query =  "insert into login_tbl ( code , name , office , deviceID , type , signdate) values ( '$code'  , '$name' , '$office' , '$deviceid' , '$type' , '".time()."' ) ";
$result = mysqli_query($conn , $query);

if ( $result  ) {
	echo "Y";	
} else {
	echo "N";
}


/*
$query = "SELECT * FROM login_tbl where code='".$code."'";
$query .= "and name='".$name."'";
$query .= "and office='".$office."'";

$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
    $json[] = $row;
}

if (count($json) == 0) {
  echo "N";
}else{
  $query = "UPDATE login_tbl SET deviceID='".$deviceid."', signdate='".time()."' , type = '".$type."' where code='".$code."'";
  $query .= "and name='".$name."'";
  $query .= "and office='".$office."'";
  mysqli_query($conn, $query);

  echo "Y";
}
*/

?>
