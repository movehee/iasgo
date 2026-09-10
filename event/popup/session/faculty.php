<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Session');
		re_height = $('.popupCon').outerHeight()+168;
		re_width = $('.popupCon').outerWidth()+17;
		
		if(re_height>1000){
			window.resizeTo(re_width,1000);	
		}else{
			window.resizeTo(re_width,re_height);
		}
	});
</script>
<style>
.tblDef td{background:#ffffff;padding:5px 0px 5px 10px !important;margin:0px;}
</style>
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
</script>
<?
	if($sid){
		$query = "select * from faculty_tbl where sid='$sid'";
		$result = $conn->query($query);
		if(DB::isError($result)) {
		  die($result->getMessage());
		}
		$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
		$result->free();

		$room=$d['room'];
		$absolute_room=$d['absolute_room'];
	}

	
	$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
	$room_result=$conn->query($room_query);
	if(DB::isError($room_result)) die($room_result->getMessage());
	while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
		$room_title[] = $r['title'];
		$room_key[] = $r['sid'];
	}
?>
<div class="popupCon" id="" style="width:900px;padding:20px;background:#fffff">
	<form name="facF" id="facF" method="post" action="faculty_reg.php" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?=$sid?>">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
	<input type="hidden" name="mode" value="save">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 15%;">
			<col style="">
		</colgroup>
		<tbody> 
			<tr>
				<th>None Faculty</th>
				<td class="al multi">
					<input type="checkbox" name="faculty_none" id="faculty_none" <?if($d['faculty_none']=='Y'){?>checked<?}?>  style="width:15px;height:15px;" value="Y"><label for="faculty_none" class="fcRed">패컬티가 아닌경우 체크해주세요.(체크하시면 패컬티 리스트에서 제외됩니다.)</label>
				</td>
			</tr>
			<tr>
				<th>Faculty Name</th>
				<td class="al">
					<input type="text" name="faculty_name" id="faculty_name" value="<?=$d['faculty_name']?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>Faculty Country</th>
				<td class="al">
					<input type="text" name="faculty_country" id="faculty_country" value="<?=stripslashes($d['faculty_country'])?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>Faculty Affiliation</th>
				<td class="al">
					<input type="text" name="faculty_aff" id="faculty_aff" value="<?=stripslashes($d['faculty_aff'])?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>Faculty E-mail</th>
				<td class="al">
					<input type="text" name="faculty_email" id="faculty_email" value="<?=stripslashes($d['faculty_email'])?>" style="width:90%;">
				</td>
			</tr>
			
			<tr>
				<th>사진</th>
				<td class="al">
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt" value="선택" type="text" style="width:400px;height:30px;"  readonly></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="photo_file" id="photo_file" onchange="document.getElementById('file_txt').value=this.value;" type="file" ></p>
					</div>
					<?if($d['faculty_photo']){?>
						<div style="float:left;margin-top:5px;margin-left:10px;">
							<?=IconType2($d['faculty_photo'])?>
							<span class="btnAdmin small lightBlue"><button type="button" id="fancyimg" href="/upload/faculty/<?=$d['faculty_photo']?>" data-fancybox="gallery<?=rand(1,9999)?>" >보기</button></span>
							<input type="checkbox" name="photo_filedel" id="photo_filedel" value="Y"> <label for="photo_filedel">삭제를 원하시는 경우 체크해주세요.</label>
						</div>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>패컬티 코드</th>
				<td class="al">
					<input type="text" name="faculty_code"  id="faculty_code" value="<?=stripslashes($d['faculty_code'])?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>CV</th>
				<td class="al">
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt2" value="선택" type="text" style="width:400px;height:30px;"  readonly></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="cv_file" id="cv_file" onchange="document.getElementById('file_txt2').value=this.value;" type="file" ></p>
					</div>
					<?if($d['faculty_cv']){?>
						<div style="float:left;margin-top:5px;margin-left:10px;">
							<?=IconType2($d['faculty_cv'])?>
							<input type="checkbox" name="cv_filedel" id="cv_filedel" value="Y"> <label for="cv_filedel">삭제를 원하시는 경우 체크해주세요.</label>
						</div>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Abstract</th>
				<td class="al">
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt3" value="선택" type="text" style="width:400px;height:30px;"  readonly></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="abs_file" id="abs_file" onchange="document.getElementById('file_txt3').value=this.value;" type="file" ></p>
					</div>
					<?if($d['faculty_abs']){?>
						<div style="float:left;margin-top:5px;margin-left:10px;">
							<?=IconType2($d['faculty_abs'])?>
							<input type="checkbox" name="abs_filedel" id="abs_filedel" value="Y"> <label for="abs_filedel">삭제를 원하시는 경우 체크해주세요.</label>
						</div>
					<?}?>
				</td>
			</tr>

			
			<tr>
				<td class="al" colspan="2">
					<textarea name="faculty_info" style="height:300px;"><?=$d['faculty_info']?></textarea>
				</td>
			</tr>
			
		</tbody>
	</table>
	<div class="tp20 ac">
		<span class="btnAdmin large blue"><button type="submit">확인</button></span>
		<span class="btnAdmin large darkGray"><button type="button" onclick="self.close();">취소</button></span>
	</div>
</div>