$(document).ready(function(){
	
	var width = screen.width;
	var height = screen.height;
	window.resizeTo(width,height);

	if(country=='K'){
		load_process = setInterval( function () {
			$("#session_checkin_area").load("session_button_load.php?day="+day+"&room="+room, function(response, status, xhr){
				if(status=='success'){
					if($('.CurTimes').length>0){
						var curTime = new Date();   
						var hours = ('0' + curTime.getHours()).slice(-2); 
						var minutes = ('0' + curTime.getMinutes()).slice(-2);
						$('.CurTimes').html(hours+' '+minutes);
					}
				}
			});
		}, 5000);
	}

	var notice = setInterval( function () {
		//긴급공지
		$.ajax({
			type : 'POST',
			url : 'ajax_notice.php',
			data:{ room_sid : room},
			success : function(msg) {
				var parse_data = JSON.parse(msg);
				var view_code = $('#Notice_key').val();
				if(parse_data.push!='N'){
					if(view_code!=parse_data.push){
						$(".Notice_Area").load("/play/notice.php?code="+parse_data.push+"&room_sid="+room);
						$('.Notice_Area').fadeIn();
						return false;
					}
				}else{
					//$('.Notice_Area').fadeOut();
				}
			}
		});
	}, 10000);

	/*var session_flow = setInterval( function () {
		$(".Session_Flow_Area").load("/play/load/session_flow.php?day="+day+"&room="+room);
	}, 10000);
	*/

	/*
	var session_detail = setInterval( function () {
		if($('.playMore').find("li").eq(0).attr("class")=='wide on'){
			$(".play_tech_area").load("/load/play/session_detail.php?day="+day+"&room_sid="+room);
		}
	}, 10000);
	*/

	/*var survey_chking = setInterval( function () {
		$.ajax({
			type : 'POST',
			url : '/play/load/survey_chking.php',
			success : function(data) {
				var parse_data = JSON.parse(data);
				var skey = $('#survey_key').val();
				if(parse_data.session_key!='N'){
					if($.trim(skey)!=parse_data.session_key){
						$('#survey_key').val(parse_data.session_key);
						$('.iframe_survey').trigger('click');
						
					}
				}
			}
		});
	}, 10000);*/

	//alert($('.Notice_Area:visible').length);
	//$('.iframe_survey').trigger('click');
	
	$(document).on("click",".send_question",function(){	
		if($('#fsid').length>0){
			if(!$('#fsid').val()){
				alert("Please select a author\n질문하실 연자를 선택해주세요");
				return false;
			}
		}
		if(!$('#session_question').val()){
			alert("Please enter your question\n질문하실 내용을 입력해주세요");
			return false;
		}
		var params = $("#QuestionF").serialize();
		jQuery.ajax({
			url: '/load/play/question_reg.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				alert("Your question has been sent\n질문이 전달되었습니다.");
				$('#fsid').val('');
				$('#session_question').val('');
				//viewer_area('question');
			}, error: function (request,status,error){
				alert('Question forwarding is not valid\n질문 전달이 정상적으로 되지 않았습니다.');
				return false;
			}
		});
		return false;
	});

	$(document).on("click",".send_tech",function(){	
		if(!$('#tech_question').val()){
			alert("Please enter your technical question\n내용을 입력해주세요");
			return false;
		}
		var params = $("#techF").serialize();
		jQuery.ajax({
			url: 'tech_send_reg.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				alert("Your technical question has been sent\n문의사항이 전달되었습니다.");
				$('#tech_question').val('');
				viewer_area('tech');
			}, error: function (request,status,error){
				alert('technical Question forwarding is not valid\n질문 전달이 정상적으로 되지 않았습니다.');
				return false;
			}
		});
		return false;
	});

});



function none(e) {
	var out_chking = $('#out_chking').val();
	if(out_chking=='Y'){
		(new Image()).src = "room_out.php?room="+room+"&day="+day+"&key_val="+key_val;
	}
}



function send_voting(voting){
	$.ajax({
		type:"POST",
		url:"voting_send_reg.php",
		data:{ voting : voting, room : room },
		async: false,
		success:function(msg){
			var parse_data = JSON.parse(msg);
			if(parse_data.push=='3'){
				alert("There are currently no active voting\n현재 진행중인 보팅이 없습니다.");
			}else if(parse_data.push=='2'){
				alert("The submitted voting results have been changed.\n제출하신 보팅결과를 변경하였습니다.");
			}else if(parse_data.push=='1'){
				alert("Has been involved.\n보팅결과가 제출되었습니다.");
			}
			// $(".play_tech_area").load("/load/play/voting.php");
			viewer_area('voting');
			
		}
	});
}

