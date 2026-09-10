$(document).ready(function(){
/*	
	$("input:radio[name='category']").click(function(){
		var lang = $("input:hidden[name='check_lang']").val();
		if( lang == "KOR" ){
			if( $(this).val() == "2" || $(this).val() == "4" || $(this).val() == "6" || $(this).val() == "8" ){
				$("#regist_email_box").show();
				$(".btn_regist_email_check").show();
				$("#regist_email").attr("readonly",false).val("");
				$("input:hidden[name='mem_check']").val("N");
			}else{
				$("#regist_email_box").hide();
				$("#regist_email").attr("readonly",false).val("");
				$("input:hidden[name='mem_check']").val("N");
				$(".btn_regist_email_check").hide();
			}
		}
	});
*/	
	$("input:radio[name='pay_method']").click(function(){
		
		if( $(this).val() == "B" ){
			$(".B_box").show();
			$("#paygate_hidden_box").hide();
		}else{
			$(".B_box").hide();
			$(".B_box").find("input:text").val("");
			$("#paygate_hidden_box").show();
		}
		
	});
	
});

function getTimeStamp() {
  var d = new Date();
  var s =
	leadingZeros(d.getFullYear(), 4) + '' + leadingZeros(d.getMonth() + 1, 2) + '' + leadingZeros(d.getDate(), 2) + '' + leadingZeros(d.getHours(), 2) + '' + leadingZeros(d.getMinutes(), 2) + '' + leadingZeros(d.getSeconds(), 2);

  return s;
}

function leadingZeros(n, digits) {
	var zero = '';
	n = n.toString();

	if (n.length < digits) {
		for (i = 0; i < digits - n.length; i++)
			zero += '0';
	}
	return zero + n;
}

function regist_check(f){
	
	var lang = $("input:hidden[name='check_lang']").val();
	
	if( lang == "KOR" ){

		if( $("input:hidden[name='mem_check']").val() == "N" ){
			alert("회원구분 인증을 진행해주세요.");
			$("#name_kr").focus();
			return false;
		}
		
		if( $("input:radio[name='category']").is(":checked") == false ){
			alert("등록 구분을 선택해주세요.");
			$("input:radio[name='category']").eq(0).focus();
			return false;
		} 		
		/*
		var gubun_checked = $("input[name='gubun']").val();
		if(gubun_checked == '1'){
			alert("사전등록 불가합니다. 사무국으로 문의 부탁드립니다.");
			return false;
		}else if(gubun_checked == '3'){
			alert("연회비 미납 회원입니다. 사무국으로 문의 부탁드립니다.");
			return false;
		}
		*/

		if( $("input:radio[name='category']:checked").val() == '13' ){
			if( $("input:radio[name='regi_yearv']").is(":checked") == false ){
				alert("전공의 연차를 선택해주세요.");
				$("input:radio[name='regi_yearv']").eq(0).focus();
				return false;
			} 	
		}

		if( $("input:checkbox[name='agree']").is(":checked") == false ){
			alert("참가자확인동의서에 동의해주세요.");
			$("input:checkbox[name='agree']").eq(0).focus();
			return false;
		}
		
		if( $(f.price).val() > 0 ){
			if( $("input:radio[name='pay_method']").is(":checked") == false ){
				alert("결제수단을 선택해주세요.");
				$("input:radio[name='pay_method']").eq(0).focus();
				return false;
			}
			if( $("input:radio[name='pay_method']:checked").val() == "B" ){		
				
				$("#PGIOForm").attr("action","/registration/handle/upsert.php");
				$("#PGIOForm").attr("target","");

				if( $(f.send_name).val() == "" ){
					alert("송금자명을 입력해주세요.");
					$(f.send_name).focus();
					return false;
				}
				if( $(f.send_date).val() == "" ){
					alert("송금예정일을 입력해주세요.");
					$(f.send_date).focus();
					return false;
				}
			}else{
				if( $("input:hidden[name='my_admin']").val() == "Y" ){
					return true;
				}else{
					f_cert();
					return false;
				}
			}
		}
		
	}else{
		
		if( $("input:radio[name='category']").is(":checked") == false ){
			alert("Please select a category.");
			$("input:radio[name='category']").eq(0).focus();
			return false;
		}
		
		if( $("input:checkbox[name='agree']").is(":checked") == false ){
			alert("Please checked a Participant Release and License Agreement.");
			$("input:checkbox[name='agree']").eq(0).focus();
			return false;
		}
		
		if( $(f.price).val() > 0 ){
			if( $("input:radio[name='pay_method']").is(":checked") == false ){
				alert("Please select a payment method.");
				$("input:radio[name='pay_method']").eq(0).focus();
				return false;
			}			
			if( $("input:radio[name='pay_method']:checked").val() == "B" ){
				
				$("#PGIOForm").attr("action","/registration/handle/upsert.php");
				$("#PGIOForm").attr("target","");

				if( $(f.send_name).val() == "" ){
					alert("Please enter the name of the sender.");
					$(f.send_name).focus();
					return false;
				}
				if( $(f.send_date).val() == "" ){
					alert("Please enter the expected remittance date.");
					$(f.send_date).focus();
					return false;
				}
			}else{
				if( $("input:hidden[name='my_admin']").val() == "Y" ){
					return true;
				}else{
					var user_regnum = $('input[name="user_regnum"]').val();
					var new_ref_name = user_regnum+getTimeStamp();
					
					$('input[name="ref"]').val(new_ref_name);

					$(f).attr('action','/registration/eximbay/request.php'); //만들어진곳으로 연결
					payment();
				}
			}
		} 
		
	}
	
}

