<?include "./../header2.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;


$query="SELECT * FROM faculty_group_tbl where code='".$code."'";

$query.=" order by orderby asc ";


$result = mysqli_query($conn, $query);
?>
<div id="container" style="width:1000px">
	
		<h2>Faculty Group</h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
			-->
			
		
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add_sub_type('<?=$type_sid?>','<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>ADD</a></p>
			

			<table class="tblList">
				<thead>

					<colgroup>
						<col style="width: 8%;">
						<col style="width: 82%;">
						<col style="width: 10%;">
					</colgroup>

					<tr>
						<th>순서</th>
						<th>Info</th>
						<th>관리</th>
					</tr>
				</thead>

				<tbody>
				<?while(is_array($col = mysqli_fetch_assoc($result))){?>
				<tr id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<td>
						<input onchange="changeVal(this,'faculty_group_name','<?=$col['sid']?>')" type="text" name="faculty_group_name" id="faculty_group_name"  value="<?=$col['faculty_group_name']?>" />
					</td>
					<td>
						<a href="" onclick="javascript:del('<?=$col['sid']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
					</td>
				</tr>
				<?}?>
					
				</tbody>
			</table>

			<ul class="pager">
			<?
				for($i = 0 ; $i*$num_per_page < $totalRecord ; $i++)
				{?>	
					<li <?if($i==$page){?>class="on"<?}?>><a href="<?=$_SERVER['PHP_SELF']?>?page=<?=$i?><?if($search){?>&search=<?=$search?><?}?>"><?=$i+1?></a></li>
				<?}
			?>
			</ul>
		</div>
		<!-- //contents -->
			
		
    
    </div> <!-- //container -->
	
<script type="text/javascript">


$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./group_sub_order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){

			}
		});


    });
  }
});
});

function add_sub_type(type_sid,code) {
	//alert(val.value);
	$.ajax({
		type:"POST",
		url:"./group_sub_add.php",
		data:"code="+code,
		success:function(msg){
			location.reload();
		}
	});
}


function changeVal(val,info,sid) {
	//alert(val.value);
	$.ajax({
		type:"POST",
		url:"./group_sub_update.php",
		data:"val="+encodeURIComponent(val.value)+"&info="+info+"&sid="+sid,
		success:function(msg){
			
		},error : function(request, status, error ) {   // 오류가 발생했을 때 호출된다. 
			alert("입력실패 : " + val.value);
		}
	});
}


function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		$.ajax({
			type:"POST",
			url:"./group_sub_del.php",
			data:"sid="+sid,
			success:function(msg){
				if(msg == "err") {
					alert("해당그룹으로 등록된 Faculty가 있습니다.");
					return false;
				}
				else {
					location.reload();
				}
			}
		});
	}
}



</script>

   
<?include "./../footer.php";?>