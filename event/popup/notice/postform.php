<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	if($sid) {
		$query = "select * from w_notice_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();
	} else {
		$d['use_yn'] = 'Y';
	}
	
	if(!$mode && !$d['content']){
		$mode = "form";
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('공지사항');	
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,1000);
	});
</script>
<script type="text/javascript" src="/func/tinymce_ver5/js/tinymce/tinymce.js"></script>
<script>
tinymce.init({
	selector: 'textarea',
	theme: "silver", //테마종류 modern / mobile
	mobile: { theme: 'mobile' },
	language : 'ko_KR',
	menubar:false, //상단 전체메뉴바
	quickbars_selection_toolbar: 'bold underline italic | superscript subscript', //입력글에 영역 잡았을때 퀵메뉴 정의
	
	plugins: 'print preview fullpage importcss  searchreplace autolink autosave save directionality  visualblocks visualchars fullscreen image link media   codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists  wordcount   imagetools textpattern noneditable help    charmap  quickbars  emoticons code template spellchecker ',
	
	toolbar : 'bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist  | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print |  image link anchor codesample | a11ycheck ltr rtl | showcomments addcomment table code superscript subscript template ',
    /*templates: [
	{title: '대한신경외과학회', description: '회원가입 폼', url: '/bbs/templete/templete2.php'},
	{title: '자동차 공학회 메일 템플릿', description: '비밀번호찾기', url: '/bbs/templete/templete1.php'}
	],*/
	//undo redo | 

	//branding: true,
	custom_ui_selector: '.my-custom-button',
	//fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',
	max_width: 200,

	image_title: true,

	/*이미지 경로 다나오게 설정*/
	relative_urls : false,
	remove_script_host : false,
	convert_urls : true,
	/*이미지 경로 다나오게 설정*/

	automatic_uploads: true,
	images_upload_url: '/func/tinymce_ver5/postAcceptor.php', //이미지 업로드하면 저장하는 페이지
	file_picker_types: 'image',
	
	file_picker_callback: function (cb, value, meta) {
	var input = document.createElement('input');
	input.setAttribute('type', 'file');
	input.setAttribute('accept', 'upload/tinymce/*');
	

	input.onchange = function () {
		var file = this.files[0];
		var reader = new FileReader();
		reader.onload = function () {
			var id = 'blobid' + (new Date()).getTime();
			var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
			var base64 = reader.result.split(',')[1];
			var blobInfo = blobCache.create(id, file, base64);
			blobCache.add(blobInfo);
			cb(blobInfo.blobUri(), { title: file.name });
		};
		reader.readAsDataURL(file);
	};
    input.click();
  }
});
$(function(){
	$('.room_all').on('click',function(){
		if($(this).is(':checked')==true){
			$('.rooms').prop('checked',true);
		}else{
			$('.rooms').prop('checked',false);
		}
	});
});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1200px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="post.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>제목</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="text" name="subject" id="subject" value="<?=$d['subject']?>" style="width:80%;">
					<?}else{?>
						<?=$d['title']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>내용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<textarea name="content" style="height:500px;"><?=$d['content']?></textarea>
					<?}else{?>
						<?=$d['content']?>
					<?}?>
					
				</td>
			</tr>
			<tr>
				<th>회의장</th>
				<td class="al">
					<input type="checkbox" name="room_all" id="room_all" class="room_all"> <label for="room_all">전체</label>
					<?
					$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
					$room_result=$conn->query($room_query);
					if(DB::isError($room_result)) die($room_result->getMessage());
					while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
					?>
					<input type="checkbox" name="room_sid[]" class="rooms" id="room_sid<?=$r['sid']?>" value="<?=$r['sid']?>" <?if(eregi($r['sid'],$d['room_sid'])>0){?>checked<?}?>> <label for="room_sid<?=$r['sid']?>"><?=$r['title']?></label>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>사용여부</th>
				<td class="al">
					<?foreach($_NOTICE['use'] as $tkey=>$tval){?>
						<input type="radio" value='<?=$tkey?>' name="use_yn" id="use_yn<?=$tkey?>" <?if($d['use_yn']==$tkey){?>checked<?}?> /><label for="use_yn<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>PUSH</th>
				<td class="al">
					<?foreach($_NOTICE['push'] as $tkey=>$tval){?>
						<input type="radio" value='<?=$tkey?>' name="push" id="push<?=$tkey?>" <?if($d['push']==$tkey){?>checked<?}?> /><label for="push<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btnArea btn">
		<?if($mode=='form'){?>
			<input type="submit" value="저장" class="btnPoint btnBig">
		<?}else{?>
			<input type="button" value="수정" class="btnPoint btnBig" onclick="location.href='<?=$PHP_SELF?>?sid=<?=$sid?>&mode=form'">
		<?}?>
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>
<??>
