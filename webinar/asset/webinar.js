// DOM 이 모두 로드 되었을 때 실행
var stampBnr = null,
	bbsRolling = null;


jQuery(function($) {

	initial();

	if ($("div.main").length) {
		//$("div.wrapper").addClass("mainWrap");


	}

/*
	if ($("div.main1").length) {
		$("div.wrapper").addClass("mainWrap1");
	}

	if ($("ul.eboothType").length) {
		$("div#container").addClass("eboothIntro");
	}


	if ($(".eboothList").length) {
		$("div#container").addClass("ebooth");
	}

	if ($("div#ebooth").length) {
		$("div#container").addClass("ebooth");
	}

	if ($("div.posterView").length) {
		$("div.wrapper").addClass("posterWrap");
	}
*/


	/*$("ul#quickMenu").addClass("active");*/

	$("ul#quickMenu li").not(".top").on("mouseenter", function(){
		$("ul#quickMenu").addClass("active");
		$("ul#quickMenu li").removeClass("on");
		$(this).addClass("on");
	});

	$("ul#quickMenu").on("mouseleave", function(){
		$("ul#quickMenu").removeClass("active");
		$("ul#quickMenu li").removeClass("on")
		.eq(0).addClass("on");
	});


	//로그인 배너 롤링
	/*
	if ($("div.loginBnr li").length > 5) {
		$("div.loginBnr ul").bxSlider({
			minSlides:5,
			maxSlides:5,
			moveSlides:1,
			slideWidth:190,			
			slideMargin:35,			
			pager:false,
			auto:true
		});
	}
	*/


	//푸터 배너 롤링
	if ($("dd.sponsor li").length > 7) {
		$("dd.sponsor ul").bxSlider({
			minSlides:7,
			maxSlides:7,
			moveSlides:1,
			slideMargin:15,			
			speed:1000,
			pager:false,
			auto:true
		});
	}

	//메인 Notice 롤링

	if ($("dl.mainNotice li").length > 1) {
		$("dl.mainNotice ul").bxSlider({
			minSlides:1,
			maxSlides:1,
			speed:1000,
			mode:'vertical',
			controls: true,
			pager:false,
			auto:true
		});
	}

	//live 배너 롤링
	if ($("div.bnrZone li").length > 6) {
		$("div.bnrZone ul").bxSlider({
			minSlides:6,
			maxSlides:6,
			moveSlides:1,
			slideWidth:190,			
			slideMargin:17,			
			pager:false,
			auto:true
		});
	}

	// Ebooth Pop Brochues 롤링
	if ($("dl.brochure dd li").length > 1) {
		var brochureSlider = $("dl.brochure dd ul").bxSlider({
			minSlides:1,
			maxSlides:1,
			moveSlides:1,	
			pager:false,
			controls: true,
			auto:true
		});	
		$(document).on("mouseleave", ".bx-controls a", function(){
			brochureSlider.stopAuto();
			brochureSlider.startAuto();
		});	
	}
	

	// Poster Slide
	var slider = $("div.posterCon div.rollingArea ul").bxSlider({
			controls: false,
			pager:false,
			onSlideAfter: function ($slideElement, oldIndex, newIndex) {
				$("#poster_img_sid").val($slideElement.attr("id"))
			},

		});

	$(function() {
		$('#poster_next_btn').click(function(){
			slider.goToNextSlide();				
			return false;
		});

		$('#poster_prev_btn').click(function(){
			slider.goToPrevSlide();
			return false;
		});
	});

	

// 공지사항
	if ($("dl.introBbs").length) {
		setTimeout(function(){
			$("dl.introBbs").animate({
				"height":113,
				"opacity":1
			}, 1000);
			$("div.wrapper").animate({
				"padding-bottom":50
			}, 1000);
		}, 1000);

		if ($("dl.introBbs li").length > 1) {
			$("dl.introBbs ul").bxSlider({
				mode:'vertical',
				pager:false,
				controls:false,
				auto:true
			});

			$("dl.introBbs").on("click", "a", function(){
				$("div#popupBbs").fadeIn();
				return false
			});

		}
	
	}


// Live Sessiion
	if ($("div.room").length) {
		$("div.wrapper").addClass("live");

		$("div.wrapper").click(function(e){
			if( !$(".roomCont").has(e.target).length )
				$(".roomCont").hide();
		});
	}

	$("div.roomAll a").on("click", function(){
		if ($(this).attr("class") == "view") {
			$(this).removeClass("view");
			$("div.room").removeClass("roomAll");
		} else {
			$(this).addClass("view");
			$("div.room").addClass("roomAll");
		}
		return false
	});

	$(".roomItem a.detail").on("click", function(){
		var _currDetail = $(this).parent().parent().next(".roomCont")
		
		$(".roomCont").hide();
		_currDetail.show();
		return false
	});
	



//강의장
	$("ul.playerMenu").on("click", "a", function(){

		// var sClass = $(this).parent().attr("class"),
		// 	sTxt = "dl." + $(this).attr("pub-popup");

		// $("ul.playerMenu li").removeClass("on");
		// $("dl.viewPopup").hide();			

		// if (sClass == "on") {
		// } else {
		// 	var scrollLeft = $(window).scrollLeft(),
		// 		rePoLeft = $(this).parent().offset().left - scrollLeft;
		// 	$(this).parent().addClass("on");
		// 	$(sTxt).css("left", rePoLeft);
		// 	$(sTxt).show();			
		// }
		
		// return false
	});

	$("dl.viewPopup").on("click", ".close a", function(){

		$("ul.playerMenu li").removeClass("on");
		$("dl.viewPopup").hide();			
		
		return false
	});


// E-poster
	if ($("div.sessionCon").length) {
		$("a.open").on("click", function(){
			$("body").addClass("overHidden");
			$("div.posterCon").addClass("fullScreen");
		});
		$("a.close").on("click", function(){
			$("body").removeClass("overHidden");
			$("div.posterCon").removeClass("fullScreen");
		});
	}


// E-Booth
	if ($("dl.ebooth").length) {
		$("div#container").addClass("ebooth");
	}
	
	if ($("ul.ebooth, .eboothDetail").length) {
		$("div.wrapper").addClass("ebooth");
	}

	if ($("div.eboothDetail").length) {
		$("div#container").addClass("ebooth2");
	}
	
	if ($("div.eboothDetail li").length > 1) {
		slider = $("div.eboothDetail ul").bxSlider({	
			pager:false,
			auto:false
		});
	}




	if ($("div.eBoothZone").length) {

		if ($("div.eBoothZone > ul").length > 1 ) {
			$("div.eBoothZone").bxSlider({
				controls:false
			});
			$("div.eBoothCon a.bx-pager-link").eq(0).addClass("active");
		}

		$(".eBooth_a a").snakeify({
			speed: 200	
		});

		$("ul.eBooth_a, ul.eBooth_b, ul.eBooth_a_main").on("click", "a", function(){			
			
			if( $(this).attr("data") == "136" ){ return false; }
			
			if( $(this).attr("data") != null ){
				$.ajax({
					type:"POST",
					url:"/event/booth.php",
					data:{ bsid : $(this).attr("data") },
					async: false,
					success:function(data){
						$('div#popupBooth').html("");
						$('div#popupBooth').append(data);
					}
				});
			}

			
			$("div#popupBooth").fadeIn();

			if (stampBnr != null) {
				stampBnr.destroySlider();
				stampBnr = null;
			}

			if (stampBnr == null) {
				if ($("div.stampzone ul").length > 1) {
					stampBnr = $("div.stampzone").bxSlider({
						infiniteLoop:false,
						hideControlOnEnd:true,
						pager:false
					});
					
					$("div.stamp").append('<div class="pager"><span>1</span> / '+ stampBnr.getSlideCount() + '</div>');

					$("div.stamp").on("click", "a.bx-prev", function(){

						stampBnr.goToPrevSlide();			
						var current = stampBnr.getCurrentSlide() + 1;
						$("div.stamp").find("div.pager span").text(current);

						return false
					});

					$("div.stamp").on("click", "a.bx-next", function(){
						
						stampBnr.goToNextSlide();			
						var current = stampBnr.getCurrentSlide() + 1;
						$("div.stamp").find("div.pager span").text(current);

						return false
					});
				}
			}

			return false
		});

		$("ul.eBoothView").on("click", "a", function(){
			$("div#popupBnr").fadeIn();
			return false;
		});

	}

	/*if ($("ul.subMenu").length) {
		$("ul.subMenu").removeClass().addClass("subMenu");

		for (var i=0;i<$("ul.subMenu").length;i++) {
			var reW = 100 / $("ul.subMenu").eq(i).find("li").length;
			$("ul.subMenu").eq(i).find("li").css({
				"width":reW + "%"
			});
		}
	}
*/

// 탭메뉴
	var tabArea = $(".tabArea");
	
	if (tabArea.length > 0) {
		
		for	(var i=0 ; i<tabArea.length ; i++) {
			var tabMenu = tabArea.eq(i).find("ul.tabMenu > li"),
				tabCon = tabArea.eq(i).find(".tabCon");
			
			tabMenu.removeClass("on").eq(0).addClass("on");
			tabCon.hide().eq(0).show();
		}
		
		tabArea.on("click", "ul.tabMenu a", function(){
			var currTabMenu =  $(this).parent().parent().parent().find("ul.tabMenu li"),
				currTabCon =  $(this).parent().parent().parent().find(".tabCon"),
				currIdx = $(this).parent().index();
		
			currTabMenu.removeClass("on").eq(currIdx).addClass("on");
			currTabCon.hide().eq(currIdx).show();
			
			if($(this).attr("href")) {
				return true
			} else {
				return false
			}
			
		});
		
	}

	if (tabArea.length > 0) {
		
		for	(var i=0 ; i<tabArea.length ; i++) {
			var tabMenu = tabArea.eq(i).find("ul.loginTab > li"),
				tabCon = tabArea.eq(i).find(".tabCon");
			
			tabMenu.removeClass("on").eq(0).addClass("on");
			tabCon.hide().eq(0).show();
		}
		
		tabArea.on("click", "ul.loginTab a", function(){
			var currTabMenu =  $(this).parent().parent().parent().find("ul.loginTab li"),
				currTabCon =  $(this).parent().parent().parent().find(".tabCon"),
				currIdx = $(this).parent().index();
		
			currTabMenu.removeClass("on").eq(currIdx).addClass("on");
			currTabCon.hide().eq(currIdx).show();
			
			if($(this).attr("href")) {
				return true
			} else {
				return false
			}
			
		});
		
	}



//placeholder
	var _placeholder = $("._placeholder");
	if (_placeholder.length) {
		_placeholder.placeholder();
	}



//toggle
	$("a.trigger").on("click", function(){
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");
		
		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class", "fas fa-caret-up");
			_currToggle.find(".toggleCon").fadeIn();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class", "fas fa-caret-down");
			_currToggle.find(".toggleCon").fadeOut();
		}
		
		//긴급공지추가
		$(".toggle_box_1").show();
		$(".toggle_box_2").hide();
		
		return false
	});

//Overview
	$("td.overview a").on("click", function(){
		
		if ($(this).attr("class") == "view") {
			$(this).removeClass("view");
			$(this).parent().parent().next().hide();
		} else {
			$(this).addClass("view");
			$(this).parent().parent().next().show();
		}
		

		return false
	});

//안내
	$("body").on("click", function(){
		var introNotice = $("div.intro dt.view");
		if (introNotice.length) {
			$("div.intro dt.view").removeClass("view");
			$("div.intro dd.toggleCon").hide();
			
			//긴급공지추가
			$(".toggle_box_1").show();
			$(".toggle_box_2").hide();
		}
	});




	
	$(".program td.con").on("click", function() {
		var $session_key = $(this).attr("session_key");
		if(typeof($session_key)!="undefined") {
			location.href = "/program/view.php?session_key=" + $session_key
		}
	});

	var goTop = $("#goTop");
	if (goTop.length) {

		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			if (scrollTop < 200) {
				goTop.hide();
			} else {
				goTop.show();
			}		
		});
		goTop.on("click", "a", function(){
			$(window).scrollTop(0);
		});
	
	}





	//위로 가기
	var wingBnrPosition = parseInt($("#quickMenu").css("top"));

	/*$(window).scroll(function() {
		var scrollTop = $(window).scrollTop();
		$("#quickMenu").stop().animate({"top":scrollTop+wingBnrPosition+"px"},1000);

		if ($("div.main").length) {
			$("#quickMenu").hide();

			var wrapper_h = $("div.wrapper").outerHeight(),
				win_h = $(window).height(),
				basic_h = wrapper_h - win_h - 100;
				//alert(scrollTop)
			if (scrollTop >= basic_h) {
				$(".scrolldown").fadeOut();
			} else {
				$(".scrolldown").fadeIn();
			}
		}
	});*/

	//posterView 상단 고정
	if ($("div.posterView").length) {

		$(window).scroll(function(){
			var scrollValue = $(window).scrollTop(),
				basic_h = 0;
			if (scrollValue > basic_h) {
				$("#headerWrap").addClass("fixed");
				$(".pageTit").addClass("fixed");
				$("div.util").addClass("fixed");
			} else {
				$("#headerWrap").removeClass("fixed");
				$(".pageTit").removeClass("fixed");
				$("div.util").removeClass("fixed");
			}

		});
	}


	//강의장
	if ($("div#player").length) {
		//if ($("dl.sponsor li").length > 7) {
		//	$("dl.sponsor ul").bxSlider({
		//		minSlides:7,
		//		maxSlides:7,
		//		moveSlides:1,
		//		slideWidth:155,
		//		slideMargin:10,			
		//		pager:false,
		//		auto:true
		//	});
		//}

	}


});


