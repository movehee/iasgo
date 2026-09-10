<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$chking = $conn->getOne("select count(*) from registration_tbl where id like '%$keyword%'");
	if($chking==0){
		echo json_encode(array('result'=>'N'));
		exit;
	}else if($chking==1){
	
		$query = "select * from registration_tbl where id like '%$keyword%'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		echo json_encode(array('result'=>'Y','sid'=>$d['sid']));
		exit;
	}else if($chking>1){
		

		$query = "select * from registration_tbl where id like '%$keyword%'";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());
		
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$user_sid[] = $d['sid'];
		}
		echo json_encode(array('result'=>'S','sid'=>implode(",",$user_sid)));
		exit;
	}
?>