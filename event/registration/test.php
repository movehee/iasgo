<?
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	$query = "select * from checkin_tbl where day='3' and nec_score is not null order by nec_score desc, s4_sdate asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	?>
	<table border=1>
	<tr>
		<td>아이디</td>
		
		<td>입장</td>
		<td>퇴장</td>
		<td>분</td>
		<td>점수</td>
	</tr>
	<?
	while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {

		$s4_sdater = $conn->getOne("select min(check_in) from checkin_detail_tbl_history where day='3' and session='4' and room='6' and id='".$d['id']."'");
		$s4_edater = $conn->getOne("select if((check_out='' or check_out is null),max(check_in),max(check_out)) from checkin_detail_tbl_history where day='3' and session='4' and room='6' and id='".$d['id']."' order by check_in desc limit 0,1");


		$s4_sdate = $conn->getOne("select min(check_in) from checkin_detail_tbl_history where day='3' and session='4' and room='6' and id='".$d['id']."'");
		$s4_edate = $conn->getOne("select if((check_out='' or check_out is null),max(check_in),max(check_out)) from checkin_detail_tbl_history where day='3' and session='4' and room='6' and id='".$d['id']."' order by check_in desc limit 0,1");

		if(strtotime('2020-09-19 14:30:00')>$s4_sdate){
			$s4_sdate = strtotime('2020-09-19 14:30:00');
		}
		if(strtotime('2020-09-19 16:30:00')<$s4_edate){
			$s4_edate = strtotime('2020-09-19 16:30:00');
		}
		$s1_time = $s4_edate-$s4_sdate;
		$mm1 = ($s1_time/60);

	?>
	<tr>
		<td><?=$d['id']?></td>
		
		<td><?=date("H:i",$s4_sdater)?></td>
		<td><?=date("H:i",$s4_edater)?></td>
		<td><?=floor($mm1)?></td>
		<td><?=$d['nec_score']?></td>
	</tr>
	<?
		
	}
?>
</table>