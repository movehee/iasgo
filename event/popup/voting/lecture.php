<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	$query = "select * from lecture_tbl where sid='$sid'";
	$result = $conn->query($query);
	if(DB::isError($result)) {
	  die($result->getMessage());
	}
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();

	if($d['eventdate']){
		$eventdate = date("Y-m-d",$d['eventdate']);
	}

	$room_cnt = $conn->getOne("select * from workshop_session_category where kind='P' and del='N'");
	
	if($room_cnt>0){
		$room_query = "select * from workshop_session_category where kind='P' and del='N' order by sort_num asc,sid asc";
		$room_result=$conn->query($room_query);
		if(DB::isError($room_result)) die($room_result->getMessage());
		while(is_array($r=$room_result->fetchRow(DB_FETCHMODE_ASSOC))){
			$room_sid[] = $r['sid'];
			$room_name[$r['sid']] = $r['title'];
		}
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('연자등록');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,400);

		$('#lecF').submit(function(){
			if(!$('#name').val()){
				alert("연자명을 입력해주세요");
				return false;
			}
		});
	});
</script>
<style>
	
</style>
<div class="popupCon" id="" style="width:700px;padding:20px;background:#ffffff;">
<form method="post" name="lecF" id="lecF" action="lecture_reg.php">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="code" id="code" value="<?=$code?>"/>
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 20%;">
			<col style="width: *;">
		</colgroup>
		<tbody>
			<tr>
				<th>ROOM</th>
				<td class="al" height=30>
					<?foreach($room_sid as $tkey=>$tval){?>
					<input type="radio" name="room" id="room<?=$tkey?>" <?if($d['room']==$tkey){?>checked<?}?> value="<?=$tval?>" class="room"> <label for="room<?=$tkey?>"><?=$room_name[$tval]?></label>
					<?}?>
				</td>
			</tr>
			<tr>
				<th>연자명</th>
				<td class="al">
					<input type="text" name="name" id="name" value="<?=$d['name']?>" style="width:80%;">
				</td>
			</tr>
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
<??>
