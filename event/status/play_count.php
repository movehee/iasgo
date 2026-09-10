<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	

	$query = "select count(*) ";
	
	foreach($_CONFIG['room'] as $tkey=>$tval){
		$query .= ", sum(case when room='$tkey' and country='K' then 1 else 0 end) RK_cnt".$tkey;	
		$query .= ", sum(case when room='$tkey' and country='F' then 1 else 0 end) RF_cnt".$tkey;	
	}
	$query .= " from registration_tbl where del='N' and member_level!='M' and classification not in ('M','Y')";
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();

	echo json_encode(array(
		'room1_Kcnt'=>$cnt['RK_cnt1'],
		'room2_Kcnt'=>$cnt['RK_cnt2'],
		'room3_Kcnt'=>$cnt['RK_cnt3'],
		'room4_Kcnt'=>$cnt['RK_cnt4'],
		'room5_Kcnt'=>$cnt['RK_cnt5'],
		'room6_Kcnt'=>$cnt['RK_cnt6'],
		'room7_Kcnt'=>$cnt['RK_cnt7'],
		'room8_Kcnt'=>$cnt['RK_cnt8'],
		'room1_Fcnt'=>$cnt['RF_cnt1'],
		'room2_Fcnt'=>$cnt['RF_cnt2'],
		'room3_Fcnt'=>$cnt['RF_cnt3'],
		'room4_Fcnt'=>$cnt['RF_cnt4'],
		'room5_Fcnt'=>$cnt['RF_cnt5'],
		'room6_Fcnt'=>$cnt['RF_cnt6'],
		'room7_Fcnt'=>$cnt['RF_cnt7'],
		'room8_Fcnt'=>$cnt['RF_cnt8']
	));

	$conn->disconnect();
	exit;
?>