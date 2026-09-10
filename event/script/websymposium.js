// DOM 이 모두 로드 되었을 때 실행
var stampBnr = null,
	bbsRolling = null;


jQuery(function($) {

// 최소 높이 설정
	initial();


// 공지사항
	if ($("dl.introBbs li").length > 1) {
		$("dl.introBbs ul").bxSlider({
			mode:'vertical',
			pager:false,
			controls:false,
			auto:true
		});

		$("dl.introBbs").on("click", "a", function(){
			if (bbsRolling != null) {
				bbsRolling.destroySlider();
				bbsRolling = null;
			}

			if (bbsRolling == null) {
				if ($("div.bbsRolling li").length > 6) {
					bbsRolling = $("div.bbsRolling ul").bxSlider({
						mode:'vertical',
						minSlides:6,
						maxSlides:6,
						infiniteLoop:false,
						hideControlOnEnd:true,
						controls:false
					});
					
				}
			}

			//fullpage_api.setAllowScrolling(false);
			// $("div#popupBbs").fadeIn();
			// return false
		});
	}



// Program at a Glance
	$("a.viewPag").on("click", function(){
		
		// $.ajax({
			// type:"POST",
			// url:"/event/pag.php",
			// async: false,
			// success:function(data){
				// data = JSON.parse(data);
				// $(".tabCon").eq(0).html(data[1]);
			// }
		// });
		
		$("div#popupPag").fadeIn();
		var re_mLeft = ($("div#popupPag > div").outerWidth() / 2) * (-1),
			re_mTop = ($("div#popupPag > div").outerHeight() / 2) * (-1);

		 $("div#popupPag > div").css({
			"margin-left":re_mLeft,
			"margin-top":re_mTop
		 });

		return false
	});


// E-Poster
	if ($("div.ePosterCon").length) {
		$("div.eposterZone").bxSlider({
			infiniteLoop:false,
			hideControlOnEnd:true				
		});

		var move_dt = $("dl.eposterSearch > dt").outerWidth(),
			move_dd = $("dl.eposterSearch > dd").outerWidth();

		$("dl.eposterSearch").on("click", "dt a", function(){
			$("dl.eposterSearch > dt").animate({"right":(move_dt * (-1))}, 1000);
			setTimeout(function(){$("dl.eposterSearch > dd").animate({"right":0}, 1000)}, 300);
			return false
		});

		$("dl.eposterSearch").on("click", ".close a", function(){
			setTimeout(function(){$("dl.eposterSearch > dt").animate({"right":0}, 1000)}, 300);
			$("dl.eposterSearch > dd").animate({"right":(move_dd * (-1))}, 1000);
			return false
		});
	}

	$("ul.eposterList").on("click", "a", function(){
		//fullpage_api.setAllowScrolling(false);
		$("div#popupPoster").fadeIn();
		return false
	});

	$("div#popupPoster").on("click", "a.viewCon", function(){
		var text = $(this).text();
		if (text == "발표영상 보기") {
			$(this).text("포스터 보기");
			$("div#popupPoster .viewImg").hide();
			$("div#popupPoster .viewVod").show();
		} else {
			$(this).text("발표영상 보기");
			$("div#popupPoster .viewImg").show();
			$("div#popupPoster .viewVod").hide();
		}
		return false
	});

// E-Booth
	if ($("div.eBoothZone").length) {
		if ($("div.eBoothZone > ul").length > 1 ) {
			$("div.eBoothZone").bxSlider({
				infiniteLoop:false,
				hideControlOnEnd:true				
			});
		}

		$(".eBooth_a a").snakeify({
			speed: 200	
		});

		$("ul.eBooth_a, ul.eBooth_b, ul.eBooth_a_main").on("click", "a", function(){			
			
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

//안내
	$("body").on("click", function(){
		var introNotice = $("div.intro dt.view");
		if (introNotice.length) {
			//$("div.intro dt.view").removeClass("view");
			//$("div.intro dd.toggleCon").hide();
			
			//긴급공지추가
			$(".toggle_box_1").show();
			$(".toggle_box_2").hide();
		}
	});

});


// 페이지가 리사이징 될때마다
$(window).resize(function(){
						
// 초기화
	initial();

 
});

function initial() {
	var poBtm = parseInt($("p.reigst").css("bottom")),
		first_section = $("div.section").attr("id");

	

	if (first_section == "section0") {


		var myFullpage = new fullpage('#container', {
			v2compatible: true,
			anchors: ['navi01', 'navi02', 'navi03', 'footPage'],
			navigation:true,
			navigationTooltips: ['Web Symposium', 'E-Poster', 'E-Booth'],
			showActiveTooltip: true,
			verticalCentered: false,
			scrollOverflow: true,
			css3: true,
			menu: '#gnb',
			onLeave: function(anchorLink, index){
	/*
				if (index == 1) {
					$("#fp-nav").addClass("black");
				} else {
					$("#fp-nav").removeClass("black");
				}
	*/
				$("#gnb > li").removeClass("active")
				if (index == 1) {
					$("#gnb > li").eq(0).addClass("active");
				} else if (index == 2) {
					$("#gnb > li").eq(2).addClass("active");
				}  else if (index == 3) {
					$("#gnb > li").eq(3).addClass("active");
				} else {
					$("#gnb > li").eq(1).addClass("active");
				}

			},
			afterLoad: function(anchorLink, index, direction){

				if (index == 4) {
					var re_poBtm = $("div#footer").outerHeight() + 30;
					$("dl.introBbs").animate({
						"bottom" : re_poBtm
					}, 500);
				} else {
					$("dl.introBbs").animate({
						"bottom" : 20
					}, 500);
				}
				
			}
		});

		if ($("div#fp-nav .goTop").length == 0) {
			//$("div#fp-nav").addClass("black");
			$("div#fp-nav > ul > li").eq(3).addClass("hide");
			$("div#fp-nav > ul").append('<li><a href="#" class="goTop"><span class="fp-sr-only">TOP</span><span></span></a><div class="fp-tooltip fp-right">TOP</div></li>');
		}


		$("#gnb a").on("click", function(){
			if( $(this).html() != "Logout" ){
				var viewnum = $(this).parent().index() + 1;
				$("#gnb > li").removeClass("active");
				$("#gnb > li").eq($(this).parent().index()).addClass("active");
				fullpage_api.moveTo(viewnum);
			}
		});

		document.querySelector('.goTop').addEventListener('click', function(e){
			e.preventDefault();
			fullpage_api.moveTo(1);
			//$("#fp-nav").addClass("black");
			$(this).removeClass("active");
		});

	} else if (first_section == "section1") {
		var myFullpage = new fullpage('#container', {
			v2compatible: true,
			navigation:false,
			scrollOverflow: true,
			css3: true,
			afterLoad: function(anchorLink, index, direction){

				if (index == 2) {
					var re_poBtm = $(".onAir").outerHeight() + parseInt($(".onAir").css("bottom")) + $("div#footer").outerHeight() + 30;
					$("p.reigst, dl.introBbs").animate({
						"bottom" : re_poBtm
					}, 500);
				} else {
					$("p.reigst").animate({
						"bottom" : poBtm
					}, 500);
					$("dl.introBbs").animate({
						"bottom" : 20
					}, 500);
				}
				
			}
		});
	}


	$('.down a').click(function(e){
		e.preventDefault();
		myFullpage.moveSectionDown();
	});

	$('.fp-tooltip').on('click', function(e){
		e.preventDefault();
		var num = $(this).parent().index() + 1;
		if (num == 4) {
			num = 1
		}
		fullpage_api.moveTo(num);
	});

	if ($("dl.introBbs").length) {
		setTimeout(function(){
			$("dl.introBbs").animate({
				"height":90,
				"opacity":1
			}, 1000);
		
		}, 4000);
	}

}