$(window).on("scroll", function() {
	//강의장


	if ($("div#player").length) {
		var basicH = $("div#player").offset().top,
			popupT = $("div#my_video").offset().top + 20;;
		
		var scrollTop = $(window).scrollTop(),
			scrollLeft = $(window).scrollLeft();

		for (var i=0;i<$("ul.playerMenu a.viewPopup").length;i++) {
			var viewPopup = $("ul.playerMenu a.viewPopup").eq(i),
				rePoLeft = viewPopup.offset().left - scrollLeft;
			$("dl.notice").eq(i).css("left", rePoLeft);
		}

		if (scrollTop >= basicH) {
			$(".playerPannel").addClass("fixed");
		} else {
			$(".playerPannel").removeClass("fixed");
			var popupT = popupT - scrollTop;
			$("dl.notice").css("top", popupT);
		}

		if (scrollLeft > 0) {
			for (var i=0;i<$("ul.playerMenu a.viewPopup").length;i++) {
				var viewPopup = $("ul.playerMenu a.viewPopup").eq(i),
					rePoLeft = viewPopup.offset().left - scrollLeft;
				$("dl.notice").eq(i).css("left", rePoLeft);
			}
		}

		
	}
});


// 브라우저창 사이즈가 변경될 때
$(window).resize(function(){
	initial();
});

function initial() {
	if ($(window).height() > 760) {
		setTimeout(function(){
			var re_minH = $(window).height() - $("div#headerWrap").outerHeight() - $("div#footerWrap").outerHeight(),
				con_minH = re_minH - $(".pageTit").outerHeight();

			if (con_minH < 630) {
				con_minH = 630
			}
			$("div#container").css("min-height", re_minH);
			$("div.contents").css("min-height", con_minH);
			$("div.main iframe").css("height", con_minH);
		}, 100);
	}


	if ($("dl.notice").length) {
		var popupT = $("div#my_video").offset().top + 20,
			scrollLeft = $(window).scrollLeft();
		$("dl.notice").css("top", popupT);

		for (var i=0;i<$("ul.playerMenu a.viewPopup").length;i++) {
			var viewPopup = $("ul.playerMenu a.viewPopup").eq(i),
				rePoLeft = viewPopup.offset().left- scrollLeft;
			$("dl.notice").eq(i).css("left", rePoLeft);
		}
	

	}
}


