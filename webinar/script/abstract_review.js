$(document).ready(function(){
	
});
function number_format(n, width) {
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}

function score(){
	var answer_length = $('.answer_box').length;
	var total = 0;

	for($i=1;$i<=answer_length;$i++){
		if($('input[name="score'+$i+'"]').is(':checked') !== false){
			total += Number($('input[name="score'+$i+'"]:checked').val());
		}
	}

	var total_score = number_format(total, 2);

	$('#total_score').val(total_score);
	$('.score_txt').html(total_score);
}

function review_check(f){
	
	if( $("input:radio[name='score1']").is(":checked") == false ){
		alert("Please check Research Accomplishment.");
		$("input:radio[name='score1']").eq(0).focus();
		return false;
	}

	if( $("input:radio[name='score2']").is(":checked") == false ){
		alert("Please check Originality.");
		$("input:radio[name='score2']").eq(0).focus();
		return false;
	}

	if( $("input:radio[name='score3']").is(":checked") == false ){
		alert("Please check Concrete & Logicality.");
		$("input:radio[name='score3']").eq(0).focus();
		return false;
	}

	if( $("input:radio[name='score4']").is(":checked") == false ){
		alert("Please check Practicality.");
		$("input:radio[name='score4']").eq(0).focus();
		return false;
	}

	if( $("input:radio[name='score5']").is(":checked") == false ){
		alert("Please check Contribution to Scientific Field.");
		$("input:radio[name='score5']").eq(0).focus();
		return false;
	}

	if( $("#bunya_Yn").val()=='Y' ){
		if( $("input:radio[name='bunya']").is(":checked") == false ){
			alert("Please check 분야선택.");
			$("input:radio[name='bunya']").eq(0).focus();
			return false;
		}
	}

	if( $("input:radio[name='accom']").is(":checked") == false ){
		alert("Please check High Value Presentation 추천 여부.");
		$("input:radio[name='accom']").eq(0).focus();
		return false;
	}
}
