var ajax_sleep = false;
var ajax_sleep_content = "Please try again in a few minutes";

$(function() {


	//메인 notice 클릭
	$('dl.noticeBox  li.notice_fadein').click(function() { 
		
		if(!$("#popupBbs").find("div.bbsList").length) {
			$("#popupBbs").load("/main/get_notice.php");
		}
		$index = $(this).index() - 1;
		main_notice_show($index);
		 
	});

	//메인 notice 내부클릭
	$('#popupBbs').on("click", "div.mainLayer_noticeList li", function() {
		$("div.mainLayer_noticeList li").removeClass("on");
		$(this).addClass("on");		

		$index = $(this).index();

		$("div.popupCon dl.bbsCon").hide();		
		$("div.popupCon dl.bbsCon").eq($index).show();
	});
	
	
	//Glance live 클릭
	$('.wrapper').on("click", ".onair_area", function() {
		var room = $(this).closest("td").find("input[type='hidden']").val() - 1;
		location.href = "/live/view.php?room=" + room
	});

	//브로슈어 다운
	$("a.brochure_down").on("click", function() {
		
		var booth_sid = $(this).attr("booth_sid");
		var b_sid = $(this).attr("b_sid");
		var href = $(this).attr('href');
		$.ajax({
			data: {booth_sid: booth_sid, b_sid: b_sid},
			type: "POST",
			url: "/booth/brochure_down_proc.php", 
			success: function(data) {
				if(data == "Y") {
					window.open(href,'_blank');
				}
			},
			error: function(request,status,error){
				return false;
			}

		});

		return false;
	});
	
	//부스 동영상 클릭 #aocc전용
	$("a.booth_vod_view").on("click", function() {
		var sid = $(this).attr('sid');
		$.ajax({
			data: {booth_sid: sid, kind:'m'},
			type: "POST",
			url: "/booth/booth_log_proc.php", 
			success: function(data) {
				if(data == "Y") {
					alert("completed.");
				}
			},
			error: function(request,status,error){
				return false;
			}

		});
	});
	
	//부스 페이지 방문 #aocc전용
	$("a.booth_page_view").on("click", function() {
		var sid = $(this).attr('sid');
		var href = $(this).attr('href');

		$.ajax({
			data: {booth_sid: sid, kind:'b'},
			type: "POST",
			url: "/booth/booth_log_proc.php", 
			success: function(data) {
				window.open(href, 'booth'+sid, 'width=1600, height=900, scrollbars=yes');
				return false;
			},
			error: function(request,status,error){
				return false;
			}

		});

		return false;
	});


	$(".vod_view_btn").on("click", function() {
		var session = $(this).attr("session");
		var session_detail = $(this).attr("session_detail");
		var vod_url = $(this).attr("vod_url");

		$.ajax({
			data: {session: session, session_detail:session_detail},
			type: "POST",
			dataType: "JSON",
			url: "/program/vod_log_reg.php", 
			success: function(data) {
				//console.log(data)
				if(data.success == 'Y') {
					popup_call('vod_view.php', 'vod_view', {vod_url: vod_url}, 1600, 900)
				} else {
					alert("Please try again.");
				}
			},
			error: function(request,status,error){
				return false;
			}

		});
	});
	

	//강의 시청 동의
	$("#live_agree_form").submit(function() {
		
		if($("#agree").is(":checked")) {
			
			var day = $("#param_day").val();
			var room = $("#param_room").val();
			var session = $("#param_session").val();
			var session_code = $("#param_session_code").val();

			$.ajax({
				data: {day: day, room: room, session: session, session_code: session_code, type: 'R'},
				type: "POST",
				dataType: "JSON",
				url: "/live/load/session_room_checkin.php", 
				success: function(data) {
					$('.layerPopup').hide();
				},
				error: function(request,status,error){
					return false;
				}

			});
			
			return false;

		} else {

			//var agree_lang = $("#agree").attr("agree_lang");
			//if(agree_lang == 'F') alert_msg = "Available after consent.";
			//else alert_msg = "동의하기를 선택해주세요.";

			alert("Available after consent.");
			return false;
		}
	});


	//룸 선택(이동)
	$("#room_move").on("click", function() {

		if(confirm("Are you sure you want to leave now?")) {
			//location.replace("/live/room.php");
			
			var day = $("#param_day").val();
			var room = $("#param_room").val();

			$.ajax({
				data: {day: day, room: room, type: "M"},
				type: "POST",
				dataType: "JSON",
				url: "/live/load/session_room_checkout.php", 
				success: function(data) {
					if(data.success == 'Y') {
						location.replace("/live/room.php");
					} else {
						alert("Please try again");
					}


				},
				error: function(request,status,error){
					return false;
				}

			});
		}
	});


	//세션 종료(이동)
	$("#room_out").on("click", function() {

		if(confirm("Are you sure you want to leave now?")) {

			
			var day = $("#param_day").val();
			var room = $("#param_room").val();
			$.ajax({
				data: {day: day, room: room, type: "E"},
				type: "POST",
				dataType: "JSON",
				url: "/live/load/session_room_checkout.php", 
				success: function(data) {
					if(data.success == 'Y') {
//						location.replace("/main/");
						location.replace("/live/room.php");
					} else {
						if(data.err) {
							alert(data.err)
						}
						alert(ajax_sleep_content);
					}


				},
				error: function(request,status,error){
					return false;
				}

			});
		}
	});

	//세션 입/퇴장
	$("#session_check_inout").on("click", function() {
		var day = $("#param_day").val();
		var room = $("#param_room").val();
		var session = $("#param_session").val();
		var session_code =  $("#param_session_code").val();
		var session_inout = $(this).attr("session_inout");

		if(!session_inout) {
			alert("입출가능한 세션이 없습니다.");
			return false;
		}

		$.ajax({
			data: {day: day, room: room, session: session, session_code:session_code, session_inout: session_inout, type: 'S'},
			type: "POST",
			dataType: "JSON",
			url: "/live/load/session_checkinout.php", 
			success: function(data) {
				//if(data.test) { alert(data.test) }
				//console.log(data)
				if(data.success == 'Y') {
					if(session_inout == "in") {
						
						$("#session_check_inout")
							.removeClass("in")
							.removeClass("out_chk")
							.addClass("out");
						$("#session_check_inout").attr("session_inout", "out");
						$("#session_inout_txt").text(data.session_inout_txt);

						if(data.s1_in) $("#s1_in").val(data.s1_in);
						else if(data.s2_in) $("#s2_in").val(data.s2_in);
						else if(data.s3_in) $("#s3_in").val(data.s3_in);
						else if(data.s4_in) $("#s4_in").val(data.s4_in);
						else if(data.s5_in) $("#s5_in").val(data.s5_in);
						else if(data.s6_in) $("#s6_in").val(data.s6_in);
						else if(data.s7_in) $("#s7_in").val(data.s7_in);


						alert("You are IN.");
					} else if(session_inout == "out") {
						if(data.session_next == 'Y') {

							$("#session_check_inout").attr("session_inout", "in");

							if(data.session_inout_txt) {
								$("#session_inout_txt").text(data.session_inout_txt);
							}

							if(data.session_name_txt) {
								$("#session_name_txt").text(data.session_name_txt);
							}

							if(data.param_session) {
								$("#param_session").val(data.param_session);
							}

							if(data.param_session_code) {
								$("#param_session_code").val(data.param_session_code);
							}
						}

						$("#session_check_inout")
							.removeClass("in")
							.removeClass("out")
							.addClass("out_chk");

						if(data.s1_out) $("#s1_out").val(data.s1_out);
						else if(data.s2_out) $("#s2_out").val(data.s2_out);
						else if(data.s3_out) $("#s3_out").val(data.s3_out);
						else if(data.s4_out) $("#s4_out").val(data.s4_out);
						else if(data.s5_out) $("#s5_out").val(data.s5_out);
						else if(data.s6_out) $("#s6_out").val(data.s6_out);
						else if(data.s7_out) $("#s7_out").val(data.s7_out);

						alert("퇴장 기록 되었습니다.\n최종 퇴장시에는 우측 HOME 버튼을 클릭 후 퇴장해 주시기 바랍니다.\nYou are Out.");
					}
				} else if(data.success == 'E') {
					alert("입/퇴장 할수 없는 강의입니다.");
				} else {
					alert(ajax_sleep_content);
				}
			},
			error: function(request,status,error){
				return false;
			}

		});
	});

	//강의 질문
	$("#lecture_question_form").submit(function() {
		if(!$("#question_content").val()) {
			alert("Please enter your question");
			return false;
		}

		if(ajax_sleep == false) {

			ajax_sleep = true;

			var day = $("#param_day").val();
			var room = $("#param_room").val();
			var session = $("#param_session").val();
			var session_code = $("#param_session_code").val();

			$.ajax({
				data:  $("#lecture_question_form").serialize() + "&day="+day+"&room="+room+"&session="+session+"&session_code="+session_code,
				type: "POST",
				dataType: "JSON",
				url: "/live/load/question_regist_proc.php", 
				success: function(data) {
					if(data.result == 'Y') {
						setTimeout(ajax_wake, 1000);
						$("#question_content").val("");
						$(".questionSend").toggle();
						alert("Your question has been sent.");
						return false;
					} else {
						
						alert("please try again.");
						ajax_sleep = false;
						return false;
					}

				},
				error: function(request,status,error){
					ajax_sleep = false;
				}

			});

			return false;

		} else {
			alert(ajax_sleep_content);
			return false;
		}


		
	});


	//voting
	$("#utilPopup_voting li > a").on("click", function() {

		var val = $(this).attr('q');
		var room = $("#param_room").val();

		$.ajax({
			type:"POST",
			url:"/live/load/voting.php",
			data:{ val : val, room : room },
			success:function(msg){
				if(msg=='1'){
					alert("Has been involved.");
				}else if(msg=='2'){
					alert("The submitted voting results have been changed");
				}else if(msg=='3'){
					alert("This session does not require voting.");
				}
			}
		});
	});


	//우측바 notice선택
	$("#r_notice, .c_notice").on("click", function() {

		if(!$("#popupBbs").find("div.bbsList").length) {
			$("#popupBbs").load("/main/get_notice.php");
		}
		main_notice_show(0);
		$("#popupBbs").show();
	});


	//onair
	$("#currently_onair_btn").on("click", function() {


		if($("#currently_onair").is(':visible')) {
			$('#currently_onair').fadeOut();
		} else {
	
			if(ajax_sleep == false) {

				var room = $("#param_room").val();
				ajax_sleep = true;

				$.ajax({
					data: {room: room},
					type: "POST",
					dataType: "TEXT",
					url: "/live/load/on_air.php", 
					success: function(data) {
						setTimeout(ajax_wake, 1000);
						$("#currently_onair dd.scrollArea").empty().append(data);
						$("#currently_onair").show();
					},
					error: function(request,status,error){
						ajax_sleep = false;
					}

				});

			} else {
				alert(ajax_sleep_content);
			}
			return false;

		}
	});

	$("#room_pag_btn").on("click", function() {

		
//		alert("");
	
		$("#popupProgramGlance").load("/upload/program.html");
		$("#popupProgramGlance").parent("div").show();
		return false;

		
	});

	
	
	//부스 클릭 #aocc전용
	$(".booth_open").on("click", function() {
		if(ajax_sleep == false) {
			
			var booth_sid = $(this).attr("booth_sid");
			ajax_sleep = true;

			$.ajax({
				data: {booth_sid: booth_sid},
				type: "POST",
				url: "/booth/visit_reg.php", 
				success: function(data) {

					ajax_sleep = false;

					if(data == "Y") {
						setTimeout(ajax_wake, 1000);
						return true;
					} else {
						return false;
					}
				},
				error: function(request,status,error){
					ajax_sleep = false;
					return false;
				}

			});


		} else {
			alert(ajax_sleep_content);
			return false;
		}
	});

	//비밀번호 찾기
	$("#find_pw").submit(function() {
		var user_id = $.trim($("#find_user_id").val());
		if(!user_id) {
			alert("Please enter your ID (E-mail)");
			$("#find_user_id").focus();
			return false;
		}

		if(ajax_sleep == false) {
			
			ajax_sleep = true;

			$.ajax({
				data: {user_id: user_id},
				type: "POST",
				url: "/find_proc.php", 
				dataType: "JSON",
				success: function(data) {

					setTimeout(ajax_wake, 1000);
				
					if(data.result == 'Y') {
						alert("Your Password has been sent.");
						$('#popupFindpwd').fadeOut();
						$("#find_user_id").val('');
						return false;
					} else if(data.result == 'N') {
						alert("No Data information!!");
						$("#find_user_id").select();
						return false;
					} else {
						//console.log(data.result)
						alert("please try again.");
						return false;
					}
				},
				error: function(request,status,error){
					ajax_sleep = false;
					return false;
				}

			});

			return false;


		} else {
			alert(ajax_sleep_content);
			return false;
		}
	});

	$("dl#eBooth").on("click", "a.eBooth_link", function() {
		var link = $("#b_link_" + $(this).attr("id")).val();
		window.open(link);
	});

	$('#goTop').click( function() {
		$('html, body').animate( { scrollTop : 0 }, 400 );
		return false;
	} );

	$('.favor_chk').click( function() {

		var $obj = $(this);
		var sid = $obj.data("sid");
		var kind = $obj.hasClass("on") ? "del" : "add";
	
		if(ajax_sleep == false) {
			
			ajax_sleep = true
		
			$.ajax({
				type: "POST",
				url: "/session/load/favor.php",
				data: "sid="+sid+"&kind="+kind+"&mode=list",
				success: function(data) {
					$obj.toggleClass("on");
					setTimeout(ajax_wake, 1000);
				},
				error: function(msg){
					ajax_sleep = false;
				}
			});

		} else {
			alert(ajax_sleep_content);
		}


	});

});


