
// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	initial();
	list(); // e-poster 리스트 영역 스크롤
	view(); // e-poster 뷰페이지 영역 스크롤
    mTabMenu();
});



// 브라우저창 사이즈가 변경될 때
$(window).resize(function(){
	initial();
	list(); // e-poster 리스트 영역 스크롤
	view(); // e-poster 뷰페이지 영역 스크롤
});


//공통 이벤트
function initial(){
	if ($(window).height() > 500) {
		$("div.wrapper").height($(window).height());
	}
	/*
	if ($("div#fixedArea").length) {
		var fxed_h = $("div#fixedArea").outerHeight();
		$("div.wrapper").css({
			"padding-bottom":fxed_h
		})
	}
	*/
}

function list(){	
	if ($("div.eposterWrap").length) {
		var list_h = $(window).height() - $("div#headerWrap").outerHeight() - $("div.sch-wrap").outerHeight()  - $(".sub-tab-wrap").outerHeight() - $("div#fixedArea").outerHeight() - 80;
		var list_h_no = $(window).height() - $("div.sch-wrap").outerHeight()  - $(".sub-tab-wrap").outerHeight() - $("div#fixedArea").outerHeight() - 80;
		$("div.eposterWrap").css({
			"height":list_h
		})

		let lastScroll = 0;
		let Y = document.querySelector('.eposterWrap')

        Y.addEventListener('wheel', (event) => {
            let direction = Math.sign(event.deltaY);
	
			if (direction === 1) {
				$("div#headerWrap").css({
					"display": 'none'
				})
				$("div.eposterWrap").css({
					"height":list_h_no
				})
			} else if (direction === -1) {
				 setTimeout(() => {
					if(document.querySelector('.eposterWrap').scrollTop == 0){					
						$("div#headerWrap").css({
							"display": 'block'
						})
						$("div.eposterWrap").css({
							"height":list_h
						})
					}
				}, 300);
			}
			lastScroll = event.deltaY;
		});
	}
}


function view(){	
	if ($("div#eposterVeiw").length) {
		var list_h = $(window).height() - $(".eposterInfo").outerHeight() - $("ul.sort").outerHeight() - $("div#fixedArea").outerHeight();
		$("div.eposterCon").css({
			"height":list_h
		})
		/*pinch-zoom-parent*/
	}
}


function mTabMenu(){
    var currentTab = $('.sort li.on a').text();
    $('.js-btn-tab-menu').text(currentTab);
    console.log(currentTab);
    $('.js-btn-tab-menu').on('click',function(e){
        $(this).stop().toggleClass('on').next('ul').stop().slideToggle();
        $('.js-btn-tab-menu').text(currentTab);
    });
}