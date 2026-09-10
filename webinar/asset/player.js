// DOM 이 모두 로드 되었을 때 실행

var eBoothBnr = null;
jQuery(function($) {
	
// 최소 높이 설정
	conMinH();
	
	if ($("dl#eBooth").length) {
		$("div#player").addClass("eBooth");

		var eBooth_eaW = 180,
			eBoothW = (eBooth_eaW * 7) + 60,
			re_poLeft = eBoothW * (-1); 

		$("dl#eBooth > dt a").addClass("view");
/*
		$("dl#eBooth").css({
			"left":re_poLeft
		});
		$("dl#eBooth dd li").css({
			"width":eBooth_eaW
		});
*/


		if ($("dl#eBooth li").length > 8) {

			if (eBoothBnr != null) {
				eBoothBnr.destroySlider();
				eBoothBnr = null;
			} 
			eBoothBnr = $("dl#eBooth ul").bxSlider({
				minSlides:7,
				maxSlides:7,
				moveSlides:1,
				slideWidth:180,
				slideMargin:10,
				auto:true,
				pager:false
			});
		
		}


		$("dl#eBooth > dt a").on("click", function(){
			if ($(this).attr("class") == "view") {
				$(this).removeClass("view");
				$("dl#eBooth").animate({
					"left":($("dl#eBooth").width() * (-1))
				}, 1000);
			} else {
				$(this).addClass("view");
				$("dl#eBooth").animate({
					"left":0
				}, 1000);

			}
		});		

	}


	$(".viewTitle a").on("click", function(){
		if ($(this).attr("class") == "view") {
			$("div.playerTit").slideDown();
			$(this).removeClass("view").text("제목 닫기");
		} else {
			$("div.playerTit").slideUp();
			$(this).addClass("view").text("제목 보기");
		}
		return false
	});


	$("ul.playUtil a").on("click", function(){
		var chk  = $(this).attr("types");
		
		if( chk == null ){ return false; }
		
		if( chk != "pdf" ){
			if ($(this).attr("class") == "on") {
				$("ul.playUtil a").removeClass("on");
				$("div."+chk).hide();
			} else {
				$("ul.playUtil a").removeClass("on");
				$(this).addClass("on");
				$("div.utilPopup").not($(this)).hide()
				$("div."+chk).fadeIn();
			}
			return false;
		}	
	});

	// $("body").not("ul.playUtil a").on("click", function(){
		// $("ul.playUtil a").removeClass("on");
		// $("div.utilPopup").hide();
	// });

	if ($("dl.roomInfo").length > 1) {
		$("div#poupEnterence, div.enterenceUtil").css({
			"width":"calc(100% - 420px)",
			"margin-left":80
		});

		$("div.playerPannel").css({
			//"z-index":1000
		});

		var swiper = new Swiper('.swiper-container', {
		  slidesPerView: 2,
		  centeredSlides: false,
		  spaceBetween: 30,
		  pagination: {
			el: '.swiper-pagination',
			clickable: true,
		  },
		  navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		  },
		});

	}

	if ($("ul.playMore li").length > 5) {
		$("ul.playMore").removeClass("col3ea");
		$("ul.playMore").addClass("col3ea");
	}



//게시판
	bbsTit();



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

		return false
	});

	var stampBnr = null;


/*
	$("div#popupEbooth").on("click", "a", function(){
		var sClass = $(this).attr("class"),
			showCon = "div." + sClass;

		if (sClass == "vodArea") {
			
			$("div#popupEbooth > div").hide();
			$(showCon).show();

		} else if (sClass == "stamp") {

			$("div#popupEbooth > div").hide();
			$("a.stamp").hide();
			$("a.guestBook").show();
			$(showCon).show();

			if (stampBnr != null) {
				stampBnr.destroySlider();
				stampBnr = null;
			}

			if (stampBnr == null) {
				if ($("div.stampList > div").length > 1) {
					stampBnr = $("div.stampList").bxSlider({
						infiniteLoop:false,
						hideControlOnEnd:true,
						pager:false
					});
				}
			}

		} else if (sClass == "guestBook") {

			$("div#popupEbooth > div").hide();
			$("a.stamp").show();
			$("a.guestBook").hide();
			$(showCon).show();

		}

	});

*/
});


// 페이지가 리사이징 될때마다
$(window).resize(function(){
						
// 페이지 높이값 설정
	conMinH();


});

var bnr_onair = null;

function conMinH() {

	if ($("div.playerPannel").length) {
		$("body").addClass("player");
		if ($("dl#onair").length) {
			$("div#playzone").addClass("onair");

			var view_w = $(window).width() - $("div.playerPannel").outerWidth() - 20;
			$("dl#onair").css({
				"margin-left": view_w * (-1)			
			});

			$("dl#onair").on("click", "dt a", function(){

				if ($("dl#onair > dt").attr("class") == "view") {
					$("dl#onair > dt").removeClass("view");
					$("dl#onair").animate({
						"margin-left": view_w * (-1)		
					}, 1000);

					setTimeout(function(){
						bnr_onair.destroySlider();
						bnr_onair = null;
					}, 500)
					
				} else {
					$("dl#onair > dt").addClass("view");
					$("dl#onair").animate({
						"margin-left": 0		
					}, 1000);

					if (bnr_onair == null) {
						
						bnr_onair = $("dl#onair ul").bxSlider({
							mode:'vertical',
							pause:3000,
							speed:2000,
							auto:true,
							controls:false,
							pager:false
						});
					}


				}
				
				return false
			});

			$("dl#onair").on("click", ".close a", function(){
				$("dl#onair > dt").removeClass("view");
				$("dl#onair").animate({
					"margin-left": view_w * (-1)		
				}, 1000);
				
				setTimeout(function(){
					bnr_onair.destroySlider();
					bnr_onair = null;
				}, 1000)
							
				return false
			});

		}

		if($(window).height() > 930) {
			var re_minH = $("div.playerPannel > ul").outerHeight() + parseInt($("div.playerPannel").css("padding-bottom")),
			re_H = $(window).height();

		if ($(window).height() < re_minH) {
			re_H = re_minH
		}

		
		$("body.player, div.playerPannel").css({
			"height": re_H,
			"min-height": re_minH
		});
		
		$("dl.room dd.list").css({
			"height": re_H - 90 - $("div.btn").outerHeight() - $("div.userInfo").outerHeight() - $("div.util").outerHeight() - $("ul.playMenu").outerHeight()  - $("ul.playMore").outerHeight()  - $("dl.room > dt").outerHeight() - $("dl.room > dd.chiars").outerHeight() - $("div.onAir").outerHeight()
		});

		}

	}



}


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
			}
				bbsLink.css({
					"width" : bbsLink_reWidth,
					"padding-right" : re_paddingR
				});
				bbsLink.find("span:first-child").width(bbsLink_reWidth);


		}
	}

}