function ajax_wake() {
	ajax_sleep = false;
}

function setCookie(name, value, expiredays) {
	var date = new Date();
	date.setDate(date.getDate() + expiredays);
	document.cookie = escape(name) + "=" + escape(value) + "; expires=" + date.toUTCString();
}

function setCookieAt00( name, value, expiredays ) {   

	var todayDate = new Date();   

	todayDate = new Date(parseInt(todayDate.getTime() / 86400000) * 86400000 + 54000000);  

	if ( todayDate > new Date() ) {  
		expiredays = expiredays - 1;  
	}  

	todayDate.setDate( todayDate.getDate() + expiredays );
	
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"   

}

//메인공지 보기
function main_notice_show(i) {
	$('#popupBbs').fadeIn('slow', function() {

		$("div.mainLayer_noticeList li").removeClass("on");
		$("div.mainLayer_noticeList li").eq(i).addClass("on");

		$("div.popupCon dl.bbsCon").eq(i).show();
	});
	
}

//실시간 공지 닫기
function Notice_Close(code){
	$('.Notice_Area').fadeOut();
	setCookie(code, '1', '1');	
}

//e-poster like 클릭
function like_chk(psid, obj) {

	if(ajax_sleep == false) {
		
		ajax_sleep = true
		var like_num = $(obj).attr("like_num");
	
		$.ajax({
			type: "POST",
			url: "/session/load/like.php",
			data: "psid="+psid+"&show_num="+like_num,
			success: function(count) {
				$(obj).html('<i class="fas fa-heart"></i> ' + count + ' Like');
				$(obj).attr("like_num", count);
				$(obj).toggleClass("on");
				setTimeout(ajax_wake, 1000);
			},
			error: function(msg){
				ajax_sleep = false;
			}
		});

	} else {
		alert(ajax_sleep_content);
	}
}

