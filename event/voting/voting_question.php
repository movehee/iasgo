<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.header.php';
?>
<script type="text/javascript" src="/script/drag/js/jquery.tablednd.js"></script>
<script>
	var room="<?=$room?>";
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
					url:"/voting/sort_change.php",
					data:"sort_val="+join_sort,
					cache:false,
					async:false,
					success:function(msg){
					}
				});
			}
		});
	});

	function simple_regist(lecture,code){
		$.ajax({
			type:"POST",
			url:"/voting/simple_regist.php",
			data:"lecture="+lecture+"&code="+code+"&room="+room,
			cache:false,
			async:false,
			success:function(msg){
				if(msg=='Y'){
					location.reload();
				}
			}
		});	
	}

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
<div >
	<div class="btn" style="float:right;">
		<a href="javascript:popup_call('voting/question','lecture=<?=$sid?>&code=<?=$code?>&room=<?=$room?>')" class="btnGrey withIcon"><i class="fas fa-edit"></i>등록</a>
		<a href="javascript:simple_regist('<?=$sid?>','<?=$code?>')" class="btnGreen withIcon"><i class="fas fa-edit"></i>간편 등록</a>
	</div>
</div>
<div style="clear:both;padding-bottom:5px;"></div>
<?
	$query = "select * from voting_tbl where lecture='$sid' and del='N' order by orderby asc";
	$query .= $sort_sql;
	$result=$conn->query($query);
	if(DB::isError($result)) die($result->getMessage());
?>
<table class="tblDef sort_table">
		<colgroup>
			<col style="width: 3%;" />
			<col style="width: 22%;" />
			<col style="" />
			<col style="" />
			<col style="" />
			<col style="" />
			<col style="" />
			<col style="width: 10%;" />
			<col style="width: 5%;" />
		</colgroup>
		<thead>
			<tr>
				<th>No</th>
				<th>질문</th>
				<th>문항1</th>
				<th>문항2</th>
				<th>문항3</th>
				<th>문항4</th>
				<th>문항5</th>
				<th>상태</th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody id="product">
		<?
			$n=1;
			
			while(is_array($d=$result->fetchRow(DB_FETCHMODE_ASSOC))){
			$code = $d['code'];
		?>
		<tr id="<?=$d['sid']?>">
			<th><span class="numberic"></span></th>
			<td><?=$d['question']?></td>
			<td><?=$d['answer1']?></td>
			<td><?=$d['answer2']?></td>
			<td><?=$d['answer3']?></td>
			<td><?=$d['answer4']?></td>
			<td><?=$d['answer5']?></td>
			<td>
			<?
				if($d['status']=='2'){
					echo "<span style='color:blue;'>진행완료</span>";
				}else{
					echo "<span style='color:red;'>대기중</span>";
				}
			?>
			</td>
			<td style="cursor:default;">
				<img src="/image/icon/icon_modify.png" onclick="popup_call('voting/question','sid=<?=$d['sid']?>&code=<?=$code?>')" class="hand">
				<img src="/image/icon/icon_del.png" onclick="common_delete('<?=$d['sid']?>','voting_list')" class="hand">
			</td>
		</tr>
		<?$n++;}?>
	</tbody>
</table>
<div >
	<div class="btn ac tp10" >
		<a href="/voting/lecture.php?code=<?=$code?>" class="btnGrey">목록으로</a>
	</div>
</div>
<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/include.footer.php';
?>