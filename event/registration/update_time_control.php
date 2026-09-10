<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$day="2";

	$time_max_count = 1;

	//$query = "select t1.*,t2.license_number,t2.name_kr,t2.sid as usid from $tbl_name as t1 inner join registration_tbl as t2 on t1.usid=t2.sid and t1.day='$day' and t1.chking!='Y' "; //and t1.chking!='Y' 

	for($s=1;$s<=4;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,chking,gubun1,reg_kind";

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	foreach($_CONFIG['Gkey'] as $tkey=>$tval){
	$query .= "union all ";
	$query .= "(select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl_".$tval." as t1 inner join registration_tbl as t2 on t1.usid=t2.sid) ";
	}
	$query .= ") A where chking!='Y' and day='$day' order by first_date asc"; //and reg_kind in ('K','L','M','R','U')
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
	
	$n=1;
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		/*unset($stay_hours);
		unset($stay_min);
		unset($score);
		unset($sum_score);
		unset($sum_times);
		unset($score_kaim);

		$show_user = "N";
		
		for($i=1;$i<=$time_max_count;$i++){ //세션갯수만큼
			${"mm".$i}=0;
			${"s".$i."_sdate"} = "";
			${"s".$i."_edate"} = "";

			//${"s".$i."_sdate"} = $d['s'.$i.'_sdate'];
			${"s".$i."_sdate"} = strtotime(date("Y-m-d H:i",$d['s'.$i.'_sdate']));
			
			${"s".$i."_edate"} = $d['s'.$i.'_edate'];
			
			if(strtotime($_TIME['session'][$d['day']][$i][0])<$d['s'.$i.'_sdate'] && $d['s'.$i.'_sdate']){
				if($d['first_date']<strtotime($_TIME['session'][$d['day']][$i][1])){
					$show_user="Y";
				}
			}
			if(strtotime($_TIME['session'][$d['day']][$i][1])>$d['s'.$i.'_edate'] && $d['s'.$i.'_edate']){
				//$show_user="Y";
			}
		}

		if($show_user=='Y'){
		
			echo $n."===".$d['usid']."==".$d['name_kr']."/-------/".date("Y.m.d H:i:s",$d['first_date'])."-----".date("Y.m.d H:i:s",$d['s1_sdate'])."<br>";
		
			$n++;
		}*/
		

		
		if($d['first_date']<strtotime("2021-04-24 12:15")){
			if($d['s1_sdate']>strtotime("2021-04-24 12:15")){
				//echo $n."===".$d['usid']."==".$d['name_kr']."/-------/".date("Y.m.d H:i:s",$d['first_date'])."-----".date("Y.m.d H:i:s",$d['s1_sdate'])."<br>";
				//$n++;
			}
		}

		if($d['first_date']<strtotime("2021-04-24 13:30")){
			if($d['s2_sdate']>strtotime("2021-04-24 13:30")){
				//echo $n."===".$d['group_key']."===".$d['usid']."==".$d['name_kr']."/-------/".date("Y.m.d H:i:s",$d['first_date'])."-----".date("Y.m.d H:i:s",$d['s2_sdate'])."<br>";
				$query2 = "update checkin_tbl_".$d['group_key']." set s2_sdate='".strtotime("2021-04-24 13:30")."' where usid='".$d['usid']."' and day='2'";
				/*$result2 = $conn->query($query2);
				if(DB::isError($result2)) {
					die($result2->getMessage());
				}
				echo $query2.'<br>';
				$n++;*/
			}
		}


		if($d['first_date']<strtotime("2021-04-24 15:30")){
			if($d['s3_sdate']>strtotime("2021-04-24 15:30")){
				//echo $n."===".$d['group_key']."===".$d['usid']."==".$d['name_kr']."/-------/".date("Y.m.d H:i:s",$d['first_date'])."-----".date("Y.m.d H:i:s",$d['s2_sdate'])."<br>";
				$query2 = "update checkin_tbl_".$d['group_key']." set s3_sdate='".strtotime("2021-04-24 15:30")."' where usid='".$d['usid']."' and day='2'";
				/*$result2 = $conn->query($query2);
				if(DB::isError($result2)) {
					die($result2->getMessage());
				}*/
				echo $query2.'<br>';
				$n++;
			}
		}

		
		
		
	}
	
	
?>