//e-poster 즐겨찾기 클릭
function favor_list_chk(sid, obj){
	var kind = $(obj).hasClass("on") ? "del" : "add";
	
	if(ajax_sleep == false) {
		
		ajax_sleep = true
	
		$.ajax({
			type: "POST",
			url: "/session/load/favor.php",
			data: "sid="+sid+"&kind="+kind+"&mode=list",
			success: function(data) {
				$(obj).toggleClass("on");
				setTimeout(ajax_wake, 1000);
			},
			error: function(msg){
				ajax_sleep = false;
			}
		});

	} else {
		alert(ajax_sleep_content);
	}
}

//e-poster 즐겨찾기 클릭
function favor_chk(sid,kind){

	if(ajax_sleep == false) {
		
		ajax_sleep = true

		if(kind=='add'){
			is_class = $('#favor_'+sid).attr('class');
			
			if(is_class=='favor' || is_class=='favor '){
				$('#favor_'+sid).attr('class','favor on');
				 kind = 'add';
			}else{
				$('#favor_'+sid).attr('class','favor');
				kind = 'del';
			}
		}else if(kind=='del'){
			$('#favor_'+sid).attr('class','favor');
		}
		
		$("#my_favor_area").load("/session/load/favor.php?sid="+sid+"&kind="+kind, function(response, status, xhr){
			if(status=='success'){
				setTimeout(ajax_wake, 1000);
			}
		});

	} else {
		alert(ajax_sleep_content);
	}
}

function room_reload(room) {
	location.replace("/live/view.php?room="+room);
}

function popup_call(path, pop_name, params, w, h) {

	w = w || "500";
	h = h || "500";

	var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", path);
	form.setAttribute("target", pop_name);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);

	window.open("", pop_name, "width="+w+", height="+h+", scrollbars=yes");
    form.submit();
}