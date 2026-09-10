
// DOM 이 모두 로드 되었을 때 실행
jQuery(function($) {
	
//로그인
	var adminLogin = $("div.adminLogin");
	if (adminLogin.length) {
		var win_h = $(window).height();

		$("div.wrapper").height(win_h);
		$("body").addClass("login");
	}

	$("input[name=correct]").on("click", function(){ 

		if($("#"+$(this).attr('id')).prop("checked")){
			$("input[name=correct]:checkbox").removeProp("checked");
			$("input[id=correct"+$(this).val()+"]:checkbox").prop("checked", "checked");
			return true
		}else {
			$("input[name=correct]:checkbox").removeProp("checked");
			return true
		}
	});

		var goTop = $("#adminTop");
	if (goTop.length) {
		goTop.hide();

		$(window).scroll(function(){
			var scrollTop = $(window).scrollTop();
			if (scrollTop < 100) {
				goTop.fadeOut();
			} else {
				goTop.fadeIn();
			}		
		});
		goTop.on("click", "a", function(){
			$(window).scrollTop(0);
		});
	
	}
	if ($("div.voting span.folding").length) {
		for (var i=0;i<$("div.voting span.folding").length;i++) {
			/*
			if (i > 0) {
				$("span.folding").eq(i).addClass("up").find("a").text("열기");
				$("table.tblDef").eq(i).find("tr.foldingArea").hide();
			}
			*/
			$("table.tblDef").eq(i).addClass("voting" + i);
			$("span.folding").eq(i).find("a").addClass("voting" + i);
		}

		$("table.tblDef").on("click", "span.folding a", function(){
			var currTbl = "table." + $(this).attr("class"),
				currLink = $(this).parent(),
				sClass = $(this).parent().attr("class"),
				num = sClass.indexOf("up");

			if (num == "-1") {
				currLink.addClass("up").find("a").text("열기");
				$(currTbl).find("tr.foldingArea").css("display","none");
			} else {
				currLink.removeClass("up").find("a").text("접기");
				$(currTbl).find("tr.foldingArea").css("display","table-row");			
			}

			return false
		});

		$("a.btnViewAll").on("click", function(){
			$("span.folding").removeClass("up").find("a").text("접기");
			$("table.tblDef").find("tr.foldingArea").css("display","table-row");			
		
			return false
		});
	}


// 전체화면
	var fullScreen = $("div.wrapper > div").attr("class");

	if(typeof(fullScreen)!='undefined') {
	var	classTxt = fullScreen.indexOf("fullScreen");
	}
	
	if (classTxt > "-1") {
		var sClass = $("div.wrapper > div").attr("class");
		$("body").addClass(sClass);

		if (sClass != "fullScreen") {
			var win_h = $(window).height(),
				reH = win_h - $("div.qnaList").outerHeight();
			$("div.wrapper").height(win_h - 1);

			if ($("div.qnaList li").length > 5) {
				var listEa_w = $("div.qnaList li").eq(0).outerWidth();
					reW = listEa_w * $("div.qnaList li").length,
					count = 1;


				$("div.qnaList ul").width(reW);
				$("div.qnaList li").width(listEa_w);

				$("div.qnaList").append('<p class="util"><a href="#" class="prev">이전</a><a href="#" class="next">다음</a></p>');

				$("div.qnaList").on("click", "p.util a", function(){
					var sClass = $(this).attr("class"),
						stopNum = $("div.qnaList li").length - count;
						

					if (sClass == "next") {
						moveLeft = listEa_w * count * (-1);
						
						if (stopNum < 5) {
							alert("다음 질문이 없습니다.")							
							count = 5
						} else {
							$("div.qnaList ul").animate({
								"margin-left":moveLeft
							},500);
							
							count++													
						}
					} else {

						moveLeft = parseInt($("div.qnaList ul").css("margin-left"));
						
						if (moveLeft == 0) {
							alert("이전 질문이 없습니다.");
							
						} else {
							moveLeft = moveLeft + listEa_w;
							$("div.qnaList ul").animate({
								"margin-left":moveLeft
							},500);
							
							count--													
						}
					}
					//alert(count)
					return false
				});

			}
		}

		if ($("div.qnaCon").length) {
			var reH = $(window).height() - $("h1").outerHeight() - $("div.util").outerHeight() - ((parseInt($("div.qnaCon").css("padding-top"))) * 2);
			$("div.qnaCon").height(reH);
		}
	}

/*	
	$("p.dataUpload > a").on("click", function(){
		$("div#dataUpload").toggle();

		return false
	});

	$("a.btnSmall").on("click", function(){
		$("div.popupWrap").toggle();

		return false
	});
	

	$("div.popupWrap").on("click", "p.close a", function(){
		$("div.popupWrap").hide();

		return false
	});


	var contents_sClass = $("div.contents").attr("class"),
		strArray = contents_sClass.split(" ");

	if (strArray[1] == "case") {

		$("td.viewPop").on("click", "a", function(){
			var btn_sClass = $(this).attr("class"),
			btnStrArray = btn_sClass.split(" ");
			
			$("div.popupWrap").toggle();
			$("div.popupWrap h1").addClass(btnStrArray[1]);
			$("div.popupWrap h1").text(btnStrArray[1]);

			var popup_h = $("div.popupWrap").outerHeight(),
				reMarginT = (popup_h / 2) * (-1);

			$("div.popupWrap").css("margin-top", reMarginT);

			return false
		});
	}
*/
	$("select.excel_proc").change(function() {
		var val = $(this).val();
		var link = $(this).attr("e-link");

		if(link.indexOf("?") == "-1") {
			link = link+"?"
		}

		if(val == 'view') {
			window.open(link+"&excel_type="+val,"","width=1300,height=800");

		}
		else if(val == 'down'){
			location.href = link+"&excel_type="+val;
		}
	});

});



// 페이지내 모든 요소가 로드되었을 때 실행
$(window).resize(function(){
						

});





function onlyNumber(){
	if((event.keyCode<48)||(event.keyCode>57))
	event.returnValue=false;

}