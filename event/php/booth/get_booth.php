<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM booth_tbl where sid ='".$sid."'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

if($row['linkurl']) {
	if(stristr($row['linkurl'], 'http')) {
		$link_url = $row['linkurl'];
	} else {
		$link_url = "http://".$row['linkurl'];
	}
} else {
	$link_url = "";
}

$json=array(
	'name'=>$row['name'],
	'name_en'=>$row['name_en'],
	'booth_num'=>$row['booth_num'],
	'booth_type'=>$row['booth_type'],
	'linkurl'=>$link_url,
	'image'=>$row['image'],
	'content'=>$row['content'],
	'info_pdf'=>$row['info_pdf'],
	'info_image'=>$row['info_image']
);
echo json_encode($json);


?>
