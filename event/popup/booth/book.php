<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script style="text/javascript">
	$(function(){
		$('#Popup_Title').html("Guest Book");	
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,950);
	});
</script>
<style>
div.selectFile {overflow:hidden;padding-right:10px;padding-left:10px;}
div.selectFile p {float:left;}
div.selectFile p input[type=text] {height: 23px;padding:2px 10px 3px;}
div.selectFile p.withIcon {position: relative;width:66px;height:30px;background-color:#393939;color: #fff;text-align: center;}
div.selectFile p.withIcon i {position: absolute;left: 50%;top: 50%;font-size: 1em;margin: -0.5em 0 0 -0.5em;color:#ffffff;}
div.selectFile p.withIcon input {position: absolute;left: 0;top: 0;width:100%;height:100%;padding: 0;border: 0 none;}
#product {
	counter-reset: rowNumber;
}
.numberic:after {
	counter-increment: rowNumber;
	content: counter(rowNumber);
}

</style>
<script>
	$(function(){
		$('#load_text').html("<?=$booth_title?>");
	});
</script>
<?php
	$query = "select * from booth_book as t1 inner join registration_tbl as t2 on t1.usid=t2.sid where t1.booth_sid='$sid'";
	$query .= " order by t1.sid desc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
?>
<div class="popupCon" id="" style="width:1000px;padding:20px;background:#ffffff;">
<form method="post" name="brocF" id="brocF" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
<input type="hidden" name="file_upload" id="file_upload" value="N">
	<div class="ar bp5">
		<span class="rBtnAdmin medium green"><button type="button" onclick="location.href='book_excel.php?booth_sid=<?=$sid?>'">Excel</button></span>
	</div>
	<table class="tblDef  sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 11%;">
			<col style="width: 12%;">
			<col style="width: ;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>성명</th>
				<th>면허번호</th>
				<th>내용</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td class="numberic"></td>
				<td>
				<?
					echo $d['name_kr'];
				?>
				</td>
				<td><?=$d['license_number']?></td>
				<td class="al"><?=$d['content']?></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
