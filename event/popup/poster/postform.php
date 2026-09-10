<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select * from e_poster where sid='$sid'";
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
<script type="text/javascript" src="/func/tinymce_ver5/js/tinymce/tinymce.js"></script>
<script type="text/javascript" src="/script/tiny.js"></script>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("E-Poster 등록");

		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);

		$("select#category").on("change", function() {
			var psid=$(this).val();

			$.ajax({
				type:"POST",
				dataType:"JSON",
				url:"category.php",
				data:"psid="+psid,
				success:function(data){
					if(data.length) {
						$('select#category_sub').empty().append('<option value="">선택</option>');

						$.each(data, function(key, obj){ 
							$("select#category_sub").append(new Option(obj.value, obj.key));
						});
					}
				}
			});
		});
	});
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="post.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				
				<th>Category</th>
				<td class="al" colspan=3>
					<select name="category" id="category">
						<option value="">선택</option>
						<?
						$query = "select * from e_poster_category where depth='1' and del='N'";
						$result=$conn->query($query);
						if(DB::isError($result)) die($result->getMessage());
						while(is_array($c=$result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<option value="<?=$c['sid']?>" <?if($d['category']==$c['sid']){?>selected<?}?> ><?=$c['title']?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Sub Category</th>
				<td class="al">
					<select name="category_sub" id="category_sub">
						<option value="">선택</option>
						<?
						$query = "select * from e_poster_category where depth='2' and psid='$d[category]' and del='N'";
						$result=$conn->query($query);
						if(DB::isError($result)) die($result->getMessage());
						while(is_array($c=$result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<option value="<?=$c['sid']?>" <?if($d['category_sub']==$c['sid']){?>selected<?}?> ><?=$c['title']?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>연제번호</th>
				<td class="al" colspan=3>
					<input type="text" name="code" id="code" value="<?=stripslashes($d['code'])?>" style="width:80%;">
				</td>
			</tr>
			<tr>
				<th>Poster No.</th>
				<td class="al" colspan=3>
					<input type="text" name="poster_number" id="poster_number" value="<?=stripslashes($d['poster_number'])?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th>제목</th>
				<td class="al" colspan=3>
					<input type="text" name="subject" id="subject" value="<?=stripslashes($d['subject'])?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th>Presenter</th>
				<td class="al">
					<input type="text" name="presenter" id="presenter" value="<?=stripslashes($d['presenter'])?>" style="width:80%;">
				</td>
				<th>Presenter Affiliation</th>
				<td class="al">
					<input type="text" name="presenter_aff" id="presenter_aff" value="<?=stripslashes($d['presenter_aff'])?>" style="width:80%;">
				</td>
			</tr>
			<tr>
				<th>Presenter E-mail</th>
				<td class="al" colspan=3>
					<input type="text" name="presenter_email" id="presenter_email" value="<?=stripslashes($d['presenter_email'])?>" style="width:80%;">
				</td>
			</tr>
			<tr>
				<th>Corresponding Author E-mail</th>
				<td class="al" colspan=3>
					<input type="text" name="email" id="email" value="<?=stripslashes($d['email'])?>" style="width:80%;">
				</td>
			</tr>
			<tr>
				<th>Author</th>
				<td class="al" colspan=3>
					<div class="dfree-body mce-content-body" contenteditable="true" style="position: relative;border:1px solid gray;height:70px;width:95%;" spellcheck="false"><?=stripslashes($d['author'])?></div>
				</td>
			</tr>
			<tr>
				<th>Co-Author</th>
				<td class="al" colspan=3>
					<div class="dfree-body mce-content-body" contenteditable="true" style="position: relative;border:1px solid gray;height:70px;width:95%;" spellcheck="false"><?=stripslashes($d['co_author'])?></div>
				</td>
			</tr>
			<tr>
				<th>Author Affiliation</th>
				<td class="al" colspan=3>
					<textarea name="affiliation" id="affiliation" style="height:70px;width:99%;"><?=nl2br($d['affiliation'])?></textarea>
				</td>
			</tr>
			<tr>
				<th>Video</th>
				<td class="al" colspan=3>
					<input type="text" name="movie" id="movie" style="width:98%" value="<?=$d['movie']?>">
				</td>
			</tr>
			
			<!-- <?for($i=1;$i<=6;$i++){?>
			<tr>
				<th>저자<?=$i?></th>
				<td class="al">
					<input type="text" name="author<?=$i?>" id="author<?=$i?>" style="width:98%" value="<?=stripslashes($d['author'.$i])?>">
				</td>
				<th>저자<?=$i?>(소속번호)</th>
				<td class="al">
					<input type="text" name="author_aff<?=$i?>" id="author_aff<?=$i?>" style="width:98%" value="<?=stripslashes($d['author_aff'.$i])?>">
				</td>
			</tr>
			<?}?>
			<?for($i=1;$i<=6;$i++){?>
			<tr>
				<th>소속<?=$i?></th>
				<td class="al" colspan=3>
					<input type="text" name="position<?=$i?>" id="position<?=$i?>" style="width:98%" value="<?=stripslashes($d['position'.$i])?>">
				</td>
			</tr>
			<?}?>
			<tr>
				<th>invited</th>
				<td class="al">
					<input type="checkbox" name="invited" id="invited" value="Y" <?if($d['invited']=='Y'){?>checked<?}?>> <label for="invited">선택</label>
				</td>
				<th>Award</th>
				<td class="al">
					<input type="text" name="movie" id="movie" style="width:98%" value="<?=$d['award']?>">
				</td>
			</tr> -->
			<!-- <tr>
				<th>동영상<div class="fcRed" style="font-size:10px;">영상 주소만 입력.</div></th>
				<td class="al" colspan=3>
					<input type="text" name="movie" id="movie" style="width:98%" value="<?=$d['movie']?>">
					
				</td>
			</tr>
			<tr>
				<th>Best Award</th>
				<td class="al" colspan=3>
					<input type="checkbox" name="award" id="award" value="Y" <?if($d['award']=='Y'){?>checked<?}?>> <label for="award">선택</label>
				</td>
			</tr> -->
			<tr>
				<th>Award</th>
				<td class="al" colspan=3>
					<?foreach($_Poster['award'] as $tkey=>$tval){?>
					<input type="radio" name="award" id="award<?=$tkey?>" value="<?=$tkey?>" <?if($d['award']==$tkey){?>checked<?}?>> <label for="award<?=$tkey?>"><?=$tval?></label>
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
