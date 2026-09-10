<?
	include $_SERVER['DOCUMENT_ROOT']."/lib.php";

	$orderby = $conn->getOne("select max(orderby) from voting_tbl where code='$code' and lecture='$lecture' and del='N' and room='$room'");
	if(!$orderby){
		$order = 1;
	}else{
		$order = $orderby+1;
	}
	
	$question = "선택해주세요";
	$answer1 = "1번";
	$answer2 = "2번";
	$answer3 = "3번";
	$answer4 = "4번";
	$answer5 = "5번";


	$query = "insert into voting_tbl set question='$question'";
	$query .= " ,answer1='".$answer1."'";
	$query .= " ,answer2='".$answer2."'";
	$query .= " ,answer3='".$answer3."'";
	$query .= " ,answer4='".$answer4."'";
	$query .= " ,answer5='".$answer5."'";
	$query .= " ,code='".$code."'";
	$query .= " ,lecture='".$lecture."'";
	$query .= " ,delay='5'";
	$query .= " ,room='$room'";
	$query .= " ,correct='0'";
	$query .= " ,orderby='$order'";
	$query .= " ,signdate='".time()."'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}
	$conn->disconnect();
	echo "Y";
?>