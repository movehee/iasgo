<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>

<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Session Evaluation");
	
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);
	});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<?
				$query = "select count(*) as Tcnt ";
				for($i=1;$i<=5;$i++){
				$query .= ", sum(case when eval1='$i' then 1 else 0 end) as eval_cnt".$i;
				}
				$query .= " from session_evaluation_tbl where session_sid='$session_sid' and detail_key='first'";
				$result = $conn->query($query);
				if(DB::isError($result)) {
				  die($result->getMessage());
				}
				$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
				$result->free();
			?>
			<tr>
				<th colspan=5 style="background:#000000;color:#ffffff;text-align:left;">How do you rate the entire session? (세션에 대한 전반적 평가)</th>
			</tr>
			<tr>
				<tr >
					<th>Excellent </th>
					<th>Good </th>
					<th>Fair </th>
					<th>Poor</th>
					<th>기타</th>
				</tr>
			</tr>
			<tr>
				<tr>
					<?for($i=1;$i<=5;$i++){?>
					<td><?=$d['eval_cnt'.$i]?></td>
					<?}?>
				</tr>
			</tr>
			<?
				$etc_cnt = $conn->getOne("select count(*) from session_evaluation_tbl where session_sid='$session_sid' and detail_key='first' and eval1='5' and eval1_txt!='' and eval1_txt is not null");
				if($etc_cnt>0){
					$etc_query = "select * from session_evaluation_tbl where session_sid='$session_sid' and detail_key='first' and eval1='5' and eval1_txt!='' and eval1_txt is not null order by sid asc";
					$etc_result=$conn->query($etc_query);
					if(DB::isError($etc_result)) die($etc_result->getMessage());
					while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<tr>
					<td><?=$e['eval1_txt']?></td>
				</tr>
			</tr>
			<?}?>
			<?}?>

			<?
				$s_query = "select * from workshop_session_detail_tbl where session_sid='$session_sid' order by sort_num asc";
				$sresult=$conn->query($s_query);
				if(DB::isError($sresult)) die($sresult->getMessage());
				$snum=1;
				while(is_array($s=$sresult->fetchRow(DB_FETCHMODE_ASSOC))){
					
					$query = "select count(*) as Tcnt ";
					for($i=1;$i<=5;$i++){
						$query .= ", sum(case when eval1='$i' then 1 else 0 end) as eval1_cnt".$i;
						$query .= ", sum(case when eval2='$i' then 1 else 0 end) as eval2_cnt".$i;
					}
					$query .= " from session_evaluation_tbl where session_sid='$session_sid' and detail_key='".$s['sid']."'";
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
				<th style="background:#000000;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>, <?=$s['country']?>)<?}?><br /> How would you rate the content of the presentation? (연사<?=$snum?>의 강의 내용)</th>
			</tr>
			<tr>
				<tr>
					<th>Excellent </th>
					<th>Good </th>
					<th>Fair </th>
					<th>Poor</th>
					<th>기타</th>
				</tr>
			</tr>
			<tr>
				<tr>
					<?for($i=1;$i<=5;$i++){?>
					<td><?=$d['eval1_cnt'.$i]?></td>
					<?}?>
				</tr>
			</tr>
			<?if(count($etc1_txt)>0){?>
			<?foreach($etc1_txt as $tkey=>$tval){?>
			<tr>
				<tr>
					<?=$tval?>
				</tr>
			</tr>
			<?}?>
			<?}?>
			<tr>
				<th style="background:#000000;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>, <?=$s['country']?>)<?}?><br /> How would you rate the presentation of the speaker? (연사<?=$snum?>의 강의 진행에 대한 평가)</th>
			</tr>
			<tr>
				<tr>
					<th>Excellent </th>
					<th>Good </th>
					<th>Fair </th>
					<th>Poor</th>
					<th>기타</th>
				</tr>
			</tr>
			<tr>
				<tr>
					<?for($i=1;$i<=5;$i++){?>
					<td><?=$d['eval2_cnt'.$i]?></td>
					<?}?>
				</tr>
			</tr>
			<?if(count($etc2_txt)>0){?>
			<?foreach($etc2_txt as $tkey=>$tval){?>
			<tr>
				<tr>
					<?=$tval?>
				</tr>
			</tr>
			<?}?>
			<?}?>
			<?}?>
			<tr>
				<th style="background:#000000;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>What do you think was the merit or demerit of the session? (해당 세션의 장.단점)</th>
			</tr>
			<?
				$etc_query = "select * from session_evaluation_tbl where session_sid='$session_sid' and detail_key='etc1' and eval1_txt!='' and eval1_txt is not null order by sid asc";
				$etc_result=$conn->query($etc_query);
				if(DB::isError($etc_result)) die($etc_result->getMessage());
				while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<tr>
					<td class="al" colspan=5><?=$e['eval1_txt']?></td>
				</tr>
			</tr>
			<?}?>
			<tr>
				<th style="background:#000000;color:#ffffff;text-align:left;padding-left:5px;" colspan=5>Do you have any topics or speakers that you would like to recommend for the next Congress? <br />(차기 학술대회에서 듣고 싶은 강의 주제 또는 연사)</th>
			</tr>
			<?
				$etc_query = "select * from session_evaluation_tbl where session_sid='$session_sid' and detail_key='etc2' and eval1_txt!='' and eval1_txt is not null order by sid asc";
				$etc_result=$conn->query($etc_query);
				if(DB::isError($etc_result)) die($etc_result->getMessage());
				while(is_array($e=$etc_result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<tr>
					<td class="al" colspan=5><?=$e['eval1_txt']?></td>
				</tr>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btn">
	</div>
</form>
</div>
<??>
