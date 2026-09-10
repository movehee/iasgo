<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	if($_POST['mode']=="save"){
		
		
		if($filedel=='Y'){
			$file_query = ", session_file='', session_realfile=''";
		}
		if($_FILES['session_file']['name']){
			$ext = explode(".",$_FILES['session_file']['name']);
			$len = sizeof($ext)-1;
			$extension = $ext[$len];

			$filename = "session_".time() . "." . $extension;
			$realfilename = $_FILES['session_file']['name'];
			
			if($_SERVER['REMOTE_ADDR']!="112.76.194.32"){
				if(floor(filesize($_FILES['session_file']['tmp_name'])/1024)>10240){
					PutMessageBack("업로드 용량을 초과하였습니다. 10MB 이하로 올려주세요");
					exit;
				}
			}
			if(!copy($_FILES['session_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . "upload/session/" . $filename)){
				PutMessageBack("업로드가 정상적으로 되지 않았습니다.");
				exit;
			}

			$file_query = ", session_file='$filename', session_realfile='$realfilename'";
		}
		if($logo_filedel=='Y'){
			$file_query2 = ", logo_file=''";
		}
		if($_FILES['logo_file']['name']){
			$ext = explode(".",$_FILES['logo_file']['name']);
			$len = sizeof($ext)-1;
			$extension = $ext[$len];

			$filename = "logo_".time() . "." . $extension;
			$realfilename = $_FILES['logo_file']['name'];
			
			if($_SERVER['REMOTE_ADDR']!="112.76.194.32"){
				if(floor(filesize($_FILES['logo_file']['tmp_name'])/1024)>10240){
					PutMessageBack("업로드 용량을 초과하였습니다. 10MB 이하로 올려주세요");
					exit;
				}
			}
			if(!copy($_FILES['logo_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT'] . "upload/session/" . $filename)){
				PutMessageBack("업로드가 정상적으로 되지 않았습니다.");
				exit;
			}

			$file_query2 = ", logo_file='$filename'";
		}

		$title = $_POST['mce_1'];


		$common_query = " stime='$stime'";
		$common_query .= ", etime='$etime'";
		$common_query .= ", room='$room'";
		$common_query .= ", part='$part'";
		$common_query .= ", part2='$part2'";
		$common_query .= ", title='".addslashes($title)."'";
		$common_query .= ", lang='$lang'";
		$common_query .= ", code='$code'";
		$common_query .= ", chair='".addslashes($chair)."'";
		$common_query .= ", chair2='".addslashes($chair2)."'";
		$common_query .= ", chair3='".addslashes($chair3)."'";
		$common_query .= ", judges='$judges'";
		$common_query .= ", chair_code='$chair_code'";
		$common_query .= ", chair_code2='$chair_code2'";
		$common_query .= ", chair_code3='$chair_code3'";
		$common_query .= ", difficulty='$difficulty'";
		$common_query .= ", code_title='$code_title'";
		$common_query .= ", vod='$vod'";
		$common_query .= ", absolute_room='$absolute_room'";
		$common_query .= ", etc1='$etc1'";
		$common_query .= ", etc2='$etc2'";
		$common_query .= ", etc3='$etc3'";
		$common_query .= ", etc4='$etc4'";
		$common_query .= ", etc5='$etc5'";
		$common_query .= ", etc6='$etc6'";
		$common_query .= ", etc7='$etc7'";
		$common_query .= ", logo_link_target='$logo_link_target'";
		$common_query .= ", logo_link='$logo_link'";
		$common_query .= ", info='$info'";
		
		$common_query .= $file_query;
		$common_query .= $file_query2;

		if($_POST['sid']){
			$query = "update workshop_session_tbl set " .$common_query;
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}else{
			$query = "insert into workshop_session_tbl set " .$common_query;
			$query .= ", ev_date='$ev_date'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}
		PutMessageCloseOpenerReload("저장되었습니다.");
		exit;
	}
?>
<script type="text/javascript" src="/func/tinymce_ver5/js/tinymce/tinymce.js"></script>
<script type="text/javascript" src="/script/tiny.js"></script>
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
<?
	if($sid){
		$query = "select * from workshop_session_tbl where sid='$sid'";
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
	<form name="session_DeF" id="session_DeF" method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?=$sid?>">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
	<input type="hidden" name="mode" value="save">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 15%;">
			<col style="width: 35%;">
			<col style="width: 15%;">
			<col style="width: 35%;">
		</colgroup>
		<tbody> 
			<tr>
				<th>시간</th>
				<td class="al">
				<input type="text" name="stime" id="stime" value="<?=$d['stime']?>" class="timepicker" style="width:80px;"> ~ 
				<input type="text" name="etime" id="etime" value="<?=$d['etime']?>" class="timepicker" style="width:80px;">
				</td>
				<th>채널</th>
				<td class="al" >
					<select name="room" id="room">
						<?foreach($room_key as $tkey=>$tval){?>
						<option value="<?=$tval?>" <?if($tval==$room){?>selected<?}?>><?=$room_title[$tkey]?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<tr>
				<th>구분</th>
				<td class="al">
					<input type="text" name="part" id="part" value="<?=$d['part']?>" style="width:90%;">
				</td>
				<th>세부구분</th>
				<td class="al">
					<input type="text" name="part2" id="part2" value="<?=$d['part2']?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>언어</th>
				<td class="al">
					<?foreach($_PROGRAM['lang_code'] as $tkey=>$tval){?>
					<input type="radio" name="lang" id="lang<?=$tkey?>" class="lang" value="<?=$tkey?>" <?if($d['lang']==$tkey){?>checked<?}?>> <label for="lang<?=$tkey?>"><?=$tval?></label>
					<?}?>
				</td>
				<th>코드</th>
				<td class="al" ><input type="text" name="code" id="code" value="<?=$d['code']?>" style="width:90%;"></td>
			</tr>
			<tr>
				<th>난이도</th>
				<td class="al" ><input type="text" name="difficulty" id="difficulty" value="<?=$d['difficulty']?>" style="width:90%;"></td>
				<th>코드(Full Name)</th>
				<td class="al" ><input type="text" name="code_title" id="code_title" value="<?=$d['code_title']?>" style="width:90%;"></td>
			</tr>
			
			<tr>
				<th>Session Title</th>
				<td colspan=3 class="al">
					<div class="dfree-body mce-content-body" contenteditable="true" style="position: relative;border:1px solid gray;height:50px;width:90%;" spellcheck="false"><?=stripslashes($d['title'])?></div>
					<!-- <input type="text" name="title" id="title" value="<?=stripslashes($d['title'])?>" style="width:90%;"> -->
				</td>
			</tr>
			<tr>
				<th>좌장</th>
				<td colspan=3 class="al">
					<div>
						<input type="text" name="chair_code" id="chair_code" value="<?=$d['chair_code']?>" style="width:20%;" placeholder="CODE"> 
						<input type="text" name="chair" id="chair" value="<?=$d['chair']?>" style="width:70%;" placeholder="좌장명(소속)">
					</div>
					<div class="tp5">
						<input type="text" name="chair_code2" id="chair_code2" value="<?=$d['chair_code2']?>" style="width:20%;" placeholder="CODE"> 
						<input type="text" name="chair2" id="chair2" value="<?=$d['chair2']?>" style="width:70%;" placeholder="좌장명(소속)">
					</div>
					<div class="tp5">
						<input type="text" name="chair_code3" id="chair_code3" value="<?=$d['chair_code3']?>" style="width:20%;" placeholder="CODE"> 
						<input type="text" name="chair3" id="chair3" value="<?=$d['chair3']?>" style="width:70%;" placeholder="좌장명(소속)">
					</div>
					<div class="tp5">
						<input type="text" name="chair_code4" id="chair_code4" value="<?=$d['chair_code4']?>" style="width:20%;" placeholder="CODE"> 
						<input type="text" name="chair4" id="chair4" value="<?=$d['chair4']?>" style="width:70%;" placeholder="좌장명(소속)">
					</div>
					<!-- <div class="fcRed">좌장이 복수일 경우   | 를 이용하여 구분해주세요.</div> -->
				</td>
			</tr>
			<tr>
				<th>Judge</th>
				<td colspan=3 class="al">
					<input type="text" name="judges" id="judges" value="<?=$d['judges']?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>VOD</th>
				<td colspan=3 class="al">
					<input type="text" name="vod" id="vod" value="<?=$d['vod']?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>파일업로드</th>
				<td colspan=3 class="al">	
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt" value="선택" type="text" style="width:400px;height:30px;" readonly=""></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="session_file" id="session_file" onchange="document.getElementById('file_txt').value=this.value;" type="file"></p>
					</div>
					<?if($d['session_file']){?>
					<div style="clear:both;"><?=IconType2($d['session_file'])?><input type="checkbox" name="filedel" value="Y"> <label for="">파일삭제를 원하시면 체크해주세요.</label></div>
					<?}?>
				</td>
			</tr>
			<tr>
				<th rowspan=2>LOGO 파일</th>
				<td colspan=3 class="al">
					<div class="selectFile" style="float:left;">
						<p style="margin:0px;padding:0px;"><input name="" id="file_txt2" value="선택" type="text" style="width:400px;height:30px;" readonly=""></p>
						<p class="withIcon" style="margin:0px;padding:0px;"><i class="fas fa-search"></i><input class="opacity0" name="logo_file" id="logo_file" onchange="document.getElementById('file_txt2').value=this.value;" type="file"></p>
					</div>
					<?if($d['logo_file']){?>
					<div style="clear:both;"><?=IconType2($d['logo_file'])?><input type="checkbox" name="logo_filedel" value="Y"> <label for="">파일삭제를 원하시면 체크해주세요.</label></div>
					<?}?>
				</td>
			</tr>
			<tr>
				<td colspan=3 class="al">
					<?foreach($_CONFIG['link_target'] as $tkey=>$tval){?>
					<input type="radio" name="logo_link_target" id="logo_link_target<?=$tkey?>" value="<?=$tkey?>" <?if($d['logo_link_target']==$tkey){?>checked<?}?> ><label for="logo_link_target<?=$tkey?>"><?=$tval?></label>
					<?}?>
					<div class="tp5"><input type="text" name="logo_link" id="logo_link" value="<?=$d['logo_link']?>" style="width:90%;"></div>
				</td>
			</tr>
			
			<tr>
				<th>Room</th>
				<td colspan=3 class="al">
					<input type="radio" name="absolute_room" class="absolute_room" id="absolute_room" value=""><label for="absolute_room">없음</label>
					<?foreach($room_key as $tkey=>$tval){?>
					<input type="radio" name="absolute_room" class="absolute_room" id="absolute_room<?=$tval?>" value="<?=$tval?>" <?if($tval==$absolute_room){?>checked<?}?>><label for="absolute_room<?=$tval?>"><?=$room_title[$tkey]?></label>
					<?}?>
					<div  class="fcRed tp5">룸을 선택하시는 경우 Question/Voting의 결과가 해당방으로만 쌓이도록 고정됩니다.</div>
				</td>
			</tr>
			<!-- <tr>
				<th>구분</th>
				<td colspan=3 class="al">
					<input type="checkbox" name="etc1" class="etc1" id="etc1" value="Y" <?if($d['etc1']=='Y'){?>checked<?}?>><label for="etc1">Pre-recorded Video</label>
					<input type="checkbox" name="etc2" class="etc2" id="etc2" value="Y" <?if($d['etc2']=='Y'){?>checked<?}?>><label for="etc2">Video & Live Discussion</label>
				</td>
			</tr>
			<tr>
				<th>구분2</th>
				<td colspan=3 class="al">
					<input type="checkbox" name="etc3" class="etc3" id="etc3" value="Y" <?if($d['etc3']=='Y'){?>checked<?}?>><label for="etc3">Guest Nation Taiwan</label>
					<input type="checkbox" name="etc4" class="etc4" id="etc4" value="Y" <?if($d['etc4']=='Y'){?>checked<?}?>><label for="etc4">전공의 골절 워크샵</label>
					<input type="checkbox" name="etc5" class="etc5" id="etc5" value="Y" <?if($d['etc5']=='Y'){?>checked<?}?>><label for="etc5">일반인 건강강좌</label>
					<input type="checkbox" name="etc6" class="etc6" id="etc6" value="Y" <?if($d['etc6']=='Y'){?>checked<?}?>><label for="etc6">필수평점 세션</label>
					<input type="checkbox" name="etc7" class="etc7" id="etc7" value="Y" <?if($d['etc7']=='Y'){?>checked<?}?>><label for="etc7">산학협력 심포지엄</label>
				</td>
			</tr> -->
			<tr>
				<th>설명</th>
				<td colspan=3 class="al">
					<textarea name="info" id="content"><?=stripslashes($d['info'])?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="tp20 ac">
		<span class="btnAdmin large blue"><button type="submit">확인</button></span>
		<span class="btnAdmin large darkGray"><button type="button" onclick="self.close();">취소</button></span>
	</div>
</div>