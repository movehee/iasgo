<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$ev_date = isset($ev_date) ? (int)$ev_date : 1;
	if ($ev_date < 1 || !isset($_TIME['session'][$ev_date])) {
		PutMessageBack('잘못된 접근입니다.');
	}
	$time_max_count = count($_TIME['session'][$ev_date]);

	$search_kind = isset($search_kind) ? trim($search_kind) : '';
	if (!preg_match('/^[SO][0-9]+_time2?$/', $search_kind)) {
		PutMessageBack('잘못된 접근입니다.');
	}

	$update_kind = (isset($update_kind) && $update_kind == 'B') ? 'B' : 'A';

	$chksidSafe = array();
	if (isset($chksid) && is_array($chksid)) {
		foreach ($chksid as $oneSid) {
			$oneSid = (int)$oneSid;
			if ($oneSid > 0) {
				$chksidSafe[] = $oneSid;
			}
		}
	}
	if (count($chksidSafe) < 1) {
		PutMessageBack('선택하신 데이터가 없습니다.');
	}

	$session_field = array();
	for($s=1;$s<=$time_max_count;$s++){
		$session_field[] = "s".$s."_sdate, s".$s."_edate";
	}
	for($date=1;$date<=$date_count;$date++){
		$session_field[] = "logout_day".$date;
	}
	$add_field = ",usid,day,del,first_date,last_date,group_key,name_kr,license_number,id,aff_kor,email,classification,modify,member_level,chking";

	$fsql = "";
	for($s=1;$s<=$time_max_count;$s++){
		if($search_kind=='S'.$s.'_time'){
			$fsql = " where (s".$s."_sdate is null or s".$s."_sdate='' or s".$s."_sdate>'".strtotime($_TIME['session'][$ev_date][$s][0].':59')."')";
			$fsql .= " and day='$ev_date' and first_date<'".strtotime($_TIME['session'][$ev_date][$s][1])."' and (substr(from_unixtime(first_date),1,16)!=substr(from_unixtime(s".$s."_sdate),1,16) or s".$s."_sdate is null)";
		}
		if($search_kind=='S'.$s.'_time2'){
			$fsql = " where (s".$s."_sdate is null or s".$s."_sdate='' or s".$s."_sdate>'".strtotime($_TIME['session'][$ev_date][$s][0].':59')."') and s".$s."_edate>0";
			$fsql .= " and day='$ev_date' and first_date<'".strtotime($_TIME['session'][$ev_date][$s][1])."' and substr(from_unixtime(first_date),1,16)!=substr(from_unixtime(s".$s."_sdate),1,16)";
		}
		if($search_kind=='O'.$s.'_time'){
			$fsql = " where s".$s."_sdate>0 and (s".$s."_edate<'".strtotime($_TIME['session'][$ev_date][$s][1])."' or s".$s."_edate is null or s".$s."_edate='')";
			$fsql .= " and day='$ev_date' and first_date<'".strtotime($_TIME['session'][$ev_date][$s][1])."'";
		}
	}
	if ($fsql == "") {
		PutMessageBack('잘못된 접근입니다.');
	}
	$fsql .= " and usid in (".implode(",", $chksidSafe).")";

	$query = "select ".implode(",",$session_field). $add_field.",sid from (";
	$query .= "select ".implode(",",$session_field). $add_field.",t1.sid from checkin_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid AND t2.del='N'";
	$query .= ") A ".$fsql;
	$query .= "  order by day desc, first_date asc";

	$result=$conn->query($query);
	if(DB::isError($result)) {
		error_log('[TimeRechk] select failed: '.$result->getMessage());
		PutMessageBack('시스템 장애입니다.다시시도해주세요');
	}

	$n=0;
	$edit_sid_arr = array();
	$conn->autoCommit(false);

	while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {

		$chkinTbl = 'checkin_tbl';
		$detailTbl = 'checkin_detail_tbl';
		$rowUsid = (int)$d['usid'];
		$rowDay = (int)$d['day'];
		if ($rowUsid < 1 || $rowDay < 1) {
			continue;
		}

		$modifySdate = '';
		$modifyEdate = '';
		$updateCol = '';
		$newTs = 0;

		for($s=1;$s<=$time_max_count;$s++){
			if($search_kind=='S'.$s.'_time' || $search_kind=='S'.$s.'_time2'){
				$modifySdate = $_TIME['session'][$ev_date][$s][0];

				if($d['first_date']>strtotime($_TIME['session'][$ev_date][$s][0])){
					$modifySdate = date("Y-m-d H:i",$d['first_date']);
				}

				if($update_kind=='B'){
					$min_real_sql = "select min(min_t) from ((";
					$min_real_sql .= "select min(check_in) as min_t from checkin_detail_tbl_history where session_in='".(int)$s."' and day='".$rowDay."' and usid='".$rowUsid."'";
					$min_real_sql .= ") union  (";
					$min_real_sql .= "select min(check_in) as min_t from ".$detailTbl." where session_in='".(int)$s."' and day='".$rowDay."' and usid='".$rowUsid."'";
					$min_real_sql .= ")) A";
					$min_real_time = $conn->getOne($min_real_sql);
					if($min_real_time){
						$modifySdate = date("Y-m-d H:i",$min_real_time);
					}
				}

				$updateCol = 's'.$s.'_sdate';
				$newTs = (int)strtotime($modifySdate);
			}

			if($search_kind=='O'.$s.'_time'){
				$modifyEdate = $_TIME['session'][$ev_date][$s][1];

				if($update_kind=='B'){
					$max_real_sql = "select max(max_t) from ((";
					$max_real_sql .= "select max(check_in) as max_t from checkin_detail_tbl_history where session_in='".(int)$s."' and day='".$rowDay."' and usid='".$rowUsid."'";
					$max_real_sql .= ") union  (";
					$max_real_sql .= "select max(check_in) as max_t from ".$detailTbl." where session_in='".(int)$s."' and day='".$rowDay."' and usid='".$rowUsid."'";
					$max_real_sql .= ")) A";
					$max_real_time = $conn->getOne($max_real_sql);
					if($max_real_time){
						$modifyEdate = date("Y-m-d H:i",$max_real_time);
					}
				}

				$updateCol = 's'.$s.'_edate';
				$newTs = (int)strtotime($modifyEdate);
			}
		}

		if ($updateCol == '' || $newTs < 1) {
			continue;
		}

		if (strpos($updateCol, '_sdate') !== false) {
			$update_query = "UPDATE ".$chkinTbl." SET ".$updateCol." = IF(".$updateCol." > 0 AND ".$updateCol." < ?, ".$updateCol.", ?) WHERE day = ? AND usid = ?";
		} else {
			$update_query = "UPDATE ".$chkinTbl." SET ".$updateCol." = IF(".$updateCol." > ?, ".$updateCol.", ?) WHERE day = ? AND usid = ?";
		}

		$update_result = $conn->query($update_query, array($newTs, $newTs, $rowDay, $rowUsid));
		if(DB::isError($update_result)) {
			$conn->rollback();
			$conn->autoCommit(true);
			error_log('[TimeRechk] update failed: usid='.$rowUsid.' '.$update_result->getMessage());
			PutMessageBack('시스템 장애입니다.다시시도해주세요');
		}

		$edit_sid_arr[] = $rowUsid;
		$n++;
	}

	$conn->commit();
	$conn->autoCommit(true);
	$conn->disconnect();
?>
<form name="time_confirmF" id="time_confirmF" method="post" action="/time/">
	<input type="hidden" name="search_kind" value="<?=htmlspecialchars($search_kind, ENT_QUOTES, 'UTF-8')?>">
	<input type="hidden" name="ev_date" value="<?=(int)$ev_date?>">
	<input type="hidden" name="edit_complete" value="Y">
	<?foreach($edit_sid_arr as $tkey=>$tval){?>
	<input type="hidden" name="edit_sid[]" value="<?=(int)$tval?>">
	<?}?>
</form>
<script>
	alert("<?=(int)$n?>개가 업데이트되었습니다.");
	document.time_confirmF.submit();
</script>
