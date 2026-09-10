// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {

	$("div.speakerSlide").bxSlider({
		moveSlides:1,
		minSlides: 1,
		maxSlides: 1,
		pager:false,
		controls:false,
		auto:true
	});	

//GNB
	
		
	$("div#headerWrap").after('<div class="gnbBg"></div>');
	var gnbBg = $("div.gnbBg"),
		hideMenu = null,
		gnbBg_h = $("ul#gnb > li:first-child ul").outerHeight();

		$("ul#gnb ul").hide();

	
	gnbBg.on("mouseenter", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu);
		}
	});

		$("ul#gnb > li").on("mouseenter", function(){
			if (hideMenu != null) {
				clearTimeout(hideMenu);
			}
			
			gnbBg.height(gnbBg_h);

			if ($(this).attr("class") != "on") {
				$("ul#gnb ul").slideDown();
				gnbBg.slideDown();
				
				$("ul#gnb > li").removeClass("on");			
				$(this).addClass("on");
			
			}
			
		});
		
		$("ul#gnb, div.gnbBg").on("mouseleave", function(){
			
			hideMenu = setTimeout(function(){
				gnbBg.slideUp();
				
				$("ul#gnb > li").removeClass("on");
				$("ul#gnb").find("ul").hide();		
			}, 700);

		});

//main
	var sClass = $("div#container").attr("class");
	if (sClass == "main") {

	} else {


	}



	if ($("dl.dia li").length > 4) {
		
		$("dl.dia ul").bxSlider({
			moveSlides:1,
			minSlides: 3,
			slideWidth: 345,
			maxSlides: 3,
			pager:false,
			controls:true,
			auto:true
		});
	}

	if ($("dl.plat li").length >= 3) {
		
		$("dl.plat ul").bxSlider({
			moveSlides:1,
			minSlides: 2,
			slideWidth: 305,
			maxSlides: 2,
			pager:false,
			controls:true,
			auto:true
		});
	}

	if ($("dl.gold li").length >= 2) {
		
		$("dl.gold ul").bxSlider({
			moveSlides:1,
			minSlides: 1,
			slideWidth: 305,
			maxSlides: 1,
			pager:false,
			controls:true,
			auto:true
		});
	}



//LNB
	if ($("div.lnbWrap").length) {
		hideMenu = null;

		$("div.lnbWrap *").removeAttr("style");
		$("div.lnbWrap dd.toggleCon").show();

		for (var i=0;i<$("div.lnbWrap dl").length;i++) {
			var reW = $("div.lnbWrap dl").eq(i).outerWidth() + 20;
			
			$("div.lnbWrap dl").eq(i).width(reW).find("dd").hide();
		}

		if ($("div.lnbWrap").length) {

			$("body:not(div.lnbWrap)").on("click", function(){
				$("div.lnbWrap dt").removeClass("view");
				$("div.lnbWrap dt i").attr("class", "fas fa-caret-down");
				$("div.lnbWrap .toggleCon").slideUp();
			});

		}

	}




//게시판 타이틀관련 
	var bbsList = $("table.bbs, dl.bbsList");
	if (bbsList.length) {
		setTimeout(function(){
			bbsTit();
		}, 50);
		
	}


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
			var currTabMenu =  tabArea.find("ul.tabMenu li"),
				currTabCon =  tabArea.find(".tabCon"),
				currIdx = $(this).parent().index();
		
			currTabMenu.removeClass("on").eq(currIdx).addClass("on");
			currTabCon.hide().eq(currIdx).show();

			return false
		});
		
	}



//placeholder
	var _placeholder = $("._placeholder");
	if (_placeholder.length > 0) {
		_placeholder.placeholder();
	}



//toggle
	$("a.trigger").on("click", function(){
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");
		
		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-down", "-up");
			});
			_currToggle.find(".toggleCon").slideDown();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-up", "-down");
			});
			_currToggle.find(".toggleCon").slideUp();
		}

		return false
	});


});



// 페이지내 모든 요소가 로드되었을 때 실행
$(window).load(function(){
						


});





function bbsTit() {
	$("table.bbs td.tit a").removeAttr("style");
	$("table.bbs td.tit span").removeAttr("style");

	var bbsList = $("table.bbs");
	if (bbsList.length) {
		var bbsTit = $("table.bbs .tit"),
			bbsTit_w = $("table.bbs .tit").width();

		for (var i=0 ; i < bbsTit.length ; i++) {

			var bbsLink = bbsTit.eq(i).find("a"),
				bbsLink_reWidth = bbsTit_w;

			bbsLink.width(bbsLink_reWidth);
			bbsLink.find("span:first-child").css("width","auto");

			var bbsLinkTxt_w = bbsLink.find("span:first-child").width();
			if (bbsLinkTxt_w < bbsLink_reWidth) {
				bbsLink_reWidth = bbsLinkTxt_w;				
			} 

			var sClass = bbsLink.attr("class"),
				re_paddingR = 5;

			if (sClass != null) {
					bbsNew = sClass.indexOf("new"),
					bbsFile = sClass.indexOf("attach"),
					bbsReply = sClass.indexOf("reply");

				if (bbsNew != -1) {
					bbsLink_reWidth = bbsLink_reWidth - bbsLink.find("img.new").outerWidth();				
					re_paddingR = re_paddingR + bbsLink.find("img.new").outerWidth();
				}
				if (bbsFile != -1) {
					bbsLink_reWidth = bbsLink_reWidth - bbsLink.find(".attach").outerWidth();		
					re_paddingR = re_paddingR + bbsLink.find(".attach").outerWidth();
				}
				if (bbsReply != -1) {
					bbsLink_reWidth = bbsLink_reWidth - bbsLink.find("span.reply").outerWidth();		
					re_paddingR = re_paddingR + bbsLink.find("span.reply").outerWidth();
				}

				if ((bbsNew != -1) && (bbsFile != -1) && (bbsReply != -1)) {
					var re_poRight = bbsLink.find("span.reply").outerWidth() + bbsLink.find("img.new").outerWidth() + 4
					bbsLink.find(".attach").css({"right":re_poRight})
				}
				
				var bbsLink_sumW = bbsLink_reWidth + re_paddingR;
				if (bbsLink_sumW < (bbsTit_w - 10)) {
					bbsLink_reWidth = bbsLink.find("span:first-child").width() + 5;
				}
				bbsLink.css({
					"width" : bbsLink_reWidth,
					"padding-right" : re_paddingR
				});
				bbsLink.find("span:first-child").width(bbsLink_reWidth);
			}


		}
	}

}