<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";
	if(stristr($_SERVER['REMOTE_ADDR'],'218.235.94')==false){
		//PutMessageBack("접근이 불가능합니다.");
		//exit;
	}
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	if(!$ev_date) $ev_date = 1;
	
	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}
?>
<script>
$(function(){
	$('.session_act').on('click',function(){

		var mykey = $(this).attr("key");

		if($(this).is(':checked')==true){
			if(confirm("해당 강의의 평가여부를 활성화 하시겠습니까?")){
				$(".session_act").not($(this)).prop('checked',false);
				$.ajax({
					type:"POST",
					url:"/session/session_survey_activation.php",
					data:"chk=Y&mykey="+mykey,
					cache:false,
					async:false,
					success:function(msg){
						
					}
				});
			}else{
				return false;
			}
		}else{
			$.ajax({
				type:"POST",
				url:"/session/session_survey_activation.php",
				data:"chk=N&mykey="+mykey,
				cache:false,
				async:false,
				success:function(msg){
					
				}
			});
		}
	});
})
</script>
<div >
	<!-- <div class="btn" style="float:left;">
		<?for($date=1;$date<=$date_count;$date++){?>	
		<a href="<?=$PHP_SELF?>?code=<?=$code?>&ev_date=<?=$date?>" <?if($ev_date==$date){?>class="btnRed"<?}?>><i class="far fa-calendar-alt"></i><?=date("Y년 m월 d일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></a></li>
		<?}?>
	</div>
 -->
	
</div>
<table class="tblDef tp10">
	<colgroup>
		<col style="width: 7%;">
		<col style="">
		<col style="width: 9%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 6%;">

		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 5%;">
		<col style="width: 6%;">

		<col style="width: 10%;">
		<col style="width: 10%;">

		<col style="width: 50px;">
	</colgroup>
	<tbody>
		<tr>
			<th style="background:#263238;color:#ffffff;" rowspan=2>시간</th>
			<th style="background:#263238;color:#ffffff;" rowspan=2>강의명</th>
			<th style="background:#263238;color:#ffffff;" rowspan=2>연자</th>
			<th style="background:#263238;color:#ffffff;" colspan=5>강의 내용이 내과전공의의 수준에 적절하였다.</th>
			<th style="background:#263238;color:#ffffff;" colspan=5>강의 내용이 효과적으로 전달되었다.</th>
			<th style="background:#263238;color:#ffffff;" colspan=2>본 강의의 연자를 다음 <br />내과전공의 핵심역량 연수강좌 시에도 추천하겠다.</th>
			<th style="background:#263238;color:#ffffff;" rowspan=2>활성</th>
		</tr>
		<tr>
			<th style="background:#263238;color:#ffffff;">매우<br>그렇다</th>
			<th style="background:#263238;color:#ffffff;">그렇다</th>
			<th style="background:#263238;color:#ffffff;">보통이다</th>
			<th style="background:#263238;color:#ffffff;">그렇지<br />않다</th>
			<th style="background:#263238;color:#ffffff;">매우 그렇지<br /> 않다</th>
			<th style="background:#263238;color:#ffffff;">매우<br />그렇다</th>
			<th style="background:#263238;color:#ffffff;">그렇다</th>
			<th style="background:#263238;color:#ffffff;">보통이다</th>
			<th style="background:#263238;color:#ffffff;">그렇지<br />않다</th>
			<th style="background:#263238;color:#ffffff;">매우 그렇지<br /> 않다</th>
			<th style="background:#263238;color:#ffffff;">네</th>
			<th style="background:#263238;color:#ffffff;">아니오</th>
		</tr>
		<?
			$activation_key = $conn->getOne("select session_key from session_survey_activation");

			foreach($_TIME['session_detail'][$ev_date][1] as $skey=>$sval){
				if(!$sval[3]) continue;
				$cnt_query = "select count(*) ";
				for($i=1;$i<=5;$i++){
					$cnt_query .= ", sum(case when answer1='".$i."' then 1 else 0 end) as Que".$sval[2]."_".$i."_cnt1";
					$cnt_query .= ", sum(case when answer2='".$i."' then 1 else 0 end) as Que".$sval[2]."_".$i."_cnt2";
				}
				$cnt_query .= ", sum(case when answer3='1' then 1 else 0 end) as Que".$sval[2]."_1_cnt3";
				$cnt_query .= ", sum(case when answer3='2' then 1 else 0 end) as Que".$sval[2]."_2_cnt3";
				$cnt_query .= " from session_survey_tbl where day='$ev_date' and session_key='".$sval[2]."'";
				$cnt_result = $conn->query($cnt_query);

				$cnt_result->fetchInto(&$cnt,DB_FETCHMODE_ASSOC);
				$cnt_result->free();


				$cnt_query2 = "select count(*) ";
				for($i=1;$i<=5;$i++){
					$cnt_query2 .= ", sum(case when answer1='".$i."' then 1 else 0 end) as Que".$sval[2]."_".$i."_cnt1";
					$cnt_query2 .= ", sum(case when answer2='".$i."' then 1 else 0 end) as Que".$sval[2]."_".$i."_cnt2";
				}
				$cnt_query2 .= ", sum(case when answer3='1' then 1 else 0 end) as Que".$sval[2]."_1_cnt3";
				$cnt_query2 .= ", sum(case when answer3='2' then 1 else 0 end) as Que".$sval[2]."_2_cnt3";
				$cnt_query2 .= " from session_survey_tbl_history where day='$ev_date' and session_key='".$sval[2]."'";
				$cnt_result2 = $conn->query($cnt_query2);

				$cnt_result2->fetchInto(&$cnt2,DB_FETCHMODE_ASSOC);
				$cnt_result2->free();
		?>
		<tr>
			<td style="height:25px;background:#445964;color:#ffffff;" ><?=substr($sval[0],10,6)."~".substr($sval[1],10,6)?></td>
			<td style="background:#445964;color:#ffffff;text-align:left;padding-left:10px;" ><?=$skey?></td>
			<td style="background:#445964;color:#ffffff;" ><?=$sval[3]?></td>
			<?for($i=1;$i<=5;$i++){?>
			<td><?=$cnt['Que'.$sval[2].'_'.$i.'_cnt1']+$cnt2['Que'.$sval[2].'_'.$i.'_cnt1']?></td>
			<?}?>

			<?for($i=1;$i<=5;$i++){?>
			<td><?=$cnt['Que'.$sval[2].'_'.$i.'_cnt2']+$cnt2['Que'.$sval[2].'_'.$i.'_cnt2']?></td>
			<?}?>

			<?for($i=1;$i<=2;$i++){?>
			<td><?=$cnt['Que'.$sval[2].'_'.$i.'_cnt3']+$cnt2['Que'.$sval[2].'_'.$i.'_cnt3']?></td>
			<?}?>

			<td>
				<input type="checkbox" <?if($activation_key==$sval[2]){?>checked<?}?> name="room_sid<?=$d['sid']?>" class="session_act" key="<?=$sval[2]?>" style="width:20px;height:20px;margin:0px;">
			</td>
			
		</tr>
		<?}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>