<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	
	$query = "select * from e_poster_category where depth='1' and del='N' order by sort_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());

?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	$(function(){
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
					url:"/poster/sort_change.php",
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

		$(".sort_table_sub").tableDnD({ 
			//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
			onDragStyle : 'dragRow3', 
			onDropStyle : 'dragRow3', 
			onDragClass: 'dragRow3',
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
					url:"/poster/sort_change_sub.php",
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
	

	#product {
		counter-reset: rowNumber;
	}
	.numberic:after {
		counter-increment: rowNumber;
		content: counter(rowNumber);
	}
</style>

<div class="tp15 bp5">
	<div style="float:right;">
		<span class="btnAdmin medium green"><button type="button" onclick="popup_call('excel/upload','kind=poster_category')">Excel Upload</button></span>
	</div>
</div>
<br />

<table class="tblDef tblList sort_table">
	<colgroup>
		<col style="width: 5%;">
		<col style="">
		
		<col style="width: 40%;">
		<col style="width: 7%;">
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>Category</th>
			<th>Sub Category</th>
			<th>E-Poster 개수</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			$virtualRecordNo=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$poster_cnt = $conn->getOne("select count(*) from e_poster where category='".$d['sid']."'");

				$category_sub_cnt = $conn->getOne("select count(*) from e_poster_category where depth='2' and psid='".$d['sid']."' and del='N'");
		?>
		<tr id="<?=$d['sid']?>">
			<td style="border-top:0px;"><span class="numberic"><?//=$virtualRecordNo?></span></td>
			
			<td style="border-top:0px;"><?=$d['title']?></td>
			
			<td style="padding:0px;border-bottom:0px;border-top:0px;">
				<table class="tblDef tblList sort_table"  style="margin:0px;padding:0px;border:0px;">
					<?
					if($category_sub_cnt>0){
						$query_sub = "select * from e_poster_category where depth='2' and psid='".$d['sid']."' and del='N' order by sort_num asc";
						$result_sub=$conn->query($query_sub);
						if(DB::isError($result_sub)) die($result_sub->getMessage());

						while(is_array($sub=$result_sub->fetchRow(DB_FETCHMODE_ASSOC))){
							$poster_cnt_sub = $conn->getOne("select count(*) from e_poster where category='".$d['sid']."' and category_sub='".$sub['sid']."' and del='N'");
					?>
					<tr id="<?=$sub['sid']?>">
						<td class="al" style="border-top:0px;border-left:0px;padding-left:10px;"><?=$sub['title']?></td>
						<td style="width:60px;border-top:0px;"><?=number_format($poster_cnt_sub)?>개</td>
						<td style="width:60px;border-top:0px;cursor:default;">
							<img src="/image/icon/icon_modify.png" class="hand" onclick="popup_call('e_poster/category','sid=<?=$sub['sid']?>')">
							<img src="/image/icon/icon_del.png" class="hand" onclick="common_delete('<?=$sub['sid']?>','poster_category_sub')">
						</td>
					</tr>
					<?
						}
					}else{
						?>
						<tr >
							<td class="al" colspan=3 style="border-top:0px;border-left:0px;padding-left:10px;height:27px;color:red;"> 등록된 하위 카테고리가 없습니다.</td>
						</tr>
						<?
					}
					?>
				</table>
			</td>
			<td style="border-top:0px;"><?=number_format($poster_cnt)?>개</td>
			<td style="cursor:default;border-top:0px;">
				<img src="/image/icon/icon_modify.png" class="hand" onclick="popup_call('e_poster/category','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" class="hand" onclick="common_delete('<?=$d['sid']?>','poster_category')">
			</td>
		</tr>
		<?$virtualRecordNo++;}?>
	</tbody>
</table>

<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>