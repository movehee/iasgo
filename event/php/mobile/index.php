<?
include $_SERVER['DOCUMENT_ROOT']."/php/mobile/include/include.header.php";
?>
<script>

$(document).ready(function(){
	
	$("#sms_check").click(function(){
		
		var name    = $("#name").val();
		var license = $("#license").val();
		
		if( name == "" ){
			alert("이름을 입력해주세요");
			return false;
		}
		
		if( $("#license").val() == "" ){
			alert("면허번호를 입력해주세요.");
			$("#license").focus();
		}else{
			$.post("./handle/sms_check.php", { license : license, name : name, code : '<?=$code?>' }, function(data){
				if( data == "false"){
					alert("해당 정보가 일치하지 않습니다. 자세한 문의는 사무국으로 연락바랍니다.");
					return false;
				}else{
					$("#code_num").val(data);
					$("#pass_confirm").attr("disabled",false);
					alert("인증번호가 전송되었습니다.");
				}
			});
		}
		
	});
	
});

function search_schedule(f){
	
	if( $(f.name).val() == "" ){
		alert("이름을 입력해주세요.");
		$(f.name).focus();
		return false;
	}
	
	if( $(f.license).val() == "" ){
		alert("면허번호를 입력해주세요.");
		$(f.license).focus();
		return false;
	}
	
	if( $("#code_num").val() == "" ){
		alert("휴대폰 인증을 진행해주세요.");
		$("#code_num").focus();
		return false;
	}	
	
	if( $("#code_num").val() != $("#pass_confirm").val() ){
		alert("인증번호가 일치하지 않습니다.");
		$("#pass_confirm").focus();
		return false;
	}
	
	return true;
}
</script>    	
				
<div class="contents">
	<h2 class="hidden">신청내역 확인</h2>
	<div class="conferenceSearch">
		<ul>
			<li>* 사전등록 시 입력한 성명, 면허번호 입력해주세요.</li>
			<li>* 문의사항은 학회 사무국으로 연락바랍니다. <br>(사무국 연락처 : <?=$e['sms_number']?>)</li>
		</ul>
		<form action="/php/mobile/barcode.php" method="post" onsubmit="return search_schedule(this)">
			<input type="hidden" id="code_num" value=""/>
			<input type="hidden" id="code" name="code" value="<?=$code?>"/>
			<fieldset>
				<legend>비회원 사전등록 검색</legend>
				<table class="table1">
					<colgroup>
						<col style="width: 30%;">
						<col style="width: 70%;">
					</colgroup>
					<tbody>
						<tr>
							<th><label for="">이름</label></th>
							<td><input type="text" name="name" id="name"></td>
						</tr>
						<tr>
							<th><label for="">면허번호</label></th>
							<td><input type="text" name="license" id="license"></td>
						</tr>
						<tr>
							<th><label for="">인증코드</label></th>
							<td>
								<input type="text" id="pass_confirm" value="" disabled style="width:50%" class="fl rm10">
								<div class="btn">
									<input type="button" value="인증코드 받기" id="sms_check" class="btnDef" style="width:45%" />
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<span class="fcRed">※ 등록시 입력하신 휴대폰 번호로 인증코드가 발송됩니다.</span>
				<div class="btn tm10">
					<input type="submit" value="확인" class="btnDef">
					<input type="reset" value="취소" class="btnGrey">
				</div>
			</fieldset>
		</form>
	</div>
</div>

<? include $_SERVER['DOCUMENT_ROOT']."/php/mobile/include/include.footer.php"; ?>    