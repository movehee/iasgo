var user_id_check       = false; // 회원가입 중복확인 체크를 위한 변수
var user_passwd_check   = false; // 비밀번호 조건 성립 변수
var user_repasswd_check = false; // 비밀번호 확인 변수 

$(document).ready(function(){
	// 즐겨찾기 이벤트
	$('#favorite').on('click', function(e){
		var bookmarkURL = window.location.href;
		var bookmarkTitle = document.title;
		var triggerDefault = false;
		
		if(window.sidebar && window.sidebar.addPanel){
			// Firefox version < 23
			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
		}else if((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)){
			// Firefox version >= 23 and Opera Hotlist
			var $this = $(this);
			$this.attr('href', bookmarkURL);
			$this.attr('title', bookmarkTitle);
			$this.attr('rel', 'sidebar');
			$this.off(e);
			triggerDefault = true;
		}else if(window.external && ('AddFavorite' in window.external)){
			// IE Favorite
			window.external.AddFavorite(bookmarkURL, bookmarkTitle);
		}else{ 
			// WebKit - Safari/Chrome
			alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.');
		}
		return triggerDefault; 
	});
	
	// datepicker
	jQuery(function(a){a.datepicker.regional.ko={closeText:"닫기",prevText:"이전달",nextText:"다음달",currentText:"오늘",monthNames:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],monthNamesShort:["1월","2월","3월","4월","5월","6월","7월","8월","9월","10월","11월","12월"],dayNames:["일","월","화","수","목","금","토"],dayNamesShort:["일","월","화","수","목","금","토"],dayNamesMin:["일","월","화","수","목","금","토"],weekHeader:"Wk",dateFormat:"yy-mm-dd",firstDay:0,isRTL:false,showMonthAfterYear:false,yearSuffix:"년"};a.datepicker.setDefaults(a.datepicker.regional.ko)});
	$('#sdate, #edate, #date, .sdate, .edate').datepicker({showMonthAfterYear:true, changeMonth: true,	changeYear: true,	dateFormat: "yy-mm-dd"});
	
	$("#all_agree").click(function(){
		
		$("input:radio[name='agree1'][value='Y']").attr("checked",true);
		$("input:radio[name='agree2'][value='Y']").attr("checked",true);
		
	});
	
	//회원가입 아이디 중복확인
	$("#btn_id_check").click(function(){
	
		var id = $("#id").val();
		var num = id.search(/[0-9]/g);
		var eng = id.search(/[a-z]/ig);
		
		if( id == "" ){
			alert("아이디를 입력해주세요.");
			return;
		}
		/*else{
			if( id.length < 5 || id.length > 10 ){
				alert("아이디는 4~12자리의 영문소문자 또는 숫자 문자열로 구성되어야 합니다."); return;
			}
			if(num < 0 || eng < 0){
				alert("아이디는 5~10자리 영문소문자, 숫자 또는 조합문자로 구성되어야 합니다."); return;
			}
		}*/
		
		$.post( "/member/join/handle/id_check.php", { id : id }, function(data){
			if( data == 1 ){
				alert("이미 사용중인 아이디 입니다."); return;
			}else{
				user_id_check = true;
				$("#id").attr("readonly", true);
				alert("사용 가능한 아이디 입니다."); return;
			}
		});
		
	});
	
	$("#passwd").live("change",function(){
		var password = $(this).val();
		var num = password.search(/[0-9]/g);
		var eng = password.search(/[a-z]/ig);
		var spe = password.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);
		
		if( password != "" ){
			
			if(password.length < 4 || password.length > 12){
				alert("비밀번호는 4~12자리의 영문소문자, 숫자 조합문자열로 구성되어야 합니다.");
				user_passwd_check = false;
				return;
			}
			if( (num < 0 && eng < 0) || (eng < 0 && spe < 0) || (spe < 0 && num < 0) ){
				alert("비밀번호는 4~12자리의 영문소문자, 숫자 조합문자열로 구성되어야 합니다.");
				user_passwd_check = false;
				return;
			}
			if( $("#id").val() == password  ){
				alert("비밀번호가 아이디와 같습니다.");
				user_passwd_check = false;
				return;
			}		
			if( password.search(/\s/g) > -1 ){
				alert("비밀번호에 공백이 있습니다.");
				user_passwd_check = false;
				return;
			}
			
			if( check_passwd_same(password) == true ){
				alert("비밀번호에 연속된 동일한 숫자나 문자가 있습니다.");
				user_passwd_check = false;
				return;
			}
			
			user_passwd_check = true;
			
		}	
		
	});
	
	// 회원가입 비밀번호 확인
	$("#repasswd").keyup(function(){
		
		if( $("#passwd").val() == $(this).val() ){
			user_repasswd_check = true ;
		}else{
			user_repasswd_check = false ;
		}
		
	});
	
	//아이디찾기
	$("#btn_id_find").click(function(){

		var name   = $("#name").val();
		var credit = $("#credit").val();

		if( name == "" ){
			alert("이름을 입력해주세요.");
			$("#name").focus(); return;
		}

		if( credit == "" ){
			alert("면허번호를 입력해주세요.");
			$("#credit").focus(); return;
		}

		$.post( "/member/handle/find_proc.php", { name : name, credit : credit, type : "id" }, function(data){
			if( data == "false" ){
				alert("일치하는 정보가 없습니다.");
				return;
			}else{
				$("#find_id").html(data);
				$(".result").show();
			}

		});
	});
	
	//비밀번호찾기
	$("#btn_passwd_find").click(function(){

		var id     = $("#id").val();
		var name   = $("#name_p").val();
		var credit = $("#credit_p").val();

		if( id == "" ){
			alert("ID를 입력해주세요.");
			$("#id").focus(); return;
		}

		if( name == "" ){
			alert("이름을 입력해주세요.");
			$("#name_p").focus(); return;
		}

		if( credit == "" ){
			alert("면허번호를 입력해주세요.");
			$("#credit_p").focus(); return;
		}

		$.post( "/member/handle/find_proc.php", { id : id, name : name, credit : credit, type : "passwd" }, function(data){
			if( data == "false" ){
				alert("일치하는 정보가 없습니다.");
				return;
			}else{
				console.log(data);
				alert("회원님의 임시비밀번호는 " + data + "로 발송되었습니다.");
			}

		});

	});
	
	// 비밀번호팁 팝업레이어 보기
	$(".tipPop").on("click", function(){
		$("#pwdTip").show();
		$("div.wrapper").height($(window).height());
		return false
	});
	
	// 회비납부 레이어팝업 보기
	$(".feePop").on("click", function(){
		
		var sid    = $(this).attr("data_sid");
		var method = $(this).attr("data_method");
		
		$.ajax({
	        type: 'POST',
	        url: '/member/handle/fee_make.php',
	        data: { sid : sid, method : method },
	        async: false,
	        success: function(data) {
	        	$("#toPay").html(data);
	        }
	    });
		
		$(document).find("input[name=paydate]").removeClass('hasDatepicker').datepicker();
		
		$("#toPay").show();
		$("div.wrapper").height($(window).height());
		return false
	});
	
	//영수증 레이어팝업
	$(".receiptPop").on("click", function(){
		
		var sid    = $(this).attr("data_sid");
		
		$.ajax({
	        type: 'POST',
	        url: '/member/handle/fee_receipt_make.php',
	        data: { sid : sid },
	        async: false,
	        success: function(data) {
	        	$("#viewReciept").html(data);
	        }
	    });
		
		$("#viewReciept").show();
		$("div.wrapper").height($(window).height());
		return false
	});

	//포토뉴스 사진 크게보기
	$(".big_photo").click(function(){
		
		var sid  = $(this).attr("sid_data");
		var fsid = $(this).attr("fsid_data");
		
		$.ajax({
	        type: 'POST',
	        url: '/bbs/handle/photo_big.php',
	        data: { sid : sid, fsid : fsid },
	        async: false,
	        success: function(data) {
	        	$("#viewPhoto").html(data);
	        }
	    });
	    
	    $("div.layerPopup").show();
		$("div.wrapper").height($(window).height());
		return false
	    		
	});
	
	//포토뉴스 슬라이드
	$(".change_image").live("click",function(){
		
		var sid  = $(this).attr("sid_data");
		var fsid = $(this).attr("fsid_data");
		
		$.ajax({
	        type: 'POST',
	        url: '/bbs/handle/change_image.php',
	        data: { sid : sid, fsid : fsid },
	        async: false,
	        success: function(data) {
	        	var info = JSON.parse(data);
	        	$("#big_image_id").attr("src","http://www.skoms.org/upload/news/"+info[0]);
	        	
	        	if( info[1] == null ){
	        		$("#change_next").hide();
	        	}else{
	        		$("#change_next").show();
	        		$("#change_next").attr("fsid_data",info[1]);
	        	}
	        	
	        	if( info[2] == null){
	        		$("#change_prev").hide();
	        	}else{
	        		$("#change_prev").show();
	        		$("#change_prev").attr("fsid_data",info[2]);
	        	}
	        	
	        	$("div.wrapper").height($(window).height());
	        }
	    });
		
	});
	
	//레이어팝업 닫기
	$("div.layerPopup").on("click", "a.close", function(){
		$("div.layerPopup").hide();
		$("div.wrapper").css({"height":"auto"});
		return false
	});
	
});

