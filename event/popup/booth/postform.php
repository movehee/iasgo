<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select * from booth where sid='$sid'";
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
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<link rel='stylesheet' type='text/css' href='/mail/conf/jquery-flick.css'/>
<script type="text/javascript" src="/script/jquery-ui.min.js"></script>

<link rel="stylesheet" href="/script/jquery.ui.timepicker.css">
<script src='/script/jquery.ui.timepicker.js'></script>

<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("E-Booth 등록");	
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);
		$('.timepicker').timepicker(); //타임픽커
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
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				
				<th>부스등급</th>
				<td class="al">
					<?if($mode=='form'){?>
						<select name="booth_sid">
							<option value="">선택</option>
							<?
							$query = "select * from booth_grade where del='N' order by sort_num asc";
							$result=$conn->query($query);
							if(DB::isError($result)) die($result->getMessage());
							while(is_array($b=$result->fetchRow(DB_FETCHMODE_ASSOC))){
							?>
							<option value="<?=$b['sid']?>" <?if($d['booth_sid']==$b['sid']){?>selected<?}?> ><?=$b['title']?></option>
							<?}?>
						</select>
					<?}else{?>
						<?=$d['homepage']?>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>Type</th>
				<td class="al">
					<div style="float:left;">
						<label for="booth_type1"><img src="/image/sample/boothBg_A.png" width=100; ></label>
						<div class="ac"><input type="radio" value='A' name="booth_type" id="booth_type1"  <?if($d['booth_type']=='A'){?>checked<?}?> /><label for="booth_type1">A</label></div>
					</div>
					<div style="float:left;">
						<label for="booth_type2"><img src="/image/sample/boothBg_B.png" width=140; ></label>
						<div class="ac"><input type="radio" value='B' name="booth_type" id="booth_type2"  <?if($d['booth_type']=='B'){?>checked<?}?> /><label for="booth_type2">B</label></div>
					</div>
					
				</td>
			</tr>
			<tr>
				<th>부스명</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="text" name="title" id="title" value="<?=$d['title']?>" style="width:80%;">
					<?}else{?>
						<?=$d['title']?>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>ID</th>
				<td class="al">
					<input type="text" name="id" id="id" value="<?=$d['id']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th>Company 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op1" id="op1y" <?if($d['op1']=='Y'){?>checked<?}?> /><label for="op1y">사용</label>
						<input type="radio" value='N' name="op1" id="op1n" <?if($d['op1']=='N'){?>checked<?}?> /><label for="op1n">미사용</label>
					<?}else{?>
						<?=$d['title']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Brochures 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op2" id="op2y" <?if($d['op2']=='Y'){?>checked<?}?> /><label for="op2y">사용</label>
						<input type="radio" value='N' name="op2" id="op2n" <?if($d['op2']=='N'){?>checked<?}?> /><label for="op2n">미사용</label>
					<?}else{?>
						<?=$d['op2']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Movie 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op3" id="op3y" <?if($d['op3']=='Y'){?>checked<?}?> /><label for="op3y">사용</label>
						<input type="radio" value='N' name="op3" id="op3n" <?if($d['op3']=='N'){?>checked<?}?> /><label for="op3n">미사용</label>
					<?}else{?>
						<?=$d['op3']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Survey 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op4" id="op4y" <?if($d['op4']=='Y'){?>checked<?}?> /><label for="op4y">사용</label>
						<input type="radio" value='N' name="op4" id="op4n" <?if($d['op4']=='N'){?>checked<?}?> /><label for="op4n">미사용</label>
					<?}else{?>
						<?=$d['op4']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Guest Book 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op5" id="op5y" <?if($d['op5']=='Y'){?>checked<?}?> /><label for="op5y">사용</label>
						<input type="radio" value='N' name="op5" id="op5n" <?if($d['op5']=='N'){?>checked<?}?> /><label for="op5n">미사용</label>
					<?}else{?>
						<?=$d['op5']?>
					<?}?>
				</td>
			</tr>

			<tr>
				<th>Stamp Event 사용</th>
				<td class="al">
					<?if($mode=='form'){?>
						<input type="radio" value='Y' name="op6" id="op6y" <?if($d['op6']=='Y'){?>checked<?}?> /><label for="op6y">사용</label>
						<input type="radio" value='N' name="op6" id="op6n" <?if($d['op6']=='N'){?>checked<?}?> /><label for="op6n">미사용</label>
					<?}else{?>
						<?=$d['op6']?>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>Link</th>
				<td class="al">
					<input type="text" name="linkurl" id="linkurl" value="<?=$d['linkurl']?>" style="width:80%;" placeholder="예) https://webinar.m2comm.co.kr">
				</td>
			</tr>

			<tr>
				<th >AI Stage 제목</th>
				<td class="al">
					<input type="text" name="ai_stage_title" id="ai_stage_title" value="<?=$d['ai_stage_title']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >AI Stage 영상</th>
				<td class="al">
					<input type="text" name="ai_stage" id="ai_stage" value="<?=$d['ai_stage']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >AI Stage 오픈</th>
				<td class="al">
					<input type="checkbox" name="ai_stage_open" id="ai_stage_open" value="Y" <?if($d['ai_stage_open']=='Y'){?>checked<?}?>>
				</td>
			</tr>

			<tr>
				<th >AI Stage2 제목</th>
				<td class="al">
					<input type="text" name="ai_stage_title2" id="ai_stage_title2" value="<?=$d['ai_stage_title2']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >AI Stage2 영상</th>
				<td class="al">
					<input type="text" name="ai_stage2" id="ai_stage2" value="<?=$d['ai_stage2']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >AI Stage2 오픈</th>
				<td class="al">
					<input type="checkbox" name="ai_stage_open2" id="ai_stage_open2" value="Y" <?if($d['ai_stage_open2']=='Y'){?>checked<?}?>>
				</td>
			</tr>

			<tr>
				<th >Industry Theater 제목</th>
				<td class="al">
					<input type="text" name="in_theater_title" id="in_theater_title" value="<?=$d['in_theater_title']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >Industry Theater 영상</th>
				<td class="al">
					<input type="text" name="in_theater" id="in_theater" value="<?=$d['in_theater']?>" style="width:80%;">
				</td>
			</tr>

			<tr>
				<th >Industry Theater 오픈</th>
				<td class="al">
					<input type="checkbox" name="in_theater_open" id="in_theater_open" value="Y" <?if($d['in_theater_open']=='Y'){?>checked<?}?>>
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
