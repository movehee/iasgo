<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		
		window.resizeTo(re_width,900);
	});
</script>
<style>
.tblDef td{background:#ffffff;padding:5px 0px 5px 10px !important;margin:0px;}
</style>
<div class="popupCon" id="" style="width:900px;padding:20px;background:#ffffff;">
<form name="myfileF" id="myfileF" method="post" action="fileupload_reg.php" enctype="multipart/form-data">
<input type="hidden" name="code" id="code" value="poster"/>
<input type="hidden" name="file_key" id="file_key" value="<?=$_COOKIE['wmember_id']."_".rand(1,999999)?>"/>
<input type="hidden" name="poster_sid" id="poster_sid" value="<?=$sid?>">
	<table class="tblDef inputTbl" style="width:100%;">
		<colgroup>
			<col style="width: 80%;">
			<col style="width: 20%;">
		</colgroup>
		<tbody>
			<tr>
				<th>Poster File</th>
				<th>관리</th>
			</tr>
			<?
				$file_query = "select * from e_poster_file where psid='".$sid."' order by sort_num asc";
				$file_result=$conn->query($file_query);
				if(DB::isError($file_result)) die($file_result->getMessage());

				while(is_array($f=$file_result->fetchRow(DB_FETCHMODE_ASSOC))){
					$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/e_poster/" . $f["filename"]) . "&filename=" . base64_encode($f["filename"]);
			?>
			<tr>
				<td><img src="/upload/e_poster/<?=$f['filename']?>" alt="" width="200"></td>
				<td><img src="<?=IconType3($f['filename'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand"></td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
</div>