function mem_chk(){
	
	var mem_check = $("input:hidden[name='mem_check']").val();
	
	if( mem_check != 'Y' ){
		alert('회원구분 인증을 진행해주세요.');
		$('input[name="category"]').prop('checked', false);
		return false;
	}
	
}

function price_make(){
	
	var lang = $("input:hidden[name='check_lang']").val();
	var freeYn = $("input:hidden[name='freeYn']").val();

	if(freeYn == 'Y'){
		var price = 0;
	}else{	
		var price = $("input:radio[name='category']:checked").attr("data");
	}
	
	if( price == 0 ){
		$("#price_text").html("Free");
		$("#method_box").hide();
		$("#method_box").find("input:radio").attr("checked",false);
		$(".B_box").find("input:text").val("");
		$(".B_box").hide();
	}else{		
		$("#price_text").html((lang=="KOR"?"KRW":"USD")+" "+comma(price));
		$("#method_box").show();
		$(".B_box").show();
	}

	if(lang=="KOR"){
		$("input:hidden[name='EP_product_amt']").val(price); //결제에 넣음		
	}else{		
		$("input:hidden[name='amt']").val(price); //결제에 넣음
		$("input:hidden[name='item_0_unitPrice']").val(price); //결제에 넣음
	}
	
	$("#price").val(price);
	
}

function btn_regist_email_check(){
	
	var yearv =$("#yearv").val();
	var name_kr = $("#name_kr").val();
	var license_number = $("#license_number").val();
	var number = $("#sid").val();

	if( name_kr == "" ){

		alert("이름을 입력해주세요.");
		$("#name_kr").focus();
		return false;

	}else if( license_number == "" ){

		alert("의사면허번호를 입력해주세요.");
		$("#license_number").focus();
		return false;

	}else{

		$.ajax({
			type:"POST",
			url:"/registration/handle/mem_check.php",
			data:{
				'yearv' : yearv,
				'name_kr' : name_kr,
				'license_number' : license_number,
				'number' : number
			},
			dataType: 'json',
			async: false,
			success:function(r){
				if(!r._return){
					alert(r.msg);
					$('input[name="mem_check"]').val('N');
					$('input[name="gubun"]').val('');
					$('input[name="mem_chk1"]').val('N');
					$('#mem_chk1_txt').val('');
					$('input[name="mem_chk2"]').val('N');
					$('#mem_chk2_txt').val('');
					$('input[name="category"]').attr('disabled', true);
				}else{
					alert(r.msg);
					$("#name_kr").attr("readonly",true);
					$("#license_number").attr("readonly",true);
            		$("input:hidden[name='mem_check']").val("Y");
					$('input[name="gubun"]').val(r.gubun);
					$('input[name="mem_chk1"]').val(r.mem_chk1);
					if(r.mem_chk1 == 'Y'){
						$('#mem_chk1_txt').html("<b>"+r.mem_chk1_txt+"<b>");
					}else{
						$('#mem_chk1_txt').html("<b class='fcRed'>"+r.mem_chk1_txt+"<b>");
					}
					$('input[name="mem_chk2"]').val(r.mem_chk2);
					if(r.mem_chk2 == 'Y'){
						$('#mem_chk2_txt').html("<b>"+r.mem_chk2_txt+"<b>");
					}else{
						$('#mem_chk2_txt').html("<b class='fcRed'>"+r.mem_chk2_txt+"<b>");
					}
					$('input[name="mem_chk3"]').val(r.mem_chk2);
					if(r.mem_chk3 == 'Y'){
						$('#mem_chk3_txt').html("<b>"+r.mem_chk3_txt+"<b>");
					}else{
						$('#mem_chk3_txt').html("<b class='fcRed'>"+r.mem_chk3_txt+"<b>");
					}
            		$(".btn_regist_email_check").hide();
					$('input[name="category"]').attr('disabled', true);
					$('.regident_yearv').hide();

					if(r.gubun == '1' || r.gubun == '3'){

					}else if(r.gubun == '2'){						
						$('input[id="category_1"]').attr('disabled', false);
						$('input[id="category_3"]').attr('disabled', false);
						$('input[id="category_5"]').attr('disabled', false);
						$('input[id="category_7"]').attr('disabled', false);
						$('input[id="category_9"]').attr('disabled', false);
						$('input[id="category_11"]').attr('disabled', false);
					}else if(r.gubun == '4'){						
						$('input[id="category_2"]').attr('disabled', false);
						$('input[id="category_4"]').attr('disabled', false);
						$('input[id="category_6"]').attr('disabled', false);
						$('input[id="category_8"]').attr('disabled', false);
						$('input[id="category_10"]').attr('disabled', false);
						$('input[id="category_12"]').attr('disabled', false);
					}else if(r.gubun == '5'){						
						$('.regident_yearv').show();
						$('input[id="category_13"]').attr('disabled', false);
					}
				}
			}
		});
		return false;

	}	
	
}

function startPay(){
	var left=$("body").width()/2;
	var top=$(window).scrollTop()+100;
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();

	doTransaction(document.PGIOForm);
	$("#PGIOscreen").show();
}

function getPGIOresult() {
	var replycode = document.PGIOForm.elements['replycode'].value;
	var replyMsg = document.PGIOForm.elements['replyMsg'].value;
	
	if( replycode == "0000" ){
		alert("결제가 완료되었습니다.");
		$("#PGIOForm").attr("onsubmit","return true");
		$("#PGIOForm").submit();
	}else{
		$("#PGIOscreen").hide();
		$("input:hidden[name='replycode']").val("");
		$("input:hidden[name='replyMsg']").val("");
		$("input:hidden[name='tid']").val("");
		$("#PGIOForm").find("input:hidden[name^='card']").val("");
		alert(replyMsg);
	}
}