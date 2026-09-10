function check_search(f){

	if( $("input:text[name='m_name']").val() == "" ){
		alert("성함을 입력해주세요.");
		$("input:text[name='m_name']").focus();
		return false;
	}
	if( $("input:text[name='m_phone']").val() == "" ){
		alert("휴대폰번호를 입력해주세요.");
		$("input:text[name='m_phone']").focus();
		return false;
	}

}

function spon_check(f){

	if( $("input:text[name='office_kr']").val() == "" ){
		alert("회사명(국문)을 입력해주세요.");
		$("input:text[name='office_kr']").focus();
		return false;
	}
	if( $("input:text[name='office_eng']").val() == "" ){
		alert("회사명(영문)을 입력해주세요.");
		$("input:text[name='office_eng']").focus();
		return false;
	}
	if( $("input:text[name='license_number']").val() == "" ){
		alert("사업자등록번호를 입력해주세요.");
		$("input:text[name='license_number']").focus();
		return false;
	}
	if( $("input:text[name='representative']").val() == "" ){
		alert("대표자를 입력해주세요.");
		$("input:text[name='representative']").focus();
		return false;
	}
	if( $("input:text[name='office_zipcode']").val() == "" ){
		alert("사업장 소재지(우편번호)를 입력해주세요.");
		$("input:text[name='office_zipcode']").focus();
		return false;
	}
	if( $("input:text[name='office_addr']").val() == "" ){
		alert("사업장 소재지(주소)를 입력해주세요.");
		$("input:text[name='office_addr']").focus();
		return false;
	}
	if( $("input:text[name='office_addr_etc']").val() == "" ){
		alert("사업장 소재지(상세주소)를 입력해주세요.");
		$("input:text[name='office_addr_etc']").focus();
		return false;
	}
	/*
	if( $("input:text[name='business']").val() == "" ){
		alert("업태를 입력해주세요.");
		$("input:text[name='business']").focus();
		return false;
	}
	if( $("input:text[name='event']").val() == "" ){
		alert("종목을 입력해주세요.");
		$("input:text[name='event']").focus();
		return false;
	}
	*/
	if( $("input:text[name='m_name']").val() == "" ){
		alert("담당자 정보(이름)를 입력해주세요.");
		$("input:text[name='m_name']").focus();
		return false;
	}
	if( $("input:text[name='m_position']").val() == "" ){
		alert("담당자 정보(직급)를 입력해주세요.");
		$("input:text[name='m_position']").focus();
		return false;
	}
	if( $("input:text[name='m_tel']").val() == "" ){
		alert("담당자 정보(전화)를 입력해주세요.");
		$("input:text[name='m_tel']").focus();
		return false;
	}
	if( $("input:text[name='m_phone']").val() == "" ){
		alert("담당자 정보(휴대폰)를 입력해주세요.");
		$("input:text[name='m_phone']").focus();
		return false;
	}
	if( $("input:text[name='m_email']").val() == "" ){
		alert("담당자 정보(이메일)를 입력해주세요.");
		$("input:text[name='m_email']").focus();
		return false;
	}

	var gubunChk = false;
	var arr_gubun = document.getElementsByName("gubun[]");
	for(var i=0;i<arr_gubun.length;i++){
		if(arr_gubun[i].checked == true) {
			gubunChk = true;
			break;
		}
	}
	if( gubunChk === false ){
		alert("구분을 선택해주세요.");
		$("input:radio[name='gubun[]']").eq(0).focus();
		return false;
	} 	
	
	if( $("input:radio[name='absYn']").is(":checked") == false ){
		alert("초록집 광고를 입력해주세요.");
		$("input:radio[name='absYn']").eq(0).focus();
		return false;
	} 

	if( $("input:text[name='list1']").val() == "" ){
		alert("전시 및 주 취급품목을 입력해주세요.");
		$("input:text[name='list1']").focus();
		return false;
	} 

	if( $("input:text[name='pay_name']").val() == "" ){
		alert("수령인을 입력해주세요.");
		$("input:text[name='pay_name']").focus();
		return false;
	} 
	if( $("input:text[name='pay_email']").val() == "" ){
		alert("발행 이메일을 입력해주세요.");
		$("input:text[name='pay_email']").focus();
		return false;
	} 
	if( $("input:text[name='s_pay_date']").val() == "" ){
		alert("발행일을 입력해주세요.");
		$("input:text[name='s_pay_date']").focus();
		return false;
	} 
	
	if(!confirm('등록하시겠습니까?')){
		return false;
	}
	
}

function price_make(){

	if($("input:radio[name='gubun[]']:checked").val()=='8'){
		$("#absYn_N").prop('disabled',true);
	}else{
		$("#absYn_N").prop('disabled',false);
	}
	
	var chkbox = $("input:radio[name='gubun[]']");
	var cate = Array();
	var send_cnt = 0;

	var chkbox1 = $("input:radio[name='absYn']");
	var cate1 = Array();
	var send_cnt1 = 0;

	var price =0;
	var price1 =0;

	for(i=0;i<chkbox.length;i++) {
		if (chkbox[i].checked == true){
			cate[send_cnt] = chkbox[i].dataset.price;
			price += Number(cate[send_cnt]);
			send_cnt++;
		}
	}

	for(i=0;i<chkbox1.length;i++) {
		if (chkbox1[i].checked == true){
			cate1[send_cnt1] = chkbox1[i].dataset.price;
			price += Number(cate1[send_cnt1]);
			send_cnt1++;
		}
	}
	
	$("#price_text").html(comma(price));	
	$("#price").val(price);
	
}