$(window).load(function(){
	if (!jQuery.datepicker) {
		return;
	}
	jQuery(function(a){a.datepicker.regional.ko={closeText:'닫기',prevText:'이전달',nextText:'다음달',currentText:'오늘',monthNames:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],dayNames:['일','월','화','수','목','금','토'],dayNamesShort:['일','월','화','수','목','금','토'],dayNamesMin:['일','월','화','수','목','금','토'],weekHeader:'Wk',dateFormat:'yy-mm-dd',firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:'년'};a.datepicker.setDefaults(a.datepicker.regional.ko)});
	$('#sdate, #edate, .date').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: 'yy-mm-dd', yearRange:"1910:+10", showButtonPanel:true, showAnim:"slide"});
});


$(function(){
	
	$(document).on("keyup", "input:text[numberOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
	$(document).on("keyup", "input:text[datetimeOnly]", function() {$(this).val( $(this).val().replace(/[^0-9:\-]/gi,"") );});
	$(document).on("keyup", "input:text[engOnly]", function() {$(this).val( $(this).val().replace(/([^A-Za-z\x20])/gi,"") );});
	$(document).on("keyup", "input:text[engNumberOnly]", function() {$(this).val( $(this).val().replace(/([^A-Za-z\x20^0-9])/gi,"") );});
	$(document).on("keyup", "input:text[korOnly]", function() {$(this).val( $(this).val().replace(/([^가-힣ㄱ-ㅎㅏ-ㅣ\x20])/gi,"") );}); 

	$('#loginF').submit(function(){
		if(!$('#id').val()){
			alert("아이디를 입력해주세요");
			$('#id').focus();
			return false;
		}
		if(!$('#license_number').val()){
			alert("면허번호를 입력해주세요");
			$('#license_number').focus();
			return false;
		}
	});

	$('.allchk').on('click',function(){
		if($(this).is(':checked')==true){
			$('.chksid').prop('checked',true);
		}else{
			$('.chksid').prop('checked',false);
		}
	});


	$(document).on("click",".notice_title",function(){
		var key = $(this).attr("key");
		if(key){
			$("#notice_area").load("/load/notice.php?sid="+key);
			$('#popupBbs').fadeIn();return false;
		}
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

	
	$(document).ready(function(){
		if($(".iframe_session").length>0){//헤더에 공지사항이 항상 있기때문에 이거 하나만 조건으로 넣어둠.
			$(".iframe_session").colorbox({iframe:true, width:"800", height:"786", top:"70", transition:"fade", speed:150,fixed:true,closeButton:true,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});
		}
		if($(".iframe_session_fac").length>0){//헤더에 공지사항이 항상 있기때문에 이거 하나만 조건으로 넣어둠.
			$(".iframe_session_fac").colorbox({iframe:true, width:"1000", height:"786", top:"70", transition:"fade", speed:150});
		}
		if($(".iframe_eposter").length>0){
			$(".iframe_eposter").colorbox({iframe:true, width:"1310", height:"786", top:"70", transition:"fade", speed:150});
		}
		if($(".iframe_booth").length>0){
			$(".iframe_booth").colorbox({iframe:true, width:"1310", height:"774", top:"70", transition:"fade", speed:150});
		}
		if($(".iframe_session_ing").length>0){
			$(".iframe_session_ing").colorbox({iframe:true, width:"1510", height:"774", top:"70", transition:"fade", speed:150});
		}
		if($(".iframe_poster_comment").length>0){
			$(".iframe_poster_comment").colorbox({iframe:true, width:"600", height:"350", bottom:"100", right:"20", transition:"fade", speed:150});
		}
		if($(".iframe_poster_comment_reply").length>0){
			$(".iframe_poster_comment_reply").colorbox({iframe:true, width:"600", height:"350", transition:"fade", speed:150});
		}
		$(".Load_Base").on('click',function(){
			var W_custom = $(this).attr('Wsize');
			var H_custom = $(this).attr('Hsize');
			var T_custom = $(this).attr('Tsize');
			
			$(".Load_Base").colorbox({iframe:true, transition:"fade", width:W_custom, maxWidth:"100%", height:H_custom, maxHeight:"100%", top:T_custom,speed:150,fixed:true,closeButton:false,overlayClose:true,scrolling:true,escKey:true,opacity:0.5,reposition:true});

		});
	});

	$('.use_top').on('click',function(){
		myval = $(this).attr('key');
		if($(this).is(':checked')==true){
			chkval = "Y";
		}else{
			chkval = "N";
		}
		$.ajax({
			type:"POST",
			url:"/notice/top_use.php",
			data:"sid="+myval+"&chkval="+chkval,
			async:false,
			success:function(msg){
				if(msg!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
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
			url:"/notice/notice_use.php",
			data:"sid="+myval+"&chkval="+chkval,
			async:false,
			success:function(msg){
				if(msg!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
	});	
	$('.push').on('click',function(){
		//$('.push').not($(this)).prop('checked',false);
		chking = $(this).is(':checked');

		if(chking==true){
			puch_chk = "Y";
		}else{
			puch_chk = "N";
		}
		

		var myval = $(this).attr('key');
		var kind = $(this).attr('kind');
		var pval = $(this).attr('pval'); //기타필요한값
		if(kind=='view'){
			$('.Viewchk').not(this).attr('checked',false);
		}
		$.ajax({
			type:"POST",
			url:"/push.php",
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
		myval = $(this).attr('key');
		if(confirm("갱신하시는 경우 다시 재 공지됩니다.\n갱신하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/notice/refresh_notice.php",
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

	$('.select_change').on('change',function(){
		var kind = $(this).attr("kind");
		var kind_val = $(this).val();
		var key_val = $(this).attr("key");
		$.ajax({
			type:"POST",
			url:"/select_change_reg.php",
			data:"kind="+kind+"&kind_val="+kind_val+"&sid="+key_val,
			success:function(msg){
				if(msg!='Y'){
					alert("정상적인 접근이 아닙니다.");
					return false;
				}
			}
		});
	});

	$('.chkall').on('click',function(){
		var mykey = $(this).attr("key");
		if($(this).is(':checked')==true){
			$('.'+mykey).prop('checked',true);
			var chkval="Y";
		}else{
			$('.'+mykey).prop('checked',false);
			var chkval="N";
		}
		var Keyarray=new Array();
		var total_cnt=0;
		$("input[name="+mykey+"]").each(function(pi,po){
			if(chkval=='Y'){
				$('#'+mykey+'_'+po.value+'_btn').show();	
			}else if(chkval=='N'){
				$('#'+mykey+'_'+po.value+'_btn').hide();
			}
			Keyarray[total_cnt] = po.value;
			total_cnt++;
		});
		var keyjoin = Keyarray.join(",");
	
		$.ajax({
			type:"POST",
			url:"/booth/chking_change.php",
			data:"sort_val="+keyjoin+"&op_kind="+mykey+"&chkval="+chkval+"&all=Y",
			cache:false,
			async:false,
			success:function(msg){
				
			}
		});
	});
	$('.check_ajax').on('click',function(){
		var mykey = $(this).attr('kind');
		var keyjoin = $(this).val();
		
		if($(this).is(':checked')==true){
			var chkval="Y";
			$('#'+mykey+'_'+keyjoin+'_btn').show();
		}else{
			var chkval="N";	
			$('#'+mykey+'_'+keyjoin+'_btn').hide();
		}
		$.ajax({
			type:"POST",
			url:"/booth/chking_change.php",
			data:"sort_val="+keyjoin+"&op_kind="+mykey+"&chkval="+chkval+"&all=N",
			cache:false,
			async:false,
			success:function(msg){
				
			}
		});
	});
	$(document).on("click",".check_value",function(){
		var key = $(this).attr('key');
		var kind = $(this).attr('kind');
		var keyval = "N";
		if($(this).is(':checked')==true){
			keyval = "Y";
		}
		if(kind=='faculty_award_kind'){
			keyval = $(this).val();
		}
		
		$.ajax({
			type:"POST",
			url:"/common/check_value.php",
			data:"sid="+key+"&kind="+kind+"&keyval="+keyval,
			success:function(msg){
				var parse_data = JSON.parse(msg);
				if(parse_data.result!='Y'){
					alert("에러입니다.");
					return false;
				}
			}
		});
	});


	$(document).on("change",".Ch_con",function(){
		var key = $(this).attr('key');
		var kind = $(this).attr('kind');
		var field = $(this).attr('field');
		var field_val = $(this).val();
		
		$.ajax({
			type:"POST",
			url:"/popup/booth/update_text.php",
			data:"sid="+key+"&kind="+kind+"&field_val="+encodeURIComponent(field_val)+"&field="+field,
			success:function(msg){
				
			}
		});
	});
	
	$('#term_reset').on('click',function(){
		if($(this).is(':checked')==true){
			$('#stime').val("");
			$('#etime').val("");
		}
	});

	$('#time_set').on('click',function(){
		if($(this).is(':checked')==true){
			$('#time_limit').prop('disabled',false);
			$('#time_limit').focus();
		}else{
			$('#time_limit').prop('disabled',true);
			$('#time_limit').val("");
		}
	});
	$('.Cookie_chk').on('click',function(){
		var key = $(this).attr('id');
		if($(this).is(':checked')==true){
			setCookie(key, '1', '1');
		}else{
			setCookie(key, '', -1);
		}
	});

	
});


function exam_term_chk(){
	var params = $("#exam_termF").serialize();
	jQuery.ajax({
		url: '/exam/term_reg.php',
		type: 'POST',
		data:params,
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
		dataType: 'html',
		async: false,
		success: function (result) {
			alert("설정이 완료되었습니다.");
		}, error: function (request,status,error){
			alert('Error');
			return false;
		}
	});
	return false;
}

function popup_call(str,param){
	tit = str.replace("/","");
	window.open("/popup/"+str+".php?"+param,tit,"top=0, left=0, width=2000, height=500, scrollbars=yes");
}
function common_delete(sid,kind){
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"/common_delete.php",
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

function number_format(num){
    var num_str = num.toString();
    var result = "";
 
    for(var i=0; i<num_str.length; i++){
        var tmp = num_str.length - (i+1);
 
        if(((i%3)==0) && (i!=0))    result = ',' + result;
        result = num_str.charAt(tmp) + result;
    }
 
    return result;
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

function program_html(days){
	if(confirm("생성하신 프로그램을 HTML로 만드시겠습니까?")){
		location.href="/program/html_create.php?ev_date="+days;
	}
}
function program_delete(days){
	if(confirm("생성하신 프로그램을 삭제하시겠습니까?")){
		location.href="/program/program_delete.php?ev_date="+days;
	}
}

function file_upload_ajax(sid,fname,type){
	if(!$("input[name="+fname+"]").val()){
		alert("업로드하실 파일을 첨부해주세요"); 
		return false;
	}
	$('#file_upload').val("Y");

	$(":input").not($("input[name="+fname+"]")).prop('disabled',true);
	if($("input[name="+fname+"]").val()){
		$('#load').show();
		//$('#'+fname+'_ing').show();
		$("#brocF").attr({
			"action":"/popup/booth/upload_file.php?fname="+fname+"&sid="+sid+"&type="+type
		});
		$("#brocF").attr('target', 'hiddenfrm');
		$("#brocF").submit();
		$(":input").prop('disabled',false);
		
	}

}
function flist_load(fname,sid,type,stat,fkind){
	if(stat=='O'){
		alert('첨부파일은 50M 미만으로 해주세요.');
		return;
	}else if(stat=='N'){
		alert('파일업로드에 실패하였습니다.');
		return;
	}
	
	$("#"+fname+"_txt").val("Select File");
	$('#file_upload').val("N");
	$('#'+fname+"_Area").hide();
	$("#"+fname+"_list").load("/popup/booth/file_reload.php?fname="+fname+"&sid="+sid+"&type="+type+"&fkind="+fkind);
}
function common_delete_file(sid,kind,type){
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"/common_delete.php",
			data:"kind="+kind+"&type="+type+"&sid="+sid,
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


function select_change(str){
	fm = document.programF;
	if($('.chk_sid').is(':checked')==false){
		alert("선택한 데이터가 없습니다."); 
		return;
	}
	var gsWin = window.open('about:blank','payviewer','width=800,height=900');
	fm.action="/popup/TableGender/change.php?ev_date="+str;
	fm.target ="payviewer";
	fm.method ="post";
	fm.submit();
}
function program_add(key,direction){
	if(direction=='left'){
		alert_txt = key+"번 왼쪽으로 행을 추가하시겠습니까?";
	}else if(direction=='right'){
		alert_txt = key+"번 오른쪽으로 행을 추가하시겠습니까?";
	}else if(direction=='up'){
		alert_txt = key+"번 위쪽으로 열을 추가하시겠습니까?";
	}else if(direction=='down'){
		alert_txt = key+"번 아래쪽으로 열을 추가하시겠습니까?";
	}else if(direction=='del_cols'){
		alert_txt = key+"번 행을 삭제하시겠습니까?";
	}else if(direction=='del_rows'){
		alert_txt = key+"번 열을 삭제하시겠습니까?";
	}
	
	if(confirm(alert_txt)){
		location.href="program_add.php?code="+code+"&ev_date="+tb_sid+"&key="+key+"&direction="+direction;
	}
}

function program_backup(day){
	if(confirm("해당일자의 프로그램을 백업하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"/program/program_backup.php",
			data:"program_day="+day,
			async:false,
			success:function(msg){
				alert("백업되었습니다.");
			}
		});
	}
}


function booth_open_type(sid,str){
	$.ajax({
		type:"POST",
		url:"/booth/open_control.php",
		data:"sid="+sid+"&open_type="+str,
		async:false,
		success:function(msg){
			if(msg!='Y'){
				alert("통신에 실패하였습니다.");
			}
		}
	});
}

function time_theorem(){
	if(confirm("세부시간을 정리하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"/registration/time_theorem.php",
			async:false,
			success:function(msg){
				
				if(msg=='N'){
					alert("통신에 실패하였습니다.");
				}else{
					alert(msg+"건의 데이터가 정리되었습니다.");
				}
			}
		});
	}
}

function pickout_controller(kind,kind_val){
	if(kind=='session_chking'){
		var ex_val = kind_val.split("|");
		location.href="index.php?search_kind="+ex_val[0]+"&ev_date="+ex_val[1];
	}else if(kind=='fkind'){
		var ex_val = kind_val.split("|");
		
		$.ajax({
			type:"POST",
			url:"/faculty/faculty_kind_update.php",
			data:"sid="+ex_val[1]+"&kindval="+ex_val[0]+"&fsid="+ex_val[2],
			async:false,
			success:function(msg){
				
				if(msg!='Y'){
					alert("통신에 실패하였습니다.");
				}
			}
		});
	}
}