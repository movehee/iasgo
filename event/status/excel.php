<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Ave_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	procAdminLoginChk();
	
	$query = "select count(*) as Tcnt  ";
	$query .= " , sum(case when login_day2>0 then 1 else 0 end) as login_cnt";
	$query .= " , sum(case when room='1' then 1 else 0 end) as Room1";
	$query .= " , sum(case when room='2' then 1 else 0 end) as Room2";
	$query .= " , sum(case when room='3' then 1 else 0 end) as Room3";
	$query .= " , sum(case when room='4' then 1 else 0 end) as Room4";
	$query .= " , sum(case when room='5' then 1 else 0 end) as Room5";
	$query .= " , sum(case when room='6' then 1 else 0 end) as Room6";
	$query .= " , sum(case when room='7' then 1 else 0 end) as Room7";
	$query .= " , sum(case when room='8' then 1 else 0 end) as Room8";
	$query .= " , sum(case when room='H' then 1 else 0 end) as Hcnt";
	$query .= " , sum(case when room='S' then 1 else 0 end) as RS";
	$query .= " from registration_tbl";
	$result = $conn->query($query);
	$result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<table border=1>
	<thead>
		<tr>
			<th>다운로드 시간</th>
			<td><?=date("Y-m-d H:i:s")?></td>
		</tr>
		<tr>
			<th>전체인원</th>
			<td><?=$cnt['Tcnt']?></td>
		</tr>
		<tr>
			<th>18일 로그인 인원</th>
			<td><?=$cnt['login_cnt']?></td>
		</tr>
		<tr>
			<th>Main Hall</th>
			<td><?=$cnt['Hcnt']?></td>
		</tr>
		<tr>
			<th>룸 선택 중</th>
			<td><?=$cnt['RS']?></td>
		</tr>
		<?for($i=1;$i<=8;$i++){?>
		<tr>
			<th>Room <?=$i?></th>
			<td><?=$cnt['Room'.$i]?></td>
		</tr>
		<?}?>
	</thead>
	
</table>