<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	
	
	foreach($_TIME['session'][$day] as $tkey=>$tval){
		$start_date[$tkey] = $tval[0];
		$end_date[$tkey] = $tval[1];
		//echo $tkey.'==='.$tval[0]."~".$tval[1]."<br>";
		if($_Time['ing']<=strtotime($tval[1])){
			$before_edate = $end_date[($tkey-1)];
			$session = $tkey;
			$start_time = $tval[0];
			$end_time = $tval[1];
			break;
		}
	}

	if($session){
		$chking = $conn->getOne("select count(*) from checkin_tbl where s".$session."_sdate>0 and usid='".$_COOKIE['wmember_sid']."' and day='$day'");
		if($session!='1'){ //첫 세션이 아닐경우에만
			
			$hold_time = strtotime($before_edate."+ 10 minutes"); //현재 시작세션으로부터 +5분

			if($hold_time>=$_Time['ing']){
				$session_pre = $session-1;
				$pre_query = "select count(*) from checkin_tbl where s".$session_pre."_sdate>0 and (s".$session_pre."_edate='' or s".$session_pre."_edate is null or s".$session_pre."_edate<'".strtotime($before_edate)."')";
				$pre_query .= " and usid='".$_COOKIE['wmember_sid']."' and day='$day'";
				$pre_chk = $conn->getOne($pre_query);
			}
			if($pre_chk>0){ //이전세션을 듣고있었던 내역이 존재하는데 종료시간이 없거나, 이전세션의 종료시간보다 작으면 기준이 되는 세션을 이전세션으로 변경
				$session = $session_pre;
				$_Time['ing'] = $before_edate;
			}
		}
	}
	$conn->disconnect();
?>
<?if($session){?>
	<?if($chking || $pre_chk>0){?>
		<?if($room=='6'){?>
			<a href="javascript:session_checkin()" class="in" types="checkin">필수평점 퇴장</a>
		<?}else{?>
			
			<?if($session_pre==$session){?>
				<a href="javascript:session_checkin()" class="in" types="checkin"><b class="flicker" style="color:red;">세션<?=$session?> 퇴장하기</b></a>
			<?}else{?>
				<a href="javascript:session_checkin()" class="in" types="checkin">세션<?=$session?> 퇴장하기</a>
			<?}?>
		<?}?>
	<?}else{?>
		<?if($room=='6'){?>
			<a href="javascript:session_checkin()" class="in" types="checkin">필수평점 입장</a>
		<?}else{?>
			<a href="javascript:session_checkin()" class="in" types="checkin">세션<?=$session?> 입장하기</a>
		<?}?>
	<?}?>
<?}else{?>
	<a href="#" onclick="javascript:session_close()" class="in" types="checkin">세션 종료</a>
<?}?>