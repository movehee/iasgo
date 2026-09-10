
// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {

	if ($("div.regist").length) {
		$("div#headerWrap").hide();
	}


	if ($("div.topBnr").length) {
		$("div#headerWrap").addClass("bg");
	}


	if ($("div.eposter").length) {
		$("div#container").addClass("eposter");
	}



	if ($(".virtual").length) {
		$("div#container").addClass("bg");
	}



	if ($(".ebooth").length) {
		$("div.wrapper").addClass("ebooth");

		if ($(".gold").length) {
			$("div#container").addClass("gold");
		}
		if ($(".angel").length) {
			$("div#container").addClass("angel");
		}
	}





// 공지사항
	if ($("dl.introBbs").length) {
		setTimeout(function(){
			$("dl.introBbs").animate({
				"height":113,
				"opacity":1
			}, 1000);
		
		}, 4000);

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

// 레이어팝업 보기


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




	$("a.trigger").on("click", function(){
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");
		
		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-down", "-up");
			});
			_currToggle.find(".toggleCon").show();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-up", "-down");
			});
			_currToggle.find(".toggleCon").hide();
		}

		return false
	});




});





//게시판 리스트

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

			var bbsLinkTxt_w = bbsLink.find("span:first-child").width() + 30;
			if (bbsLinkTxt_w < bbsLink_reWidth) {
				bbsLink_reWidth = bbsLinkTxt_w;				
			} 

			var sClass = bbsLink.attr("class"),
				re_paddingR = 0;

			if (sClass != null) {
					bbsNew = sClass.indexOf("new"),
					bbsFile = sClass.indexOf("attach"),
					bbsReply = sClass.indexOf("reply");

				if (bbsNew != -1) {
					bbsLink_reWidth = bbsLink_reWidth - bbsLink.find("img.new").outerWidth();				
					re_paddingR = re_paddingR + bbsLink.find("img.new").outerWidth();

					if (bbsFile != -1) {
						re_paddingR = re_paddingR + bbsLink.find(".attach").outerWidth();
						bbsLink_reWidth = bbsLink_reWidth - bbsLink.find(".attach").outerWidth();				
					}

					if (bbsReply != -1) {
						bbsLink_reWidth = bbsLink_reWidth - bbsLink.find("img.new").outerWidth();				
						re_paddingR = re_paddingR + bbsLink.find(".reply").outerWidth();
					}

					if ((bbsFile != -1) && (bbsReply != -1)) {
						bbsLink_reWidth = bbsLink_reWidth - bbsLink.find(".reply").outerWidth() - bbsLink.find(".attach").outerWidth();				
						re_paddingR = re_paddingR + bbsLink.find(".reply").outerWidth() + bbsLink.find(".reply").outerWidth();
					}
				}

				if (bbsFile != -1) {
					bbsLink_reWidth = bbsLink_reWidth - bbsLink.find(".attach").outerWidth();		
					re_paddingR = re_paddingR + bbsLink.find(".attach").outerWidth();

					if (bbsReply != -1) {
						bbsLink_reWidth = bbsLink_reWidth - bbsLink.find(".reply").outerWidth() ;				
						re_paddingR = re_paddingR + bbsLink.find(".reply").outerWidth();
					}

				}


			}

			bbsLink.css({
				"width" : bbsLink_reWidth + 5,
				"padding-right" : re_paddingR
			});
			bbsLink.find("span:first-child").width(((bbsLink_reWidth + 5) - re_paddingR));


		}
	}

}

