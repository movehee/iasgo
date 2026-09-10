<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=booth_survey.xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	
	$query = "select * from survey_tbl where booth_sid='$sid'";
	$query .= " order by sort_num asc, sid asc";
	
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		$survey_sid[] = $d['sid'];
		$survey_title[] = $d['survey_title'];
		$survey_type[$d['sid']] = $d['type'];
		$survey_ans[$d['sid']][1] = $d['ans1'];
		$survey_ans[$d['sid']][2] = $d['ans2'];
		$survey_ans[$d['sid']][3] = $d['ans3'];
		$survey_ans[$d['sid']][4] = $d['ans4'];
		$survey_ans[$d['sid']][5] = $d['ans5'];
	}

	procAdminLoginChk();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 백업 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
br {mso-data-placement:same-cell;}
.xl24
	{mso-style-parent tyle0;
	mso-number-format:"\@";}
</style> 


</HEAD>
<table class="tblDef tblList" border=1>
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
			<th>No</th>
			<th>이름</th>
			<th>E-mail</th>
			<?foreach($survey_title as $tkey=>$tval){?>
			<th><?=$tval?></th>
			<?}?>
		</tr>
		<?
			$query = "select * from survey_result_tbl as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$sid' group by t1.usid, t1.booth_sid order by t1.sid desc";
			$result=$conn->query($query);
			if(DB::isError($result)) die($result->getMessage());

			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td><?=$n?></td>
			
			<td><?=$d['name_kr']?></td>
			<td ><?=$d['email']?></td>
			<?
			foreach($survey_sid as $tkey=>$tval){
				$answer = $conn->getOne("select user_ans from survey_result_tbl where survey_sid='$tval' and usid='".$d['usid']."'");
				if($survey_type[$tval]=='2'){
					$answer = $survey_ans[$tval][$answer];
				}
			?>
			<td><?=$answer?></td>
			<?}?>
		</tr>
		<?$n++;}?>
	</tbody>
</table>