<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$day="1";
	if(date("Y-m-d")=="2020-11-29"){
		$day="2";
	}
	$query = "select usid,count(*) as bcnt from booth_stamp where usid not in (177,181) group by usid having bcnt>=33";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$user_sid[] = $d['usid'];
	}
	
	if(count($user_sid)==0){
		exit;
	}

	$pick_time = time();

	$query = "select t1.* from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.usid in (".implode(",",$user_sid).") and t1.pick!='Y' and t2.event_chk='Y' and t1.day='$day' order by rand()";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	$pnum=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		
		unset($stay_hours);
		unset($stay_min);
		unset($score);
		unset($sum_score);
		unset($sum_times);
		for($i=1;$i<=4;$i++){ //세션갯수만큼
			${"mm".$i}=0;
			${"s".$i."_sdate"} = "";
			${"s".$i."_edate"} = "";

			${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
			${"s".$i."_edate"} = $d['s'.$i.'_edate'];
			if(strtotime($_TIME['session'][$d['day']][$i][0])>$d['s'.$i.'_sdate']){
				${"s".$i."_sdate"} = strtotime($_TIME['session'][$d['day']][$i][0]);
			}
			if(strtotime($_TIME['session'][$d['day']][$i][1])<$d['s'.$i.'_edate']){
				${"s".$i."_edate"} = strtotime($_TIME['session'][$d['day']][$i][1]);
			}
			if(${"s".$i."_sdate"}>0 && ${"s".$i."_edate"}>0 && ${"s".$i."_edate"}>strtotime($_TIME['session'][$d['day']][$i][0])){
				${"s".$i."_time"} = ${"s".$i."_edate"}-${"s".$i."_sdate"};
				${"mm".$i} = (${"s".$i."_time"}/60);
			}
			$sum_times += (${"mm".$i});
		}
		
		$sum_score = floor($sum_times);
		$stay_hours = floor($sum_score/60);
		if($stay_hours>=3){
			if($pnum>$count) continue;
			$update_query = "update checkin_tbl set pick='Y', pick_time='".$pick_time."'";
			$update_query .= " where sid='$d[sid]' and day='$day'";
			$update_result = $conn->query($update_query);
			if(DB::isError($update_result)) {
				die($update_result->getMessage());
			}
			$pick_sid[] = $d['usid'];
			$pnum++;
		}
	}
	
	if($pick_sid){
		$pick_arr = implode(",",$pick_sid);
	}
	
	if($pick_arr){
		$query = "select * from registration_tbl where sid in ($pick_arr)";
		$query .= " limit $count";
		$result=$conn->query($query);
		if(DB::isError($result)) die($result->getMessage());

		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$pick_name[] = $d['name_kr'];
			$pick_aff[] = $d['aff_kor'];
		}

		if($count=='1'){
			$data = array(
				array("name"=>$pick_name[0], "office"=>$pick_aff[0])
			);
		}else{
			$data = array(
				array("name"=>$pick_name[0], "office"=>$pick_aff[0]),
				array("name"=>$pick_name[1], "office"=>$pick_aff[1]),
				array("name"=>$pick_name[2], "office"=>$pick_aff[2]),
				array("name"=>$pick_name[3], "office"=>$pick_aff[3]),
				array("name"=>$pick_name[4], "office"=>$pick_aff[4]),
				array("name"=>$pick_name[5], "office"=>$pick_aff[5]),
				array("name"=>$pick_name[6], "office"=>$pick_aff[6]),
				array("name"=>$pick_name[7], "office"=>$pick_aff[7]),
				array("name"=>$pick_name[8], "office"=>$pick_aff[8]),
				array("name"=>$pick_name[9], "office"=>$pick_aff[9])
			);
		}
		echo json_encode($data);
	}

?>