
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript" src="/drag/js/jquery.tablednd.js"></script>
<script>
	$(function(){ 
		//tableDnD(이안에 여러 옵션들을 지정해 줄 수 있다.) 

		$("#tableId").tableDnD({
			
			//드래그 기능이 동작하는 동안 특정 CLASS를 드래그하는 TR에 적용해준다. 
			onDragStyle : 'dragRow', 
			onDropStyle : 'dragRow', 
			onDragClass: 'dragRow',
			onDrop: function(table, row){ 
				
				var rows = table.tBodies[0].rows;
				var debugStr = "Row dropped was "+row.id+". New order: ";
				for (var i=0; i<rows.length; i++) { 
					debugStr += rows[i].id+" / "+rows[i].name + " || "; 
				} 
				$('#debugArea').html(debugStr);
			}, 
			onDragStart: function(table, row){ 
				onDragClass: 'dragRow';
			}
		});
	});
</script>
<style>
	.dragRow{background-color:red;}
</style>
<div id="debugArea"></div>
<table id="tableId" border="1" style="width: 800px;">
	<tr  id="test1" class="1" alt="1" name="a1">
		<td width="100%">1</td>
	</tr>
	<tr id="tedst2" class="2" alt="2" name="a2"> 
		<td >2</td> 
	</tr> 
	<tr id="test3" class="3" alt="3" name="a3"> 
		<td >3</td> 
	</tr> 
	<tr id="test4" class="4" alt="4" name="a4"> 
		<td>4</td> 
	</tr> 
</table>
