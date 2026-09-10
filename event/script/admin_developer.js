$(document).ready(function(){
	
	// 텍스트 박스에 앞뒤 공백을 없애준다.
	$("input[type='text']").blur(function(){
		$(this).val( $.trim( $(this).val() ) );
	});
	
	// datepicker
	jQuery(function(a){a.datepicker.regional.ko={closeText:"닫기",prevText:"이전달",nextText:"다음달",currentText:"오늘",monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],monthNamesShort:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayNames:["일","월","화","수","목","금","토"],dayNamesShort:["일","월","화","수","목","금","토"],dayNamesMin:["일","월","화","수","목","금","토"],weekHeader:"Wk",dateFormat:"yy-mm-dd",firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:"년"};a.datepicker.setDefaults(a.datepicker.regional.ko)});
	$('#sdate, #edate, .date, .sdate, .edate').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: "yy-mm-dd", yearRange: 'c-98:c+3'}).on("change", function() {
		$(this).mask("9999-99-99");
	});
	
	$("#all_check").click(function(){
		var status = $(this).is(":checked");
		if(status){
			$("input:checkbox[name='check_list[]']").prop("checked",true);
		}else{
			$("input:checkbox[name='check_list[]']").prop("checked",false);
		}
	});
	
	$(".change_status").change(function(){
		var ori_value = $(this).attr("ori_data")
		var value     = $(this).val();
		var sid       = $(this).attr("data");
		
		if(confirm("정말 변경하시겠습니까?")){
			$.post("/admin/member/handle/change_status.php", { value : value, sid : sid, field : "status" }, function(data){
				alert(data);
				location.reload(); 
			});
		}else{
			$(this).val(ori_value);
		}
	});
	
	$(".btn_confirm").click(function(){
		var type = $(this).attr("type");
		var sid  = $(this).attr("sid");
		
		if(confirm("정말 승인하시겠습니까?")){
			$.post("/admin/member/handle/change_confirm.php", { type : type, sid : sid }, function(data){
				alert(data);
				location.reload(); 
			});
		}
	});
	
	$('a').on('click',function(){
		if($(this).hasClass('bg_a')){
			return false;
		}
	});

	$('a.bg_a').each(function(i){
		var $thisObj = $(this),
			this_target = $thisObj.attr('a_target'),
			this_link = $thisObj.attr('href'),
			pw = 0, ph = 0;

		if($thisObj.parents('td').length>0){
			$thisObj.parents('td').addClass('atarget_td');

			$thisObj.parents('td').on('click',function(){
				if(this_target=='popup'){
					//팝업으로 열경우
					if($thisObj.attr('pw')*1 > 0) pw = $thisObj.attr('pw')*1;
					if($thisObj.attr('ph')*1 > 0) ph = $thisObj.attr('ph')*1;

					window.open(this_link, "popup", "left=10,top=10,width="+pw+",height="+ph+",resizable=yes,toolbar=no,location=no,status=no");
					return false;
				}else{
					location.href=this_link;
				}
			});

			$thisObj.on('click',function(){
				if(this_target=='popup'){
					//팝업으로 열경우
					if($thisObj.attr('pw')*1 > 0) pw = $thisObj.attr('pw')*1;
					if($thisObj.attr('ph')*1 > 0) ph = $thisObj.attr('ph')*1;

					window.open(this_link, "popup", "left=10,top=10,width="+pw+",height="+ph+",resizable=yes,toolbar=no,location=no,status=no");
					return false;
				}else{
					location.href=this_link;
				}
			});
		}else{
			$thisObj.on('click',function(){
				if(this_target=='popup'){
					//팝업으로 열경우
					if($thisObj.attr('pw')*1 > 0) pw = $thisObj.attr('pw')*1;
					if($thisObj.attr('ph')*1 > 0) ph = $thisObj.attr('ph')*1;

					window.open(this_link, "popup", "left=10,top=10,width="+pw+",height="+ph+",resizable=yes,toolbar=no,location=no,status=no");
					return false;
				}else{
					location.href=this_link;
				}
			});

			$thisObj.on('click',function(){
				if(this_target=='popup'){
					//팝업으로 열경우
					if($thisObj.attr('pw')*1 > 0) pw = $thisObj.attr('pw')*1;
					if($thisObj.attr('ph')*1 > 0) ph = $thisObj.attr('ph')*1;

					window.open(this_link, "popup", "left=10,top=10,width="+pw+",height="+ph+",resizable=yes,toolbar=no,location=no,status=no");
					return false;
				}else{
					location.href=this_link;
				}
			});
		}
	});
});

function check_action(mode){
	
	if( $("input:checkbox[name='chk_num[]']").is(":checked") == false ){
		alert("선택된 회원이 없습니다.");
		return false;
	}else{
		var get_text = "";
		$("input:checkbox[name='chk_num[]']:checked").each(function(){
			get_text += "&chk_num[]="+$(this).val();
		});
		location.href="/admin/member/handle/check_action.php?mode="+mode+get_text;
	}
	
}

function empty_check(inputname, rtext, formname){
	var inputType = $(formname).find('input[name="'+inputname+'"]').attr('type'), selectType = 'input', noneText = false;

	if(!inputType){
		selectType = $(formname).find('[name="'+inputname+'"]')[0]['nodeName'];
	}else{
		if(inputType!='text') noneText = true;
	}

	if(inputType=='password'||inputType=='hidden') noneText = false;

	if(!noneText){
		if( !$.trim($(formname).find(selectType+'[name="'+inputname+'"]').val()) ){
			alert(rtext);
			$(formname).find(selectType+'[name="'+inputname+'"]').focus();
			return false;
		}else{
			return true;
		}
	}else{
		if( !$(formname).find(selectType+'[name="'+inputname+'"]').is(':checked') ){
			alert(rtext);
			$(formname).find(selectType+'[name="'+inputname+'"]').eq(0).focus();
			return false;
		}else{
			return true;
		}
	}
}

//탈퇴회원관리에서 회원복구를 위한함수
function recorvery_user(sid){
	
	if( sid == "" ){
		alert("비정상적 접근입니다.");
	}else{
		if(confirm("선택하신 회원을 복구하시겠습니까?")){
			location.href = "/admin/member/handle/recorvery.php?sid="+sid;
		}else{
			return;
		}
	}
	
}

//탈퇴회원관리에서 2차삭제를 위한함수
function del_user(sid){
	
	if( sid == "" ){
		alert("비정상적 접근입니다.");
	}else{
		if(confirm("선택하신 회원을 삭제하시겠습니까?")){
			location.href = "/admin/member/handle/del.php?sid="+sid;
		}else{
			return;
		}
	}
	
}