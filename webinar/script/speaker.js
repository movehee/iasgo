$(document).ready(function(){
	
	$("select[name='country']").change(function(){
		
		var cnum = $(this).find("option:selected").attr("data");
		
		if( cnum ){
			$("input[name='phone_code']").val(cnum).attr("readonly",true);
			if(cnum == '82'){
				$('.kor_tr').show();	
				$('input:radio[name="useYn1"]').prop('checked',false);
				$('input:radio[name="useYn2"]').prop('checked',false);
			}else{
				$('.kor_tr').hide();	
				$('input:radio[name="useYn1"]').prop('checked',false);
				$('input:radio[name="useYn2"]').prop('checked',false);
			}
		}else{
			$("input[name='phone_code']").val("").attr("readonly",false);
		}
				
	});
	
});


function check_title_length(id){
	
	toOneOpper(id);
	var value = $("#"+id).val();
	var value_split = value.split(' ');
	var value_length = 0;
	
	for( var i=0; i<value_split.length; i++ ){
		if(value_split[i]) value_length++;
	}
	
	if( value_length > 30 ){
		alert("The title should be less than 30 words.");
		var arr = value_split.splice(0, 30);
		var nSub = arr.join(" ");
		$("#"+id).val(nSub);
		$("#abs_title_length").html("30");
	}else{
		$("#abs_title_length").html(value_length);
	}
		
}

function abs_check(f){
	/*
	if( $(f.session_title).val() == "" ){
		alert("Please enter the Session Title.");
		$(f.session_title).focus();
		return false;
	}
	*/
	if( $(f.country).val() == "" ){
		alert("Please select the country.");
		$(f.country).focus();
		return false;
	}
	if( $(f.first_name).val() == "" ){
		alert("Please enter the  First name.");
		$(f.first_name).focus();
		return false;
	}
	if( $(f.last_name).val() == "" ){
		alert("Please enter the Last name.");
		$(f.last_name).focus();
		return false;
	}
	if( $(f.affiliation).val() == "" ){
		alert("Please enter the affiliation.");
		$(f.affiliation).focus();
		return false;
	}
	if( $(f.email).val() == "" ){
		alert("Please enter the Email.");
		$(f.email).focus();
		return false;
	}else{
		if(!isCorrectEmail($(f.email).val())){
	        alert('Email format is not valid.');
	        $(f.email).focus();
	        return false;
	    }
	}
	if( $(f.phone_code).val() == "" || $(f.phone).val() == "" ){
		alert("Please enter the Cell Phone No.");
		$(f.phone_code).focus();
		return false;
	}
	if( $("#cv_file").val() == "" && !$("#old_cv_file").val() ){
		alert("Please upload CV Upload");
		$("#cv_file").focus();
		return false;
	}

	/*
	if( $("input:radio[name='ptype']").is(":checked") == false ){
		alert("Please select the presentation type.");
		$("input:radio[name='ptype']").eq(0).focus();
		return false;
	}
	*/
	
	if( $(f.abs_title).val() == "" ){
		alert("Please enter a title.");
		$(f.abs_title).focus();
		return false;
	}
	
	/*
	data1 = CKEDITOR.instances.objectives.getData();
	
	var objectives_val = data1;
	objectives_val = data1.replace('<br />','');
	
	if (!objectives_val){
		alert('Please enter Body');
		return false;
	}
	if( han_check(objectives_val) ){
		alert('Please enter English only (Body).');
		return false;
	}
	
	if( $(f.words_cnt5).val() > 250 ){
		alert('The abstract must not exceed 250 words!');
        return false;
	}
	*/
	data1 = CKEDITOR.instances.objectives.getData();
	data2 = CKEDITOR.instances.methods.getData();
	data3 = CKEDITOR.instances.results.getData();
	data4 = CKEDITOR.instances.conclusions.getData();
	
	var objectives_val = data1;
	objectives_val = data1.replace('<br />','');

	var methods_val = data2;
	methods_val = data2.replace('<br />','');

	var results_val = data3;
	results_val = data3.replace('<br />','');

	var conclusions_val = data4;
	conclusions_val = data4.replace('<br />','');
	
	if (!objectives_val){
		alert('Please enter Body');
		return false;
	}
	if( han_check(objectives_val) ){
		alert('Please enter English only (Body).');
		return false;
	}
	/*
	if (!methods_val){
		alert('Please enter Methods');
		return false;
	}
	if( han_check(methods_val) ){
		alert('Please enter English only (Methods).');
		return false;
	}
	if (!results_val){
		alert('Please enter Results');
		return false;
	}
	if( han_check(results_val) ){
		alert('Please enter English only (Results).');
		return false;
	}
	if (!conclusions_val){
		alert('Please enter Conclusion');
		return false;
	}
	if( han_check(conclusions_val) ){
		alert('Please enter English only (Conclusion).');
		return false;
	}
	*/
	
	if( $(f.words_cnt5).val() > 250 ){
		alert('The abstract must not exceed 250 words!');
        return false;
	}

	if( $(f.country).val() == "Korea, Republic of" ){
		if( $("input:radio[name='useYn1']").is(":checked") == false ){
			alert("개인노트북 사용 여부를 선택해주세요.");
			$("input:radio[name='useYn1']").eq(0).focus();
			return false;
		}
		if( $("input:radio[name='useYn2']").is(":checked") == false ){
			alert("강의 슬라이드 내 동영상 유무를 선택해주세요.");
			$("input:radio[name='useYn2']").eq(0).focus();
			return false;
		}
	}

	if( $("input:checkbox[name='agree']").is(":checked") == false ){
        alert("Please checked to Speaker Release and License Agreement.");
        $("input:checkbox[name='agree']").eq(0).focus();
        return false;
    }

/*
	if( $("input:radio[name='review_yn']").is(":checked") == false ){
        alert("Please select Yes or No regarding to change your presentation type.");
        $("input:radio[name='review_yn']").eq(0).focus();
        return false;
    }
    if( $("input:radio[name='agree_yn']").is(":checked") == false ){
        alert("Please select Yes or No regarding to Copyright Agreement");
        $("input:radio[name='agree_yn']").eq(0).focus();
        return false;
    }

	if( $("#a_file1").val() == "" && !$("#old_a_file1").val() ){
		alert("Please upload a Figures 1");
		$("#a_file1").focus();
		return false;
	}
*/	
}
