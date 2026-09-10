<?
	include_once $_SERVER['DOCUMENT_ROOT'].'admin/include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'func/class.Block.php';
	

	$query = "select t1.*,t2.first_name,t2.last_name,t2.name_kr,t2.email,t2.regist_kind from workshop_feedback_result as t1 inner join registration_tbl as t2 on t1.id=t2.id where t2.del='N' and t2.status='Y'" .$fsql;
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	master_echo($query);

?>
<!-- <div class="ar tp10 bp10">
	<span class="rBtnAdmin medium green"><button type="button" onclick="location.href='excel_backup.php'">Excel Backup</button></span>
</div>
 -->
<table class="tblDef tblList">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 8%;">
		<col style="width: 8%;">
		<col style="width: 10%;">
		<col style="width: 10%;">
		<col style="width: 20%;">
		<col style="width: 20%;">
		<col style="width: 10%;">
	</colgroup>
	<tbody>
		<tr>
			<th rowspan=2>No</th>
			<th rowspan=2>이름</th>
			<th rowspan=2>E-mail</th>
			<th rowspan=2>전반적인 강의내용 및 토픽 등에 만족하십니까?</th>
			<th colspan=3>다음 각 강의가 선생님의 진료와 연구활동에 도움을 드릴 수 있는 내용이었는지요?</th>
			<th rowspan=2>강의 후 진행된 토론은 선생님의 진료와 연구활동에 도움을 드릴 수 있는 내용이었는지요?</th>
			<th rowspan=2>강의 중 도움이 된 부분을 기재하여 주시면 감사하겠습니다.</th>
			<th rowspan=2>등록일</th>
		</tr>
		<tr>
			<th>만성질환 약물 치료의 득과 실 - 효과 그리고 부작용</th>
			<th>만성질환 환자의 우울증 관리 - 진단과 치료</th>
			<th>디지털을 활용한 만성질환 관리의 변화 - 새로운 진단과 치료의 패러다임</th>
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
			<td><?=$d['id']?></td>
			<td><?=$_SURVEY['answer'][$d['answer1']]?></td>
			<td><?=$_SURVEY['answer'][$d['answer2']]?></td>
			<td><?=$_SURVEY['answer'][$d['answer3']]?></td>
			<td><?=$_SURVEY['answer'][$d['answer4']]?></td>
			<td><?=$_SURVEY['answer'][$d['answer5']]?></td>
			<td><?=$d['answer6']?></td>
			<td><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
		</tr>
		<?$virtualRecordNo++;}?>
	</tbody>
</table>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'admin/include.footer.php';
?>