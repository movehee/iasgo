<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	procAdminLoginChk();

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);


	foreach($daychk as $tkey=>$tval){
		
		$date = date("Y-m-d", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($tval-1), $ex_sdate[0]));

		$time_max_count=count($_TIME['session'][$tval]);
		
		$query = "insert into checkin_tbl set day='$tval'";
		$query .= ", usid='".$usid."'";
		
		for($i=1;$i<=$time_max_count;$i++){
			$input_sdate = $date." ".${"stimes".$tval."_".$i};
			$input_edate = $date." ".${"etimes".$tval."_".$i};
			if($input_sdate){
				$query .= ", s".$i."_sdate='".strtotime($input_sdate)."'";
			}
			if($input_edate){
				$query .= ", s".$i."_edate='".strtotime($input_edate)."'";
			}
		}
		$result = $conn->query($query);
		if(DB::isError($result)) {
			die($result->getMessage());
		}
		
		
	}
	$conn->disconnect();
	OpenerReload_location("저장되었습니다","search.php");
	//PutMessageCloseOpenerReload("저장되었습니다.");
?>