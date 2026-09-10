<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select t1.*,t2.name_kr,t2.license_number,t3.poster_number,t3.subject from e_poster_judge_tbl as t1 inner join registration_tbl as t2 on t1.license_number=t2.license_number ";
	$query .= " inner join e_poster as t3 on t3.sid=t1.psid ";
	$query .= " where t1.sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	if(!$mode && !$d['content']){
		$mode = "form";
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("E-Poster 심사");

		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);

		$("select#category").on("change", function() {
			var psid=$(this).val();

			$.ajax({
				type:"POST",
				dataType:"JSON",
				url:"category.php",
				data:"psid="+psid,
				success:function(data){
					if(data.length) {
						$('select#category_sub').empty().append('<option value="">선택</option>');

						$.each(data, function(key, obj){ 
							$("select#category_sub").append(new Option(obj.value, obj.key));
						});
					}
				}
			});
		});
	});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="judge_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 25%;">
			<col style="width: *;">
		</colgroup>
		<tbody>

			<tr>
				<th>Poster No.</th>
				<td class="al">
					<?=$d['poster_number']?>
				</td>
			</tr>

			<tr>
				<th>제목</th>
				<td class="al">
					<?=stripslashes($d['subject'])?>
				</td>
			</tr>

			<tr>
				<th>심사자</th>
				<td class="al"><?=$d['name_kr']?></td>
			</tr>
			<tr>
				<th>연구의 창의성 혹은 증례<br />선정의 적절성</th>
				<td class="al">
					<?for($i=5;$i>=1;$i--){?>
					<input type="radio" name="score1" id="score1_<?=$i?>" class="score1" value="<?=$i?>" <?if($d['score1']==$i){?>checked<?}?>> <label for="score1_<?=$i?>" class="hand"><?=$i?>점</label>&nbsp;&nbsp;&nbsp;
					<?}?>
				</td>
			</tr>
			<tr>
				<th>연구방법 혹은 증례 기술의<br >논리성 및 구체성</th>
				<td class="al">
					<?for($i=5;$i>=1;$i--){?>
					<input type="radio" name="score2" id="score2_<?=$i?>" class="score2" value="<?=$i?>" <?if($d['score2']==$i){?>checked<?}?>> <label for="score2_<?=$i?>" class="hand"><?=$i?>점</label>&nbsp;&nbsp;&nbsp;
					<?}?>
				</td>
			</tr>
			<tr>
				<th>학문 및<br />실용 기여도</th>
				<td class="al">
					<?for($i=5;$i>=1;$i--){?>
					<input type="radio" name="score3" id="score3_<?=$i?>" class="score3" value="<?=$i?>" <?if($d['score3']==$i){?>checked<?}?>> <label for="score3_<?=$i?>" class="hand"><?=$i?>점</label>&nbsp;&nbsp;&nbsp;
					<?}?>
				</td>
			</tr>
			<tr>
				<th>결론의<br >타당성</th>
				<td class="al">
					<?for($i=5;$i>=1;$i--){?>
					<input type="radio" name="score4" id="score4_<?=$i?>" class="score4" value="<?=$i?>" <?if($d['score4']==$i){?>checked<?}?>> <label for="score4_<?=$i?>" class="hand"><?=$i?>점</label>&nbsp;&nbsp;&nbsp;
					<?}?>
				</td>
			</tr>
			<tr>
				<th>발표력</th>
				<td class="al">
					<?for($i=5;$i>=1;$i--){?>
					<input type="radio" name="score5" id="score5_<?=$i?>" class="score5" value="<?=$i?>" <?if($d['score5']==$i){?>checked<?}?>> <label for="score5_<?=$i?>" class="hand"><?=$i?>점</label>&nbsp;&nbsp;&nbsp;
					<?}?>
				</td>
			</tr>
			<tr>
				<th>합계</th>
				<td class="al"><input type="text" name="total_score" id="total_score" value="<?=$d['total_score']?>" style="width:50px;"> <span class="fcRed">관리자는 자동계산되지 않으니, 수기로 입력해주세요.</span></td>
			</tr>
			<tr>
				<th>순위</th>
				<td class="al"><input type="text" name="p_rank" id="p_rank" value="<?=$d['p_rank']?>" style="width:50px;"></td>
			</tr>
			<tr>
				<th>심사상태</th>
				<td class="al">
				<?foreach($_ABS['final_confirm'] as $tkey=>$tval){?>
				<input type="radio" name="final_confirm" id="final_confirm_<?=$tkey?>" class="final_confirm" value="<?=$tkey?>" <?if($d['final_confirm']==$tkey){?>checked<?}?>> <label for="final_confirm_<?=$tkey?>" class="hand"><?=$tval?></label>&nbsp;&nbsp;&nbsp;
				<?}?>
				
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="submit" value="수정" class="btnPoint btnBig">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>
<??>
