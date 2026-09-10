<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();

	$program_day = "1";
	
	$query = "select * from checkin_tbl where day='$program_day' and usid='949' order by first_date asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
	
		echo date("Y.m.d H:i:s",$d['first_date']),'===='.date("Y.m.d H:i:s",$d['last_date']).'<br>';


		$set_query = "";
		foreach($_TIME['session'][$program_day] as $tkey=>$tval){
			$start_date[$tkey] = $tval[0];
			$end_date[$tkey] = $tval[1];
			$ind[$tkey] = $tval[2];

			if($d['first_date']<=strtotime($end_date[$tkey]) && $d['last_date']>=strtotime($start_date[$tkey])){
				echo "Session:".$tkey."====";
				echo $start_date[$tkey]."==".$end_date[$tkey]."<br>";
				
				if($d['s'.$tkey.'_sdate']==""){ //입장시간이 없으면 최초 강의실 입장시간으로 넣어줌.
					if($d['first_date']>=$start_date[$tkey]){ //최초 입장이 세션의 시작시간보다 크면 최종시간으로 현세션의 시작시작을 업데이트
						$set_query .= ", s".$tkey."_sdate='".$d['first_date']."'";
					}else{
						$set_query .= ", s".$tkey."_sdate=unix_timestamp('".$start_date[$tkey]."')";
					}
				}else{
					if($d['s'.$tkey.'_sdate']>$start_date[$tkey]){ 
						$set_query .= ", s".$tkey."_sdate=unix_timestamp('".$start_date[$tkey]."')";
					}
				}

				if($d['s'.$tkey.'_edate']==""){ //퇴장시간이 없을 때
					if($d['last_date']>$start_date[$tkey]){ //최종 퇴장시간이 세션의 시작시간보다 크면
						$set_query .= ", s".$tkey."_edate=unix_timestamp('".$end_date[$tkey]."')";
					}else{
						$set_query .= ", s".$tkey."_edate=unix_timestamp('".$end_date[$tkey]."')";
					}
				}else{
					if($d['last_date']>$d['s'.$tkey.'_edate']){
						if($d['s'.$tkey.'_edate']<strtotime($end_date[$tkey])){
							$set_query .= ", s".$tkey."_edate=unix_timestamp('".$end_date[$tkey]."')";
						}
					}
				}

			}

			/*if($_Time['ing']<=strtotime($tval[1])){
				$session = $tkey;
				$start_time = $tval[0];
				$end_time = $tval[1];
				$ind_chk = $tval[2];
				break;
			}else{
				if($tkey=='C') continue;
				$befor_session = $tkey;
				$before_edate = $_TIME['session'][$day][$room][$tkey][1];
				$befor_ind = $_TIME['session'][$day][$room][$tkey][2];
			}*/
		}

		

		$query2 = "update checkin_tbl set chking='N', modify='N'";
		$query2 .= $set_query;
		$query2 .= " where sid='$d[sid]' and day='$program_day'";
		$result2 = $conn->query($query2);
		/*if(DB::isError($result2)) {
			die($result2->getMessage());
		}*/
		echo $query2."<br><br>";
	}
?>