function session_checkin(){
	if($('.inout_txt').html()=="Waiting.."){
		alert("잠시 기다려주세요");
		return false;
	}
	$('.inout_txt').html("Waiting..");
	
	$.ajax({
		type:"POST",
		url:"checkin.php",
		data:{ day : day, room : room, key_val : key_val },
		async: true,
		success:function(msg){
			data = JSON.parse(msg);
			if(data.inout=='In'){
				alert("입장 시간이 기록되었습니다.");
			}else if(data.inout=='Out'){
				alert("체류 시간이 기록되었습니다.");
			}else if(data.inout=='Final'){
				alert("시청해주셔서 감사합니다.");
				location.href="/enter.html";
			}else{
				alert("퇴장 시간이 업데이트 되었습니다.");
			}
		}
	});	
}
function channel_select(){
	if(confirm("강의장을 이동 하시겠습니까? ")){
		$('#out_chking').val('N');
		$.ajax({
			type:"POST",
			url:"room_out.php",
			data:{ key_val : key_val, day : day, room : room },
			async: false,
			success:function(msg){
				location.href="room_selection.php?befor_room="+room;
			}
		});
	}
}
function location_hall(){
	
	$('#out_chking').val('N');
	$.ajax({
		type:"POST",
		url:"room_out.php",
		data:{ key_val : key_val, day : day, room : room },
		async: false,
		success:function(msg){
			opener.location.href="/enter/";
			self.close();
		}
	});
}
function session_close(room){
	var alert_txt = "세션이 종료되었습니다.\n종료하시는 시점으로 퇴장시간이 최종 기록됩니다.\n종료하고 창을 닫으시겠습니까?";
	if(confirm(alert_txt)){
		$('#out_chking').val('N');
		$.ajax({
			type:"POST",
			url:"room_out.php",
			data:{ key_val : key_val, day : day, room : room },
			async: false,
			success:function(msg){
				// self.close();
				location.href="/session/";
			}
		});
	}
}
function room_close(kind){
	if(kind=='exit'){
		if(confirm("퇴장하시는 시점으로 \n현재 진행중인 세션의 퇴장시간이 최종 기록됩니다.\n진행중인 세션 종료전까지 재입장하여 강의를 이어들으시면 \n체류시간은 연장됩니다.\n종료하고 창을 닫으시겠습니까?")){
			$('#out_chking').val('N');
			$.ajax({
				type:"POST",
				url:"room_out.php",
				data:{ key_val : key_val, day : day, room : room },
				async: false,
				success:function(msg){
					// self.close();
					location.href="/session/";
				}
			});
		}
	}else if(kind=='selection'){
		if(confirm("Would you like to move another session?\nYou will be moved to the session selection page.")){
			$('#out_chking').val('N');
			$.ajax({
				type:"POST",
				url:"room_out.php",
				data:{ key_val : key_val, day : day, room : room },
				async: false,
				success:function(msg){
					// opener.location.href="/session/";
					// self.close();
					location.href="/session/";
					
				}
			});
		}
	}
}



function room_refresh(){
	$('#out_chking').val('N');
	$.ajax({
		type:"POST",
		url:"room_out.php",
		data:{ key_val : key_val, day : day, room : room },
		async: false,
		success:function(msg){
			location.reload();
		}
	});
}

function going_room(next_room){
	if(confirm("Would you like to move another session?\nYou can move If you click ‘Confirm’.\n(It will be record of leaving).")){
		$('#out_chking').val('N');
		$.ajax({
			type:"POST",
			url:"room_out.php",
			data:{ key_val : key_val, day : day, room : room },
			async: false,
			success:function(msg){
				location.href="index.php?room_sid="+next_room;
			}
		});
	}
}
function Notice_Close(code){
	
	//$('.Notice_Area').fadeOut();
	$('div.Notice_Area').fadeOut()
	if(code){
		setCookie(code, '1', '1');	
	}
	return;
}

function session_none(){
	alert("현재세션은 평점이 없는 세션으로 입/퇴장이 없습니다.");
	return false;
}
function session_ready(){
	alert("세션2 입장은 13시부터 가능합니다.");
	return false;
}

function currently_air(){
	$(".otherRoom").load("/load/play/session_ing.php");
	$('.otherRoom').fadeIn();
}

$(function(){
	if($('.load_area').length>0){
		$(document).on("click",".load_area",function(){

			$(this).closest("ul").find("li").removeClass("on");
			$(this).closest("li").addClass("on");

			var kind = $(this).attr('id');
			if(kind=='program'){
				$(".play_tech_area").load("/load/play/session_detail.php?day="+day+"&room_sid="+room);
			}else if(kind=='question'){
				$(".play_tech_area").load("/load/play/question.php?room_sid="+room);
			}else if(kind=='voting'){
				$(".play_tech_area").load("/load/play/voting.php?room_sid="+room);
			}else if(kind=='chat'){
				$(".play_tech_area").load("/load/play/chatting.php?room_sid="+room);
			}
		});
	}
	$('#agree_chk').on('click',function(){
		if($(this).is(':checked')==true){
			$(this).parent().addClass("on");
		}else{
			$(this).parent().removeClass("on");
		}
	});

	$('#agree_confirm').on('click',function(){
		if($('#agree_chk').is(':checked')==false){
			alert("주의사항에 동의해주세요.\nPlease agree to the notice");
			return false;
		}else{
			var agree_day = "agree_day"+day+"_"+room;
			setCookie(agree_day, '1', '1');
			$('.layerPopup').hide();
		}
	});

});

function break_time(){
	alert("다음세션은 15분전부터 입장이 가능합니다.");
	// return false;
}

