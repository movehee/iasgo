// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {

	var win_h = $(window).height(),
		header_h = $("div.selfprint h1").outerHeight(),
		conH = win_h - header_h;
	
	$("div.contents").css({"height":conH})

});




// 브라우저창 사이즈가 변경될 때
$(window).resize(function(){
});


