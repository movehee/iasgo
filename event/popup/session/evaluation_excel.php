<?
	if($_SERVER['REMOTE_ADDR']!='218.235.94.220'){
		header('Content-Type: text/html; charset=utf-8');
		header( "Content-type: application/vnd.ms-excel" );
		header( "Content-Disposition: attachment; filename=Registration_".date("YmdHis").".xls" );
		header( "Content-Description: PHP4 Generated Data" );
	}
	include_once $_SERVER['DOCUMENT_ROOT'].'lib.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	procAdminLoginChk();
	
	$ssquery = "select * from workshop_session_tbl where del='N' ";
	$ssquery .= " order by ev_date asc, room asc, stime asc";
	$ssresult=$conn->query($ssquery);
	if(DB::isError($ssresult)) die($ssresult->getMessage());
	
	while(is_array($ss=$ssresult->fetchRow(DB_FETCHMODE_ASSOC))){
?>

<table class="tblDef inputTbl" style="width:100%;"border=1>
	<colgroup>
		<col style="width: 20%;">
		<col style="width: *;">
	</colgroup>
	<tbody>
		<tr><td colspan=5 style="background:#000000;color:#ffffff;text-align:left;font-size:19px;"><?=$ss['title']?>(<?=$ss['code']?>)</td></tr>
		<?
			$query = "select count(*) as Tcnt ";
			for($i=1;$i<=5;$i++){
			$query .= ", sum(case when eval1='$i' then 1 else 0 end) as eval_cnt".$i;
			}
			$query .= " from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='first'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
			  die($result->getMessage());
			}
			$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
			$result->free();
		?>
		<tr>
			<th colspan=5 style="background:gray;color:#ffffff;text-align:left;">How do you rate the entire session? (세션에 대한 전반적 평가)</th>
		</tr>
		<tr >
			<th style="text-align:center;">Excellent </th>
			<th style="text-align:center;">Good </th>
			<th style="text-align:center;">Fair </th>
			<th style="text-align:center;">Poor</th>
			<th style="text-align:center;">기타</th>
		</tr>
		<tr>
			<tr>
				<?for($i=1;$i<=5;$i++){?>
				<td style="text-align:center;"><?=$d['eval_cnt'.$i]?></td>
				<?}?>
			</tr>
		</tr>
		<?
			$etc_cnt = $conn->getOne("select count(*) from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='first' and eval1='5' and eval1_txt!='' and eval1_txt is not null");
			if($etc_cnt>0){
				$etc_query = "select * from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='first' and eval1='5' and eval1_txt!='' and eval1_txt is not null order by sid asc";
				$etc_result=$conn->query($etc_query);
				if(DB::isError($etc_result)) die($etc_result->getMessage());
				while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){
		?>
		<tr>
			<td style="text-align:left;"><?=$e['eval1_txt']?></td>
		</tr>
		<?}?>
		<?}?>

		<?
			$s_query = "select * from workshop_session_detail_tbl where session_sid='$ss[sid]' order by sort_num asc";
			$sresult=$conn->query($s_query);
			if(DB::isError($sresult)) die($sresult->getMessage());
			$snum=1;
			while(is_array($s=$sresult->fetchRow(DB_FETCHMODE_ASSOC))){
				
				$query = "select count(*) as Tcnt ";
				for($i=1;$i<=5;$i++){
					$query .= ", sum(case when eval1='$i' then 1 else 0 end) as eval1_cnt".$i;
					$query .= ", sum(case when eval2='$i' then 1 else 0 end) as eval2_cnt".$i;
				}
				$query .= " from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='".$s['sid']."'";
				$result = $conn->query($query);
				if(DB::isError($result)) {
				  die($result->getMessage());
				}
				$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
				$result->free();

				if(trim($d['eval1_txt'])){
					$etc1_txt[] = $d['eval1_txt'];
				}
				if(trim($d['eval2_txt'])){
					$etc2_txt[] = $d['eval2_txt'];
				}
		?>
		<tr>
			<th style="background:gray;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>)<?}?><br> How would you rate the content of the presentation? (연사<?=$snum?>의 강의 내용)</th>
		</tr>
		<tr>
			<th style="text-align:center;">Excellent </th>
			<th style="text-align:center;">Good </th>
			<th style="text-align:center;">Fair </th>
			<th style="text-align:center;">Poor</th>
			<th style="text-align:center;">기타</th>
		</tr>
		<tr>
			<?for($i=1;$i<=5;$i++){?>
			<td style="text-align:center;"><?=$d['eval1_cnt'.$i]?></td>
			<?}?>
		</tr>
		<?if(count($etc1_txt)>0){?>
		<?foreach($etc1_txt as $tkey=>$tval){?>
		<tr>
			<?=$tval?>
		</tr>
		<?}?>
		<?}?>
		<tr>
			<th style="background:gray;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>)<?}?><br> How would you rate the presentation of the speaker? (연사<?=$snum?>의 강의 진행에 대한 평가)</th>
		</tr>
		<tr>
			<th style="text-align:center;">Excellent </th>
			<th style="text-align:center;">Good </th>
			<th style="text-align:center;">Fair </th>
			<th style="text-align:center;">Poor</th>
			<th style="text-align:center;">기타</th>
		</tr>
		<tr>
			<?for($i=1;$i<=5;$i++){?>
			<td style="text-align:center;"><?=$d['eval2_cnt'.$i]?></td>
			<?}?>
		</tr>
		<?if(count($etc2_txt)>0){?>
		<?foreach($etc2_txt as $tkey=>$tval){?>
		<tr>
			<?=$tval?>
		</tr>
		<?}?>
		<?}?>
		<?$snum++;}?>
		<tr>
			<th style="background:gray;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>What do you think was the merit or demerit of the session? (해당 세션의 장.단점)</th>
		</tr>
		<?
			$etc_query = "select * from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='etc1' and eval1_txt!='' and eval1_txt is not null order by sid asc";
			$etc_result=$conn->query($etc_query);
			if(DB::isError($etc_result)) die($etc_result->getMessage());
			while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){
				$user_query = "select * from registration_tbl where sid='".$e['usid']."'";
				$user_result = $conn->query($user_query);
				$user_result->fetchInto(&$usr,DB_FETCHMODE_ASSOC);
				$user_result->free();
		?>
		<tr>
			<td class="al" colspan=4><?=$e['eval1_txt']?></td>
			<td  style="text-align:left;"><?=$usr['name_kr']?>(<?=$usr['etc_field2']?>)</td>
		</tr>
		<?}?>
		<tr>
			<th style="background:gray;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Do you have any topics or speakers that you would like to recommend for the next Congress? (차기 학술대회에서 듣고 싶은 강의 주제 또는 연사)</th>
		</tr>
		<?
			$etc_query = "select * from session_evaluation_tbl where session_sid='$ss[sid]' and detail_key='etc2' and eval1_txt!='' and eval1_txt is not null order by sid asc";
			$etc_result=$conn->query($etc_query);
			if(DB::isError($etc_result)) die($etc_result->getMessage());
			while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){

				$user_query = "select * from registration_tbl where sid='".$e['usid']."'";
				$user_result = $conn->query($user_query);
				$user_result->fetchInto(&$usr,DB_FETCHMODE_ASSOC);
				$user_result->free();
		?>
		<tr>
			<td  style="text-align:left;" colspan=4><?=$e['eval1_txt']?></td>
			<td  style="text-align:left;"><?=$usr['name_kr']?>(<?=$usr['etc_field2']?>)</td>
		</tr>
		<?}?>
	</tbody>
</table>
<?}?>