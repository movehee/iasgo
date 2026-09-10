<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Survey_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	
	$query = "select * from survey_result_tbl2 as t1 inner join registration_tbl as t2 on t1.usid=t2.sid order by t1.sid asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th>No</th>
		<th >이름</th>
		<th >E-mail</th>
		<th >가장 도움이 된 세션을 적어주세요</th>
		<th >가장 좋은 강의를 우선 순위로 2-3개 적어주세요.</th>
		<th >추후 학술대회에서 꼭 다루길 바라는 주제는 무엇인가요?</th>
		<th >기타 의견 </th>
		<th >등록일</th>
		
	</tr>
	<?
		$n=1;

		while ($d = $result->fetchRow(DB_FETCHMODE_ASSOC)) {

			$stamp_count = $conn->getOne("select count(*) from booth_stamp where usid='$d[sid]'");
			$star_count = $conn->getOne("select count(*) from e_poster_star_tbl where usid='".$d['sid']."'");
			
	?>
	<tr>
		<td><?=$n?></td>
		<td >
		<?
			echo $d['name_kr'];
		?>
		</td>
		<td><?=$d['email']?></td>
		<td><?=$d['answer1']?></td>
		<td><?=$d['answer2']?></td>
		<td><?=$d['answer3']?></td>
		<td><?=$d['answer4']?></td>

		<td><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
	</tr>
	<?$n++;?>
	<?}?>
</table>