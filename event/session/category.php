<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
	
	
	$query = "select * from workshop_session_category where del='N' order by sort_num asc";
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<!-- <script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
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
					url:"/booth/sort_change.php",
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
</script> -->
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
<table class="tblDef sort_table">
	<colgroup>
		<col style="width: 5%;">
		<col style="">
		<col style="width: 22%;">
		<col style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>Title</th>
			<th>Sub Title</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody id="product">
		<?
			$virtualRecordNo=1;
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
				$booth_cnt = $conn->getOne("select count(*) from booth where booth_sid='".$d['sid']."'");

		?>
		<tr id="<?=$d['sid']?>">
			<td><span class="numberic"><?//=$virtualRecordNo?></span></td>
			<td><?=$d['title']?></td>
			<td><?=$d['title_sub']?></td>
			<td style="cursor:default;">
				<img src="/image/icon/icon_modify.png" class="hand" onclick="popup_call('TableGender/category','sid=<?=$d['sid']?>')">
				<img src="/image/icon/icon_del.png" class="hand" onclick="common_delete('<?=$d['sid']?>','session_category')">
			</td>
		</tr>
		<?$virtualRecordNo++;}?>
	</tbody>
</table>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>