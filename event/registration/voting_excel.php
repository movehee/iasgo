<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=voting_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	procAdminLoginChk();
	
	$lecture_query = "select * from lecture_tbl where del='N' and code='$v_code'  order by sid asc";
	$lecture_result=$conn->query($lecture_query);
	if(DB::isError($lecture_result)) die($lecture_result->getMessage());
	while ($lec = $lecture_result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$lecture_sid[] = $lec['sid'];
		$lecture_title[] = $lec['name'];
		$Vcnt[] = $conn->getOne("select count(*) from voting_tbl where del='N' and status>0 and lecture='".$lec['sid']."'");

		$voting_query = "select * from voting_tbl where del='N' and status>0 and lecture='".$lec['sid']."'";
		$voting_result=$conn->query($voting_query);
		if(DB::isError($voting_result)) die($voting_result->getMessage());

		while ($vt = $voting_result->fetchRow(DB_FETCHMODE_ASSOC)) {
			$voting_sid[] = $vt['sid'];
			$voting_order[] = $vt['orderby'];
		}
	}
	
	$query = "select * from registration_tbl ";
	if($v_code=='day1'){
		$dd="1";
		$query .= " where login1='Y' and member_level!='M'";
	}else if($v_code=='day2'){
		$dd="2";
		$query .= " where login2='Y' and member_level!='M'";
	}
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th rowspan=2>No</th>
		<th rowspan=2>등록구분</th>
		<th rowspan=2>구분</th>
		
		<th rowspan=2>연차</th>
		<th rowspan=2>성명</th>
		<th rowspan=2>면허번호</th>	
		
		<?foreach($lecture_title as $tkey=>$tval){?>
		<th colspan="<?=$Vcnt[$tkey]?>"><?=$tval?>(<?=$Vcnt[$tkey]?>건)</th>
		<?}?>
		<th rowspan=2>최초입장</th>
		<th rowspan=2>최종퇴장</th>	
	</tr>
	<tr>
		<?foreach($voting_sid as $tkey=>$tval){?>
		<th ><?=$voting_order[$tkey]?>번</th>
		<?}?>
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {

			$v_result_query = "select count(*) ";
			foreach($voting_sid as $tkey=>$tval){
				$v_result_query .= ", sum(case when deviceid='".$d['sid']."' and voting_sid='$tval' then val else '' end) as V_val".$tval;
			}
			if($v_code=='day1'){
				$v_result_query .= " from voting_result_tbl_day1 where deviceid='".$d['sid']."'";
			}else{
				$v_result_query .= " from voting_result_tbl where deviceid='".$d['sid']."'";
			}
			$v_result = $conn->query($v_result_query);

			$v_result->fetchInto(&$vc,DB_FETCHMODE_ASSOC);
			$v_result->free();

			$chkin_query = "select first_date,last_date from checkin_tbl where day='".$dd."' and usid='".$d['sid']."'";
			$chkin_result = $conn->query($chkin_query);

			$chkin_result->fetchInto(&$ck,DB_FETCHMODE_ASSOC);
			$chkin_result->free();
	?>
	<tr>
		<td><?=$n?></td>
		<td><?=$_REG['class_kind'][$d['classification']]?></td>
		<td><?if($d['reg_kind']=='A' || $d['reg_kind']=='B'){?>사전-<?}?><?=$_REG['reg_kind'][$d['reg_kind']]?></td>
		<td>
		<?
			echo $d['major_year'];
		?>
		</td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['license_number']?></td>
		
		<?foreach($voting_sid as $tkey=>$tval){?>
		<td><?if($vc['V_val'.$tval]>0){?><?=$vc['V_val'.$tval]?><?}?></td>
		<?}?>
		<td>
		<?
			if($ck['first_date']>0 ){
				echo date("H:i",$ck['first_date']);
			}
		?>
		</td>
		<td>
		<?
			if($ck['last_date']>0 || $d['logout_day'.$dd]>0){
				if($d['logout_day'.$dd]>$ck['last_date']){
					echo date("H:i",$d['logout_day'.$dd]);
				}else{
					echo date("H:i",$ck['last_date']);
				}
			}
		?>	
		</td>
	</tr>
	<?$n++;?>
	<?}?>
</table>