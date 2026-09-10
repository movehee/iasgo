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
		$('#Popup_Title').html("Survey 등록");
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
				
				$.ajax({
					type:"POST",
					url:"survey_sort.php",
					data:"sort_val="+join_sort,
					cache:false,
					async:false,
					success:function(msg){
						if(msg=='Y'){
							alert("변경되었습니다.");
						}
					}
				});
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

$(function() {
	$("select.survey_type").change(function() {
		$p = $(this).closest("tr").find("p.answer_set");
		
		if($(this).val()=='2') {
			$p.show();
		} else {
			$p.hide();
		}
	});

	$("p.answer_set").click(function() {
		popup_call('booth/survey_ans','sid='+$(this).attr("key"))
	});
});

</script>
<div class="popupCon" id="" style="width:800px;padding:20px;background:#ffffff;">
<form method="post" name="brocF" id="brocF" action="company_reg.php" enctype="multipart/form-data">
<input type="hidden" name="sid" id="sid" value="<?=$d['sid']?>"/>
<input type="hidden" name="booth_sid" id="booth_sid" value="<?=$sid?>"/>
<input type="hidden" name="file_upload" id="file_upload" value="N">
	<table class="tblDef tblList sort_table" style="width:100%;">
		<colgroup>
			<col style="width: 8%;">
			<col style="width: 12%;">
			<col style="width: ;">
			<col style="width: 11%;">
			<col style="width: 12%;">
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>Type</th>
				<th>질문</th>
				<th>선택지</th>
				<th>삭제</th>
			</tr>
		</thead>
		<tbody id="product">
			<?
				$query = "select * from survey_tbl where booth_sid='$sid'";
				$query .= " order by sort_num asc, sid asc";
				$result=$conn->query($query);
				if(DB::isError($result)) die($result->getMessage());
				
				while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			?>
			<tr id="<?=$d['sid']?>">
				<td style="padding:0px !important;"><span class="numberic"></span></td>
				<td>
					<select class="Ch_con survey_type" kind="survey" field="type" key="<?=$d['sid']?>">
						<option value="">선택</option>
						<option value="1" <?if($d['type']=='1'){?>selected<?}?> >점수(별)형</option>
						<option value="2" <?if($d['type']=='2'){?>selected<?}?> >선택형</option>
						<option value="3" <?if($d['type']=='3'){?>selected<?}?> >주관식</option>
					<select>
				</td>
				<td class="al"><input type="text" style="width:92%;" value="<?=$d['survey_title']?>" class="Ch_con" kind="survey" field="survey_title" key="<?=$d['sid']?>"></td>
			
				<td style="padding:0px !important;">
					<p class="answer_set hand" <?if($d['type']!='2'){?>style="display:none;"<?}?> key="<?=$d['sid']?>"><i class="fas fa-search"></i>
				</td>
				<td style="padding:0px !important;cursor:default;">
					<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','survey')">
				</td>
			</tr>
			<?}?>
		</tbody>
	</table>
	<div class="btnArea btn">
		<input type="button" value="추가" class="btnPoint btnBig" onclick="add_conference('<?=$sid?>','survey')">
		<input type="button" value="닫기" onclick="self.close()" class="btnGrey btnBig">
	</div>
</form>
<iframe name="hiddenfrm" id="hiddenfrm"  style="width:500px;height:300px;border:1px solid red;display:none;"></iframe>
</div>
<??>
