<?
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, must-revalidate");

	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	
	if($_SERVER['REMOTE_ADDR']=='218.235.94.225' && $mode == "test"){
		$day=5;
		$room=9;
		//$_Time['ing'] = strtotime("2021-04-24 09:35");
	}

	if(!$room){
		exit;
	}
	
	foreach($_TIME['session'][$day][$room] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		$ind[$tkey] = $tval[2];
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		
		if($_Time['ing']<=strtotime($tval[1])){
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			$ind_chk = $tval[2];
			$delay_time = $tval[3];
			$N_session = $tval[4];
			break;
		}else{
			if($tkey=='C') continue;
			$befor_session = $tkey;
			$before_edate = $_TIME['session'][$day][$room][$tkey][1];
			$befor_ind = $_TIME['session'][$day][$room][$tkey][2];
			$delay_time = $_TIME['session'][$day][$room][$tkey][3];
			$befor_N_session = $_TIME['session'][$day][$room][$tkey][4];
		}
	}
	if(!$session){ //세션이 없는경우 마지막 세션을 가져옴
		$session = end(array_keys($_TIME['session'][$day][$room]));
	}
	//echo '<span style="color:#ffffff">['.$session.']</span>';
	//echo '<span style="color:#ffffff">['.$session.'//'.$ind_chk.'//'.$befor_ind.']</span>';

	/*if($day=='1'){
		if($room=='6' && strtotime("2021-10-14 13:00:00")<$_Time['ing'] && strtotime("2021-10-14 14:15:00")>$_Time['ing']){
			$ind_chk="Y";

		}else if($room=='6' && strtotime("2021-10-14 14:15:00")<$_Time['ing'] && strtotime("2021-10-14 14:30:00")>$_Time['ing']){
			$ind_echk = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and s".$session."_edate>'".strtotime("2021-10-14 14:15:00")."' and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			
			if($ind_echk==0){
				$befor_ind="Y";
				$delay_time=270;
				$befor_session=2;
			}
		}
	}else if($day=='2'){
		if($room=='6' && strtotime("2021-10-15 16:20:00")<$_Time['ing'] && strtotime("2021-10-15 17:30:00")>$_Time['ing']){
			$ind_chk="Y";

		}else if($room=='6' && strtotime("2021-10-15 17:30:00")<$_Time['ing'] && strtotime("2021-10-15 17:40:00")>$_Time['ing']){
			$ind_echk = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and s".$session."_edate>'".strtotime("2021-10-15 17:30:00")."' and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			
			if($ind_echk==0){
				$befor_ind="Y";
				$delay_time=165;
				$befor_session=3;
			}
		}
	}*/
	

	//echo '<span style="color:#ffffff">['.$ind_chk.']</span>';
	
	if($session){
		
		if(($ind_chk=='Y' || $befor_ind=='Y')){ // && $_COOKIE['wmember_exam']=='Y'
			
			if($ind_chk=='Y'){
				$chking = $conn->getOne("select count(*) from checkin_tbl_ind where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			}else{
				$chking = $conn->getOne("select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
			}
			if($session!='1'){ //첫 세션이 아닐경우에만
				
				$hold_time = strtotime($before_edate."+ ".$delay_time." minutes"); //현재 시작세션으로부터 +5분
				//echo date("Y.m.d H:i:s",$hold_time);
				//echo '<span style="color:#ffffff">['.date("Y.m.d H:i",$hold_time).']</span>';
				if($hold_time>=$_Time['ing']){
					if($befor_ind=='Y'){
						//echo '<span style="color:#ffffff">['.$befor_ind.']</span>';
						$pre_query = "select count(*) from checkin_tbl_ind where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
						$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and s".$befor_session."_edate<'".$before_edate."' and day='$day'";
						$pre_chk = $conn->getOne($pre_query);
					}else{
						$pre_query = "select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
						$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
						$pre_chk = $conn->getOne($pre_query);
					}

				}

				//echo '<span style="color:#ffffff">['.$pre_chk.']</span>';
				
				if($pre_chk>0){ //이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작으면 기준이 되는 세션을 이전세션으로 변경
					$session = $befor_session;
					$_Time['ing'] = $before_edate;
					$ind_chk=$befor_ind;
				}
			}
			
			//echo '<span style="color:#ffffff">['.$session.']</span>';

		}else{

			
			if($session=='N' || $session=='N2'){
			
			}else{

				$chking = $conn->getOne("select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");

				if($session!='1'){ //첫 세션이 아닐경우에만
					
					$hold_time = strtotime($before_edate."+ ".$delay_time." minutes"); //현재 시작세션으로부터 +5분
					if($hold_time>=$_Time['ing']){
						
						$pre_query = "select count(*) from checkin_tbl".$_COOKIE['Gkey']." where s".$befor_session."_sdate>0 and (s".$befor_session."_edate='' or s".$befor_session."_edate is null or s".$befor_session."_edate<'".strtotime($before_edate)."')";
						$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
						$pre_chk = $conn->getOne($pre_query);
					}
					if($pre_chk>0){ //이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작으면 기준이 되는 세션을 이전세션으로 변경
						$session = $befor_session;
						$N_session = $befor_N_session;
						$ind_chk=$_TIME['session'][$day][$room][($session-1)][2];
						$_Time['ing'] = $before_edate;
					}
				}
			}

		}
		
	}

	$conn->disconnect();
	if($N_session!='Y'){
		$session=$N_session;
	}
	
	if($ind_chk=='Y' || $befor_ind=='Y'){
		$btn_txt = "필수세션 ";
	}else{
		// $btn_txt = "세션 ".$session." ";
		$btn_txt = "";
	}


	if( $day=="5" && $room == "9" && ($ind_chk=='Y' || $befor_ind=='Y') && $_Time['ing'] < strtotime("2022-09-24 13:55:00") ) { //전세션 기록없이 필수 세션만 들어왔을경우 대비
		if($chking || $pre_chk>0) {

		} else {
			$session = "B";
		}
	}
	
	//echo '<span style="color:#ffffff">['.$session.'||||'.$chking.'||||pre_chk='.$pre_chk.'||||ind_chk='.$ind_chk.']</span>';
?>
<?if($session){?>
	<?if($session=='N' || $session=='N2'){?>
		<a href="javascript:session_none()" class="in" types="checkin">No Session</a>
	<?}else if($session=='B'){?>
		<a href="javascript:break_time()" class="in" types="checkin">Break</a>
	<?}else{?>
		<?if($chking || $pre_chk>0){?>
			<?if($befor_session==$session){?>
				<!--<a href="javascript:session_checkin()"  class="log inout_txt" types="checkin"><b class="flicker" style="color:yellow ;font-weight:normal;"><?=$btn_txt ? $btn_txt :"퇴장시간 "?>기록</b></a>퇴장하기-->
				<a href="javascript:session_checkin()"  class="log inout_txt" types="checkin"><b class="flicker" style="color:yellow ;font-weight:normal;"><?=$btn_txt?>퇴장시간 기록</b></a><!--퇴장하기-->
			<?}else{?>
				<!--<a href="javascript:session_checkin()"  class="out inout_txt" types="checkin"><?=$btn_txt ? $btn_txt :"체류시간 "?>기록</a>퇴장하기-->
				<a href="javascript:session_checkin()"  class="out inout_txt" types="checkin"><?=$btn_txt?>체류시간 기록</a><!--퇴장하기-->
			<?}?>
		<?}else{?>
			<!--<a href="javascript:session_checkin()" class="in inout_txt" types="checkin"><b class="flicker" style="color:yellow;font-weight:normal;"><?=$btn_txt ? $btn_txt :"입장시간 "?>기록</b></a>입장하기-->
			<a href="javascript:session_checkin()" class="in inout_txt" types="checkin"><b class="flicker" style="color:yellow;font-weight:normal;"><?=$btn_txt?>입장시간 기록</b></a><!--입장하기-->
		<?}?>
	<?}?>
<?}else{?>
	<!-- <a href="#" onclick="javascript:session_close('<?=$room?>')" class="in inout_txt reExit" types="checkin"><b class="flicker" style="color:#F4B084;font-weight:normal;"><?if($befor_ind=='Y'){?>필수<?}?>세션 종료</b></a> -->
	<!-- <a href="javascript:session_checkin()"  class="out inout_txt" types="checkin"><b class="flicker" style="color:yellow;font-weight:normal;"><?=$btn_txt?>퇴장하기</b></a> -->

	<!-- <a href="javascript:session_checkin()"  class="out inout_txt" types="checkin"><b class="flicker" style="color:yellow;font-weight:normal;"><?=$btn_txt?>세션종료</b></a> -->
	<a href="javascript:session_close('<?=$room?>')"  class="out inout_txt" types="checkin"><b class="flicker" style="color:yellow;font-weight:normal;"><?=$btn_txt?>퇴장하기</b></a>
<?}?>
