<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';


	$query = "select * from e_poster where category='104'";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$snum = 1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

		$in_query = "insert into e_poster_file set psid='$d[sid]'";
		$in_query .= ", filename='$d[e_poster_file]'";
		$in_query .= ", realfile='$d[e_poster_file]'";
		$in_query .= ", sort_num='1'";
		$in_result = $conn->query($in_query);
		if(DB::isError($in_result)) {
			die($in_result->getMessage());
		}
	
	}
?>