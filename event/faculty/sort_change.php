<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($kind=='faculty'){
		$query = "select * from faculty_tbl where sid in ($sort_val) order by field(sid,$sort_val)";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		
		$snum = 1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
			$query2 = "update faculty_tbl set sort_num='$snum' where sid='".$d['sid']."'";
			$result2 = $conn->query($query2);
			if(DB::isError($result2)) {
				die($result2->getMessage());
			}
		
			$snum++;
		}
	}else if($kind=='award'){
		$query = "select * from faculty_tbl where sid in ($sort_val) order by field(sid,$sort_val)";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		
		$snum = 1;
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
			$query2 = "update faculty_tbl set award_sort_num='$snum' where sid='".$d['sid']."'";
			$result2 = $conn->query($query2);
			if(DB::isError($result2)) {
				die($result2->getMessage());
			}
		
			$snum++;
		}	
	}
	echo "Y";
	$conn->disconnect();
?>