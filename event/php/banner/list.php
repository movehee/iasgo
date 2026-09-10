<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";

$query = "SELECT * FROM banner_tbl where code='".$code."' and sdate<".time()." and edate>".time();
if($gubun){
	$query .= " and gubun='".$gubun."'";
}
$query .= " and del='N' and showYN='Y' order by orderby";


$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_array($result)){
   $json[]=array(
		'sid'=>$row['sid'],
		'gubun'=>$row['gubun'],
		'image'=>"/upload/banner/".$row['image'],
		'image2'=>"/upload/banner/".$row['image2'],
	    'image3'=>"/upload/banner/".$row['image3'],
		'linkurl'=>$row['linkurl']
	);
}
echo json_encode($json);
?>
