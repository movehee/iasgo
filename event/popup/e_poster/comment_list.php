<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script style="text/javascript">
	$(function(){
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
		$('#Popup_Title').html("포스터 댓글");
	});
</script>
<?php
	$query = "select t1.content,t1.type, t2.name_kr,t2.email,t2.cell,t1.signdate from comment_tbl as t1 inner join registration_tbl as t2 on t1.id=.t2.sid where replace(t1.number,'s_','')='$sid' ";
	$query .= " order by t1.signdate asc";

	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
	
?>
<br />
<div class="popupCon" id="" style="width:<?if($mode!='user'){?>1000px<?}else{?>92%<?}?>;padding:20px;background:#ffffff;">
<form method="post" name="brocF" id="brocF" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
<input type="hidden" name="file_upload" id="file_upload" value="N">
	<table class="tblDef tblList " style="width:100%;">
		<colgroup>
			<col style="width: 7%;">
			<col style="width: 11%;">
			<?if($mode!='user'){?><col style="width: 12%;"><?}?>
			<col style="width: ;">
			<col style="width: 11%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>성명</th>
				<?if($mode!='user'){?>
				<th>이메일</th>
				<?}?>
				<th>내용</th>
				<th>일시</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
			$n=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td><?if($d['type']=='CC'){?><i class="fab fa-replyd" style="font-size:28px;"></i><?}else{?><?=$n?><?}?></td>
				<td><?=$d['name_kr']?></td>
				<td><?=$d['email']?></td>
				<td class="al"><?=nl2br($d['content'])?></td>
				<td><?=date("Y.m.d H:i:s",$d['signdate'])?></td>
			</tr>
			<?
			if($d['type']=='C') $n++;
			}?>
		</tbody>
	</table>
	
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
