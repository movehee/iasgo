<?

include_once $_SERVER['DOCUMENT_ROOT']."/connect.php";
include_once $_SERVER['DOCUMENT_ROOT']."/func/include.function.php";


$setting_query="SELECT * FROM session_set_tbl where code='".$code."'";
$setting_result = mysqli_query($conn, $setting_query);
$setting_col = mysqli_fetch_array($setting_result);


if($setting_col['photo_order']=="2"){
	$orderby = " order by cnt desc, a.signdate desc, a.idx asc ";
}else if($setting_col['photo_order']=="1"){
	$orderby = " order by a.signdate desc, a.idx asc ";
}



//if($setting_col['photo_type']=="1"){

	$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	if($tab){
		$query .= " and a.tab='".$tab."'";
	}
	$query .= " and a.del='N'";
	$query .= " group by a.sid";
	$query .= $orderby;
	$result = mysqli_query($conn, $query);



	$query2 = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid and b.deviceid='".$deviceid."' where a.code='".$code."'";
	if($tab){
		$query2 .= " and a.tab='".$tab."'";
	}
	$query2 .= " and a.del='N' ";
	$query2 .= " group by a.sid";
	$query2 .= $orderby;
	//echo $query2;
	$result2 = mysqli_query($conn, $query2);


	while($row = mysqli_fetch_array($result)){
		$row2 = mysqli_fetch_array($result2);
		$json[]=array(
			'sid'=>$row['sid'],
			'cnt'=>$row['cnt'],
			'title'=>$row['title'],
			'url'=>$row['url'],
			'myfav'=>$row2['cnt'],
			'deviceid'=>$row['deviceid']
			
		);
	}

/*
}else if($setting_col['photo_type']=="2"){

	$cnt_query="SELECT count(*) cnt FROM photo_tbl where code='".$code."' and tab='".$tab."' and del='N'";
	$cnt_result = mysqli_query($conn, $cnt_query);
	$cnt_d = mysqli_fetch_array($cnt_result);

	$cnt = ($cnt_d['cnt'] - ($cnt_d['cnt'] % 5)) / 5;
	if(($cnt_d['cnt'] % 10) > 0 && ($cnt_d['cnt'] % 10) < 5){
		$cnt++;
	}

	$query = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	$query .= " and a.del='N'";
	$query .= " and a.tab='".$tab."' group by a.sid ";
	$query .= $orderby;
	$query .= " limit ".$cnt;
	//echo $query;

	$result = mysqli_query($conn, $query);


	$query2 = "SELECT count(b.sid) cnt, a.* FROM photo_tbl a left join photo_favor_tbl b on a.sid=b.photo_sid where a.code='".$code."'";
	$query2 .= " and a.del='N'";
	$query2 .= " and a.tab='".$tab."' group by a.sid ";
	$query2 .= $orderby;
	$query2 .= " limit  ".$cnt.",".$cnt_d['cnt'];

	//echo $query2;

	$result2 = mysqli_query($conn, $query2);

	$cnt=0;
	while($row2 = mysqli_fetch_array($result2)){

		if($cnt==0){
			$row = mysqli_fetch_array($result);
			if($row){
			$json[]=array(
				'size'=>'B',
				'sid'=>$row['sid'],
				'cnt'=>$row['cnt'],
				'url'=>$row['url']
			);
			}
		}
		if($cnt==6){
			$row = mysqli_fetch_array($result);
			if($row){
			$json[]=array(
				'size'=>'B',
				'sid'=>$row['sid'],
				'cnt'=>$row['cnt'],
				'url'=>$row['url']
			);
			}
		}
		$cnt++;
		if($cnt==8){
			$cnt=0;
		}

		$json[]=array(
			'size'=>'S',
			'sid'=>$row2['sid'],
			'cnt'=>$row2['cnt'],
			'url'=>$row2['url']
		);
	}
}
*/

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
