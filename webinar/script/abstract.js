$(document).ready(function(){
	
	//소속 제거
	$(document).on("click",".del_affi",function(){
		$(this).closest("table").remove();
		
		var count = $("#institution_count").val()-1;
		$("#institution_count").val( count );
		
		$("#p_affiliation_1 option:last").remove();
		$("#p_affiliation_2 option:last").remove();
		$("#c_affiliation_1 option:last").remove();
		$("#c_affiliation_2 option:last").remove();
		$("select[name='author_affi_1[]']").find("option:last").remove();
		$("select[name='author_affi_2[]']").find("option:last").remove();
		
		for( var i=1; i<=count; i++ ){
			$(".affi_num_text").eq(i-1).html(i);

			if( count == 1 ){
				$("#p_affiliation_2").prop("disabled", true);
				$("#c_affiliation_2").prop("disabled", true);
				$("select[name='author_affi_2[]']").val('').prop("selected",true).prop("disabled", true);
			}else{
				$("#p_affiliation_2").prop("disabled", false);
				$("#c_affiliation_2").prop("disabled", false);
				$("select[name='author_affi_2[]']").prop("disabled", false);
			}
		}
	});
	
	//저자 제거
	$(document).on("click",".del_author",function(){
		
		$(this).closest("tr").remove();
		
		var count = $("#author_count").val()-1;
		$("#author_count").val( count );
		
		for( var i=1; i<=count; i++ ){
			$(".author_num_text").eq(i-1).html(i);
			$("input:radio[name^='p_author']").eq(i-1).attr("name","p_author_"+i);
		}
		
	});
	
	$(document).on("click","input[name^='p_author_']",function(){
		$("input[name^='p_author_']").attr("checked",false);
		$(this).prop("checked",true);
		
		var first_name = $(this).closest("tr").find("input[name='author_firstname[]']").val();
		var last_name = $(this).closest("tr").find("input[name='author_lastname[]']").val();
		var affi_1 = $(this).closest("tr").find("select[name='author_affi_1[]']").val();
		var affi_2 = $(this).closest("tr").find("select[name='author_affi_2[]']").val();
		
		$("#p_last_name").val(last_name);
		$("#p_first_name").val(first_name);
		$("#p_affiliation_1").val(affi_1);
		$("#p_affiliation_2").val(affi_2);
	});
	
	$(document).on("click","input[name^='c_author_']",function(){
		$("input[name^='c_author_']").attr("checked",false);
		$(this).prop("checked",true);
		
		var first_name = $(this).closest("tr").find("input[name='author_firstname[]']").val();
		var last_name = $(this).closest("tr").find("input[name='author_lastname[]']").val();
		var affi_1 = $(this).closest("tr").find("select[name='author_affi_1[]']").val();
		var affi_2 = $(this).closest("tr").find("select[name='author_affi_2[]']").val();
		
		$("#c_last_name").val(last_name);
		$("#c_first_name").val(first_name);
		$("#c_affiliation_1").val(affi_1);
		$("#c_affiliation_2").val(affi_2);
	});
	
	$("select[name='p_country'], select[name='c_country']").change(function(){
		
		var cnum = $(this).find("option:selected").attr("data");
		var gubun = $(this).attr("data");
		
		if( cnum ){
			$("input[name='"+gubun+"_phone_code']").val(cnum).attr("readonly",true);
		}else{
			$("input[name='"+gubun+"_phone_code']").val("").attr("readonly",false);
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

function make_institution(){
	
	var count = $("#institution_count").val();
	var i_length = $(".institution_box").length;
	
	//숫자로 재정의
	count    = Number(count);
	i_length = Number(i_length);
	
	if( count != i_length ){
		
		if( count > i_length ){
			$.ajax({
                type: 'POST',
                url: '/abstract/ajax/make_institution.php',
                data: { count : count, i_length : i_length },
                async: false,
                success: function(data) {
                	$("#institution_table").append(data);
                	
                	for( var i = i_length; i < count ; i++  ){
                		
                		if( count == 1 ){
                			$("#p_affiliation_2").prop("disabled", true);
		            		$("#c_affiliation_2").prop("disabled", true);
		            		$("select[name='author_affi_2[]']").prop("disabled", true);
                		}else{
							$("#p_affiliation_2").prop("disabled", false);
		            		$("#c_affiliation_2").prop("disabled", false);
		            		$("select[name='author_affi_2[]']").prop("disabled", false);
						}
                		
                		$("#p_affiliation_1").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                		$("#p_affiliation_2").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                		$("#c_affiliation_1").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                		$("#c_affiliation_2").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                		$("select[name='author_affi_1[]']").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                		$("select[name='author_affi_2[]']").append("<option value="+(i+1)+">"+(i+1)+"</option>");
                	}
                	
                }
	        });
		}else{
			for( var i = i_length; i > count ; i-- ){
				$(".institution_box").eq(i-1).remove();

				if( count == 1 ){
					$("#p_affiliation_2").prop("disabled", true);
					$("#c_affiliation_2").prop("disabled", true);
					$("select[name='author_affi_2[]']").val('').prop("selected",true).prop("disabled", true);
				}else{
					$("#p_affiliation_2").prop("disabled", false);
					$("#c_affiliation_2").prop("disabled", false);
					$("select[name='author_affi_2[]']").prop("disabled", false);
				}
				
				$("#p_affiliation_1 option[value='"+i+"']").remove();
				$("#p_affiliation_2 option[value='"+i+"']").remove();
				$("#c_affiliation_1 option[value='"+i+"']").remove();
				$("#c_affiliation_2 option[value='"+i+"']").remove();
				$("select[name='author_affi_1[]'] option[value='"+i+"']").remove();
				$("select[name='author_affi_2[]'] option[value='"+i+"']").remove();
			}
		}
		
	}
	
}

function make_author(){
	
	var count = $("#author_count").val();
	var a_length = $(".author_box").length;
	var i_length = $(".institution_box").length;
	
	//숫자로 재정의
	count    = Number(count);
	a_length = Number(a_length);
	
	if( count != a_length ){
		
		if( count > a_length ){
			$.ajax({
                type: 'POST',
                url: '/abstract/ajax/make_author.php',
                data: { count : count, a_length : a_length, i_length : i_length },
                async: false,
                success: function(data) {
                	$("#author_table").append(data);
                }
	        });
		}else{
			for( var i = a_length; i > count ; i-- ){
				$(".author_box").eq(i-1).remove();
			}
		}
		
	}
	
}

function move_author(f,mode){
	
	var target = $(f).closest("tr");
	var count = $("#author_count").val();
		
	if( mode == "down" ){
		target.next().after(target);
	}else{
		target.prev().before(target);
	}
	
	for( var i=1; i<=count; i++ ){
		$(".author_num_text").eq(i-1).html(i);
		$("input:radio[name^='p_author']").eq(i-1).attr("name","p_author_"+i);
	}

	$('.del_author:eq(0)').css("display","none");
	$('.del_author:not(:eq(0))').css("display","inline-block");
	
}

function abs_check(f){
	
	if( $("input:radio[name='ptype']").is(":checked") == false ){
		alert("Please select the presentation type.");
		$("input:radio[name='ptype']").eq(0).focus();
		return false;
	}
	/*
	if( $("input:radio[name='topic']").is(":checked") == false ){
		alert("Please select the topic.");
		$("input:radio[name='topic']").eq(0).focus();
		return false;
	}
	*/
	if( $(f.abs_title).val() == "" ){
		alert("Please enter a title for your abstract.");
		$(f.abs_title).focus();
		return false;
	}
	
	//소속
	var institution_count = $(f.institution_count).val();
	
	if( institution_count == "" ){
	    alert("Please select 'Number of institution'.");
	    $(f.institution_count).focus();
	    return false;
    }
    
    for( var i=0; i<institution_count; i++ ){
    	if( $("select[name='i_country[]']").eq(i).val() == "" ){
			alert("Please choose Country.");
			$("select[name='i_country[]']").eq(i).focus();
			return false;
		}
		if( $("input:text[name='department[]']").eq(i).val() == "" ){
			alert("Please enter Department.");
			$("input:text[name='department[]']").eq(i).focus();
			return false;
		}
		if( $("input:text[name='affiliation[]']").eq(i).val() == "" ){
			alert("Please enter Affiliation.");
			$("input:text[name='affiliation[]']").eq(i).focus();
			return false;
		}
		if( $("input:text[name='cs[]']").eq(i).val() == "" ){
			alert("Please enter City/Sate.");
			$("input:text[name='cs[]']").eq(i).focus();
			return false;
		}
		
	}
	
	//저자
	var author_count = $(f.author_count).val();
	
	if( author_count == "" ){
	    alert("Please select 'Number of author'.");
	    $(f.author_count).focus();
	    return false;
    }
    
    for( var i=0; i<author_count; i++ ){
    	if( $("input:text[name='author_firstname[]']").eq(i).val() == "" ){
			alert("Please enter First Name.");
			$("input:text[name='author_firstname[]']").eq(i).focus();
			return false;
		}
    	if( $("input:text[name='author_lastname[]']").eq(i).val() == "" ){
			alert("Please enter Last Name.");
			$("input:text[name='author_lastname[]']").eq(i).focus();
			return false;
		}
		if( $("select[name='author_affi_1[]']").eq(i).val() == "" ){
			alert("Please select the First institution.");
			$("input:text[name='author_affi_1[]']").eq(i).focus();
			return false;
		}
	}
	
	if( $("input:radio[name^='p_author_']:checked").length <= 0 ){
		alert('Please choose Presenting Author.');
		$("input:radio[name^='p_author_']").eq(0).focus();
		return false;
	}
	if( $("input:radio[name^='c_author_']:checked").length <= 0 ){
		alert('Please choose Corresponding Author.');
		$("input:radio[name^='c_author_']").eq(0).focus();
		return false;
	}
	if( $(f.p_first_name).val() == "" ){
		alert("Please enter the presenter First name.");
		$(f.p_first_name).focus();
		return false;
	}
	if( $(f.p_last_name).val() == "" ){
		alert("Please enter the presenter Last name.");
		$(f.p_last_name).focus();
		return false;
	}
	if( $(f.p_affiliation_1).val() == "" ){
		alert("Please select the presenter first affiliation.");
		$(f.p_affiliation_1).focus();
		return false;
	}
	if( $(f.p_country).val() == "" ){
		alert("Please select the presenter country.");
		$(f.p_country).focus();
		return false;
	}
	if( $("input:radio[name='p_category']").is(":checked") == false ){
		alert("Please select the presenter category.");
		$("input:radio[name='p_category']").focus();
		return false;
	}
	if( $(f.p_email).val() == "" ){
		alert("Please enter the presenter Email.");
		$(f.p_email).focus();
		return false;
	}else{
		if(!isCorrectEmail($(f.p_email).val())){
	        alert('Email format is not valid.');
	        $(f.p_email).focus();
	        return false;
	    }
	}
	if( $(f.p_phone_code).val() == "" || $(f.p_phone).val() == "" ){
		alert("Please enter the presenter Mobile.");
		$(f.p_phone_code).focus();
		return false;
	}
	if( $(f.c_first_name).val() == "" ){
		alert("Please enter the corresponding First name.");
		$(f.c_first_name).focus();
		return false;
	}
	if( $(f.c_last_name).val() == "" ){
		alert("Please enter the corresponding Last name.");
		$(f.c_last_name).focus();
		return false;
	}
	if( $(f.c_affiliation_1).val() == "" ){
		alert("Please select the corresponding first affiliation.");
		$(f.c_affiliation_1).focus();
		return false;
	}
	if( $(f.c_country).val() == "" ){
		alert("Please select the corresponding country.");
		$(f.c_country).focus();
		return false;
	}
	if( $("input:radio[name='c_category']").is(":checked") == false ){
		alert("Please select the corresponding category.");
		$("input:radio[name='c_category']").focus();
		return false;
	}
	if( $(f.c_email).val() == "" ){
		alert("Please enter the corresponding Email.");
		$(f.c_email).focus();
		return false;
	}else{
		if(!isCorrectEmail($(f.c_email).val())){
	        alert('Email format is not valid.');
	        $(f.c_email).focus();
	        return false;
	    }
	}
	if( $(f.c_phone_code).val() == "" || $(f.c_phone).val() == "" ){
		alert("Please enter the corresponding Mobile.");
		$(f.c_phone_code).focus();
		return false;
	}
	
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
		alert('Please enter Purpose');
		return false;
	}
	if( han_check(objectives_val) ){
		alert('Please enter English only (Purpose).');
		return false;
	}
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
	
	if( $(f.words_cnt5).val() > 250 ){
		alert('The abstract must not exceed 250 words!');
        return false;
	}
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
/*
	if( $("#a_file1").val() == "" && !$("#old_a_file1").val() ){
		alert("Please upload a Figures 1");
		$("#a_file1").focus();
		return false;
	}
*/	
}
