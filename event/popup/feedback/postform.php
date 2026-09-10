<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?	
	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);

	$query = "select * from feedback_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
	
	$admin_yn="Y";
?>
<link rel="stylesheet" href="/css/pickout.css">
<style>
.pk-field{width:300px !important;border-color:red;}	
.pk-search{width:90%;}
.pk-modal{padding:0; margin:0;width:30%;}
</style>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('Feedback');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);

		$('#title').on('change',function(){
			var key = $(this).val();
			$(".title_sub_area").load("/registration/change_title.php?key="+key);	
		});

		$('.kind').on('click',function(){
			if($('.kind:checked').val()=='A'){
				$('.kind_area_A').show();
			}else{
				$('.kind_area_A').hide();
			}
		});
		$('.que_type').on('click',function(){
			if($('.que_type:checked').val()=='Z'){
				$('.que').val("");
			}else{
				var txt = $(this).attr('txt');
				var split_txt = txt.split(",");
				for(i=0;i<split_txt.length;i++){
					var input_txt = split_txt[i].split(":");
					$('#que'+(i+1)).val(input_txt[1]);
				}

			}
		});
		
	});
	
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<form method="post" name="postForm" id="postForm" action="post.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: 80%;">
		</colgroup>
		<tbody>
			<tr>
				<th>유형</th>
				<td class="al">
					<?foreach($_Feedback['kind'] as $tkey=>$tval){?>
						<input type="radio" name="kind" class="kind" id="kind<?=$tkey?>" value="<?=$tkey?>" <?if($tkey==$d['kind']){?>checked<?}?>><label for="kind<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>질문</th>
				<td class="al">
					<textarea name="question" id="question" style="width:99%;height:100px;"><?=$d['question']?></textarea>
				</td>
			</tr>
			<tr class="kind_area_A">
				<th>문항유형</th>
				<td class="al" style="padding:0px;">
					<ul style="list-style:none;padding-left:15px;font-size:1.2em;">
						<?foreach($_Feedback['que_type'] as $tkey=>$tval){?>
							<li><input type="radio" name="que_type" class="que_type" id="que_type<?=$tkey?>" value="<?=$tkey?>" txt="<?=$tval?>"> <label for="que_type<?=$tkey?>"><?=$tval?></label></li>
						<?}?>
					</ul>
				</td>
			</tr>
			<?for($i=1;$i<=5;$i++){?>
			<tr class="kind_area_A">
				<th>문항 <?=$i?></th>
				<td class="al"><input type="text" name="que<?=$i?>" id="que<?=$i?>" class="que" value="<?=$d['que'.$i]?>" style="width:99%;"></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<?if(!$d['sid']){?>
			<input type="submit" value="저장" class="btnPoint btnBig">
		<?}else{?>
			<input type="submit" value="수정" class="btnPoint btnBig">
		<?}?>
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>