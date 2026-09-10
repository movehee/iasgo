
// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	
// 최소 높이 설정
	conMinH();

	$("div#header").on("click", "a.viewMenu", function(){
		$("dl.related div").show();
		
		return false
	});


	$("div#header").on("click", "dl.related p.close a", function(){
		$("dl.related div").hide();
		
		return false
	});

// Gnb
	$("div#header").on("click", "a.viewGnb", function(){
		$("div.gnbWrap").fadeIn(800);

		$("div.gnbWrap > div").animate({
			"margin-left":0
		}, 800);
		return false
	});
	
	$("div.gnbWrap").on("click", ".close a", function(){
		
		$("div.gnbWrap").fadeOut(800);

		$("div.gnbWrap > div").animate({
			"margin-left":"-100%"
		}, 800);
		return false
	});


//gnb > subMenu
	$("ul#gnb").on("click", "a.subMenu", function(){
		//alert("a")
		$(this).toggleClass("on");
		$(this).next().slideToggle();

		return false
	});



// Lnb
	$("div#lnb").on("click", "dt a", function(){
		var _currMenu = $(this).parent().parent(),
			sClass = _currMenu.attr("class");
		
		if (sClass == "view") {
			_currMenu.removeClass("view");
			_currMenu.find(".lnbMenu").slideUp();
		} else {
			_currMenu.addClass("view");
			_currMenu.find(".lnbMenu").slideDown();
		}
		
		return false
	});

	$("div.wrapper").not("div#lnb").on("click", function(){
		$("div#lnb dl").removeClass("view");
		$("div#lnb dl").find(".lnbMenu").slideUp();
		
	});

// 메인배너
	if ($("div.mainBnr li").length > 1) {
		$("div.mainBnr ul").bxSlider({
			controls:false,
			auto:true
		});
	}
	
	
// 포토 뉴스
	if ($("div.photoBbs li").length > 1) {
		var photoCon_w = $("div.photoBbs").width(),
			photoEa_w = photoCon_w / 2,
			photoEa_h = $("div.photoBbs li").height(),
			$bnrStart = null;
			
		$("div.photoBbs ul").css({
			"height": photoEa_h
		});
			
		$("div.photoBbs li").css({
			"width": photoEa_w
		});

		//배너 자동롤링
		$bnrStart = setInterval(function(){
			var bnrClone = $("div.photoBbs li").eq(0);
			$("div.photoBbs ul").append(bnrClone);
			$("div.photoBbs li").removeClass("on").eq(0).addClass("on");
		}, 1500);



		$("div.photoBbs").on("click", "p.next a", function(){
			
			if ($bnrStart !== null) {
				clearTimeout($bnrStart);
			}
			
			$("div.photoBbs li").removeClass("on").eq(0).addClass("on");
			
			setTimeout(function(){
				var bnrClone = $("div.photoBbs li").eq(0);
				$("div.photoBbs ul").append(bnrClone);
				$("div.photoBbs li").removeClass("on").eq(0).addClass("on");
			}, 500);
		
			return false
		});

		$("div.photoBbs").on("click", "p.prev a", function(){
			
			if ($bnrStart !== null) {
				clearTimeout($bnrStart);
			}
			$("div.photoBbs li").removeClass("on").eq(0).addClass("on");

			
			setTimeout(function(){
				var bnrClone = $("div.photoBbs li").eq($("div.photoBbs li").length - 1);
				$("div.photoBbs ul").prepend(bnrClone);
				$("div.photoBbs li").removeClass("on").eq(0).addClass("on");
			}, 500);

			
			return false
		});
		


		
/*
		$("div.photoBbs ul").bxSlider({
			speed:700,
			maxSlides:2,
			minSlides:2,
			moveSlides:1,
			slideWidth:photoEa_w,
			pager:false,
			auto:true
		});


		$("div.photoBbs ul").bxSlider({
			maxSlides:2,
			minSlides:2,
			moveSlides:1,
			slideWidth:photoEa_w,
			pager:false,
			auto:true,
			onSliderLoad: function(){
				list_ea = $("div.photoBbs li").length
				$("div.photoBbs li").removeClass("on").eq(nIdx).addClass("on");
				nIdx++
			},
			onSlideAfter: function(){
				if (nIdx == basicEa) {
					nIdx = 2
				}
				$("div.photoBbs li").removeClass("on").eq(nIdx).addClass("on");
				nIdx++
			},
			onSlidePrev: function() {
				setTimeout(function(){
					$("div.photoBbs li").removeClass("on").eq(2).addClass("on");
				}, 600)
				
			}
		});
*/
	}


//subMenu
	$("dl.subMenu").on("click", "dt a", function(){
		$(this).toggleClass("on");
		$("dl.subMenu > dd").slideToggle();

		return false
	});

//Toggle
	$("a._toggle").on("click", function(){
		var _currPer = $(this).parent().parent(),
			sClass = _currPer.attr("class"),
			num = sClass.lastIndexOf("on");
		
		if (num > 0) {
			_currPer.removeClass("on");
			_currPer.find(".toggleCon").hide();
		} else {
			_currPer.addClass("on");
			_currPer.find(".toggleCon").show();
		}

		return false
	});


