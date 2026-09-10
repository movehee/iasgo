$(document).ready(function(){
	// datepicker
	jQuery(function(a){a.datepicker.regional.ko={closeText:"닫기",prevText:"이전달",nextText:"다음달",currentText:"오늘",monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],monthNamesShort:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayNames:["일","월","화","수","목","금","토"],dayNamesShort:["일","월","화","수","목","금","토"],dayNamesMin:["일","월","화","수","목","금","토"],weekHeader:"Wk",dateFormat:"yy-mm-dd",firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:"년"};a.datepicker.setDefaults(a.datepicker.regional.ko)});
	$('.c_datepicker').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: "yymmdd", yearRange: 'c-100:c+10'});
	
	$("#all_agree").click(function(){
		
		$("input:radio[name='agree1'][value='Y']").attr("checked",true);
		$("input:radio[name='agree2'][value='Y']").attr("checked",true);
		
	});
});


//학술대회 참석 확인 유효성검사
function confirm_check(f){
	
	if( $(f.name).val() == "" ){
		alert("이름을 입력해주세요");
		$(f.name).focus();
		return false;
	}
	
	if( $(f.license).val() == "" ){
		alert("면허번호를 입력해주세요");
		$(f.license).focus();
		return false;
	}
	
	return true;
}

//사전등록 다음 우편번호 검색
function openDaumPostcode(){

	new daum.Postcode({
		oncomplete: function(data) {
			$(":text[name='zipcode']").val(data.zonecode);
			$(":text[name='addr1']").val(data.address).focus();
		}
	}).open();
}

function make_regist_price(text,price){
	
	$("#price_text").html(text+"원");
	$("#price").val(price);
	
}

function c_regist_check(){
	
	if( $("input[name='agree']").is(":checked") == false ){
		alert("약관의 동의해주세요.");
		$("input[name='agree']").focus();
		return false;		
	};
	
	if( $("input[name='name']").val() == "" ){
		alert("이름을 입력해주세요.");
		$("input[name='name']").focus();
		return false;		
	};
	
	if( $("input[name='license']").val() == "" ){
		alert("면허번호를 입력해주세요.");
		$("input[name='license']").focus();
		return false;		
	};
	
	if( $("input[name='type']").val() == "N" ){
		
		$("input[name='uid']").val( "offLine_"+$("input[name='license']").val() );
		
	}
	
	if( $("input[name='birth']").val() == "" ){
		alert("생년월일을 입력해주세요.");
		$("input[name='birth']").focus();
		return false;		
	};
	
	if( $("input:radio[name='sex']").is(":checked") == false ){
		alert("성별을 선택해주세요.");
		$("input:radio[name='sex']").focus();
		return false;		
	};
	
	if( $("select[name='mobile1']").val() == "" || $("input[name='mobile2']").val() == "" || $("input[name='mobile3']").val() == "" ){
		alert("휴대폰 번호를 입력해주세요.");
		$("select[name='mobile1']").focus();
		return false;		
	};
	
	if( $("input[name='email']").val() == "" ){
		alert("이메일을 입력해주세요.");
		$("input[name='email']").focus();
		return false;		
	};
	
	if( $("input[name='office']").val() == "" ){
		alert("근무처명을 입력해주세요.");
		$("input[name='office']").focus();
		return false;		
	};
	
	// if( $("input[name='branch1']").val() == "" ){
		// alert("소속지부를 입력해주세요.");
		// $("input[name='branch1']").focus();
		// return false;		
	// };
// 	
	// if( $("input[name='branch2']").val() == "" ){
		// alert("소속분회를 입력해주세요.");
		// $("input[name='branch2']").focus();
		// return false;		
	// };
// 	
	// if( $("input[name='zipcode']").val() == "" ){
		// alert("우편번호를 입력해주세요.");
		// $("input[name='zipcode']").focus();
		// return false;		
	// };
// 	
	// if( $("input[name='addr1']").val() == "" ){
		// alert("주소를 입력해주세요.");
		// $("input[name='addr1']").focus();
		// return false;		
	// };
	
	if( $("input:radio[name='reg_type']").is(":checked") == false ){
		alert("등록구분을 선택해주세요.");
		$("input:radio[name='reg_type']").focus();
		return false;		
	};
	
	if( $("input:radio[name='method']").is(":checked") == false ){
		alert("결제방법을 선택해주세요.");
		$("input:radio[name='method']").focus();
		return false;		
	};
	
	if( $("input[name='price']").val() == "" || $("input[name='price']").val() == "0" ){
		alert("등록비가 0원입니다. 다시 확인 해주시기 바랍니다.");
		$("input[name='price']").focus();
		return false;		
	};
	
	return true;
	
}