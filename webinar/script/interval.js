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
	var session_detail = setInterval( function () {
		if($('.playMore').find("li").eq(0).attr("class")=='wide on'){
			$(".play_tech_area").load("/play/load/session_detail.php?day="+day+"&room_sid="+room);
		}
	}, 10000);

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

});