//searchArea
	$("dl.searchArea").on("click", "dt a", function(){
		
		$(this).toggleClass("view");
		$("dl.searchArea > dd").slideToggle();

		return false
	});


//키보드 보기
	$("dl.keyboard").on("click", "dd p>a", function(){
		var nIdx = $(this).parent().parent().index();
		
		if (nIdx == 0) {
			nIdx = 1;
		} else {
			nIdx = 0;
		}
		$("dl.keyboard > dd > div").hide().eq(nIdx).show();

		return false
	});


//radion, checkbox 체크시 bg  변경
	$("span.changeBg input").on("change", function(){
		//$(this).parent().toggleClass("on");
	});

// 레이어팝업
	$("a._viewPop").on("click", function(){
		$("div.layerPopup").show();
		$("body").addClass("overHidden");
		
		return false
	});
	
	$("div.layerPopup").on("click", ".close", function(){
		$("div.layerPopup").hide();
		$("body").removeClass("overHidden");
		
		return false
	});

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

			return false
		});
		
	}

//게시판 타이틀관련 
	var bbsList = $("dl.bbsItem");
	if (bbsList.length) {
		bbsItemTit();
	}	

});



// 페이지내 모든 요소가 로드되었을 때 실행
$(window).resize(function(){
						
// 페이지 높이값 설정
	conMinH();

//게시판 타이틀관련 
	var bbsList = $("dl.bbsItem");
	if (bbsList.length) {
		bbsItemTit();
	}		
});




function conMinH() {
	var win_h = $(window).height(),
		header_h = $("div#header").outerHeight(),
		footer_h = $("div#footer").outerHeight() + parseInt($("div#footer").css("margin-top")) + parseInt($("div#footer").css("margin-bottom")),
		lnb_h = $("div#lnb").outerHeight(),
		con_space = parseInt($("div.contents").css("padding-top")) + parseInt($("div.contents").css("padding-bottom"));
		con_minH = win_h - header_h - lnb_h - con_space - footer_h,
		fixedArea = $("div#fixedArea");


//하단 고정영역이 있을 경우
	if (fixedArea.length) {
		var fixedArea_h = fixedArea.outerHeight();
		
		$("div.wrapper").css({
			"min-height":win_h - fixedArea_h,
			"padding-bottom":fixedArea_h		
		});

		$("div.contents").css({"min-height":con_minH - fixedArea_h});
		

	} else {

		$("div.wrapper").css({"min-height":win_h});
		$("div.contents").css({"min-height":con_minH});

	}

// 공유버튼 보기
	$("div#lnb").on("click", "p.share a", function(){
		var reHeight = $(window).height() - $("div#header").outerHeight() - $("div#lnb").outerHeight(); 
		
		$("dl#share").height(reHeight);
		$("dl#share").toggle();
		return false
	});

	$("dl#share").on("click", "p.close a", function(){
		$("dl#share").hide();
		return false
	});

}


//게시판 리스트
function bbsItemTit() {
	var bbsList = $("dl.bbsItem");

	for (var i=0 ; i < bbsList.length ; i++) {
		var bbsTitArea = bbsList.eq(i).find("dt"),
			bbsTitArea_w = bbsTitArea.outerWidth(),
			bbsTit = bbsTitArea.find("a"),
			bbsIcon = bbsTitArea.find("span.icon");
			bbsIcon_w = bbsIcon.outerWidth();

		bbsTit.css({
			"width":"auto"
		});

		if (bbsIcon.length) {
			var rePaddingR = bbsIcon_w + 5;

		} else {
			var rePaddingR = 0		
		}

		var bbsTit_reW = bbsTitArea_w - rePaddingR;
		bbsTitArea.find("a").css({
			"padding-right":rePaddingR
		});

		var bbsTit_w = bbsTit.outerWidth();
		if (bbsTit_w > bbsTitArea_w) {
			
			bbsTitArea.find("a").css({
				"width":bbsTit_reW
			});
		}
	}

	if ($("div.bbsView").length) {
		var bbsTitArea = bbsList.find("dt"),
			bbsTitArea_w = bbsTitArea.outerWidth(),
			bbsTxt = bbsTitArea.find("span.tit");
			bbsTxt_w = bbsTxt.outerWidth();
			bbsIcon = bbsTitArea.find("span.icon");
			bbsIcon_w = bbsIcon.outerWidth();
			
		if (bbsIcon.length) {
			var rePaddingR = bbsIcon_w + 5;

		} else {
			var rePaddingR = 0		
		}

		var bbsTit_reW = bbsTxt_w + rePaddingR;
		if (bbsList.width() < bbsTit_reW) {
			bbsTit_reW = bbsList.width() - rePaddingR;
		} else {
			bbsTit_reW = bbsTit_reW - rePaddingR;
		}
		
		bbsTitArea.css({
			"width":bbsTit_reW,
			"padding-right":rePaddingR
		});

	}

}



