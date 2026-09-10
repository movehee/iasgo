<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<link rel="stylesheet" href="/css/pickout.css">
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Faculty 회원연결');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,500);
	});
	
</script>
<style>
	td {height:30px;}
</style>
<?
	$option_arr = array(
		"A"=>"이메일이 일치하는경우 업데이트합니다",
		"B"=>"세션코드와 일치하는 경우 업데이트합니다",
		"C"=>"이름과 일치하는 경우 업데이트합니다"
	)
?>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<div class="fcRed bp10"><b>* 사전등록 데이터와 Faculty 등록정보 중 매칭이 가능한 데이터를 선택해주세요</b></div>
<form method="post" name="postForm" id="postForm" action="reg_connect_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 15%;">
			<col style="width: ;">
		</colgroup>
		<tbody>
			<tr>
				<th>옵션 1</th>
				<td colspan=3 class="al">
					<?foreach($option_arr as $tkey=>$tval){?>
					<div style="font-size:16px;padding:5px;"><input type="radio" style="width:15px;height:15px;" name="kind" id="kind<?=$tkey?>" value="<?=$tkey?>"><label for="kind<?=$tkey?>"><?=$tval?></a></div>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>옵션 2</th>
				<td colspan=3 class="al" style="font-size:16px;">
					<input type="checkbox" name="fac_reset" id="fac_reset" value="Y" style="width:15px;height:15px;">
					<label for="fac_reset">이미 회원이 지정된 Faulty도 초기화 후 새롭게 지정합니다.</label>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="btnArea btn">
		<?if(!$d['sid']){?>
			<input type="submit" value="연결" class="btnPoint btnBig">
		<?}else{?>
			<input type="submit" value="수정" class="btnPoint btnBig">
		<?}?>
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>