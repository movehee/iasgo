//<![CDATA[
function nl2br(str){  
    return str.replace(/\n/g, "<br />");  
}  

jQuery(function($) {
	$('div#COMMENT_LIST_GROUP').on('click', 'div._submitBtn > a', function(){
		$form = $(this).parents('table.cminput');
		$thisObj = $(this);
		if(!$.trim($form.find('textarea[id="comment_text"]').val())){
			alert('Please enter comment.');
			$form.find('textarea[id="comment_text"]').focus();
			return false;
		}
		
		var msg = $form.find('textarea[id="comment_text"]').val().autoLink({ callback: function(url){
				return /\.(gif|png|jpe?g)$/i.test(url) ? '<a href="' + url + '" target="_blank"><img src="' + url + '"></a>' : null;
			},target: "_blank"
		});

		var inputarr = {
			cname : $form.find('input[name="comment_cname"]').val(),
			cid : $form.find('input[name="comment_cid"]').val(),
			_csid : $form.find('input[name="comment_csid"]').val(),
			poster_sid : $form.find('input[name="poster_sid"]').val(),
			_poster_sid : $form.find('input[name="comment_csid"]').val(),
			content : msg,
			rname : $form.find('input[name="comment_rname"]').val(),
			_number : $form.find('input[name="comment_number"]').val(),
			file_name : $form.find('input[name="file_name"]').val()
		};
		inputarr = jQuery.param(inputarr);
		
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: "/api_comment/ajax/insert_comment.php",
			async: false,
			data: inputarr
		}).done(function( r ) {
			if(!r._return){
				alert(r.msg);
				return false;
			}else{
				//성공했다면 아무것도 하지마 리스트에서 자동로드되도록
				//텍스트 박스 초기화
				$form.find('textarea.textarea').val('');

				//클릭시 기존 오픈되어있던 댓글을 모두 제거
				$('div#COMMENT_LIST_GROUP').find('span.btn_recancel').removeClass('btn_recancel').addClass('btn_recomment').text('Reply');
				$('div#COMMENT_LIST_GROUP').find('span.btn_mocancel').removeClass('btn_mocancel aa').addClass('btn_modify').text('Edit');
				$('div#COMMENT_LIST_GROUP').find('div.comment_box').html('');
				location.reload();
			}
		});
		return false;
	}).on('click', 'div._modifyBtn > a', function(){
		$form = $(this).parents('table.cminput');
		$thisObj = $(this);
		if(!$.trim($form.find('textarea[id="comment_text"]').val())){
			alert('Please enter comment.');
			$form.find('textarea[id="comment_text"]').focus();
			return false;
		}

		var msg = $form.find('textarea[id="comment_text"]').val().autoLink({ callback: function(url){
				return /\.(gif|png|jpe?g)$/i.test(url) ? '<a href="' + url + '" target="_blank"><img src="' + url + '"></a>' : null;
			},target: "_blank"
		});

		var inputarr = {
			cname : $form.find('input[name="comment_cname"]').val(),
			cid : $form.find('input[name="comment_cid"]').val(),
			poster_sid : $form.find('input[name="poster_sid"]').val(),
			content : msg,
			this_sid : $form.find('input[name="this_sid"]').val(),
			file_name : $form.find('input[name="file_name"]').val()
		};
		inputarr = jQuery.param(inputarr);

			$.ajax({
				type: 'post',
				dataType: 'json',
				url: "/api_comment/ajax/modi_comment.php",
				async: false,
				data: inputarr
			}).done(function( r ) {
				if(!r._return){
					alert(r.msg);
					return false;
				}else{
					//성공했다면 수정된 내용을 입력해준다.
					alert('Complete.');
					$thisObj.parents('li').find('span.comment_content').html(nl2br($form.find('textarea.textarea').val()));


					//텍스트 박스 초기화
					$form.find('textarea.textarea').val('');

					//클릭시 기존 오픈되어있던 댓글을 모두 제거
					$('div#COMMENT_LIST_GROUP').find('span.btn_recancel').removeClass('btn_recancel').addClass('btn_recomment').text('Reply');
					$('div#COMMENT_LIST_GROUP').find('span.btn_mocancel').removeClass('btn_mocancel aa').addClass('btn_modify').text('Edit');
					$('div#COMMENT_LIST_GROUP').find('div.comment_box').html('');
				}
			});
		
		return false;
	}).on('click', 'span.btn_recomment', function(){
		//클릭시 기존 오픈되어있던 댓글을 모두 제거
		$('div#COMMENT_LIST_GROUP').find('span.btn_recancel').removeClass('btn_recancel').addClass('btn_recomment').text('Reply');
		$('div#COMMENT_LIST_GROUP').find('span.btn_mocancel').removeClass('btn_mocancel aa').addClass('btn_modify').text('Edit');
		$('div#COMMENT_LIST_GROUP').find('div.comment_box').html('');

		$thisObj = $(this);
		var ctype = $(this).parents('li').hasClass('CC')?'CC':'C';
		var inputarr = {
			cname : $('input[name="user_cname"]').val(),
			cid : $('input[name="user_cid"]').val(),
			poster_sid : $('input[name="poster_sid"]').val(),
			csid : $(this).parents('li').attr('csid'),
			rname : $(this).parents('li').attr('rname'),
			_number : $('input[name="comment_number"]').val(),
			ctype : ctype,
			file_name : $('input[name="user_file_name"]').val()
		};
		inputarr = jQuery.param(inputarr);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: "/api_comment/ajax/add_cminput.php",
			async: false,
			data: inputarr
		}).done(function( r ) {
			if(!r._return){
				alert(r.msg);
				return false;
			}else{
				$thisObj.removeClass('btn_recomment').addClass('btn_recancel').text('Cancel');
				$thisObj.parents('li').find('div.comment_box').html(r.html);
				$thisObj.parents('li').find('div.comment_box textarea.textarea').focus();
			}
		});
		return false;
	}).on('click', 'span.btn_recancel', function(){
		$thisObj = $(this);
		$thisObj.removeClass('btn_recancel').addClass('btn_recomment').text('Reply');
		$thisObj.parents('li').find('div.comment_box').html('');
	}).on('click', 'span.btn_mocancel', function(){
		$thisObj = $(this);
		$thisObj.removeClass('btn_mocancel aa').addClass('btn_modify').text('Edit');
		$thisObj.parents('li').find('div.comment_box').html('');
	}).on('click', 'span.btn_delete', function(){
		if(confirm('Delete?')){
			$thisObj = $(this);
			var ctype = $(this).parents('li').hasClass('CC')?'CC':'C';
			var inputarr_arr = {
				cname : $('input[name="user_cname"]').val(),
				cid : $('input[name="user_cid"]').val(),
				poster_sid : $('input[name="poster_sid"]').val(),
				this_sid : $(this).parents('li').attr('this_sid'),
				file_name : $('input[name="user_file_name"]').val()
			};

			inputarr = jQuery.param(inputarr_arr);

			$.ajax({
				type: 'post',
				dataType: 'json',
				url: "/api_comment/ajax/del_cminput.php",
				async: false,
				data: inputarr
			}).done(function( r ) {
				if(!r._return){
					alert(r.msg);
					return false;
				}else{
					//삭제성공시 ctype == 'C' 라면 댓글
					if(ctype == 'C'){
						//카운트 하나 빼기
						var ccnt = ( $('p.total').find('span.comment_cnt').text() * 1 ) - 1;
						$('p.total').find('span.comment_cnt').text(ccnt);
					}
					$thisObj.parents('ul').find('li.li_'+inputarr_arr['this_sid']).remove();
					
					location.reload();
				}
			});
			return false;
		}
	}).on('click', 'span.btn_modify', function(){
		//클릭시 기존 오픈되어있던 댓글을 모두 제거
		$('div#COMMENT_LIST_GROUP').find('span.btn_recancel').removeClass('btn_recancel').addClass('btn_recomment').text('댓글');
		$('div#COMMENT_LIST_GROUP').find('div.comment_box').html('');

		$thisObj = $(this);
		var inputarr = {
			cname : $('input[name="user_cname"]').val(),
			cid : $('input[name="user_cid"]').val(),
			poster_sid : $('input[name="poster_sid"]').val(),
			this_sid : $(this).parents('li').attr('this_sid'),
			content : $(this).parents('li').find('span.comment_content').html(),
			file_name : $('input[name="user_file_name"]').val()
		};
		inputarr = jQuery.param(inputarr);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: "/api_comment/ajax/add_cminput.php",
			async: false,
			data: inputarr
		}).done(function( r ) {
			if(!r._return){
				alert(r.msg);
				return false;
			}else{
				$thisObj.removeClass('btn_modify').addClass('btn_mocancel leftNone').text('Cancel');
				$thisObj.parents('li').find('div.comment_box').html(r.html);
				$thisObj.parents('li').find('div.comment_box textarea.textarea').focus();
			}
		});
		return false;
	});
});

//]]>