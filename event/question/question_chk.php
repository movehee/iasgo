<?
	include $_SERVER['DOCUMENT_ROOT']."lib.php";
	
	$qcnt = $conn->getOne("select count(*) from question_tbl where push='Y' and room='$room' and day='$day'");

	$query = "select * from question_tbl where push='Y' and room='$room' and day='$day' order by sid desc limit 0,1";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	if($qcnt==0){
		echo "Q&A";
	}else{
		echo nl2br($d['question']);
	}
?>
