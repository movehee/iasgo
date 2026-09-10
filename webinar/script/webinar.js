$(function(){

	$('#loginF').submit(function(){
		if(!$('#id').val()){
			alert("Please enter your ID (E-mail)");
			$('#id').focus();
			return false;
		}
		if(!$('#passwd').val()){
			alert("Please enter your password");
			$('#passwd').focus();
			return false;
		}
	});

	$(document).on("click",".notice_title",function(){
		var key = $(this).attr("key");
		if(key){
			$("#notice_area").load("/load/notice.php?sid="+key);
			$('#popupBbs').fadeIn();return false;
		}
	});

	$(document).on("click",".color_close",function(){
		parent.$.colorbox.close();
	});
	

	$(document).on('click','.change_notice',function(){
		var key = $(this).attr("key");
		
		if(key){
			$(".bbsCon").load("/load/notice_content.php?sid="+key, function(response, status, xhr){
				if(status=='success'){
					$('.nlist').removeClass('on');
					$('#notice_list_'+key).attr('class','nlist on');
				}
			});
		}
		return false;
	});


	$('.use_yn').on('click',function(){
		myval = $(this).attr('key');
		if($(this).is(':checked')==true){
			chkval = "Y";
		}else{
			chkval = "N";
		}
		$.ajax({
			type:"POST",
			url:"/admin/notice/notice_use.php",
			data:"sid="+myval+"&chkval="+chkval,
			async:false,
			success:function(msg){
				if(msg!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
	});	

	$('#booth_bookF').submit(function(){
		
	});
	$('.push').on('click',function(){
		$('.push').not($(this)).prop('checked',false);
		chking = $(this).is(':checked');

		if(chking==true){
			puch_chk = "Y";
		}else{
			puch_chk = "N";
		}

		var myval = $(this).attr('key');
		var kind = $(this).attr('kind');
		var pval = $(this).attr('pval'); //기타필요한값
		
		$.ajax({
			type:"POST",
			url:"/admin/push.php",
			data:"sid="+myval+"&kind="+kind+"&pval="+pval+"&chking="+puch_chk,
			async:false,
			success:function(msg){
				if(msg!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
	});
	$('.refresh_notice').on('click',function(){
		$('.push').not($(this)).prop('checked',false);
		myval = $(this).attr('key');
		if(confirm("갱신하시는 경우 다시 재 공지됩니다.\n갱신하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/admin/notice/refresh_notice.php",
				data:"sid="+myval,
				async:false,
				success:function(msg){
					if(msg!='Y'){
						alert("통신에 실패하였습니다.");
					}else{
						alert("갱신되었습니다.")
					}
				}
			});
		}
	});

	$('#examF').submit(function(){
		var ecnt = $('#exam_cnt').val();
		for(i=1;i<=ecnt;i++){
			if($('.que'+i).is(':checked')==false){
				alert(i+"번 문제의 답을 체크해주세요");
				$('.que'+i).focus();
				return false;
			}
		}
	});

	$('.judge_score').on('change',function(){
		var key = $(this).attr('key');
		var Tscore = 0;
		for(i=1;i<=5;i++){
			Tscore += Number($('#score'+i+'_'+key).val());
		}
		$('#total_score_'+key).val(Tscore);
		$('#Tsum_'+key).html(Tscore);
	});

	$('#techF').submit(function(){
		
		if(!$('#tech_question').val()){
			alert("Please enter your technical question\n내용을 입력해주세요");
			$('#tech_question').focus();
			return false;
		}
		/*if($('#name_kr').length>0){
			if(!$('#name_kr').val()){
				alert("성명을 입력해주세요");
				$('#name_kr').focus();
				return false;
			}
		}
		if($('#cell').length>0){
			if(!$('#cell').val()){
				alert("연락처를 입력해주세요");
				$('#cell').focus();
				return false;
			}
		}*/
		
		var params = $("#techF").serialize();
		jQuery.ajax({
			url: '/load/tech_reg.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				alert("Completion of technical inquiry");
				$('#tech_question').val('');
				//viewer_area('tech');
				//parent.location.reload();
				parent.$.colorbox.close();
			}, error: function (request,status,error){
				alert('please try again.');
				return false;
			}
		});
		return false;
	});
	
	$('#opinionF').submit(function(){
		if(!$('#opinion').val()){
			alert("세미나 관련 의견을 입력해주세요");
			$('#opinion').focus();
			return false;
		}
	});

	$('#main_agree_chk').on('click',function(){
		if($(this).is(':checked')==true){
			$(this).parent().addClass("on");
		}else{
			$(this).parent().removeClass("on");
		}
	});

	$('#main_agreeF').submit(function(){
		
		if($('#main_agree_chk').is(':checked')==false){
			alert("이용에 동의해주세요");
			return false;
		}
		
		var params = $("#main_agreeF").serialize();
		jQuery.ajax({
			url: '/main_agree.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				$('.layerPopup').fadeOut();
				return false;
			}, error: function (request,status,error){
				alert('Error');
				return false;
			}
		});
		return false;
	});

	$('#surveyF').submit(function(){
		if($('.job').is(':checked')==false){
			alert("직종을 선택해주세요");
			$('.job').eq(0).focus();
			return false;
		}
		if($('.charge').is(':checked')==false){
			alert("감염관리 담장자를 선택해주세요");
			$('.charge').eq(0).focus();
			return false;
		}
		if(!$('#yearv').val()){
			alert("감염관리경력을 입력해주세요");
			$('#yearv').focus();
			return false;
		}
	});

	$(document).on("submit","#commentF",function(){
		if(!$('#comment').val()){
			alert("Please enter a comment");
			return false;
		}
		var params = $("#commentF").serialize();
		jQuery.ajax({
			url: '/poster/comment_input_reg.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				$('#comment').val("");
				$(".VC_area").load("/load/comment_list.php?sid="+result);
			}, error: function (request,status,error){
				alert('Error');
				return false;
			}
		});
		return false;
	});
	$(document).on('submit','.replyF',function(){
		frm = $(this).attr("name");
		if(!$('#'+frm+' #reply_comment').val()){
			alert("Please enter a comment");
			$('#'+frm+' #reply_comment').focus();
			return false;
		}
		var params = $("#"+frm).serialize();
		jQuery.ajax({
			url: '/e_poster/comment_input_reg.php',
			type: 'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
			dataType: 'html',
			async: false,
			success: function (result) {
				//alert(result)
				$(".VC_area").load("/load/comment_list.php?sid="+result);
			}, error: function (request,status,error){
				alert('Error');
				return false;
			}
		});
		return false;
	});
	$(document).on('click','.comment_del',function(){
		var keyval = $(this).attr("key");
		var psid = $(this).attr("psid");
		var th = $(this);
		if(confirm("삭제하시겠습니까?")){	
			
			$.ajax({
				type:"POST",
				url:"/load/common_delete.php",
				data:"sid="+keyval+"&psid="+psid,
				success:function(msg){
					if(msg=='N'){
						alert("please try again");
						return false;
					}else{
						$('#Tcnt').html(msg);
						th.closest("dl.reply").remove();
					}
				}
			});
		}
	});

	$(document).on('click','.direct_stamp',function(){
		var booth_key = $(this).attr("key");
		$.ajax({
			type:"POST",
			url:"/booth/direct_stamp.php",
			data:"booth_sid="+booth_key,
			success:function(msg){
				if(msg=='N'){
					alert("please try again.");
					return false;
				}
			}
		});
	});
	
	

	$('.company_vod').on('click',function(){
		
		var keyval = $(this).attr('key');
		
		$.ajax({
			type:"POST",
			url:"/load/booth/company_stamp.php",
			data:"booth_sid="+keyval,
			async:false,
			success:function(msg){
				var parse_data = JSON.parse(msg);
				if(parse_data.result!='Y'){
					alert("통신에 실패하였습니다.");
				}else{
					alert("Completed.");
				}
			}
		});
	});


	$('.Booth_cnt').on('click',function(){
		var keyval = $(this).attr('key');
		$.ajax({
			type:"POST",
			url:"/load/booth/update_booth_count.php",
			data:"booth_sid="+keyval,
			async:false,
			success:function(msg){
				var parse_data = JSON.parse(msg);
				if(parse_data.result!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
	});


	$(".faculty_favor_btn").on("click", function() {
		var $this = $(this);
		var faculty_sid = $(this).attr("faculty_sid");

		$.ajax({
			type:"POST",
			url:"/load/faculty_favor.php",
			data:"faculty_sid="+faculty_sid,
			async:false,
			success:function(msg){
				$this.toggleClass("on");
			}
		});
		
	});
});

$(document).ready(function(){
	if($(".Load_notice").length>0){//헤더에 공지사항이 항상 있기때문에 이거 하나만 조건으로 넣어둠.	
		$(".Load_notice").colorbox({iframe:true, transition:"fade", width:"1303", maxWidth:"98%", height:"777", maxHeight:"800", minHeight:"800", top:"20",speed:150,fixed:false,scrolling:true,closeButton:false,overlayClose:true,escKey:true,opacity:0.5,reposition:true});
	}
	if($(".Load_logout").length>0){
		$(".Load_logout").colorbox({iframe:true, transition:"fade", width:"410", maxWidth:"98%", height:"340", maxHeight:"800", minHeight:"800", top:"20%",speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
	}
	if($(".Load_glance").length>0){
		$(".Load_glance").colorbox({iframe:true, transition:"fade", width:"1203", maxWidth:"98%", height:"864", maxHeight:"1000", minHeight:"800", top:"0",speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:false,escKey:true,opacity:0.5,reposition:true});
	}
	if($(".Load_session_list").length>0){
		$(".Load_session_list").colorbox({iframe:true, transition:"fade", width:"800", maxWidth:"98%", height:"595", maxHeight:"1000", minHeight:"800", top:"10%",speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:false,escKey:true,opacity:0.5,reposition:true});
	}
	
	$(".Load_Base").on('click',function(){
		var W_custom = $(this).attr('Wsize');
		var H_custom = $(this).attr('Hsize');
		var T_custom = $(this).attr('Tsize');
		
		$(".Load_Base").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:false,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
	});

	$(".Load_Base2").on('click',function(){
		var W_custom = $(this).attr('Wsize');
		var H_custom = $(this).attr('Hsize');
		var T_custom = $(this).attr('Tsize');
		
		$(".Load_Base2").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:false,closeButton:true,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
	});


	$(".Load_Base_R").on('click',function(){
		var W_custom = $(this).attr('Wsize');
		var H_custom = $(this).attr('Hsize');
		var T_custom = $(this).attr('Tsize');
		
		$(".Load_Base_R").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:false,closeButton:false,scrolling:true,escKey:true,opacity:0.5,reposition:true});

	});

	$(".Load_Base_fix").on('click',function(){
		var W_custom = $(this).attr('Wsize');
		var H_custom = $(this).attr('Hsize');
		var T_custom = $(this).attr('Tsize');
		var Reload = $(this).attr('Reload');
		var Browser_W = $(window).width();
		var Browser_H = $(window).height();

		
		
		
		if((Browser_H-50)<H_custom){
			H_custom = "90%;";
		}
		if((Browser_W-50)<W_custom){
			W_custom = "80%;";
		}
		if(Reload=='Y'){
			$(".Load_Base_fix").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true,onClosed:function(){
				location.reload();
			}});	
		}else if(Reload=='L'){
			$(".Load_Base_fix").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true,onClosed:function(){
				
			}});
		}else{
			$(".Load_Base_fix").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
		}
	});
	
	// 240329 e-poster headerWrap 상단 고정
	eposter_fix();
	
});


function viewer_area(kind){
	
	if(kind!='question') $('.Question_area').hide();
	if(kind!='notice') $('.Notice_Area').hide();
	if(kind!='tech') $('.Tech_area').hide();
	if(kind!='voting') $('.Voting_area').hide();

	if(kind=='question'){
		if($('.Question_area').is(':visible')==false){
			$('#question').val("");
			$('.Question_area').show();
		}else{
			$('.Question_area').hide();
		}
	}else if(kind=='voting'){
		$('.Notice_Area').hide();
		if($('.Voting_area').is(':visible')==false){
			$('.Voting_area').show();
		}else{
			$('.Voting_area').hide();
		}
	}else if(kind=='notice'){
		if($('.Notice_Area').is(':visible')==false){
			$('#question').val("");
			$('.Notice_Area').show();
			$("#Notice_content").load("notice_load.php?room_sid="+room, function(response, status, xhr){
				if(status=='success'){
				
				}
			});
		}else{
			$('.Notice_Area').hide();
		}
	}else if(kind=='tech'){
		if($('.Tech_area').is(':visible')==false){
			$('.Tech_area').show();
		}else{
			$('.Tech_area').hide();
		}
	}
	
}

function popup_call(str,param){
	tit = str.replace("/","");
	window.open("/popup/"+str+".php?"+param,tit,"top=0, left=0, width=500, height=500, scrollbars=yes");
}
function common_delete(sid,kind){
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"/admin/common_delete.php",
			data:"kind="+kind+"&sid="+sid,
			success:function(msg){
				if(msg=='Y'){
					location.reload();
				}else{
					alert("정상적인 접근이 아닙니다.");
					return false;
				}
			}
		});
	}
}

function hide_notice(){
	$(".Notice_Area").hide();
	
	popup_setCookie( "close_notice", "Y");
	setTimeout(function(){
		setCookie('close_notice', '', -1);
	}, 6000);
}

function popup_setCookie( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function popup_getCookie( name )
{
        var nameOfCookie = name + "=";
        var x = 0;
        while ( x <= document.cookie.length )
        {
                var y = (x+nameOfCookie.length);
                if ( document.cookie.substring( x, y ) == nameOfCookie ) {
                        if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                                endOfCookie = document.cookie.length;
                        return unescape( document.cookie.substring( y, endOfCookie ) );
                }
                x = document.cookie.indexOf( " ", x ) + 1;
                if ( x == 0 )
                        break;
        }
        return "";
}

function setCookie(name, value, expiredays) {
	var date = new Date();
	date.setDate(date.getDate() + expiredays);
	document.cookie = escape(name) + "=" + escape(value) + "; expires=" + date.toUTCString();
}

function closePopup() {
	if (document.getElementById("check").value) {
		setCookie("popupYN", "N", 1);
		self.close();
	}
}
function numFormat(variable){
	variable = Number(variable).toString();
	if(Number(variable) < 10 && variable.length == 1)
		variable = "0" + variable;
	return variable;
}

function poster_viewer(sid){
	$('.List_poster').find("li").removeClass("on");
	
	$('.PList_'+sid).addClass("on");
	$(".eposterView").load("/e_poster/e_poster_view.php?sid="+sid);
	$(".eposterView_top").load("/e_poster/e_poster_view_top.php?sid="+sid);
	
}
function play_room(day){
	var width = screen.width;
	var height = screen.height;
	//location.href="/play/index.php";
	//window.open("/play/index.php","player","width="+width+", height="+height+',fullscreen=yes');
	window.open("/play/room_selection.php","player","width="+width+", height="+height+",fullscreen=yes");
}

function play_test(){
	var width = screen.width;
	var height = screen.height;
	window.open("/play_test.php","player","width="+width+", height="+height+",fullscreen=yes");
}

function play_room_con(){
	window.open("/play/index_con.php","player","width=1000, height=1000");
	
}
function file_open(kind,param){
	if(kind){
		window.open("/lecture_popup.php?kind="+kind+"&"+param,"Lecture","width=1000, height=1000");
	}else{
		alert("no data");
	}
}
function direct_room(str){
	var width = screen.width;
	var height = screen.height;
	//location.href="/play/index.php";
	//window.open("/play/index.php","player","width="+width+", height="+height+',fullscreen=yes');
	
	// window.open("/play/index.php?room_sid="+str+"&lang=K","player","width="+width+", height="+height+",fullscreen=yes");
	location.href = "/play/index.php?room_sid="+str+"&lang=K";
}

function direct_room_openner(str){
	var width = screen.width;
	var height = screen.height;
	// $.colorbox.close();
	window.parent.location.href = "/play/index.php?room_sid="+str+"&lang=K";
}


function direct_room_eng(str){
	var width = screen.width;
	var height = screen.height;
	//location.href="/play/index.php";
	//window.open("/play/index.php","player","width="+width+", height="+height+',fullscreen=yes');
	window.open("/play/index.php?room_sid="+str+"&lang=F","player","width="+width+", height="+height+",fullscreen=yes");
}


function favor_chk(sid,kind){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });

	if(kind=='add'){
		is_class = $('#favor_'+sid).attr('class');
		var plen = $('#p_favor_'+sid+'_parent').length;

		
		
		if(is_class=='favor' || is_class=='favor '){
			alert("1")
			$('#favor_'+sid).attr('class','favor on');
			 kind = 'add';
			 if(plen>0){
				$('#p_favor_'+sid+'_parent').attr('class','favor on');	
			}
		}else{
			alert(is_class)
			$('#favor_'+sid).attr('class','favor');
			kind = 'del';
			if(plen>0){
				$('#p_favor_'+sid+'_parent').attr('class','favor');
			}
		}
	}else if(kind=='del'){
		$('#favor_'+sid).attr('class','favor');
		if(plen>0){
			$('#p_favor_'+sid+'_parent').attr('class','favor');
		}
	}
	
	$("#my_favor_area").load("/poster/favor.php?sid="+sid+"&kind="+kind, function(response, status, xhr){
		if(status=='success'){
			
		}
	});
	
}
function favor_list_chk(sid,kind){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });

	if(kind=='add'){
		is_class = $('#favor_'+sid).attr('class');
		var plen = $('#p_favor_'+sid+'_parent').length;
		
		if(is_class=='favor' || is_class=='favor '){
			$('#favor_'+sid).attr('class','favor on');
			 kind = 'add';
			 if(plen>0){
				$('#p_favor_'+sid+'_parent').attr('class','favor on');	
			}
		}else{
			$('#favor_'+sid).attr('class','favor');
			kind = 'del';
			if(plen>0){
				$('#p_favor_'+sid+'_parent').attr('class','favor');
			}
		}
	}else if(kind=='del'){
		$('#favor_'+sid).attr('class','favor');
		if(plen>0){
			$('#p_favor_'+sid+'_parent').attr('class','favor');
		}
	}
	$.ajax({
		type:"POST",
		url:"/poster/favor.php",
		data:"sid="+sid+"&kind="+kind+"&mode=list",
		async:false,
		success:function(msg){
			
			if(msg!='Y'){
				//alert("통신에 실패하였습니다.");
			}
		}
	});
}


