<?include "./../header.php";?>

<?

$num_per_page = 100;
if(empty($page)) $page = 0;

if(empty($tab)){
	$result = mysqli_query($conn, "select sid from agenda_tbl where code='".$code."' and del='N' order by sid asc limit 1");
	$row = mysqli_fetch_array($result);
	$tab = $row['sid'];
}

$query="SELECT * FROM session_time_tbl where code='".$code."' and tab='".$tab."'";

$result = mysqli_query($conn, "SELECT count(*) cnt FROM session_time_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$totalRecord = $row['cnt'];

$query.=" order by orderby asc LIMIT ".$page*$num_per_page.",".$num_per_page;

$result = mysqli_query($conn, "select max(orderby) maxs from session_time_tbl where code='".$code."'");
$row = mysqli_fetch_array($result);
$max = $row['maxs'];


$result = mysqli_query($conn, $query);
?>
<div id="container">
	
		<h2>Time 관리</h2>
		<div class="contents member">
			

			<!--
			<p class="btn" style="top: -44px; right: 460px; position: absolute;"><a href="" onclick="javascript:css('<?=$code?>')" class="btnDef"><i class="fas fa-cog"></i>CSS 설정</a></p>
			-->
			
		
			
		
			<p class="btn" style="top: -44px; right: 30px; position: absolute;"><a  onclick="javascript:add('<?=$tab?>','<?=$code?>')" class="btnDef"><i class="fas fa-plus-circle"></i>Time 등록</a></p>

			
			<?
			$tab_result = mysqli_query($conn, "select * from agenda_tbl where code='".$code."' and del='N' order by sid asc");
			while(is_array($tab_col = mysqli_fetch_array($tab_result))){
			?>

			<p class="btn" style="float:left;margin-right:20px"><a href="./time.php?tab=<?=$tab_col['sid']?>" class="<?if($tab==$tab_col['sid']){?>btnDef<?}else{?>btnGrey<?}?>"><?=$tab_col['name']?></a></p>



			<?}?>
			

			<table class="tblList">
			
				<tbody>
				<?while(is_array($col = mysqli_fetch_array($result))){?>

				<tr class="bg" id="<?=$col['sid']?>">
					<td onclick="javascript:up('<?=$col['orderby']?>','<?=$col['tab']?>')">▲</td>
					<td><?=$col['orderby']?></td>
					<td onclick="javascript:down('<?=$col['orderby']?>','<?=$max?>','<?=$col['tab']?>')">▼</td>


					<td><?=$col['time']?></td>
					<td><?=$col['showYN']?></td>
					<td>
						<a href="" onclick="javascript:modify('<?=$col['sid']?>','<?=$tab?>','<?=$code?>')"><img src="/admin/image/btn_modify.png" alt="수정" /></a>
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

function up(sid,tab) {
	if(sid>1)
	{
		val2 = sid-1;
		window.open("time_order.php?tab="+tab+"&val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}
function down(sid,max,tab) {
	if(sid<max)
	{
		val2 = Number(sid)+Number(1);
		window.open("time_order.php?tab="+tab+"&val1="+sid+"&val2="+val2,"","width=530,height=770");
	}
}


function showYN(val,sid) {
	window.open("show.php?show="+val+"&sid="+sid,"","width=530,height=500");
}

function add(tab,code) {
	window.open("time_add.php?tab="+tab+"&code="+code,"","width=800,height=1000");
}


function modify(sid,tab,code) {
	window.open("time_add.php?sid="+sid+"&tab="+tab+"&code="+code,"","width=530,height=500");
}	

function del(sid) {
	if(confirm("삭제하시겠습니까?")){
		window.open("time_del.php?sid="+sid,"","width=530,height=520");
	}
}

$(function() {
 $(".tblList tbody").sortable( {
	update: function( event, ui ) {
    $(this).children().each(function(index) {
			index = index+1;
			$.ajax({
			type:"POST",
			url:"./time_order2.php",
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