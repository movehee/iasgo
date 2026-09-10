<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	$query = "select * from survey_result_tbl2 as t1 inner join registration_tbl as t2 on t1.usid=t2.sid order by t1.sid asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<div class="btn btnArea ar tp0 bp10">
	<input type="button" value="Excel Backup" onclick="location.href='survey_excel.php'" class="btnMint initialism fade_open btn btn-success ex_btn">
</div>
<table class="tblDef tblList">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 5%;">
		<col style="width: 10%;">
		<col style="width: 20%;">
		<col style="width: 20%;">
		<col style="width: 20%;">
		<col style="width: 20%;">
		<col style="width: 10%;">
	</colgroup>
	<tbody>
		<tr>
			<th >No</th>
			<th >이름</th>
			<th >E-mail</th>
			<th >가장 도움이 된 세션을 적어주세요</th>
			<th >가장 좋은 강의를 우선 순위로 2-3개 적어주세요.</th>
			<th >추후 학술대회에서 꼭 다루길 바라는 주제는 무엇인가요?</th>
			<th >기타 의견 </th>
			<th >등록일</th>
		</tr>
		<?
			
			$virtualRecordNo=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><?=$virtualRecordNo?></td>
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
		<?$virtualRecordNo++;}?>
	</tbody>
</table>