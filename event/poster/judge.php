<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	$query = "select t1.*,t2.name_kr,t2.license_number,t3.poster_number,t3.subject from e_poster_judge_tbl as t1 inner join registration_tbl as t2 on t1.license_number=t2.license_number ";
	$query .= " inner join e_poster as t3 on t3.sid=t1.psid order by t3.poster_number asc, t2.license_number asc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());


?>
<script type="text/javascript" src="/script/jquery.rowspanizer.js"></script>
<script>
$(function(){
	$(".target-table").rowspanizer({
		cols :[1,2],
		vertical_align: "middle"
	});
});
</script>
<div class="bp5">
	
</div>
<br />
<table class="tblDef target-table">
	<colgroup>
		<col style="width: 3%;">
		<col style="width: 6%;">
		<col style="">
		<col style="width: 5%;">
		<col style="width: 11%;">
		<col style="width: 12%;">
		<col style="width: 7%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 3%;">
	</colgroup>
	<tbody>
		<tr>
			<th>No</th>
			<th>Poster No.</th>
			<th>Subject</th>
			<th>심사자명</th>
			<th>연구의 창의성 혹은 증례<br />선정의 적절성</th>
			<th>연구방법 혹은 증례 기술의<br >논리성 및 구체성</th>
			<th>학문 및<br />실용 기여도</th>
			<th>결론의<br >타당성</th>
			<th>발표력</th>
			<th>합계</th>
			<th>순위</th>
			<th>심사상태</th>
			<th>관리</th>
		</tr>
		<?
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><?=$n?></td>
			<td><?=$d['poster_number']?></td>
			<td class="al"><?=nl2br($d['subject'])?></td>
			<td><?=$d['name_kr']?></td>
			<td><?=$d['score1']?></td>
			<td><?=$d['score2']?></td>
			<td><?=$d['score3']?></td>
			<td><?=$d['score4']?></td>
			<td><?=$d['score5']?></td>
			<td><?=$d['total_score']?></td>
			<td><?=$d['p_rank']?></td>
			<td style="color:<?=$_CONFIG['YN_color'][$d['final_confirm']]?>"><?=$_ABS['final_confirm'][$d['final_confirm']]?></td>
			<td>
				<img src="/image/icon/icon_modify.png" onclick="popup_call('poster/judge','sid=<?=$d['sid']?>')">
			</td>
		</tr>
		<?$n++;}?>
	</tbody>
</table>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>