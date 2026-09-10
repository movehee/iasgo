<?
header('Content-Type: text/html; charset=UTF-8');

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";
$file_path = $DOCUMENT_ROOT."voting/upload/photo/";


$img = base64_decode($_REQUEST['img']);
$signdate = time();
$file = $file_path.$deviceid.$signdate.".png";
$success = file_put_contents($file, $img);

$query = "insert into photo_tbl (code,tab,url,signdate, idx, deviceid, title) values ('".$code."','-1', '".$deviceid.$signdate.".png', '".time()."','1','".$deviceid."', '".addslashes($title)."')";
$result = $conn->query($query);


$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
$query .= " and a.del='N'";
$query .= " and a.tab='-1' group by a.sid";
$query .= $orderby;
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result)){
	$json[]=array(
		'sid'=>$row['sid'],
		'cnt'=>$row['cnt'],
		'title'=>$row['title'],
		'url'=>$row['url'],
		'deviceid'=>$row['deviceid']
		
	);
}
echo json_encode($json);
?>