function like_chk(sid){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });
	is_class = $('#p_like_'+sid).attr("class");
	var plen = $('#p_like_'+sid+'_parent').length;
	var mplen = $('.mypage_like_'+sid).length;
	
	if(is_class=='like' || is_class=='like '){
		$('#p_like_'+sid).attr('class','like on');
		kind = 'add';
		if(plen>0){
			$('#p_like_'+sid+'_parent').attr('class','like on');	
		}
	}else{
		$('#p_like_'+sid).attr('class','like');
		kind = 'del';
		if(plen>0){
			$('#p_like_'+sid+'_parent').attr('class','like');
		}
		if(mplen>0){
			$('.mypage_like_'+sid).remove();
		}
	}
	
	$.ajax({
		type:"POST",
		url:"/poster/like.php",
		data:"sid="+sid+"&kind="+kind,
		async:false,
		success:function(msg){
			
			var sp_msg = msg.split("||");
			$('#like_'+sid+'_txt').html(sp_msg[0]);
			//$('#favor_cnt1').html(sp_msg[1]);
			//$('#favor_cnt2').html(sp_msg[2]);
			
		}
	});
}
function reply_show(sid){
	if($('#reply_area'+sid+':visible').length>0){
		$('#reply_area'+sid).hide();
	}else{
		$('#reply_area'+sid).show();
	}
	//alert($('#reply_area'+sid+':visible').length)
	
}

