<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM booth_tbl where code='".$code."'";
$query .= " and del='N' and add_booth_chk='1' order by orderby";


$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
   
   $image = "";
   if($row['image2']){
		$image = $row['image2'];
   }else{
		$image = $row['image'];
   }

	$json[]=array(
		'sid'=>$row['sid'],
		'linkurl'=>$row['linkurl'],
		'image'=>"http://ezv.kr/upload/booth/".$image
	);
}
echo json_encode($json);
?>