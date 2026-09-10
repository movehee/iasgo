<?include "./include/include.header.php"?>
<?
	$session_query = "select * from workshop_session_tbl where sid='".$session_sid."'";
	$session_result = $conn->query($session_query);
	if(DB::isError($session_result)) {
	  die($session_result->getMessage());
	}
	$session_result->fetchInto(&$ss,DB_FETCHMODE_ASSOC);
	$session_result->free();
?>
<div class="popupWrap" id="popupSurvey">

		<h1 class="bg"><?=$ss['code_title']?> (<?=$ss['code']?>) - Session Evaluation</h1>
		<div class="popupCon">

			<div class="formArea scrollArea" style="height: 680px;">
				<div class="note">
					Please evaluate the sessions you have attended during the KCR 2023<br>
					There will be a lucky draw, and winners will be given prizes!<br><br>
					KCR 2023 에서 직접 참석하셨던 세션을 평가 해주세요. 세션 평가도 하고, 상품 증정의 기회도 잡으세요! (랜덤 증정)
				</div>
				<form id="session_evalF" name="session_evalF" action="session_evaluation_reg.php" method="post">
                    <input type="hidden" name="session_sid" value="<?=$session_sid?>">
					<fieldset>
						<legend>Survey</legend>
                        <?
							$query = "select * from session_evaluation_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$session_sid' and detail_key='first'";
							$result = $conn->query($query);
							if(DB::isError($result)) {
							  die($result->getMessage());
							}
							$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
							$result->free();
						?>

						<div class="question">How do you rate the entire session? (세션에 대한 전반적 평가)</div>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: 20%;">
								<col style="width: 20%;">
								<col style="width: 20%;">
								<col style="width: 20%;">
								<col style="width: 20%;">
							</colgroup>
							<thead>
								<tr>
									<th>Excellent</th>
									<th>Good</th>
									<th>Fair</th>
									<th>Poor</th>
									<th>기타</th>
								</tr>
							</thead>
							<tbody>
                            <tr>
								<?
								for($i=1;$i<=5;$i++){
								?>
								<td>
									<span class="inputC <?if($col['eval1']==$i){?> on<?}?>"><input type="radio" class="chk_answer" name="first" value="<?=$i?>" id="answer<?=$d['sort_num']."_".$i?>" <?if($col['eval1']==$i){?>checked<?}?> key="eval1"></span>
								</td>
								<?}?>
								</tr>
								<tr id="session_txt_areaeval1_1" style="display:<?if($col['eval1']!='5'){?>none<?}?>;">
									<td colspan=5><textarea style="width:99%;height:50px;" name="answereval1_txt1" value="" ><?=$col['eval1_txt']?></textarea></td>
								</tr>
							</tbody>
						</table>

                        <?
							$s_query = "select * from workshop_session_detail_tbl where session_sid='$session_sid' order by sort_num asc";
							$sresult=$conn->query($s_query);
							if(DB::isError($sresult)) die($sresult->getMessage());
							$snum=1;
							while(is_array($s=$sresult->fetchRow(DB_FETCHMODE_ASSOC))){

								$query = "select * from session_evaluation_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$session_sid' and detail_key='".$s['sid']."'";
								$result = $conn->query($query);
								if(DB::isError($result)) {
								  die($result->getMessage());
								}
								$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
								$result->free();
						?>
						<input type="hidden" name="detail_sid[]" value="<?=$s['sid']?>">
						<h4>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>)<?}?><br /> How would you rate the content of the presentation? (연사<?=$snum?>의 강의 내용)</h4>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
							</colgroup>
							<thead>
								<tr>
									<th>Excellent </th>
									<th>Good </th>
									<th>Fair </th>
									<th>Poor</th>
									<th>기타</th>
								</tr>
							</thead>
							<tbody >
								<tr>
								<?
								for($i=1;$i<=5;$i++){
								?>
								<td>
									<span class="inputC <?if($col['eval1']==$i){?> on<?}?>"><input type="radio" class="chk_answer" name="answer<?=$s['sid']?>_1" value="<?=$i?>" id="answer<?=$s['sid']?>_1" <?if($col['eval1']==$i){?>checked<?}?> key="<?=$s['sid']?>"></span>
								</td>
								<?}?>
								</tr>
								<tr id="session_txt_area<?=$s['sid']?>_1" style="display:<?if($col['eval1']!='5'){?>none<?}?>;">
									<td colspan=5><textarea style="width:99%;height:50px;" name="answer<?=$s['sid']?>_txt1"><?=$col['eval1_txt']?></textarea></td>
								</tr>
							</tbody>
						</table>
						<h4>Speaker <?=$snum?> <?if($s['author']){?>(<?=$s['author']?>)<?}?><br /> How would you rate the presentation of the speaker? (연사<?=$snum?>의 강의 진행에 대한 평가) </h4>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
							</colgroup>
							<thead>
								<tr>
									<th>Excellent </th>
									<th>Good </th>
									<th>Fair </th>
									<th>Poor</th>
									<th>기타</th>
								</tr>
							</thead>
							<tbody >
								<tr>
								<?
								for($i=1;$i<=5;$i++){
								?>
								<td>
									<span class="inputC <?if($col['eval2']==$i){?> on<?}?>"><input type="radio" class="chk_answer2" name="answer<?=$s['sid']?>_2" value="<?=$i?>" id="answer<?=$d['sort_num']."_".$i?>" <?if($col['eval2']==$i){?>checked<?}?> key="<?=$s['sid']?>"></span>
								</td>
								<?}?>
								</tr>
								<tr id="session_txt_area<?=$s['sid']?>_2" style="display:<?if($col['eval2']!='5'){?>none<?}?>;">
									<td colspan=5><textarea style="width:99%;height:50px;" name="answer<?=$s['sid']?>_txt2"><?=$col['eval2_txt']?></textarea></td>
								</tr>
							</tbody>
						</table>
						<?$snum++;}?>


                        <?
							$query = "select * from session_evaluation_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$session_sid' and detail_key='etc1'";
							$result = $conn->query($query);
							if(DB::isError($result)) {
							  die($result->getMessage());
							}
							$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
							$result->free();
						?>		
						<h4>What do you think was the merit or demerit of the session? (해당 세션의 장.단점)</h4>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: 10%;">
							</colgroup>
							<thead>
								<tr>
									<th><textarea style="width:96%;height:80px;" name="etc1"><?=$col['eval1_txt']?></textarea></th>
								</tr>
							</thead>
							<tbody >
								
							</tbody>
						</table>
						<?
							$query = "select * from session_evaluation_tbl where usid='".$_COOKIE['wmember_sid']."' and session_sid='$session_sid' and detail_key='etc2'";
							$result = $conn->query($query);
							if(DB::isError($result)) {
							  die($result->getMessage());
							}
							$result->fetchInto(&$col,DB_FETCHMODE_ASSOC);
							$result->free();
						?>		
						<h4>Do you have any topics or speakers that you would like to recommend for the next Congress? <br />(차기 학술대회에서 듣고 싶은 강의 주제 또는 연사)</h4>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: 10%;">
							</colgroup>
							<thead>
								<tr>
									<th><textarea style="width:96%;height:80px;" name="etc2"><?=$col['eval1_txt']?></textarea></th>
								</tr>
							</thead>
							<tbody >
								
							</tbody>
						</table>

						<div class="btn btnArea" style="margin-top: 20px;">
                            <input type="button" value="SUBMIT" class="btnDef btnBig" id="save_eval" >
						</div>
					</fieldset>
				</form>
			</div>
		</div>

		
		<div class="close"><a class="color_close"></a></div>
	</div>
	<!-- //popupWrap -->
	
</body>

<script>
	$(function(){
		$(":radio").on("click", function() {
			$(this).closest("tr").find("span").removeClass("on");
			$(this).closest("span").addClass("on");
		});

		$('#save_eval').on('click',function(){
			var params = $("#session_evalF").serialize();
			jQuery.ajax({
				url: '/load/session_evaluation_reg.php',
				type: 'POST',
				data:params,
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
				dataType: 'html',
				async: false,
				success: function (result) {
					
					var parse_data = JSON.parse(result);
					var status = parse_data.push;
					if(status=='Y'){
						alert("Submit completed.");
						parent.$.colorbox.close();
					}

				}, error: function (request,status,error){
					alert('Error');
					return false;
				}
			});
			return false;
		});
	});
	$('.chk_answer').on('click',function(){
		var key = $(this).attr('key');
		if($(this).val()=='5'){
			$('#session_txt_area'+key+'_1').show();
		}else{
			$('#session_txt_area'+key+'_1').hide();
		}
	});

	$('.chk_answer2').on('click',function(){
		var key = $(this).attr('key');
		if($(this).val()=='5'){
			$('#session_txt_area'+key+'_2').show();
		}else{
			$('#session_txt_area'+key+'_2').hide();
		}
	});
</script>

</html>