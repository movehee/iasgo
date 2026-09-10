<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	//include_once $_SERVER['DOCUMENT_ROOT'] . "func/config.exam.php";
	if($sid) {
		$query = "select * from exam_tbl where sid='$sid'";
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
<link type="text/css" rel="stylesheet" href="/asset/webinar.css">
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('문제등록');	
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
	$('#postForm').submit(function(){
		
	});
});

</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="post.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="kind" id="kind" value="<?=$kind?>"/>
<input type="hidden" name="chkday" id="chkday" value="<?=$chkday?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 12%;">
			<col style="width: 7%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<?if($_Activation['category']){?>
			<tr>
				<th>선택</th>
				<td class="al" colspan=3>
					<?foreach($_Exam['category'] as $tkey=>$tval){?>
					<input type="radio" name="category" id="category<?=$tkey?>" class="category" value="<?=$tkey?>" <?if($d['category']==$tkey){?>checked<?}?>> <label for="category<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
			</tr>
			<?}?>
			<tr>
				<th>제출자</th>
				<td class="al" colspan=3>
					<input type="text" name="name_kr" id="name_kr" value="<?=$d['name_kr']?>" style="width:90%;">
				</td>
			</tr>

			<tr>
				<th>문제</th>
				<td class="al" colspan=3>
					<textarea name="question" style="height:300px;"><?=$d['question']?></textarea>
				</td>
			</tr>
			<tr>
				<th>문항번호</th>
				<th>정답</th>
				<th>문항내용</th>
			</tr>
			<?for($i=1;$i<=5;$i++){?>
			<tr>
				<th><?=$i?>번</th>
				<th><input type="checkbox" name="answer[]" value="<?=$i?>" class="answer" style="width:20px;height:20px;" <?if(eregi($i,$d['answer'])>0){?>checked<?}?>></th>
				<td class="al">
					<input type="text" name="que<?=$i?>" id="que<?=$i?>" value="<?=$d['que'.$i]?>" style="width:90%;">
				</td>
			</tr>
			<?}?>
			<tr>
				<th>점수</th>
				<td class="al" colspan=3>
					<input type="text" name="score" id="score" value="<?=$d['score']?>" style="width:10%;">
				</td>
			</tr>
			<tr>
				<th>해설</th>
				<td class="al" colspan=3>
					<textarea name="commentary" style="height:300px;"><?=$d['commentary']?></textarea>
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
