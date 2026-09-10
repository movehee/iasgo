<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.header.php';
	
	require_once $_SERVER['DOCUMENT_ROOT'].'func/class.Page.php';
	require_once $_SERVER['DOCUMENT_ROOT'].'func/class.Block.php';
	

	$query = "select * from feedback_tbl where del='N' order by sort_num asc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

	master_echo($query);

?>
<div class="btn bp10" style="float:right;">
	<a href="javascript:popup_call('feedback/postform','')" class="btnGrey withIcon"><i class="fas fa-edit"></i>Feedback 등록</a>


	<a href="./excel_feedback_kor.php" class="btnGrey ">Excel Backup(KOR)</a>
	<a href="./excel_feedback_eng.php" class="btnGrey ">Excel Backup(ENG)</a>

</div>
<div class="contents" style="width:100%;">
	<table class="tblDef">
	<colgroup>
		<col style="width: 3%;">

		<col style="width: 6%;">
		<col style="width:">
		<?for($i=1;$i<=6;$i++){?>
		<col style="width: 12%;">
		<?}?>
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>유형</th>
			<th>질문</th>
			<?for($i=1;$i<=6;$i++){?>
			<th>선택 <?=$i?></th>
			<?}?>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?
			
			$virtualRecordNo=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
	
		<tr>
			<td><?=$virtualRecordNo?></td>
			<td ><?=$_Feedback['kind'][$d['kind']]?></td>
			<td><?=$d['question']?></td>
			<?for($i=1;$i<=6;$i++){?>
			<td><?=$d['que'.$i]?></td>
			<?}?>
			<td>
				<img src="/image/icon_modify.png" alt="삭제" class="hand" onclick="popup_call('feedback/postform','sid=<?=$d['sid']?>')">
				<img src="/image/icon_del.png" alt="삭제" class="hand" onclick="common_delete('<?=$d['sid']?>','feedback')">
			</td>
		</tr>
		<?$virtualRecordNo++;}?>
	</tbody>
</table>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'include.footer.php';
?>