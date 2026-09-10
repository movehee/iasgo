<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<?
	
	$query = "select * from faculty_tbl where sid='".$sid."'";
	$result = $conn->query($query);
	$result->fetchInto(&$d,DB_FETCHMODE_ASSOC);
	$result->free();
?>
<script style="text/javascript">
	
	$(function(){
		$('#Popup_Title').html("<?=$d['faculty_name']?><div style='font-size:13px;'>(<?=$d['faculty_aff']?> / <?=$d['faculty_email']?>)</div>");
		$('.color_close').on('click',function(){
			parent.$.colorbox.close();
		});
	});
	function concat_js(usid,fsid){
		$.ajax({
			type:"POST",
			url:"/load/faculty/reg_connect_reg.php",
			data:"usid="+usid+"&fsid="+fsid+"&kind=in",
			async:false,
			success:function(msg){
				var parse_data = JSON.parse(msg);
				if(parse_data.result=='Y'){
					parent.$('#Conn_'+fsid).attr('class','btnAdmin small lightBlue');
					parent.$.colorbox.close();
				}
			}
		});
	}
	function concat_js_cancel(fsid){
		if(confirm("연결된 회원을 해제하시겠습니까?")){
			$.ajax({
				type:"POST",
				url:"/load/faculty/reg_connect_reg.php",
				data:"fsid="+fsid+"&kind=del",
				async:false,
				success:function(msg){
					var parse_data = JSON.parse(msg);
					if(parse_data.result=='Y'){
						parent.$('#Conn_'+fsid).attr('class','btnAdmin small empty darkGray');
						parent.$.colorbox.close();
					}
				}
			});
		}
	}
	
</script>
<div class="popupCon" id="" style="width:100%;background:#fffff;">
	<!-- <div style="font-size:12px;padding-left:10px;padding-top:5px;" class="fcRed">
		★ 바탕색이 노랑색으로 표시된 세션은 선택된 세션이 아닌 선택한 프로그램과 세션명이 같다는 표시입니다.<br>
		★ 선택이 완료된 세션은 오른쪽의 버튼이 파랑색으로 표시됩니다.
	</div> -->

	
	
	<div style="padding:10px;overflow-y:auto; overflow-x:hidden; width:97%; height:600px;">

	<?
		$over_sql = "select * from registration_tbl where sid='".$d['usid']."'";
		$over_result = $conn->query($over_sql);
		$over_result->fetchInto(&$over,DB_FETCHMODE_ASSOC);
		$over_result->free();
		if($over>0){
	?>
	<div class="bp5">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width:15%;">
			<col style="">
		</colgroup>
		<tbody>
			<tr>
				<th style="background:#445964;color:#ffffff;">이름</th>
				<th style="background:#445964;color:#ffffff;">면허번호</th>
				<th style="background:#445964;color:#ffffff;">소속</th>
				<th style="background:#445964;color:#ffffff;">E-mail</th>
				<th style="background:#445964;color:#ffffff;">관리</th>
			</tr>
			<tr>
				<td><?=$over['name_kr']?></td>
				<td><?=$over['license_number']?></td>
				<td><?=$over['aff_kor']?></td>
				<td><?=$over['email']?></td>
				<td>
					<span class="btnAdmin small red"><button type="button" onclick="concat_js_cancel(<?=$d['sid']?>)">선택취소</button></span>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	<?}?>

	<form name="searchF" id="searchF" method="post" action="<?=$PHP_SELF?>">
	<input type="hidden" name="sid" id="sid" value="<?=$sid?>">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width:15%;">
			<col style="">
		</colgroup>
		<tbody>
			<tr>
				<th>검색</th>
				<td class="al">
					<input type="text" name="keyword" style="width:80%;">
					<span class="rBtnAdmin medium"><button type="submit">확인</button></span>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
	
	<?
	if($keyword){
		$Tcnt = $conn->getOne("select count(*) from registration_tbl where name_kr like '%$keyword%' or license_number like '%$keyword%'or name_eng like '%$keyword%' or aff_kor like '%$keyword%' or email like '%$keyword%'");
		if($Tcnt>0){
	?>
	<br />
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 5%;">
			<col style="width: 10%;">
			<col style="width: 10%;">
			<col style="width: 30%;">
			<col style="width: 30%;">
			<col style="width: 5%;">
		</colgroup>
		<tbody> 
			<tr>
				<th style="background:#445964;color:#ffffff;">No</th>
				<th style="background:#445964;color:#ffffff;">이름</th>
				<th style="background:#445964;color:#ffffff;">면허번호</th>
				<th style="background:#445964;color:#ffffff;">소속</th>
				<th style="background:#445964;color:#ffffff;">E-mail</th>
				<th style="background:#445964;color:#ffffff;">선택</th>
			</tr>
			<?
				
			$n=1;
				$search_query = "select t1.*,t2.sid as overlap from registration_tbl as t1 left join faculty_tbl as t2 on t1.sid=t2.usid";
				$search_query .= " where t1.name_kr like '%$keyword%' or t1.license_number like '%$keyword%'or t1.name_eng like '%$keyword%' or t1.aff_kor like '%$keyword%' or t1.email like '%$keyword%'";
				$search_result=$conn->query($search_query);
				if(DB::isError($search_result)) die($search_result->getMessage());

				while(is_array($s=$search_result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?=$n?></td>
				<td><?=$s['name_kr']?></td>
				<td><?=$s['license_number']?></td>
				<td><?=$s['aff_kor']?></td>
				<td><?=$s['email']?></td>
				<td>
					<?if($s['overlap']>0){?>
						<span class="btnAdmin small red"><button type="button" onclick="alert('이미 선택된 회원입니다.')">선택불가</button></span>
					<?}else{?>
						<span class="btnAdmin small blue<?if($session['sid']!=$d['code2']){?> empty<?}?>"><button type="button" onclick="concat_js(<?=$s['sid']?>,<?=$d['sid']?>)">선택</button></span>
					<?}?>
				</td>
			</tr>
			<?$n++;}?>
		</tbody>
	</table>
	<?}else{?>
		<div class="ac fcRed" style="font-size:22px;padding-top:100px;">검색된 데이터가 존재하지 않습니다.</div>
	<?}?>
	<?}else{?>
		<div class="ac fcRed" style="font-size:22px;padding-top:100px;">연결하실 회원을 검색해주세요.</div>
	<?}?>
	</div>
	
</div>