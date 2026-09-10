
// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	
// 최소 높이 설정
	conMinH();



	var toggleArea = $(".toggleArea, div.session, div.abstract");

	toggleArea.on("click", "a.trigger", function(){
		var _currToggle = $(this).parent().parent(),
			_currToggleCon = _currToggle.find(".toggleCon");
		
		$(this).toggleClass("view");
		_currToggleCon.slideToggle();

		return false
	});

	$("a.search_btn").on("click", function(){
		$("div.searchArea").toggle();
		return false
	});
	$(".searchkey").on("click", function(){
		$("div.searchArea").toggle();
		return false
	});
	
	if ($("div.rollingArea").length) {
		$("div.rollingArea > ul").bxSlider({
			adaptiveHeight:true,
			pagerType: 'short'
		});
	}


//radion, checkbox 체크시 bg  변경
	$("span.changeBg input").on("change", function(){
		//$(this).parent().toggleClass("on");
	});

//팝업 보기
	$("a.viewPop").on("click", function(){
		var win_h = $(window).height(),
			popup_reH = win_h - 80;

		$("div.wrapper").css({
			"overflow":"hidden",
			"height":win_h
		});
		$("div.popupCon").outerHeight(popup_reH);
		$("div.popupWrap").show();

		//Sponsors 팝업
		if ($("div.popupWrap").attr("id") == "popupSponsor") {
			var reH = popup_reH - parseInt($("div.popupCon").css("padding-top")) - parseInt($("div.popupCon").css("padding-bottom")) - $("dl.sponsorInfo").outerHeight() - 20;
			$("#popupSponsor div.scrollArea").height(reH);
		}

		return false
	});
	
	$(".close a").on("click", function(){
		$("div.wrapper").css({
			"overflow":"visible",
			"height":"auto"
		});

		$("div.popupWrap").hide();

		return false
	});

	
	if ($("div.rollingArea").length) {
		$("div.rollingArea > ul").bxSlider({
			adaptiveHeight:true,
			pagerType: 'short'
		});
	}

	$("a.trigger").on("click", function(){
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");
		
		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class", "fas fa-caret-up");
			_currToggle.find(".toggleCon").slideDown();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class", "fas fa-caret-down");
			_currToggle.find(".toggleCon").slideUp();
		}

		return false
	});



//Product
	var product = $("div.productBnr");
	if (product.length) {

		var productBnr = $("div.productBnr li");
		if (productBnr.length > 1) {
			$("div.productBnr ul").bxSlider({
				controls:false
			});
		}
	}


//PubReader
	if ($("div#pubReader").length) {
		var reHeight = $(window).height();

		$("div#pubReader").height(reHeight);
	}

//검색관련 script
	var resultArea = $("div.resultArea");
	if (resultArea.length) {
		var resultArea_h = $("div.resultArea").outerHeight(),
			con_h = $("div#containerWrap").height() - $("div.titArea").outerHeight() - $("div.searchArea").outerHeight();

		if (con_h > resultArea_h) {
			$("div.resultArea").height(con_h);
		}
	}

	var newSearch = $("a._newSearch");
	if (newSearch.length) {
		$("a._newSearch").on("click", function(){
			$("input._newSearch").focus().val("");
		
			return false
		});
	}


//검색
	var resultArea = $("ul.resultList");
	if (resultArea.length) {
		var conH = $("div.contents").height(),
			searchAreaH = $("div.searchArea").outerHeight(),
			resultEa = resultArea.find("li");
	
		resultArea.css({"min-height":conH - searchAreaH});
		
		if (resultEa.length) {
			resultArea.css({"background":"none"});
		}
	}


//세로 정렬 영역
	if ($(".tblCell").length) {
		var reWidth = $(".tblCell").parent().width()
		$(".tblCell").width(reWidth);
	}



	var goTop = $(".goTop");
	if (goTop.length) {
		var scrollTop = $(window).scrollTop();
		if (scrollTop < 100) {
			goTop.hide();
		} else {
			goTop.show();
		}		

		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			if (scrollTop < 100) {
				goTop.hide();
			} else {
				goTop.show();
			}		
		});
	}

});



// 페이지내 모든 요소가 로드되었을 때 실행
$(window).resize(function(){
						
// 페이지 높이값 설정
	conMinH();


});




function conMinH() {
	var win_h = $(window).height(),
		header_h = $("div.titArea").outerHeight(),
		footer_h = $("div#footerWrap").outerHeight(),
		con_minH = win_h - header_h - footer_h,
		fixedArea = $("div#fixedArea"),
		scrollArea = $("div.scrollArea");


//하단 고정영역이 있을 경우
	if (fixedArea.length) {
		var fixedArea_h = fixedArea.outerHeight();
		
		$("div.wrapper").css({
			"min-height":win_h - header_h - fixedArea_h,
			"padding-top":header_h,
			"padding-bottom":fixedArea_h		
		});

		$("div.contents").css({"min-height":con_minH - fixedArea_h});
		

	} else {

		$("div.wrapper").css({
			"min-height":win_h - header_h,
			"padding-top":header_h
		});
		$("div.contents").css({"min-height":con_minH});

	}


//스크롤 영역이 있는 경우
	if (scrollArea.length) {
		var space = $("ul.subMenu").outerHeight() + $(".conMenu").outerHeight(),
			scroArea_h = con_minH - space;

		scrollArea.css({"height":scroArea_h});
	}

	var caseList = $("ul.caseList"),
		conH = $("div.contents").height();
	if (caseList.length) {
		caseList.css({
			"min-height":conH
		})
	}


}