function step01_check(){
	
	if( $("input:radio[name='agree1']:checked").val() == null || $("input:radio[name='agree1']:checked").val() == "N" ){
		alert("대한한의학회 이용 약관에 동의해주세요.");
		$("input:radio[name='agree1']").focus();
		return false;
	}
	
	if( $("input:radio[name='agree2']:checked").val() == null || $("input:radio[name='agree2']:checked").val() == "N" ){
		alert("개인정보취급방침동의에 동의해주세요.");
		$("input:radio[name='agree2']").focus();
		return false;
	}
	
	return true;
	
}

function step02_check(){
	
	if( $("input[name='name']").val() == "" ){
		alert("이름을 입력해주세요");
		$("input[name='name']").focus();
		return false;
	}
	
	if( $("input[name='credit']").val() == "" ){
		alert("면허번호를 입력해주세요");
		$("input[name='credit']").focus();
		return false;
	}
	
	var step02_check = false;
	
	$.ajax({
        type: 'POST',
        url: '/member/join/handle/step02_check.php',
        data: { data : $("#step02_form").serialize() },
        async: false,
        success: function(data) {
        	if( data != "true"){
				alert(data);
				step02_check = false;
			}else{
				step02_check = true;
			}
        }
    });
	
	if( step02_check == true ){
		return true;
	}else{
		return false;
	}
	
}

