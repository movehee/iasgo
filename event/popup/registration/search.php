<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?	
	include_once $_SERVER['DOCUMENT_ROOT']."/func/config_time.php";

	$chkdate = strtotime($_Webinar['edate'])-strtotime($_Webinar['sdate']);
	$date_count = date("d",$chkdate);
	$ex_sdate = explode("-",$_Webinar['sdate']);
	
	if($_POST['keyword_val']){
		$chking = $conn->getOne("select count(*) from registration_tbl where id like '%$keyword_val%'");
		if($chking==1){
			$usid = $conn->getOne("select sid from registration_tbl where id like '%$keyword_val%'");
		}
	}
?>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html('입/퇴장 임의등록');
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,900);
		
		
		$('#reg_searchF').submit(function(){
			if(!$('#keyword_val').val()){
				alert("검색하실 회원의 아이디를 입력해주세요");
				return false;
			}
		});
		$('.time_reset_all').on('click',function(){
			var key = $(this).attr("key");
			$('.times'+key).val("");
		});

		$('.time_reset').on('click',function(){
			var key = $(this).attr("key");
			$('#'+key).val("");
		});
	});
	function time_insert(){
		if($('.daychk').is(':checked')==false){
			alert("행사일자를 선택해주세요");
			return false;
		}
		document.day_regF.submit();
	}
</script>
<style>
	td {height:30px;}
</style>
<div class="popupCon" id="" style="width:1400px;padding:20px;background:#ffffff;">
	<form method="post" name="reg_searchF" id="reg_searchF" action="<?=$PHP_SELF?>">
		<table class="tblDef inputTbl" style="width:100%;">
			<colgroup>
				<col style="width: 20%;">
				<col style="width: 80%;">
			</colgroup>
			<tbody>
				<tr>
					<th>검색</th>
					<td colspan=3 class="al">
						<div>
							<div style="float:left;"><input type="text" name="keyword_val" id="keyword_val" placeholder="아이디를 검색해주세요" style="width:580px;"></div>
							<div class="btn bp5" style="float:left;padding-left:10px;">
								<input type="submit" value="회원검색" class="btnPoint ">
							</div>
						</div>
							
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	<?if($chking!=1){?>
	<br />
	<table class="tblDef inputTbl" style="width:100%;">
		
		<tbody>
			<?if($chking==0){?>
			<tr>
				<th colspan=2 class="fcRed">검색된 회원이 없습니다.</th>
			</tr>
			<?}else{?>
				<tr>
					<th>선택</th>
					<th>아이디</th>
					<th>성명</th>
					<th>소속</th>
				</tr>
				<?
					$uqeury = "select * from registration_tbl where id like '%$keyword_val%'"; 
					$uresult=$conn->query($uqeury);
					if(DB::isError($uresult)) die($uresult->getMessage());

					while(is_array($u=$uresult->fetchRow(DB_FETCHMODE_ASSOC))){
				?>
				<tr>
					<td><span class="btnAdmin small blue"><button type="button" onclick="location.href='<?=$PHP_SELF?>?usid=<?=$u['sid']?>&chking=1'">선택</button></span></td>
					<td><?=$u['id']?></td>
					<td><?=$u['name_kr']?></td>
					<td><?=$u['aff_kor']?></td>
				</tr>
				<?}?>
			<?}?>
		</tbody>
	</table>
	<?}?>
	<?
		if($usid){
			$Gkey = $conn->getOne("select group_key from registration_tbl where sid='".$usid."'");
	?>
	<br />
	<div style="font-weight:bold;padding-bottom:10px;">※ <?=$conn->getOne("select name_kr from registration_tbl where sid='$usid'")?>님을 선택하였습니다.</div>
	<form name="day_regF" id="day_regF" method="post" action="search_reg.php">
	<input type="hidden" name="usid" id="usid" value="<?=$usid?>">
	<input type="hidden" name="Gkey" id="Gkey" value="<?=$Gkey?>">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 5%;">
			<col style="width: 7%;">
			<col style="">
		</colgroup>
		<tbody>
			<tr>
				<th>선택</th>
				<th>행사일</th>
				<th>입/출기록</th>
			</tr>
			<?for($date=1;$date<=$date_count;$date++){?>
			<?
				$chking = $conn->getOne("select sid from checkin_tbl where usid='".$usid."' and day='".$date."'");
				$time_max_count=count($_TIME['session'][$date]);
			?>
			<tr>
				<td><?if(!$chking){?><input type="checkbox" class="daychk" name="daychk[]" id="daychk<?=$date?>" value="<?=$date?>"><?}?></td>
				<td><?=date("n월 j일", mktime(0,0,0,$ex_sdate[1],$ex_sdate[2]+($date-1), $ex_sdate[0]));?></td>
				<td style="padding:0px;margin:0px;text-align:left;border:0px;">
					<table class="tblDef" cellpadding="0" cellspacing="0" style="border:0px;">
						<tr>
							<th style="width:50px;">Reset</th>
							<?for($i=1;$i<=$time_max_count;$i++){?>
							<th>Session <?=$i?> 입장</th>
							<th>Session <?=$i?> 퇴장</th>
							<?}?>
						</tr>
						<tr>
							<?if($chking){?>
								<td colspan="<?=($time_max_count*2)+1?>" class="fcRed">
								이미 등록된 입출기록이 있습니다. <span class="btnAdmin small navy"><button type="button" onclick="popup_call('registration/session_time','sid=<?=$chking?>&day=<?=$date?>')">View</button></span>
								</td>
							<?}else{?>
								<td><i class="fas fa-minus-square time_reset_all" style="font-size:25px;color:#CC0000;cursor:pointer;" key="<?=$date?>"></i></td>
								<?for($i=1;$i<=$time_max_count;$i++){?>
								
								<td >
									<input type="text" style="width:80px;" class="times<?=$date?>" name="stimes<?=$date?>_<?=$i?>" id="stimes<?=$date?>_<?=$i?>" value="<?=trim(substr($_TIME['session'][$date][$i][0],10,6))?>">
									<i class="fas fa-minus-square time_reset" style="font-size:25px;cursor:pointer;" key="stimes<?=$date?>_<?=$i?>"></i>
								</td>
								<td>
									<input type="text" style="width:80px;" class="times<?=$date?>" name="etimes<?=$date?>_<?=$i?>" id="etimes<?=$date?>_<?=$i?>" value="<?=trim(substr($_TIME['session'][$date][$i][1],10,6))?>">
									<i class="fas fa-minus-square time_reset" style="font-size:25px;cursor:pointer;" key="etimes<?=$date?>_<?=$i?>"></i>
								</td>
								<?}?>
							<?}?>
						</tr>
					</table>
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
	
	<div class="btnArea btn">
		<input type="button" value="선택일자 등록하기" class="btnPoint btnBig" onclick="time_insert()">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
	</form>
	<?}?>
</div>