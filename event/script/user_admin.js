// DOM 이 모두 로드 되었을 때 실행
jQuery(function(){

	var gnbEa = $("ul#gnb>li"),
		gnbEa_reW = 100 / gnbEa.length,
		hideMenu = null;

	gnbEa.css({
		"width":gnbEa_reW + "%"
	});

	for (var i=0;i<gnbEa.length;i++) {
		var re_poLeft = gnbEa.eq(i).position().left
		gnbEa.eq(i).find("ul").css({
			"min-width":gnbEa.eq(i).outerWidth(),
			"left":re_poLeft
		})
	}

	$("ul#gnb > li").on("mouseenter", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu)
		}

		$("ul#gnb > li > a").blur();
		$("ul#gnb > li").removeClass("on");
		$("ul#gnb ul").hide();
		$(this).find("ul").stop().slideDown();
	});

	$("ul#gnb ul").on("mouseenter", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu)
		}
		$(this).parent().addClass("on");
	});

	$("ul#gnb").on("mouseleave", function(){
		if (hideMenu != null) {
			clearTimeout(hideMenu)
		}
		
		hideMenu = setTimeout(function(){
			$("ul#gnb > li > a").blur();
			$("ul#gnb > li").removeClass("on");
			$("ul#gnb ul").slideUp();
		}, 500);
	});



	if ($("dl.otherAdmin").length) {
		$("dl.otherAdmin dt").addClass("view");
		$("dl.otherAdmin dd").show();

		setTimeout(function(){
			$("dl.otherAdmin dt").removeClass("view");
			$("dl.otherAdmin dd").slideUp();
		}, 1000);
	}

	$("#changeLayout").on("click", function(){
		var sClass = $("div#container").attr("class"),
			lnbEa = $("ul#lnb>li"),
			lnbEa_reW = 100 / lnbEa.length;

		
		var wideStatus = false;
		if (sClass == "wide") {
			$("div#container").removeClass("wide");
			$("#changeLayout").text("와이드화면 전환");
		} else {
			lnbEa_reW = lnbEa_reW - 0.5;
			$("div#container").addClass("wide");
			$("#changeLayout").text("기본화면 전환");
			wideStatus = true;
		}

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/admin/session_wide.php',
			async: false,
			data: {'wideStatus' : wideStatus}
		}).done(function( r ) {
			if(!r._return){
				//alert(r.msg);
			}
		});
		if ($("ul#lnb").length) { 


		}

		lnbEa.css({
			"width":lnbEa_reW + "%"
		});

		return false
	});



	if ($("ul#lnb").length) { 
		var sClass = $("div#container").attr("class");

		var lnbEa = $("ul#lnb>li"),
			lnbEa_reW = 100 / lnbEa.length;

		if (sClass == "wide") {
			lnbEa_reW = lnbEa_reW - 0.5;
		}

		lnbEa.css({
			"width":lnbEa_reW + "%"
		});
	}

	if ($("ul.conMenu_admin").length) { 

		$("div.contents").addClass("fr")
	}

	if ($("div#gnbSearch").length) {
		$("div#gnbSearch").on("click", "p.close a", function(){
			var sClass = $(this).attr("class");
			if (sClass == "hide") {
				$(this).removeClass("hide");
				$(this).attr("title", "검색창 숨김");
				$(this).find("i").attr("class", "fas fa-times");
				$("div#gnbSearch div.formArea").fadeIn();
			} else {
				$(this).addClass("hide");
				$(this).attr("title", "검색창 보기");
				$(this).find("i").attr("class", "fas fa-search");
				$("div#gnbSearch div.formArea").fadeOut();
			}
			
			return false
		});
	}

	//floatArea
	var floatArea_moveH = parseInt($(".floatArea").css("top"));

	$(window).scroll(function() {
		var position = $(window).scrollTop();
		$(".floatArea").stop().animate({"top":position+floatArea_moveH+"px"},1000);
		
	});


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

});