<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select * from booth_company where booth_sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	if(!$mode && !$d['content']){
		$mode = "form";
	}
?>
<script style="text/javascript">
	var booth_sid = "<?=$sid?>";
	$(function(){
		$('#Popup_Title').html("회사소개 등록");
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,1000);

		$('.company_filedel').on('click',function(){
			var kind = $(this).attr("kind");
			if(confirm("삭제하시겠습니까?")){
				$.ajax({
					type:"POST",
					url:"company_filedel.php",
					data:"kind="+kind+"&booth_sid="+booth_sid,
					async:false,
					success:function(msg){
						if(msg=='Y'){
							location.reload();
						}
					}
				});
			}
		});
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
<script type="text/javascript">
	$(window).load(function () {
		$("#hidFileName").val('');
		
		$(".cancel").click(function () { history.back(); });
		$("#postForm").submit(function () {
			$("#postForm").attr("target", "_self");
			$("#postForm").attr("action", "company_reg.php?code=<?=$_GET['code']?>&mode=post");

			if($("#status").val()=='Y'){ 
				return true; 
			}
			/*Tiny 내용검사*/
			var tiny_text = tinymce.activeEditor.getContent({format: 'textarea'});
			tiny_text = tiny_text.replace(/(<([^>]+)>)/ig,"");
			tiny_text = tiny_text.replace(/<br\/>/ig, "\n");
			tiny_text = tiny_text.replace(/<(\/)?([a-zA-Z]*)(\s[a-zA-Z]*=[^>]*)?(\s)*(\/)?>/ig, "");
			
			if(!$.trim(tiny_text)){
                alert('내용을 입력해 주세요.');
				tinyMCE.activeEditor.focus();
                return false;
            }
			return true;
		});
		
	  /* Tiny 제어
	  tinymce.activeEditor.setMode('readonly');  // readonly
	  tinymce.activeEditor.setMode('design'); //readonly 해제
	  */
	});
//});

<?
/* 스팸코드 주석
function changeZsfImg() {
	document.getElementById("zsfImg").src="http://<?=$_SERVER['HTTP_HOST']?>/func/zmSpamFree/zmSpamFree.php?re&zsfimg="+new Date().getTime();
}
*/
?>
//]]>
</script>
<div class="popupCon" id="" style="width:1500px;padding:10px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 65%;">
			<col style="">
		</colgroup>
		<tbody>
			<tr>
				<td style="margin:0px !important;padding:0px !important;" valign="top">
					<?if($mode=='form'){?>
						<textarea name="content" id="content" style="width:100%;height:600px;"><?=$d['content']?></textarea>
					<?}else{?>
						<?=$d['content']?>
					<?}?>
				</td>
				<td valign="top" style="margin:0px !important;padding:0px !important;border-top:0px !important;">
					<table class="tblDef inputTbl" style="width:100%;margin:0px !important;padding:0px !important;border-top:0px !important;border-left:0px !important;border-right:0px !important;">
						<colgroup>
							<col style="width: 25%;">
							<col style="">
						</colgroup>
						<tbody>
							<tr>
								<th style="border-left:0px;">로고파일</th>
								<td class="al">
									<?if($mode=='form'){?>
										<div class="selectFile" style="float:left;">
											<p style="margin:0px;padding:0px;"><input name="" id="logo_file_txt" value="선택" type="text" style="width:100px;height:30px;"  readonly></p>
											<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="logo_file" id="logo_file" onchange="document.getElementById('logo_file_txt').value=this.value;" type="file" ></p>
										</div>
									<?}?>
									<?if($d['logo_file']){?>
										<div style="float:left;margin-top:5px;margin-left:10px;">
											<?=IconType2($d['logo_file'])?>
											<span class="btnAdmin small lightBlue"><button type="button" id="fancyimg" href="/upload/booth/<?=$d['logo_file']?>" data-fancybox="gallery<?=rand(1,9999)?>" >보기</button></span>
											<span class="btnAdmin small red"><button type="button" class="company_filedel" kind="logo_file">삭제</button></span>
										</div>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">명함이미지</th>
								<td class="al">
									<?if($mode=='form'){?>
										<div class="selectFile" style="float:left;">
											<p style="margin:0px;padding:0px;"><input name="" id="card_file_txt" value="선택" type="text" style="width:100px;height:30px;"  readonly></p>
											<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="card_file" id="card_file" onchange="document.getElementById('card_file_txt').value=this.value;" type="file" ></p>
										</div>
									<?}?>
									<?if($d['card_file']){?>
										<div style="float:left;margin-top:5px;margin-left:10px;">
											<?=IconType2($d['card_file'])?>
											<span class="btnAdmin small lightBlue"><button type="button" id="fancyimg" href="/upload/booth/<?=$d['card_file']?>" data-fancybox="gallery<?=rand(1,9999)?>" >보기</button></span>
											<span class="btnAdmin small red"><button type="button" class="company_filedel" kind="card_file">삭제</button></span>
										</div>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">성명</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="name_kr" id="name_kr" value="<?=$d['name_kr']?>" style="width:90%;">
									<?}else{?>
										<?=$d['name_kr']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">부서</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="department" id="department" value="<?=$d['department']?>" style="width:90%;">
									<?}else{?>
										<?=$d['department']?>
									<?}?>
								</td>
							</tr>
							
							<tr>
								<th style="border-left:0px;">Phone</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="cell" id="cell" value="<?=$d['cell']?>" style="width:90%;">
									<?}else{?>
										<?=$d['cell']?>
									<?}?>
								</td>
							</tr>

							<tr>
								<th style="border-left:0px;">Tel</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="tel" id="tel" value="<?=$d['tel']?>" style="width:90%;">
									<?}else{?>
										<?=$d['tel']?>
									<?}?>
								</td>
							</tr>

							<tr>
								<th style="border-left:0px;">fax</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="fax" id="fax" value="<?=$d['fax']?>" style="width:90%;">
									<?}else{?>
										<?=$d['fax']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">E-mail</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="email" id="email" value="<?=$d['email']?>" style="width:90%;">
									<?}else{?>
										<?=$d['email']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">주소</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="address" id="address" value="<?=$d['address']?>" style="width:90%;">
									<?}else{?>
										<?=$d['address']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">Website</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="homepage" id="homepage" value="<?=$d['homepage']?>" style="width:90%;">
									<?}else{?>
										<?=$d['homepage']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">Booth Link</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="booth_link" id="booth_link" value="<?=$d['booth_link']?>" style="width:90%;">
									<?}else{?>
										<?=$d['booth_link']?>
									<?}?>
								</td>
							</tr>
							<tr>
								<th style="border-left:0px;">VOD</th>
								<td class="al">
									<?if($mode=='form'){?>
										<input type="text" name="vod_link" id="vod_link" value="<?=$d['vod_link']?>" style="width:60%;">
										<input type="checkbox" name="vod_stamp" id="vod_stamp" value="Y" style="width:22px;height:22px;" <?if($d['vod_stamp']=='Y'){?>checked<?}?>> <label for="vod_stamp">Stamp</label>
									<?}else{?>
										<?=$d['vod_link']?>
										<div class="tp5">
										<input type="checkbox" style="width:22px;height:22px;margin:0px;padding:0px;" id="vod_stamp" key="<?=$d['sid']?>" kind="vod_stamp" class="check_value" <?if($d['vod_stamp']=='Y'){?>checked<?}?>>
										<label for="vod_stamp">Stamp</label>
										</div>
									<?}?>
								</td>
							</tr>

							

							<tr>
								<th style="border-left:0px;">Brochures</th>
								<td class="al">
									<?if($mode=='form'){?>
										<div class="selectFile">
											<p style="margin:0px;padding:0px;"><input name="" id="brochures_txt" value="선택" type="text" style="width:100px;height:30px;"  readonly></p>
											<p style="margin:0px;padding:0px;" class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="brochures" id="brochures" onchange="document.getElementById('brochures_txt').value=this.value;" type="file" ></p>
										</div>
									<?}?>
									<?if($d['brochures']){?>
										<div style="float:left;margin-top:5px;margin-left:10px;">
											<?=IconType2($d['brochures'])?>
											<span class="btnAdmin small lightBlue"><button type="button" id="fancyimg" href="/upload/booth/<?=$d['brochures']?>" data-fancybox="gallery<?=rand(1,9999)?>" >보기</button></span>
											<span class="btnAdmin small red"><button type="button" class="company_filedel" kind="brochures">삭제</button></span>
										</div>
									<?}?>
								</td>
							</tr>
							
							<tr>
								<th style="border-left:0px;">Social</th>
								<td class="al" style="width:100%;padding:0px !important;margin:0px !important;">
									<table cellpadding="0" cellspacing="0" style="width:100%;border:0px;padding:0px !important;margin:0px !important;">
										<?foreach($_Booth['social'] as $tkey=>$tval){?>
										<tr>
											<td style="width:70px;padding:0px;margin:0px;font-weight:bold;"><?=$tval?></td>
											<td>
												<?if($mode=='form'){?>
												<input type="text" style="width:90%;" name="<?=$tkey?>" value="<?=$d[$tkey]?>">
												<?}else{?>
												: <?=$d[$tkey]?>
												<?}?>
											</td>
										</tr>
										<?}?>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
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
