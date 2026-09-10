<?	
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$ex_result =  explode("✚",$result);

	
	for($i=1;$i<count($ex_result);$i++){
		$ex_name = explode("|::|",$ex_result[$i]);

			
		for($n=1;$n<count($ex_name);$n++){
			$field_val = $ex_name[$n];
			$val = addslashes(trim(str_replace('\"',"",$field_val)));
			$content = "<p>".str_replace("||","</p><p>",$val)."</p>";
			$query = "insert into workshop_schedule_tbl set code='$code', bsid='$chk_date', tr='$i', td='$n', content='$content'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
	}

	$conn->disconnect();
	PutMessageCloseOpenerReload("생성 되었습니다.");
?>