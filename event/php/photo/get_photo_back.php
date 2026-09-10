<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";



$cnt_query="SELECT count(*) cnt FROM photo_tbl where code='".$code."' and tab='".$tab."' and del='N'";
$cnt_result = mysqli_query($conn, $cnt_query);
$cnt_d = mysqli_fetch_array($cnt_result);

$cnt = ($cnt_d['cnt'] - ($cnt_d['cnt'] % 5)) / 5;

$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
$query .= " and a.del='N'";
$query .= " and a.tab='".$tab."' group by a.sid order by cnt desc, a.signdate desc, a.idx asc limit ".$cnt;


$result = mysqli_query($conn, $query);


$query2 = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
$query2 .= " and a.del='N'";
$query2 .= " and a.tab='".$tab."' group by a.sid order by cnt desc, a.signdate desc, a.idx asc limit  3,1000";

//echo $query2;

$result2 = mysqli_query($conn, $query2);

$cnt=0;
while($row2 = mysqli_fetch_array($result2)){

	if($cnt==0){
		$row = mysqli_fetch_array($result);
		$json[]=array(
			'sid'=>$row['sid'],
			'cnt'=>$row['cnt'],
			'url'=>$row['url']
		);
	}
	if($cnt==6){
		$row = mysqli_fetch_array($result);
		$json[]=array(
			'sid'=>$row['sid'],
			'cnt'=>$row['cnt'],
			'url'=>$row['url']
		);
	}
	$cnt++;
	if($cnt==8){
		$cnt=0;
	}

	$json[]=array(
		'sid'=>$row2['sid'],
		'cnt'=>$row2['cnt'],
		'url'=>$row2['url']
	);


}
	/*
	if($row['cnt']>0){
		$json[]=array(
			'size'=>'b',
			'sid'=>$row['sid'],
			'cnt'=>$row['cnt'],
			'url'=>$row['url']
		);
	}else {
		$temp[]=array(
			'size'=>'s',
			'sid'=>$row['sid'],
			'cnt'=>$row['cnt'],
			'url'=>$row['url']
		);
		$cnt++;
		if($cnt==4){
			
			$json [] = $temp[0];
			$json [] = $temp[1];
			$json [] = $temp[2];
			$json [] = $temp[3];
			$cnt=0;
			$temp=null;
		}
	}
}
if($cnt>0){
	$json [] = $temp[0];
}
if($cnt>1){
	$json [] = $temp[1];
}
if($cnt>2){
	$json [] = $temp[2];
}

*/
echo json_encode($json);

?>
