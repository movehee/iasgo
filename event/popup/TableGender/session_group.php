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

			$filename = time() . "." . $extension;
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
		
		if($_POST['sid']){
			$query = "update workshop_session_tbl set stime='$stime'";
			$query .= ", etime='$etime'";
			$query .= ", room='$room'";
			$query .= ", part='$part'";
			$query .= ", part2='$part2'";
			$query .= ", title='$title'";
			$query .= ", lang='$lang'";
			$query .= ", code='$code'";
			$query .= ", chair='$chair'";
			$query .= ", judges='$judges'";
			$query .= ", difficulty='$difficulty'";
			$query .= ", code_title='$code_title'";
			$query .= ", vod='$vod'";
			$query .= $file_query;
			$query .= " where sid='$sid'";
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}
		}else{
			$query = "insert into workshop_session_tbl set ev_date='$ev_date'";
			$query .= ", stime='$stime'";
			$query .= ", etime='$etime'";
			$query .= ", room='$room'";
			$query .= ", part='$part'";
			$query .= ", part2='$part2'";
			$query .= ", title='$title'";
			$query .= ", lang='$lang'";
			$query .= ", code='$code'";
			$query .= ", chair='$chair'";
			$query .= ", judges='$judges'";
			$query .= ", difficulty='$difficulty'";
			$query .= ", code_title='$code_title'";
			$query .= ", vod='$vod'";
			$query .= $file_query;
			$result = $conn->query($query);
			if(DB::isError($result)) {
				die($result->getMessage());
			}	
		}
		PutMessageCloseOpenerReload("저장되었습니다.");
		exit;
	}
?>
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
	}

?>
<div class="popupCon" id="" style="width:1500px;padding:20px;background:#fffff">
	<form name="session_DeF" id="session_DeF" method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
	<input type="hidden" name="sid" value="<?=$sid?>">
	<input type="hidden" name="ev_date" value="<?=$ev_date?>">
	<input type="hidden" name="mode" value="save">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: 30%;">
			<col style="width: 20%;">
			<col style="width: 30%;">
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
						<?
							$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
							$room_result=$conn->query($room_query);
							if(DB::isError($room_result)) die($room_result->getMessage());
							while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
						?>
						<option value="<?=$r['sid']?>" <?if($r['sid']==$room){?>selected<?}?>><?=$r['title']?></option>
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
					<input type="text" name="title" id="title" value="<?=$d['title']?>" style="width:90%;">
				</td>
			</tr>
			<tr>
				<th>좌장</th>
				<td colspan=3 class="al">
					<input type="text" name="chair" id="chair" value="<?=$d['chair']?>" style="width:90%;">
					<div class="fcRed">좌장이 복수일 경우  /(슬래시) 를 이용하여 구분해주세요.</div>
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
					<input type="file" name="session_file" id="session_file">
					<?if($d['session_file']){?>
					<?=IconType2($d['session_file'])?><input type="checkbox" name="filedel" value="Y"> <label for="">파일삭제를 원하시면 체크해주세요.</label>
					<?}?>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="tp20 ac">
		<span class="btnAdmin large blue"><button type="submit">확인</button></span>
		<span class="btnAdmin large darkGray"><button type="button" onclick="self.close();">취소</button></span>
	</div>
</div>