<?include $_SERVER['DOCUMENT_ROOT'].'popup/include.header.php'?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script style="text/javascript">
	$(function(){
		re_height = $('.popupCon').outerHeight()+68;
		re_width = $('.popupCon').outerWidth()+27;
		window.resizeTo(re_width,950);
	});
</script>

<script>
	$(function(){
		$('#Popup_Title').html("Brochures 등록");
		$(".sort_table").tableDnD({ 
			//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
			onDragStyle : 'dragRow2', 
			onDropStyle : 'dragRow2', 
			onDragClass: 'dragRow2',
			onDragStart: function(table, row){ 
				onDragClass: 'dragRow';
			},
			onDrop: function(table, row){ 
				var rows = table.tBodies[0].rows;
				var debugStr = "";
				var debugStr = new Array();
				for (var i=0; i<rows.length; i++) {
					//debugStr += rows[i].id + "||"; 
					debugStr[i] = rows[i].id; 
				}
				var join_sort = debugStr.join(",");
				
				/*$.ajax({
					type:"POST",
					url:"/admin/booth/sort_change_booth.php",
					data:"sort_val="+join_sort,
					cache:false,
					async:false,
					success:function(msg){
						if(msg=='Y'){
							alert("변경되었습니다.");
						}
					}
				});*/
			}
		});
	});
</script>
<style>
.dragRow{border:2px solid red !important;}
.dragRow2{background:#f1ff44 !important;}
.dragRow3{background:#FFA042 !important;}
.dragRow_role{border:2px solid red !important;}
.dragRow2_role{background:#EA6C55 !important;color:#ffffff;}

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
function add_conference(sid,kind){
	$.ajaxSetup({ cache: false });
	$.ajaxSetup({ async:false });
	$.get( "/popup/booth/add.php?kind="+kind+"&sid="+sid, function( data ) {
		$("#product").append( data );
	});
	
}

</script>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<form method="post" name="brocF" id="brocF" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
<input type="hidden" name="file_upload" id="file_upload" value="N">
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 10%;">
			<col style="width: ;">
			<col style="width: 11%;">
			<col style="width: 11%;">
			<col style="width: 8%;">
			<col style="width: 12%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Title</th>
				<th>표지</th>
				<th>파일</th>
				<th>Stamp</th>
				<th>삭제</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
				$query = "select * from booth_brochures where booth_sid='$sid'";
				$query .= " order by sort_num asc, sid asc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr>
				<td style="padding:0px !important;"><span class="numberic"></span></td>
				<td class="al"><input type="text" style="width:92%;" value="<?=$d['broc_title']?>" class="Ch_con" kind="broc" field="broc_title" key="<?=$d['sid']?>"></td>
				<td style="padding:0px !important;cursor:default;">
					<?
						$Fname = "cover_".$d['sid'];
						$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $d["cover_file"]) . "&filename=" . base64_encode($d["cover_file"]);
					?>
					<div class="selectFile" id="<?=$Fname?>_Area" style="display:<?if($d['cover_file']){?>none<?}?>;">
						<p><input name="" id="<?=$Fname?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
						<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname?>" id="<?=$Fname?>" onchange="document.getElementById('<?=$Fname?>_txt').value=this.value;file_upload_ajax(<?=$d['sid']?>,'<?=$Fname?>','broc')" type="file" ></p>
					</div>
					<div id="<?=$Fname?>_list">
						<?if($d['cover_file']){?>
						<div class="f_<?=$d['sid']?>">
							<img src="<?=IconType3($d['cover_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand" style="width:16px;">
							<span><img src="/image/icon/icon_del.png" onclick="common_delete_file(<?=$d['sid']?>,'broc_file','cover')" class="hand"></span>
						</div>
						<?}?>
					</div>
				</td>
				<td style="padding:0px !important;">
					<?
						$Fname2 = "broc_".$d['sid'];
						$queryString = "path=" . base64_encode($_SERVER['DOCUMENT_ROOT']."/upload/booth/" . $d["broc_file"]) . "&filename=" . base64_encode($d["broc_file"]);
					?>
					<div class="selectFile" id="<?=$Fname2?>_Area" style="display:<?if($d['broc_file']){?>none<?}?>;">
						<p><input name="" id="<?=$Fname2?>_txt" value="Select File" type="text" style="width:0px;display:none;"  readonly></p>
						<p class="withIcon"><i class="fas fa-search"></i><input class="opacity0" name="<?=$Fname2?>" id="<?=$Fname2?>" onchange="document.getElementById('<?=$Fname2?>_txt').value=this.value;file_upload_ajax(<?=$d['sid']?>,'<?=$Fname2?>','broc')" type="file" ></p>
					</div>
					<div id="<?=$Fname2?>_list">
						<?if($d['broc_file']){?>
						<div class="f_<?=$d['sid']?>">
							<img src="<?=IconType3($d['broc_file'])?>" onclick="location.href='/func/download.php?<?=$queryString?>'"class="hand">
							<span><img src="/image/icon/icon_del.png" onclick="common_delete_file(<?=$d['sid']?>,'broc_file','broc')" class="hand"></span>
						</div>
						<?}?>
					</div>
				</td>
				<td>
					<input type="checkbox" style="width:22px;height:22px;margin:0px;padding:0px;" key="<?=$d['sid']?>" kind="broc_stamp" class="check_value" <?if($d['stamp']=='Y'){?>checked<?}?>>
				</td>
				<td style="padding:0px !important;cursor:default;">
					<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','broc')">
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="추가" class="btnPoint btnBig" onclick="add_conference('<?=$sid?>','broc')">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
