// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	
// 최소 높이 설정
	setTimeout(function(){
		conMinH();
	}, 500);

	$("div.toolTip .close a").on("click", function(){
		if( $(this).attr("data") != "none" ){
			$(this).parent().parent().hide();
			return false
		}
	});

	if ($("div.bnrZone li").length > 3) {
		$("div.bnrZone ul").bxSlider({
			slideWidth:80,
			slideMargin:10,
			minSlides:3,
			maxSlides:3,
			moveSlides:1,
			pager:false,
			auto:true
		});
	}


	if ($("ul.stamp").length > 1) {
		$("div.rollingArea").bxSlider({
			slideWidth:210,
			slideMargin:20,
			infiniteLoop:false
		});
	}


	if ($("div.boothRolling li").length > 1) {
		var re_padding = ($(window).height() - $("ul.conMenu").outerHeight() - $("div.close").outerHeight() - $("div.boothRolling li").outerHeight()) / 2;

		$("div.boothRolling").css({
			"padding": re_padding + "px 0"
		});

		$("div.boothRolling ul").bxSlider({});
	}

//toggle	
	$(document).on("click","a.trigger",function() {
		var _currToggle = $(this).parent().parent(),
			sClass = _currToggle.attr("class");

		if (sClass.indexOf("view") > 0) {
			_currToggle.removeClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-up", "-down");
			});
			_currToggle.find(".toggleCon").slideUp();
		} else {
			_currToggle.addClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-down", "-up");
			});
			_currToggle.find(".toggleCon").slideDown();
		}

		return false
	});


// 탭메뉴
	var tabArea = $(".tabArea");
	
	if (tabArea.length) {
		
		for (var i=0 ; i<tabArea.length ; i++) {
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


			conMinH();

			return false
		});
		
	}



});

$(window).resize(function(){

// 최소 높이 설정
	setTimeout(function(){
		conMinH();
	}, 500);

});

function conMinH() {
	var win_h = $(window).height();
	
	$("#player").css({
		"min-height":win_h
	});

	if ($("div.webinarMain").length) {
		var re_minH = $("ul.wsMenu").outerHeight() + (parseInt($("ul.wsMenu").css("bottom")) * 2)
		$("body").addClass("bg");
		$("div.webinarMain").css({
			"min-height":re_minH
		});
	}

	var vMiddle_h = $("div.vMiddle").outerHeight();
	if (vMiddle_h < win_h) {
		var reM_t = (win_h - vMiddle_h) / 2;

		$("div.vMiddle").css({
			"height":win_h
		});

		$("div.vMiddle> *").css({
			"margin-top":reM_t
		});
	}
}