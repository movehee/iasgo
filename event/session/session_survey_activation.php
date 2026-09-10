<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	if($chk=='Y'){
		$record_chk = $conn->getOne("select count(*) from session_survey_activation");
		if($record_chk>0){
			$query = "update session_survey_activation set session_key='$mykey'";
		}else{
			$query = "insert into session_survey_activation set session_key='$mykey'";
		}
		
	}else if($chk=='N'){
		$query = "update session_survey_activation set session_key=''";
	}
	$result = $conn->query($query);
	if(DB::isError($result)) {
		die($result->getMessage());
	}

	echo "Y";
?>