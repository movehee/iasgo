<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$query = "select * from workshop_session_detail_tbl where sid in ($sort_val) order by field(sid,$sort_val)";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	$n=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	
		$query2 = "update workshop_session_detail_tbl set sort_num='$n' where sid='$d[sid]'";
		$result2 = $conn->query($query2);
		if(DB::isError($result2)) {
			die($result2->getMessage());
		}
	$n++;
	}

	echo "Y";
?>