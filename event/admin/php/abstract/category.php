<?include "./../header.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;



$query="SELECT * FROM abstract_category_tbl where code='".$code."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM abstract_category_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, "select max(orderby) maxs from abstract_category_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];




$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Category 관리</h2>
		<div class="contents member">
			
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Category 등록</a></p>
			

			<table class="tblList">

				<thead>
					<tr>
						<th>NO</th>
						<th>부모값</th>
						<th>name</th>
						<th>color</th>
						<th>관리</th>
					</tr>
				</thead>



			
				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){
					$parent_result = mysqli_query($conn, "select info from abstract_category_tbl where sid='".$col['parent']."'");
					$parent_row = mysqli_fetch_array($parent_result);
				?>

				<tr class="bg" id="<?=$col['sid']?>">
					<td><?=$col['orderby']?></td>
					<td><?=$parent_row['info']?></td>
					<td><?=$col['info']?></td>
					<td><?=$col['color']?></td>

					<td>
						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$code?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
						<a href="" onclick="javascript:del('<?=$col['sid']?>','<?=$col['code']?>')"><img src="/admin/image/btn_delete.png" alt="삭제" /></a>
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

function up(sid) {
	if(sid>1)
	{
		val2 = sid-1;
		window.open("category_order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}
function down(sid,max) {
	if(sid<max)
	{
		val2 = Number(sid)+Number(1);
		window.open("category_order.php?val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}


function showYN(val,sid) {
	window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}

function add(code) {
	window.open("category_add.php?code="+code,"","width=800,height=1000");
}

function set() {
	window.open("set.php","","width=950,height=1000");
}


function room() {
	window.open("room.php","");
}

function timeset() {
	window.open("time.php","");
}


function css() {
	window.open("css.php","","width=530,height=700");
}
function view(code) {
	window.open("/php/feedback/view.php?code="+code,"","width=530,height=800");
}


function modify(sid,code) {
	window.open("category_add.php?sid="+sid+"&code="+code,"","width=530,height=500");
}	

function del(sid,code) {
	if(confirm("삭제하시겠습니까?")){

		$.ajax({
		type:"POST",
		url:"./category_del.php",
		data:"sid="+sid+"&code="+code,
		success:function(msg){
			location.reload();
		}
	});
	}
}

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./category_order.php",
			data:"sid="+$(this).attr('id')+"&orderby="+index,
			success:function(msg){
				

			}
		});


    });
  }
});
});
</script>

   
<?include "./../footer.php";?>