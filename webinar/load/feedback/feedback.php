<?include "../include/include.header.php"?>
<?
	$Tcnt = $conn->getOne("select count(*) from feedback_tbl where del='N'");

	$query = "select * from feedback_tbl where del='N' order by sort_num asc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());


	$query2 = "select * from feedback_result_tbl where usid='".$_COOKIE['wmember_sid']."'";
	$result2 = $conn->query($query2);
	if(DB::isError($result2)) {
	  die($result2->getMessage());
	}
	$result2->fetchInto(&$col,DB_FETCHMODE_ASSOC);
	$result2->free();
?>

    <div class="popupWrap" id="popupSurvey">
        <h1 class="bg">Survey</h1>
		<div class="popupCon">
			
			<div class="formArea scrollArea">
                <div class="note">
					Please evaluate the sessions you have attended during the KCR 2023<br>
					There will be a lucky draw, and winners will be given prizes!<br><br>
					KCR 2023 에서 직접 참석하셨던 세션을 평가 해주세요. 세션 평가도 하고, 상품 증정의 기회도 잡으세요! (랜덤 증정)
				</div>

				<form id="feedbackF" name="feedbackF" action="feedback_reg.php" method="post">
				<input type="hidden" name="Tcnt" value="<?=$Tcnt?>">
				<input type="hidden" name="sid" value="<?=$col['sid']?>">
					<fieldset>
						<legend>Survey</legend>
						
						<h4>이번 심포지엄에 대한 만족도를 평가해 주세요</h4>
						<table class="inputTbl ac">
							<colgroup>
								<col style="width: *;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 10%;">
								<col style="width: 12%;">
							</colgroup>
							<thead>
								<tr>
									<th>내용</th>
									<th>매우<br>만족</th>
									<th>만족</th>
									<th>보통</th>
									<th>불만족</th>
									<th>매우<br>불만족</th>
									<th>모르겠다</th>
								</tr>
							</thead>
							<tbody >
								<?
									while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
								?>
								<?if($d['kind']=='A'){?>
								<tr>
									<td class="al"><?=$d['sort_num']?>. <?=$d['question']?></td>
									<?
									for($i=1;$i<=6;$i++){
									if(!trim($d['que'.$i])) continue;
									?>
									<td>
										<span class="inputC <?if($col['answer'.$d['sort_num']]==$i){?> on<?}?>"><input type="radio" name="answer<?=$d['sort_num']?>" value="<?=$i?>" id="answer<?=$d['sort_num']."_".$i?>" <?if($col['answer'.$d['sort_num']]==$i){?>checked<?}?>></span>
									</td>
									<?}?>
								</tr>
								<?}else if($d['kind']=='B'){?>
								<tr class="answer_area">
									<td class="al" colspan="7">
										<label for=""><?=$d['sort_num']?>. <?=$d['question']?></label>
										<textarea  placeholder="Please enter the contents. " name="answer<?=$d['sort_num']?>" id="answer<?=$d['sort_num']?>" cols="30" rows="10"><?=$col['answer'.$d['sort_num']]?></textarea>
									</td>
								 
								</tr>
								<?}?>
								<?}?>
							</tbody>
						</table>

						<div class="btn btnArea">
							<input type="submit" value="Submit" class="btnPoint btnBig">
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="close"><a href="# return false;" class="color_close"></a></div>
	</div>
	<!-- //popupWrap -->

<script>
	$(function(){
		$(":radio").on("click", function() {
			$(this).closest("tr").find("span").removeClass("on");
			$(this).closest("span").addClass("on");
		});
   
		$('#feedbackF').submit(function(){
			var params = $("#feedbackF").serialize();
			jQuery.ajax({
				url: '/load/feedback/feedback_reg.php',
				type: 'POST',
				data:params,
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
				dataType: 'html',
				async: false,
				success: function (result) {
					var parse_data = JSON.parse(result);
					var status = parse_data.push;
					if(status=='O'){
						alert("로그인이 끊겼습니다. 다시 로그인해주세요.");
						location.href="/logout.php";
					}else if(status=='Y'){
						alert("Your submission is complete.");
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
</script>


</body>
</html>