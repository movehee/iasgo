<?
	include_once $_SERVER['DOCUMENT_ROOT']."lib.php";
	procAdminLoginChk();
	
	$query = "select count(*) ";
	$query .= " , sum(case when login_day".$chkday.">0 and country='K' then 1 else 0 end) as login_cnt_K";
	$query .= " , sum(case when login_day".$chkday.">0 and country='F' then 1 else 0 end) as login_cnt_F";
	foreach($_CONFIG['room'] as $tkey=>$tval){
		$query .= ", sum(case when room='$tkey' and country='K' then 1 else 0 end) RK_cnt".$tkey;	
		$query .= ", sum(case when room='$tkey' and country='F' then 1 else 0 end) RF_cnt".$tkey;	
	}
	$query .= " from registration_tbl where del='N' and member_level!='M' and classification not in ('M','Y')";
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();

	$in_query = "insert into room_statistics_tbl set day='$chkday'";
	$in_query .= ", login_K='".$cnt['login_cnt_K']."'";
	$in_query .= ", login_F='".$cnt['login_cnt_F']."'";
	foreach($_CONFIG['room'] as $tkey=>$tval){
		$in_query .= ", room".$tkey."_kor='".$cnt['RK_cnt'.$tkey]."'";
		$in_query .= ", room".$tkey."_eng='".$cnt['RF_cnt'.$tkey]."'";
	}
	$in_query .= ", signdate='".time()."'";
	$in_result=$conn->query($in_query);
	if(DB::isError($in_result)) die($in_result->getMessage());



	$list_query = "select * from room_statistics_tbl where day='$chkday' order by signdate desc";
	$list_result=$conn->query($list_query);
	if(DB::isError($list_result)) die($list_result->getMessage());

	$n=1;
	while(is_array($d=$list_result->fetchRow(DB_FETCHMODE_ASSOC))){
?>
<tr>
	<td><?=$n?></td>
	<td><?=$d['login_K']?></td>
	<td><?=$d['login_F']?></td>
	<?foreach($_CONFIG['room'] as $tkey=>$tval){?>
	<td><?=$d['room'.$tkey.'_kor']?></td>
	<td><?=$d['room'.$tkey.'_eng']?></td>
	<?}?>
	<td><?=date('y.n.j H:i',$d['signdate'])?></td>
</tr>
<?
	$n++;
	}
	if($conn){
		$conn->disconnect();
	}
?>