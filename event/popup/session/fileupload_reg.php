<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";
	include $_SERVER['DOCUMENT_ROOT'] . "func/func.thumb.php";

	
	/*$max_num = $conn->getOne("select max(sort_num) from e_poster_file where psid='$poster_sid' and sort_num is not null or sort_num!=''");
	
	if(!$max_num){
		$max_num = 1;
	}else{
		$max_num = $max_num+1;
	}


	$query = "select * from e_poster_file where sort_num is null or sort_num='' order by sid asc";
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
		
		$thumbfile = $_SERVER['DOCUMENT_ROOT'] . "/upload/e_poster/thumb/" . $d['filename'];
		
		thumbnail($_SERVER['DOCUMENT_ROOT'].'upload/e_poster/'. $d['filename'],$thumbfile, 500);
		
		$query2 = "update e_poster_file set sort_num='$max_num' where sid='".$d['sid']."'";
		
		$result2 = $conn->query($query2);
		if(DB::isError($result2)) {
			die($result2->getMessage());
		}		

		$max_num++;
	}*/
	$conn->disconnect();
	PutMessageCloseOpenerReload("등록되었습니다.");
?>