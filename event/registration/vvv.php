<?include $_SERVER['DOCUMENT_ROOT']."include.header.php"?>
<div class="contents">
	<table class="tblDef">
		<thead>
			<tr>
				<th>연지명</th>
				<th>룸</th>
				<th>질문</th>
				<th colspan=2>문항1</th>
				<th colspan=2>문항2</th>
				<th colspan=2>문항3</th>
				<th colspan=2>문항4</th>
				<th colspan=2>문항5</th>

				<th>총합</th>
			</tr>
		</thead>
		<tbody>
			<?
				$query = "select t1.*,t2.name,t2.room from voting_tbl as t1 inner join lecture_tbl as t2 on t1.code=t2.code and t1.lecture=t2.sid where t1.del='N' and t2.del='N' order by t2.code asc, t2.room asc, t2.sid asc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){

					$cnt_query = "select count(sid) as Tcnt ";
					for($i=1;$i<=5;$i++){
					$cnt_query .= " , sum(case when val='".$i."' then 1 else 0 end) as Vcnt".$i;
					}
					$cnt_query .= " from voting_result_tbl where voting_sid='".$d['sid']."'";
					$cnt_result = $conn->query($cnt_query);
					$cnt_result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
					$cnt_result->free();


					$Vtotal = $cnt['Vcnt1']+$cnt['Vcnt2']+$cnt['Vcnt3']+$cnt['Vcnt4']+$cnt['Vcnt5'];

			?>
			<tr>
				<td><?=$d['name']?></td>
				<td><?=$d['room']?></td>
				<td><?=$d['question']?></td>
				<td><?=$d['answer1']?></td>
				<td><?if($cnt['Vcnt1']>0){?><?=$cnt['Vcnt1']?>(<?=round(($cnt['Vcnt1']/$Vtotal)*100,1)?>%)<?}?></td>
				<td><?=$d['answer2']?></td>
				<td><?if($cnt['Vcnt2']>0){?><?=$cnt['Vcnt2']?>(<?=round(($cnt['Vcnt2']/$Vtotal)*100,1)?>%)<?}?></td>
				<td><?=$d['answer3']?></td>
				<td><?if($cnt['Vcnt3']>0){?><?=$cnt['Vcnt3']?>(<?=round(($cnt['Vcnt3']/$Vtotal)*100,1)?>%)<?}?></td>
				<td><?=$d['answer4']?></td>
				<td><?if($cnt['Vcnt4']>0){?><?=$cnt['Vcnt4']?>(<?=round(($cnt['Vcnt4']/$Vtotal)*100,1)?>%)<?}?></td>
				<td><?=$d['answer5']?></td>
				<td><?if($cnt['Vcnt5']>0){?><?=$cnt['Vcnt5']?>(<?=round(($cnt['Vcnt5']/$Vtotal)*100,1)?>%)<?}?></td>



				<td><?=$Vtotal?></td>
			</tr>
			<?$virtualRecordNo--;}?>
		</tbody>
	</table>
	<?
		if($add_search2) $search_url .= $add_search2;
		if($sort_field) $search_url .= "&sort_field=".$sort_field;
		if($orderby) $search_url .= "&orderby=".$orderby;
		if($ev_date) $search_url .= "&ev_date=".$ev_date;

		$excel_kind = "exam_result"; //엑셀백업 구분값
	?>
</div> 
<?include $_SERVER['DOCUMENT_ROOT'].$_Path['link']."/include.footer.php"?>		

    
 