function step03_check(f){
	
	if( $("input[name='mode']").val() != "modify" ){
	
		if( $(f.id).val() == "" ){
				alert("아이디를 입력해주세요.");
				f.id.focus();
				return false;
		}
	
		if($(f.id).attr("readonly") == null){
			if( user_id_check == false ){
				alert("아이디 중복 확인을 진행해주세요.");
				f.id.focus();
				return false;
			}
		}
	
	}
	
	if( $("input[name='mode']").val() != "modify" || ( $("input[name='mode']").val() == "modify" && $(f.passwd).val() != "" ) ){

		if( $(f.passwd).val() == "" || $(f.repasswd).val() == "" ){
			alert("비밀번호를 입력해주세요.");
			f.passwd.focus();
			return false;
		}
	
		if( user_passwd_check == false ){
			alert("비밀번호를 확인해주세요.");
			f.repasswd.focus();
			return false;
		}
	
		if( user_repasswd_check == false ){
			alert("비밀번호가 일치 하지 않습니다.");
			f.repasswd.focus();
			return false;
		}
	
	}
	
	if( $(f.email).val() == "" ){
		alert("이메일을 입력해주세요.");
		f.email.focus();
		return false;
	}
	
	if( $("input:radio[name='emailYn']").is(":checked") == false ){
		alert("이메일 수신여부를 선택해주세요.");
		$("input:radio[name='emailYn']").focus();
		return false;
	} 
	
	if( $(f.phone1).val() == "" || $(f.phone2).val() == "" || $(f.phone3).val() == "" ){
		alert("휴대폰 번호를 입력해주세요.");
		f.phone1.focus();
		return false;
	}
	
	if( $(f.tel1).val() == "" || $(f.tel2).val() == "" || $(f.tel3).val() == "" ){
		alert("연락처 번호를 입력해주세요.");
		f.tel1.focus();
		return false;
	}
	
	if( $("input:radio[name='infoYn']").is(":checked") == false ){
		alert("정보공개여부를 선택해주세요.");
		$("input:radio[name='infoYn']").focus();
		return false;
	} 
	
	return true;
	
}

