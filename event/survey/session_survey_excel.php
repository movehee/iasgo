<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=survey.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';

	$lec_query = "select t1.sid,t1.title,t1.author,t1.detail_time,t2.ev_date from workshop_session_detail_tbl as t1 inner join workshop_session_tbl as t2 on t1.session_sid=t2.sid ";
	$lec_query .= " where t1.title not like '%패널%' and t1.title not like '%폐회%' order by t2.sort_num asc, t1.sort_num asc";

	
	$lec_result=$conn->query($lec_query);
	if(DB::isError($lec_result)) die($lec_result->getMessage());
	$n=1;
	while ($l = $lec_result->fetchRow(DB_FETCHMODE_ASSOC)) {
		$ex_author = explode("(",$l['author']);
		if($l['ev_date']=='1'){
			$lec_arr1[] = $ex_author[0];
		}else{
			$lec_arr2[] = $ex_author[0];
		}
	}
	
	$fsql = " where t1.usid>0";
	$query = "select t1.*,t2.name_kr,t2.license_number,t2.reg_kind,t2.gubun1 from session_survey_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid" .$fsql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table border=1>
	<tr>
		<th rowspan=2>No</th>
		<th rowspan=2>구분</th>
		<th rowspan=2>성명</th>
		<th rowspan=2>면허번호</th>
		<th rowspan=2>직종</th>
		<th rowspan=2>감염관리<br>담당자</th>
		<th rowspan=2>감염관리<br>경력</th>
		<th colspan=12>평가 Day1</th>
		<th colspan=12>평가 Day2</th>
		<th rowspan=2>의견</th>
	</tr>
	<tr>
		<?foreach($lec_arr1 as $tkey=>$tval){?>
		<th><?=$tval?></th>
		<?}?>
		<?foreach($lec_arr2 as $tkey=>$tval){?>
		<th><?=$tval?></th>
		<?}?>
	</tr>
	<?
		while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
	?>
	<tr>
		<td><?=$virtualRecordNo?></td>
		<td>
			<?if($d['reg_kind']){?><div><?=$_REG['reg_kind'][$d['reg_kind']]?></div><?}?>
			<?if($d['gubun1']){?><div><?=$_REG['gubun1'][$d['gubun1']]?></div><?}?>
		</td>
		<td><?=$d['name_kr']?></td>
		<td><?=$d['license_number']?></td>

		<td><?=$_SURVEY['job'][$d['job']]?></td>
		<td><?=$_SURVEY['charge'][$d['charge']]?></td>
		<td><?=$d['yearv']?></td>
		<?foreach($lec_arr1 as $tkey=>$tval){?>
		<td><?=$_SURVEY['answer'][$d['answer1_'.($tkey+1)]]?></td>
		<?}?>
		<?foreach($lec_arr2 as $tkey=>$tval){?>
		<td><?=$_SURVEY['answer'][$d['answer2_'.($tkey+1)]]?></td>
		<?}?>
		<td><?=nl2br($d['memo'])?></td>
	</tr>
	<?$virtualRecordNo--;}?>
</table>