function pdf_viewer(str){
	if(str){
		window.open(str,"Lecture","width=1000, height=1000");
	}else{
		alert("no data ");
	}
}


function session_favor(sid,mode){
	$.ajax({
		type:"POST",
		url:"/load/session_favor.php",
		data:"sid="+sid+"&mode="+mode,
		async:false,
		success:function(msg){
			var parse_data = JSON.parse(msg);
			if(parse_data.push=='R'){
				//alert("이미 추가된 세션입니다.");
				$('#favor_btn'+sid).removeClass("on");
			}else if(parse_data.push=='Y'){
				//alert("즐겨찾기에 추가되었습니다.");
				$('#favor_btn'+sid).addClass("on");
			}else if(parse_data.push=='D'){
				//alert("즐겨찾기에서 삭제되었습니다.");
				//$('#session_favor'+sid).remove();
				$('#favor_btn'+sid).removeClass("on");
			}else{
				alert("An error has occurred. Please try again later.");
			}
		}
	});
	
}

//240329 eposter 상단 고정
function eposter_fix() {
	if ($("div.e-poster")) {
	    const containerY = document.querySelector("#container").offsetTop;
        
        window.addEventListener('scroll', () => {
		    const currentY = window.scrollY;

            if(currentY > containerY) {
                $("#headerWrap").addClass("fixed");
				$("div.searchArea").addClass("fixed");
            } else {
				$("#headerWrap").removeClass("fixed");
				$("div.searchArea").removeClass("fixed");
			}
        })
	}
}


function parent_link(str){
	parent.location.href=str;
}