// 비밀번호 연속된 동일 문자 숫자 체크
function check_passwd_same(value) {

	var temp = "";
	var intCnt = 0;

	for( var i = 0; i < value.length; i++ ){
	    temp = value.charAt(i);
	    if( temp == value.charAt(i+1) && temp == value.charAt(i+2) && temp == value.charAt(i+3) ) {
    		intCnt = intCnt + 1;
	    }
	}

	if( intCnt > 0 ){
		return true;
	}else{
		return false;
	}

}

// 로그인 유효성 검사
function login_check(f){

	if( $(f.id).val() == "" ){
		alert("아이디를 입력해주세요");
		return false;
	}

	if( $(f.passwd).val() == "" ){
		alert("비밀번호를 입력해주세요");
		return false;
	}

	return true;

}

function fee_check(f){
	
	if($(f.method).val()=="B"){
		
		if(!$(f.payname).val()){
			alert("입금자명을 입력해주세요");
			$(f.payname).focus()
			return false;
		}
		
		if(!$(f.paydate).val()){
			alert("입금예정일을 설정해주세요");
			$(f.paydate).focus();
			return false;
		}
		
		if(!$(f.memo_society_name).val()){
			if(confirm("입금처리를 원하는 분과학회가 있습니까?")){
				return false;
			}
		}
		
	}else{
		
		if(!$(f.memo_society_name).val()){
			if(confirm("입금처리를 원하는 분과학회가 있습니까?")){
				return false;
			}
		}
		
	}

	return true;
	
}

function sendSns(sns, url, txt)
{
    var o;
    var _url = encodeURIComponent(url);
    var _txt = encodeURIComponent(txt);
    var _br  = encodeURIComponent('\r\n');

    switch(sns)
    {
        case 'facebook':
            o = {
                method:'popup',
                url:'http://www.facebook.com/sharer/sharer.php?u=' + _url
            };
            break;

        case 'twitter':
            o = {
                method:'popup',
                url:'http://twitter.com/intent/tweet?text=' + _txt + '&url=' + _url
            };
            break;

        case 'me2day':
            o = {
                method:'popup',
                url:'http://me2day.net/posts/new?new_post[body]=' + _txt + _br + _url + '&new_post[tags]=epiloum'
            };
            break;

        case 'kakaotalk':
            o = {
                method:'web2app',
                param:'sendurl?msg=' + _txt + '&url=' + _url + '&type=link&apiver=2.0.1&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent('Epiloum 개발노트'),
                a_store:'itms-apps://itunes.apple.com/app/id362057947?mt=8',
                g_store:'market://details?id=com.kakao.talk',
                a_proto:'kakaolink://',
                g_proto:'scheme=kakaolink;package=com.kakao.talk'
            };
            break;

        case 'kakaostory':
            o = {
                method:'web2app',
                param:'posting?post=' + _txt + _br + _url + '&apiver=1.0&appver=2.0&appid=dev.epiloum.net&appname=' + encodeURIComponent('Epiloum 개발노트'),
                a_store:'itms-apps://itunes.apple.com/app/id486244601?mt=8',
                g_store:'market://details?id=com.kakao.story',
                a_proto:'storylink://',
                g_proto:'scheme=kakaolink;package=com.kakao.story'
            };
            break;

        case 'band':
            o = {
                method:'web2app',
                param:'create/post?text=' + _txt + _br + _url,
                a_store:'itms-apps://itunes.apple.com/app/id542613198?mt=8',
                g_store:'market://details?id=com.nhn.android.band',
                a_proto:'bandapp://',
                g_proto:'scheme=bandapp;package=com.nhn.android.band'
            };
            break;

        default:
            alert('지원하지 않는 SNS입니다.');
            return false;
    }

    switch(o.method)
    {
        case 'popup':
            window.open(o.url);
            break;

        case 'web2app':
            if(navigator.userAgent.match(/android/i))
            {
                // Android
                setTimeout(function(){ location.href = 'intent://' + o.param + '#Intent;' + o.g_proto + ';end'}, 100);
            }
            else if(navigator.userAgent.match(/(iphone)|(ipod)|(ipad)/i))
            {
                // Apple
                setTimeout(function(){ location.href = o.a_store; }, 200);
                setTimeout(function(){ location.href = o.a_proto + o.param }, 100);
            }
            else
            {
                alert('이 기능은 모바일에서만 사용할 수 있습니다.');
            }
            break;
    }
}